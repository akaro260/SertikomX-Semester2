<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'photo',
        'status',
        'admin_response',
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 

    

}