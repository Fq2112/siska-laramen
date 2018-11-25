<?php

namespace App\Http\Controllers\Agencies;

use App\Agencies;
use App\Carousel;
use App\Cities;
use App\ConfirmAgency;
use App\Events\Agencies\VacancyPaymentDetails;
use App\FavoriteAgency;
use App\FungsiKerja;
use App\Industri;
use App\Invitation;
use App\JobLevel;
use App\JobType;
use App\Jurusanpend;
use App\PaymentCategory;
use App\PaymentMethod;
use App\Plan;
use App\Provinces;
use App\Salaries;
use App\Seekers;
use App\Support\RomanConverter;
use App\Tingkatpend;
use App\User;
use App\Vacancies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'agency'])->except(['index', 'showProfile']);
    }

    public function index()
    {
        $provinces = Provinces::all();
        $carousels = Carousel::all();
        $plans = Plan::all();

        return view('home-agency', compact('provinces', 'carousels', 'plans'));
    }

    public function showProfile($id)
    {
        $provinces = Provinces::all();
        $agency = Agencies::findOrFail($id);
        $user = User::find($agency->user_id);
        $industry = Industri::find($agency->industri_id);
        $vacancies = Vacancies::where('agency_id', $agency->id)->where('isPost', true)->orderByDesc('updated_at')->get();
        $likes = FavoriteAgency::where('agency_id', $agency->id)->where('isFavorite', true)->count();

        return view('_agencies.profile-agency', compact('provinces', 'agency', 'user', 'industry',
            'vacancies', 'likes'));
    }

    public function downloadSeekerAttachments($files)
    {
        $file_path = public_path('storage/users/seekers/attachments/' . $files);
        return response()->download($file_path);
    }

    public function inviteSeeker(Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $vacancy = Vacancies::find($request->vacancy_id);
        $seeker = Seekers::find($request->seeker_id);
        $seekerName = User::find($seeker->user_id)->name;
        $inv = Invitation::where('seeker_id', $seeker->id)->where('agency_id', $agency->id);

        if (count($inv->get()) == 0) {
            Invitation::create([
                'agency_id' => $agency->id,
                'vacancy_id' => $vacancy->id,
                'seeker_id' => $seeker->id,
                'isInvite' => true,
            ]);

            return back()->with('seeker', '' . $seekerName . ' is successfully invited for ' . $vacancy->judul . '!');

        } else {
            $inv->first()->delete();

            return back()->with('seeker', 'Invitation for ' . $seekerName . ' is successfully aborted!');
        }
    }

    public function showJobPosting($id)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $paymentCategories = PaymentCategory::all();
        $vacancies = Vacancies::where('agency_id', $agency->id)->where('isPost', false)->orderByDesc('id')->get();

        $plan = Plan::find(decrypt($id));
        $totalAds = array_sum(str_split(filter_var($plan->job_ads, FILTER_SANITIZE_NUMBER_INT)));
        $price = $plan->price - ($plan->price * $plan->discount / 100);

        return view('_agencies.form-jobPosting', compact('agency', 'paymentCategories', 'vacancies',
            'plan', 'totalAds', 'price'));
    }

    public function getVacancyCheck($id)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $vacancies = Vacancies::where('agency_id', $agency->id);

        $plan = Plan::find($id);
        $number = filter_var($plan->job_ads, FILTER_SANITIZE_NUMBER_INT);
        $totalAds = array_sum(str_split($number));

        if ($vacancies->count() > 0) {
            if ($vacancies->where('isPost', false)->count() > 0) {
                if ($vacancies->where('isPost', false)->count() >= $totalAds) {
                    return 3;

                } else {
                    return 2;
                }

            } else {
                return 1;
            }

        } else {
            return 0;
        }
    }

    public function getVacancyReviewData($vacancy)
    {
        $vac_ids = '';
        foreach ((array)$vacancy as $select) {
            $vac_ids .= $select . ', ';
        }
        $vac_ids = explode(",", substr($vac_ids, 0, -2));
        $vacancies = Vacancies::whereIn('id', $vac_ids)->get()->toArray();

        $i = 0;
        foreach ($vacancies as $row) {
            if (substr(Cities::find($row['cities_id'])->name, 0, 2) == "Ko") {
                $cities = substr(Cities::find($row['cities_id'])->name, 5);
            } else {
                $cities = substr(Cities::find($row['cities_id'])->name, 10);
            }

            $userAgency = User::findOrFail(Agencies::findOrFail($row['agency_id'])->user_id);
            if ($userAgency->ava == "agency.png" || $userAgency->ava == "") {
                $filename = asset('images/agency.png');
            } else {
                $filename = asset('storage/users/' . $userAgency->ava);
            }

            $city = array('city' => $cities);
            $degrees = array('degrees' => Tingkatpend::findOrFail($row['tingkatpend_id'])->name);
            $majors = array('majors' => Jurusanpend::findOrFail($row['jurusanpend_id'])->name);
            $jobfunc = array('job_func' => FungsiKerja::findOrFail($row['fungsikerja_id'])->nama);
            $industry = array('industry' => Industri::findOrFail($row['industry_id'])->nama);
            $jobtype = array('job_type' => JobType::findOrFail($row['jobtype_id'])->name);
            $joblevel = array('job_level' => JobLevel::findOrFail($row['joblevel_id'])->name);
            $salary = array('salary' => Salaries::findOrFail($row['salary_id'])->name);
            $ava['user'] = array('ava' => $filename, 'name' => $userAgency->name);
            $update_at = array('updated_at' => Carbon::createFromFormat('Y-m-d H:i:s',
                $row['updated_at'])->diffForHumans());

            $vacancies[$i] = array_replace($ava, $vacancies[$i], $city, $degrees, $majors, $jobfunc, $industry,
                $jobtype, $joblevel, $salary, $update_at);

            $i = $i + 1;
        }

        return $vacancies;
    }

    public function getPlansReviewData($plan)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();
        $vacancies = Vacancies::where('agency_id', $agency->id)->where('isPost', false)->count();

        $plans = Plan::find($plan)->toArray();
        $totalAds = array_sum(str_split(filter_var($plans['job_ads'], FILTER_SANITIZE_NUMBER_INT)));
        $price = $plans['price'] - ($plans['price'] * $plans['discount'] / 100);
        $plans = array_replace($plans, array('total_vac' => $vacancies), array('job_ads' => $totalAds),
            array('main_feature' => $plans['job_ads']),
            array('price' => $price),
            array('rp_price' => number_format($price, 2, ',', '.')));

        return $plans;
    }

    public function getPaymentMethod($id)
    {
        return PaymentMethod::find($id);
    }

    public function submitJobPosting(Request $request)
    {
        $user = Auth::user();
        $agency = Agencies::where('user_id', $user->id)->firstOrFail();

        $it = new \MultipleIterator();
        $it->attachIterator(new \ArrayIterator($request->vacancy_ids));
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

        $confirmAgency = ConfirmAgency::create([
            'agency_id' => $agency->id,
            'plans_id' => $request->plans_id,
            'total_ads' => $request->total_ads,
            'vacancy_ids' => $request->vacancy_ids,
            'total_quiz' => $request->total_quiz,
            'total_psychoTest' => $request->total_psychoTest,
            'payment_method_id' => $request->pm_id,
            'payment_code' => strtoupper($request->payment_code),
            'cc_number' => $request->number,
            'cc_name' => $request->name,
            'cc_expiry' => $request->expiry,
            'cc_cvc' => $request->cvc,
            'total_payment' => $request->total_payment,
        ]);

        $this->paymentDetailsMail($confirmAgency);

        return back()->withInput(Input::all())->with([
            'jobPosting' => 'We have sent your payment details to ' . $user->email . '. Your vacancy will be posted as soon as your payment is completed.',
            'confirmAgency' => $confirmAgency,
            'posting_id' => $confirmAgency->id
        ]);
    }

    private function paymentDetailsMail($confirmAgency)
    {
        $pm = PaymentMethod::find($confirmAgency->payment_method_id);
        $pc = PaymentCategory::find($pm->payment_category_id);
        $pl = Plan::find($confirmAgency->plans_id);

        $plan_price = $pl->price - ($pl->price * $pl->discount / 100);
        $price_per_ads = Plan::find(1)->price - (Plan::find(1)->price * Plan::find(1)->discount / 100);

        $old_totalVacancy = array_sum(str_split(filter_var($pl->job_ads, FILTER_SANITIZE_NUMBER_INT)));
        $diffTotalVacancy = $confirmAgency->total_ads - $old_totalVacancy;
        $totalVacancy = $old_totalVacancy . "(+" . $diffTotalVacancy . ")";
        $price_totalVacancy = $diffTotalVacancy * $price_per_ads;

        $old_totalQuizApplicant = $pl->quiz_applicant;
        $diffTotalQuizApplicant = $confirmAgency->total_quiz - $old_totalQuizApplicant;
        $totalQuizApplicant = $old_totalQuizApplicant . "(+" . $diffTotalQuizApplicant . ")";
        $price_totalQuiz = $diffTotalQuizApplicant * $pl->price_quiz_applicant;

        $old_totalPsychoTest = $pl->psychoTest_applicant;
        $diffTotalPsychoTest = $confirmAgency->total_psychoTest - $old_totalPsychoTest;
        $totalPsychoTest = $old_totalPsychoTest . "(+" . $diffTotalPsychoTest . ")";
        $price_totalPsychoTest = $diffTotalPsychoTest * $pl->price_psychoTest_applicant;

        $data = [
            'confirmAgency' => $confirmAgency,
            'payment_method' => $pm,
            'payment_category' => $pc,
            'plans' => $pl,
            'plan_price' => $plan_price,
            'totalVacancy' => $totalVacancy,
            'price_totalVacancy' => $price_totalVacancy,
            'totalQuizApplicant' => $totalQuizApplicant,
            'price_totalQuiz' => $price_totalQuiz,
            'totalPsychoTest' => $totalPsychoTest,
            'price_totalPsychoTest' => $price_totalPsychoTest,
        ];
        event(new VacancyPaymentDetails($data));
    }

    public function invoiceJobPosting($id)
    {
        $confirmAgency = ConfirmAgency::find(decrypt($id));
        $vac_ids = ConfirmAgency::where('id', decrypt($id))->pluck('vacancy_ids')->toArray();
        $vacancies = Vacancies::whereIn('id', $vac_ids[0])->get();
        $agency = Agencies::find($confirmAgency->agency_id);
        $user = User::find($agency->user_id);

        $pm = PaymentMethod::find($confirmAgency->payment_method_id);
        $pc = PaymentCategory::find($pm->payment_category_id);
        $pl = Plan::find($confirmAgency->plans_id);

        $plan_price = $pl->price - ($pl->price * $pl->discount / 100);
        $price_per_ads = Plan::find(1)->price - (Plan::find(1)->price * Plan::find(1)->discount / 100);

        $old_totalVacancy = array_sum(str_split(filter_var($pl->job_ads, FILTER_SANITIZE_NUMBER_INT)));
        $diffTotalVacancy = $confirmAgency->total_ads - $old_totalVacancy;
        $totalVacancy = $old_totalVacancy . "(+" . $diffTotalVacancy . ")";
        $price_totalVacancy = $diffTotalVacancy * $price_per_ads;

        $old_totalQuizApplicant = $pl->quiz_applicant;
        $diffTotalQuizApplicant = $confirmAgency->total_quiz - $old_totalQuizApplicant;
        $totalQuizApplicant = $old_totalQuizApplicant . "(+" . $diffTotalQuizApplicant . ")";
        $price_totalQuiz = $diffTotalQuizApplicant * $pl->price_quiz_applicant;

        $old_totalPsychoTest = $pl->psychoTest_applicant;
        $diffTotalPsychoTest = $confirmAgency->total_psychoTest - $old_totalPsychoTest;
        $totalPsychoTest = $old_totalPsychoTest . "(+" . $diffTotalPsychoTest . ")";
        $price_totalPsychoTest = $diffTotalPsychoTest * $pl->price_psychoTest_applicant;

        $date = Carbon::parse($confirmAgency->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));
        $invoice = 'INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $confirmAgency->id;

        return view('_agencies.inv-jobPosting', compact('confirmAgency', 'vacancies', 'agency', 'user',
            'pm', 'pc', 'pl', 'plan_price', 'totalVacancy', 'price_per_ads', 'price_totalVacancy', 'totalQuizApplicant',
            'price_totalQuiz', 'totalPsychoTest', 'price_totalPsychoTest', 'invoice'));
    }

    public function uploadPaymentProof(Request $request)
    {
        $confirmAgency = ConfirmAgency::find($request->confirmAgency_id);

        $payment_proof = $request->file('payment_proof');
        $name = $payment_proof->getClientOriginalName();

        if ($confirmAgency->payment_proof != '') {
            Storage::delete('public/users/agencies/payment/' . $confirmAgency->payment_proof);
        }

        $request->payment_proof->storeAs('public/users/agencies/payment', $name);

        $confirmAgency->update([
            'payment_proof' => $name
        ]);

        return $name;
    }

    public function deleteJobPosting($id)
    {
        $confirmAgency = ConfirmAgency::find(decrypt($id));
        $date = Carbon::parse($confirmAgency->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));
        $invoice = '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $confirmAgency->id;
        $confirmAgency->delete();

        return redirect()->route('agency.vacancy.status')
            ->with('delete', 'Invoice ' . $invoice . ' is successfully deleted!');
    }
}
