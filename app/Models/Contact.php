<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = "contacts";
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
            1 => 'Platinum',
            2 => 'Gold'
        ];

    /**
     * Get the transactions for the contact.
     */
    public function transaction()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
