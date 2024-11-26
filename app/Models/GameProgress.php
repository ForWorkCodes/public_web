<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameProgress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'level', 'score', 'data'];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
