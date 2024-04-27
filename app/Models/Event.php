<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $fillable = [
        'name',
        'description',
        'date',
        'time',
        'location',
        'max_capacity',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
