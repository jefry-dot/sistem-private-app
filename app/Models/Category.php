<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
