<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'modul','username','question'
    ];

    public function comment() {
        return $this->hasMany(Comment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
