<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = "members";
//    TODO this should be the logged in user
//    protected $attributes = array (
//        'updatedByUserId'  => ''
//    );

    public static $_salutation = [
            1 => 'Dr',
            2 => 'Mr',
            3 => 'Ms',
            4 => 'Mrs',
            5 => 'Mdm'
        ];
    public static $_gender = [1 => 'Male', 2 => 'Female'];
    public static $_memberType = [
            1 => 'Basic',
            2 => 'Silver',
            3 => 'Gold',
            4 => 'Platinum'
        ];

    /**
     * Get the transactions for the member.
     */
    public function transaction()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    /**
     * Get the transactions for the member.
     */
    public function loyaltyPoints()
    {
        return $this->hasMany('App\Models\MemberPoints');
    }
}
