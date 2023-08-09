<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SemanticNetworkWord extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function Words(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(Word::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('word_id');
    }
}
