<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'modul1','modul2','modul3','modul4'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
