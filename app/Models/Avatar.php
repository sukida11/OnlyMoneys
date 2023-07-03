<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'url',
        'user_id'
    ];

    public $timestamps = false;

    protected $guarded = false;
    protected $table = 'avatars';
}
