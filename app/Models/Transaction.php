<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = "transactions";
    protected $dates = ['deleted_at'];

    public static $_paymentMode = [
            1 => 'CASH',
            2 => 'NETS',
            3 => 'Credit Card',
            4 => 'Debit Card',
            5 => 'Cheque',
            6 => 'Mobile'
        ];
    public static $_paymentType = [
        2 => [
            1 => 'NETS Cash Card',
            2 => 'NETS FlashPay',
            3 => 'NETS Debit'
        ],
        3 => [
            4 => 'VISA',
            5 => 'Master',
            6 => 'AMEX',
            7 => 'Diner\'s Club'
        ],
        4 => [
            8 => 'VISA',
            9 => 'Master'
        ],
        6 => [
            10 => 'Apple Pay',
            11 => 'Samsung Pay',
            12 => 'Dash',
            13 => 'DBS Paylah',
            14 => 'GoogleWallet',
            15 => 'Alipay',
            16 => 'WeChat'
        ]
    ];
    public static $_status = [
            1 => 'Successful',
            2 => 'Void'
        ];

    public function member()
    {
        return $this->belongsTo('App\Models\Member');
    }
}
