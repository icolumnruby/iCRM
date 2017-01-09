<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoyaltyConfig extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $table = "loyalty_config";

    public static $_action = [
            1 => 'Purchase',
            2 => 'Sign Up',
            3 => 'Birthday Bonus',
            4 => 'Redemption',
            5 => 'Membership Expired'
        ];

    public function checkPurchasePoints($companyId)
    {
        $points = $this::where([
                ['is_active', 'Y'],
                ['company_id', $companyId],
                ['expiry', $companyId]
            ])->get();

        $results = DB::select(
                DB::raw("SELECT * FROM $this->table WHERE is_active = 'Y' AND"
                        . "companyId = :companyId AND (expiry = '-' OR expiry => )"), array(
            'companyId' => $companyId,
        ));
    }
}
