<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberPoints extends Model
{
    protected $table = "member_points";

    public static function _getPoints($memberId)
    {
        //get the member's loyalty points
        $memberPointsModel = MemberPoints::where([
                ['member_points.member_id', $memberId],
                ['member_points.deleted_at', NULL],
            ])
            ->orderBy('member_points.created_at', 'desc')
            ->limit(1)
            ->get();

        $totalPoints = 0;
        if (count($memberPointsModel)) {
            $totalPoints = $memberPointsModel[0]->points_balance ? $memberPointsModel[0]->points_balance : 0;
        }

        return $totalPoints;
    }

}
