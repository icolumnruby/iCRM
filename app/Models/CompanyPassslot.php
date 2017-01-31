<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPassslot extends Model
{
    use SoftDeletes;
    protected $table = "company_passslot";
    protected $primaryKey = 'passslot_id';

    /**
     * Get the brand that owns the pass template.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
