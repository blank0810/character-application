<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_url',
        'character_name',
        'character_gender',
        'character_height',
        'character_hair_color',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
