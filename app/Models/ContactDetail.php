<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    protected $table = "contact_detail";
    public $timestamps = false;

    /**
     * Get the post that owns the comment.
     */
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact');
    }
}
