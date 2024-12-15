<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginActivityLog extends Model
{
    
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'login_at', 'logout_at', 'login_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
