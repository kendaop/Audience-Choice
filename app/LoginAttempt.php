<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $table = 'login_attempts';
    protected $primaryKey = 'ip_address';

    public function resetAttempts()
    {
        $this->attempts = 0;
        $this->save();
    }
}
