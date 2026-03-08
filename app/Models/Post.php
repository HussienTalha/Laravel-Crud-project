<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Category|null $category
 */
class Post extends Model
{
    /**
     * @use HasFactory<PostFactory>
     */
    use HasFactory;

    protected $fillable = [
        'title',
        'post',
        'status',
        'user_id',
        'category_id',
        'image',
    ];

    /**
     * Summary of user
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 
     * 
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
