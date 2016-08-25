<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaOption extends Model
{
    protected $table = "meta_options";
    public $timestamps = false;

    /**
     * Get the post that owns the options.
     */
    public function meta()
    {
        return $this->belongsTo('App\Models\Meta');
    }
}
