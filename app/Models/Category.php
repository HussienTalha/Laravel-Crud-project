<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
