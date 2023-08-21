<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'request_id',
        'status',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
