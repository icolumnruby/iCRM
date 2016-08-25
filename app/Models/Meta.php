<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "meta";

    public static $_type = array(
        1 => 'Short text',
        2 => 'Long text',
        3 => 'Dropdown',
        4 => 'Radio button',
        5 => 'Multiple Choice Checkbox',
        6 => 'Date',
        7 => 'Email',
        8 => 'Number',
    );

    /**
     * Get the details for the contact.
     */
    public function options()
    {
        return $this->hasMany('App\Models\MetaOption');
    }
}
