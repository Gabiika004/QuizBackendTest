<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userboost extends Model
{
    use HasFactory;

    // Kapcsolat a User modellhez
    public function user() {
        return $this->belongsTo(User::class, 'userid');
    }

    // Kapcsolat a Booster modellhez
    public function booster() {
        return $this->belongsTo(Booster::class, 'boosterid');
    }
}
