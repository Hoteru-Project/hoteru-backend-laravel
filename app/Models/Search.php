<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;

    protected $fillable = [
        "search",
        "type",
        "count"
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
