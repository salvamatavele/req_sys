<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'doc_name',
        'phone',
        'doc',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(UserRequest::class);
    }
    public function discharge()
    {
        return $this->hasOne(Discharge::class);
    }
}
