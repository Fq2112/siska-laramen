<?php

use Illuminate\Database\Seeder;
use App\PaymentMethod;
use App\PaymentCategory;
use Faker\Factory;

class PaymentMethodSeeder extends Seeder
{
    const METHOD = [
        'ATM/Bank Transfer' => [
            'BCA',
            'BNI',
            'BRI',
            'BTN',
            'Mandiri',
        ],
        'E-Banking' => [
            'BCA KlikPay',
            'BNI Debit Online',
            'e-Banking BRI',
            'Debit BTN Online',
            'Mandiri ClickPay',
        ],
        'Credit Card' => [
            'Credit Card'
        ],
        'Convenience Store' => [
            'Alfamart',
            'Alfamidi',
            'Indomaret',
        ],
        'E-Wallet' => [
            'Doku Wallet',
            'Kredivo',
            'PayPal',
            'Stripe',
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        $i = 0;
        foreach (static::METHOD as $method => $payment_category) {
            $cat = PaymentCategory::create([
                'name' => $method,
                'caption' => $faker->sentence($nbWords = 8, $variableNbWords = true)
            ]);

            foreach ($payment_category as $category) {
                $i = $i + 1;
                PaymentMethod::create([
                    'logo' => 'pm' . $i . '.png',
                    'name' => $category,
                    'payment_category_id' => $cat->id,
                    'account_name' => 'PT. SISKA',
                    'account_number' => $faker->bankAccountNumber,
                ]);
            }
        }

        PaymentCategory::find(1)->update([
            'caption' => 'Pay safely and securely with your bank account'
        ]);
        PaymentCategory::find(2)->update([
            'caption' => 'Pay safely and securely with your bank account'
        ]);
        PaymentCategory::find(3)->update([
            'caption' => 'Pay safely and securely with your credit card'
        ]);
        PaymentCategory::find(4)->update([
            'caption' => 'Pay without sharing your payment information'
        ]);
        PaymentCategory::find(5)->update([
            'caption' => 'Pay without sharing your payment information'
        ]);

        PaymentMethod::where('payment_category_id', '!=', 1)->update([
            'account_name' => null,
            'account_number' => null,
        ]);
    }
}
