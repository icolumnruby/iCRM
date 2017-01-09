<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $table = "company";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  protected $fillable = ['company_code', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the branches.
     */
    public function branches()
    {
        return $this->hasMany('App\Models\Branch');
    }
}
