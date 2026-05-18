<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteOption extends Model
{
    use HasFactory;

    protected $fillable = ['vote_id', 'label', 'image_path', 'votes_count'];

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }
}
