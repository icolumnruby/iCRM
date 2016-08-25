<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactLangSpoken extends Model
{
    protected $table = "contact_lang_spoken";

    /**
     * Get the post that owns the comment.
     */
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact');
    }
}
