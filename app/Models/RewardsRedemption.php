<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardsRedemption extends Model
{
    use SoftDeletes;

    protected $table = "rewards_redemption";
}
