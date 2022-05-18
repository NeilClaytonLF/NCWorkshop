<?php

namespace App\Models;

use App\Models\Traits\EnumValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, EnumValue;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'state'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
