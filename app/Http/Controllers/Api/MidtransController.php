<?php

namespace App\Http\Controllers\Api;

use App\ConfirmAgency;
use App\Http\Controllers\Controller;
use App\Mail\Agencies\InvoiceMail;
use App\Plan;
use App\Support\RomanConverter;
use App\User;
use App\Vacancies;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransController extends Controller
{
    public $channels;

    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY'); // Set your Merchant Server Key
        Config::$isProduction = false; // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isSanitized = true; // Set sanitization on (default)
        Config::$is3ds = true; // Set 3DS transaction for credit card to true

        // Uncomment for append and override notification URL
        // Config::$appendNotifUrl = "https://example.com";
        // Config::$overrideNotifUrl = "https://example.com";

        // Optional, remove this to display all available payment methods
        $this->channels = ["credit_card", "bca_va", "echannel", "bni_va", "permata_va", "other_va", "gopay", "indomaret", "alfamart"];
    }

    public function snap(Request $request)
    {
        $user = User::find($request->user_id);
        $agency = $user->agencies;
        $split_name = explode(" ", $user->name);
        $first_name = array_shift($split_name);
        $last_name = implode(" ", $split_name);

        $plan = Plan::find($request->plans_id);
        $plan_price = $plan->discount > 0 ? $plan->price - ($plan->price * $plan->discount / 100) : $plan->price;
        $plan_ads = array_sum(str_split(filter_var($plan->job_ads, FILTER_SANITIZE_NUMBER_INT)));

        $price_per_ads = $request->total_ads > $plan_ads ? Plan::find(1)->price - (Plan::find(1)->price * Plan::find(1)->discount / 100) : 0;
        $qty_ads = $request->total_ads > $plan_ads ? $request->total_ads - $plan_ads : $plan_ads;
        $name_ads = $request->total_ads - $plan_ads > 0 ? $plan_ads.' (+'.ceil($request->total_ads - $plan_ads).')' : $plan_ads;

        $price_per_quiz = $request->total_quiz > $plan->quiz_applicant ? $plan->price_quiz_applicant : 0;
        $qty_quiz = $request->total_quiz > $plan->quiz_applicant ? $request->total_quiz - $plan->quiz_applicant : $plan->quiz_applicant;
        $name_quiz = $request->total_quiz - $plan->quiz_applicant > 0 ? $plan->quiz_applicant.' (+'.ceil($request->total_quiz - $plan->quiz_applicant).')' : $plan->quiz_applicant;

        $price_per_psychoTest = $request->total_psychoTest > $plan->psychoTest_applicant ? $plan->price_psychoTest_applicant : 0;
        $qty_psychoTest = $request->total_psychoTest > $plan->psychoTest_applicant ? $request->total_psychoTest - $plan->psychoTest_applicant : $plan->psychoTest_applicant;
        $name_psychoTest = $request->total_psychoTest - $plan->psychoTest_applicant > 0 ? $plan->psychoTest_applicant.' (+'.ceil($request->total_psychoTest - $plan->psychoTest_applicant).')' : $plan->psychoTest_applicant;

        $arr_items[] = [
            'id' => 'PLAN-' . $request->plans_id,
            'price' => ceil($plan_price),
            'quantity' => 1,
            'name' => strtoupper($plan->name).' Package',
            'category' => 'Plans Built'
        ];

        $arr_items[] = [
            'id' => 'ADS-' . $plan->id,
            'price' => ceil($price_per_ads),
            'quantity' => ceil($qty_ads),
            'name' => 'Job Ads ['.$name_ads.']',
            'category' => 'Job Ads'
        ];

        if($plan->isQuiz == true) {
            $arr_items[] = [
                'id' => 'QUIZ-' . $request->plans_id,
                'price' => ceil($price_per_quiz),
                'quantity' => ceil($qty_quiz),
                'name' => 'Quiz Participant ['.$name_quiz.']',
                'category' => 'Participant/Applicant'
            ];
        }

        if($plan->isPsychoTest == true) {
            $arr_items[] = [
                'id' => 'PSYCHO-' . $request->plans_id,
                'price' => ceil($price_per_psychoTest),
                'quantity' => ceil($qty_psychoTest),
                'name' => 'Psycho Test Participant ['.$name_psychoTest.']',
                'category' => 'Participant/Applicant'
            ];
        }

        if ($request->discount > 0) {
            $arr_items[] = [
                'id' => 'DISC-' . strtoupper(uniqid(ConfirmAgency::count() + 1)),
                'price' => ceil($request->discount_price * -1),
                'quantity' => 1,
                'name' => 'Discount ' . $request->discount . '%'
            ];
        }

        return Snap::getSnapToken([
            'enabled_payments' => $this->channels,
            'transaction_details' => [
                'order_id' => strtoupper(uniqid(ConfirmAgency::count() + 1)),
                'gross_amount' => ceil($request->total_payment),
            ],
            'customer_details' => [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $agency->phone,
                'email' => $user->email,
                'address' => $agency->alamat,
                'billing_address' => [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'address' => $agency->alamat,
                    'phone' => $agency->phone,
                    'country_code' => 'IDN'
                ],
                'shipping_address' => [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'address' => $agency->alamat,
                    'phone' => $agency->phone,
                    'country_code' => 'IDN'
                ],
            ],
            'item_details' => $arr_items,
        ]);
    }

    public function unfinishCallback(Request $request)
    {
        $data_tr = collect(Transaction::status($request->transaction_id))->toArray();
        $code = $data_tr['order_id'];
        if ($data_tr['payment_type'] == 'credit_card') {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['card_type'];
            $account = $data_tr['masked_card'];

        } else if ($data_tr['payment_type'] == 'bank_transfer') {
            $type = $data_tr['payment_type'];

            if (array_key_exists('permata_va_number', $data_tr)) {
                $bank = 'permata';
                $account = $data_tr['permata_va_number'];
            } else {
                $bank = implode((array)$data_tr['va_numbers'][0]->bank);
                $account = implode((array)$data_tr['va_numbers'][0]->va_number);
            }

        } else if ($data_tr['payment_type'] == 'echannel') {
            $type = 'bank_transfer';
            $bank = 'mandiri';
            $account = $data_tr['bill_key'];

        } else if ($data_tr['payment_type'] == 'cstore') {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['store'];
            $account = $data_tr['payment_code'];

        } else {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['payment_type'];
            $account = null;
        }

        $user = User::find($request->user_id);
        $agency = $user->agencies;
        $vac_ids = $request->vacancy_ids;
        sort($vac_ids);

        $it = new \MultipleIterator();
        $it->attachIterator(new \ArrayIterator($vac_ids));
        $it->attachIterator(new \ArrayIterator($request->passing_grade));
        $it->attachIterator(new \ArrayIterator($request->quiz_applicant));
        $it->attachIterator(new \ArrayIterator($request->psychoTest_applicant));
        foreach ($it as $value) {
            $vacancy = Vacancies::find($value[0]);
            $vacancy->update([
                'plan_id' => $request->plans_id,
                'passing_grade' => $value[1] != 0.00 ? $value[1] : null,
                'quiz_applicant' => $value[2] != 0 ? $value[2] : null,
                'psychoTest_applicant' => $value[3] != 0 ? $value[3] : null,
            ]);
        }

        $confirmAgency = ConfirmAgency::firstOrCreate([
            'agency_id' => $agency->id,
            'plans_id' => $request->plans_id,
            'total_ads' => $request->total_ads,
            'vacancy_ids' => $request->vacancy_ids,
            'total_quiz' => $request->total_quiz,
            'total_psychoTest' => $request->total_psychoTest,
            'promo_code' => $request->promo_code,
            'is_discount' => !is_null($request->discount_price) ? 1 : 0,
            'discount' => $request->discount_price,
            'total_payment' => $request->total_payment,
            'payment_type' => $type,
            'payment_name' => $bank,
            'payment_number' => $account,
            'isPaid' => false,
        ]);
        $plan = $confirmAgency->getPlan;

        $date = $confirmAgency->created_at;
        $romanDate = RomanConverter::numberToRoman($date->format('y')).'/'. RomanConverter::numberToRoman($date->format('m'));

        $price_per_ads = Plan::find(1)->price - (Plan::find(1)->price * Plan::find(1)->discount / 100);

        $old_totalVacancy = array_sum(str_split(filter_var($plan->job_ads, FILTER_SANITIZE_NUMBER_INT)));
        $diffTotalVacancy = $confirmAgency->total_ads - $old_totalVacancy;
        $totalVacancy = $old_totalVacancy . "(+" . $diffTotalVacancy . ")";
        $price_totalVacancy = $diffTotalVacancy * $price_per_ads;

        $old_totalQuizApplicant = $plan->quiz_applicant;
        $diffTotalQuizApplicant = $confirmAgency->total_quiz - $old_totalQuizApplicant;
        $totalQuizApplicant = $old_totalQuizApplicant . "(+" . $diffTotalQuizApplicant . ")";
        $price_totalQuiz = $diffTotalQuizApplicant * $plan->price_quiz_applicant;

        $old_totalPsychoTest = $plan->psychoTest_applicant;
        $diffTotalPsychoTest = $confirmAgency->total_psychoTest - $old_totalPsychoTest;
        $totalPsychoTest = $old_totalPsychoTest . "(+" . $diffTotalPsychoTest . ")";
        $price_totalPsychoTest = $diffTotalPsychoTest * $plan->price_psychoTest_applicant;

        $data = array_replace($confirmAgency->toArray(), [
            'invoice' => '#INV/'.$confirmAgency->created_at->format('Ymd').'/'.$romanDate.'/'.$confirmAgency->id,
            'encryptID' => encrypt($confirmAgency->id),
            'payment_type' => strtoupper(str_replace('_',' ',$confirmAgency->payment_type)),
            'payment_type2' => $confirmAgency->payment_type,
            'payment_icon' => asset('images/paymentMethod/'.$confirmAgency->payment_name.'.png'),
            'expDay' => Carbon::parse($confirmAgency->created_at)->addDay()->format('l, j F Y'),
            'expTime' => Carbon::parse($confirmAgency->created_at)->addDay()->format('H:i'),
            'plans' => $plan,
            'plan_price' => $plan->discount > 0 ? $plan->price - ($plan->price * $plan->discount / 100) : $plan->price,
            'totalVacancy' => $totalVacancy,
            'price_totalVacancy' => $price_totalVacancy,
            'totalQuizApplicant' => $totalQuizApplicant,
            'price_totalQuiz' => $price_totalQuiz,
            'totalPsychoTest' => $totalPsychoTest,
            'price_totalPsychoTest' => $price_totalPsychoTest,
        ]);

        $this->invoiceMail($code, $user, $request->pdf_url, $data);

        return response()->json([
            'status' => true,
            'message' => 'We have sent your payment details to ' . $user->email . '. Your vacancy will be posted as soon as your payment is completed.',
            'data' => $data
        ], 200);
    }

    public function finishCallback(Request $request)
    {
        $data_tr = collect(Transaction::status($request->transaction_id))->toArray();
        $code = $data_tr['order_id'];

        try {
            if (!array_key_exists('fraud_status', $data_tr) ||
                (array_key_exists('fraud_status', $data_tr) && $data_tr['fraud_status'] == 'accept')) {

                if ($data_tr['payment_type'] == 'credit_card' &&
                    ($data_tr['transaction_status'] == 'capture' || $data_tr['transaction_status'] == 'settlement')) {

                    // same process with unfinish

                    $this->updatePayment($code);

                    return response()->json([
                        'status' => true,
                        'message' => 'We have sent your payment details to ' . $user->email . '. Your vacancy will be posted soon.',
                        'data' => $data
                    ], 200);
                }
            }

        } catch (\Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    public function notificationCallback()
    {
        $notif = new Notification();
        $data_tr = collect(Transaction::status($notif->transaction_id))->toArray();

        try {
            if (!array_key_exists('fraud_status', $data_tr) ||
                (array_key_exists('fraud_status', $data_tr) && $data_tr['fraud_status'] == 'accept')) {

                if ($data_tr['payment_type'] != 'credit_card' &&
                    ($data_tr['transaction_status'] == 'capture' || $data_tr['transaction_status'] == 'settlement')) {

                    // same process with unfinish

                    $this->updatePayment($notif->order_id);

                    return response()->json([
                        'status' => true,
                        'message' => 'We have sent your payment details to ' . $user->email . '. Your vacancy will be posted soon.',
                        'data' => $data
                    ], 200);
                }
            }

        } catch (\Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    private function updatePayment($code)
    {
       // ADMIN APPROVE
    }

    private function invoiceMail($code, $user, $pdf_url, $data)
    {
        if (!is_null($pdf_url)) {
            $instruction = $code . '-instruction.pdf';
            Storage::put('public/users/agencies/payment/' . $instruction, file_get_contents($pdf_url));
        } else {
            $instruction = null;
        }

        Mail::to($user->email)->send(new InvoiceMail($code, $data, $instruction));
    }
}
