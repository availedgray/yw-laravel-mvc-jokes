<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Joke extends Model
{
    /** @use HasFactory<\Database\Factories\JokeFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'title',
        'text',
        'author_id',
        'category_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
