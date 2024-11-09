<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    protected $fillable = ['email_id', 'file_path', 'file_name'];

    public function email()
    {
        return $this->belongsTo(OutgoingEmail::class, 'email_id');
    }
}

