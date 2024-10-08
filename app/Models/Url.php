<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','title','long_url', 'short_code', 'visits'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
