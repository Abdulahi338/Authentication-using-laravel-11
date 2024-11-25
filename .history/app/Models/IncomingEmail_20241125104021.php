<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingEmail extends Model
{
    protected $fillable = ['user_id',  'subject', 'content', 'received_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

