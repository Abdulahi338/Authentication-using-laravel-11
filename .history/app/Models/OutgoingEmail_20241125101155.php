<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingEmail extends Model
{
    protected $fillable = [
        'user_id',
        'from',
        'to',
        'subject',
        'content',
        'sent_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

