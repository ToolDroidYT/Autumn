<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'program', 'status', 'closes_at'];

    protected function casts(): array
    {
        return ['closes_at' => 'datetime'];
    }

    public function options(): HasMany
    {
        return $this->hasMany(VoteOption::class);
    }
}
