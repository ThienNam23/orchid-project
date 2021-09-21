<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Orchid\App\Song;

class Category extends Model
{
    use HasFactory, AsSource, Filterable;
    /**
     * 
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * 
     */
    protected $allowedSorts = [
        'name'
    ];

    /**
     * 
     */
    protected $allowedFilters = [
        'name'
    ];

    public function songs() {
        return $this->belongsToMany(Song::class, 'song_categories', 'category_id', 'song_id');
    }
}
