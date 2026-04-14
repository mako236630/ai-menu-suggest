<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'recipe_text',
        'ingredients',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
