<?php

use Illuminate\Database\Seeder;

class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('payment_type')->delete();   //delete payment_type table records
        DB::table('payment_type')->insert(array(
            ['name' => 'American Express', 'is_active' => 'Y' ],
            ['name' => 'ANZ MasterCard', 'is_active' => 'Y' ],
            ['name' => 'ANZ Visa', 'is_active' => 'Y' ],
            ['name' => 'Bank of China MasterCard', 'is_active' => 'Y' ],
            ['name' => 'Bank of China Visa', 'is_active' => 'Y' ],
            ['name' => 'CapitaCard MasterCard Debit Card', 'is_active' => 'Y' ],
            ['name' => 'CapitaCard Visa Platinum Card', 'is_active' => 'Y' ],
            ['name' => 'Cash', 'is_active' => 'Y' ],
            ['name' => 'Cash Card', 'is_active' => 'Y' ],
            ['name' => 'China Union Pay', 'is_active' => 'Y' ],
            ['name' => 'CIMB MasterCard', 'is_active' => 'Y' ],
            ['name' => 'CIMB Visa', 'is_active' => 'Y' ],
            ['name' => 'Citibank Amex', 'is_active' => 'Y' ],
            ['name' => 'Citibank MasterCard', 'is_active' => 'Y' ],
            ['name' => 'Citibank Rewards MasterCard', 'is_active' => 'Y' ],
            ['name' => 'Citibank Rewards Visa', 'is_active' => 'Y' ],
            ['name' => 'Citibank Visa', 'is_active' => 'Y' ],
            ['name' => 'DBS Amex Card', 'is_active' => 'Y' ],
            ['name' => 'DBS MasterCard', 'is_active' => 'Y' ],
            ['name' => 'DBS Visa', 'is_active' => 'Y' ],
            ['name' => 'Diners Club', 'is_active' => 'Y' ],
            ['name' => 'EZ-Link', 'is_active' => 'Y' ],
            ['name' => 'HSBC MasterCard', 'is_active' => 'Y' ],
            ['name' => 'HSBC Visa', 'is_active' => 'Y' ],
            ['name' => 'Maybank MasterCard', 'is_active' => 'Y' ],
            ['name' => 'Maybank Visa', 'is_active' => 'Y' ],
            ['name' => 'NETS', 'is_active' => 'Y' ],
            ['name' => 'OCBC MasterCard', 'is_active' => 'Y' ],
            ['name' => 'OCBC Visa', 'is_active' => 'Y' ],
            ['name' => 'Other Credit Card', 'is_active' => 'Y' ],
            ['name' => 'Other MasterCard', 'is_active' => 'Y' ],
            ['name' => 'Other Visa', 'is_active' => 'Y' ],
            ['name' => 'POSB MasterCard', 'is_active' => 'Y' ],
            ['name' => 'Prepaid Card', 'is_active' => 'Y' ],
            ['name' => 'RBS/ABN AMRO MasterCard', 'is_active' => 'Y' ],
            ['name' => 'RBS/ABN AMRO Visa', 'is_active' => 'Y' ],
            ['name' => 'Standard Chartered MasterCard', 'is_active' => 'Y' ],
            ['name' => 'Standard Chartered Visa', 'is_active' => 'Y' ],
            ['name' => 'UOB Amex Card', 'is_active' => 'Y' ],
            ['name' => 'UOB JCB', 'is_active' => 'Y' ],
            ['name' => 'UOB Lady\'s Card', 'is_active' => 'Y' ],
            ['name' => 'UOB MasterCard', 'is_active' => 'Y' ],
            ['name' => 'UOB Visa', 'is_active' => 'Y' ]
        ));
    }

}
