<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use App\Models\Song;

class Artist extends Model
{
    use HasFactory, AsSource, Filterable;
    /**
     * 
     */
    protected $fillable = [
        'name',
        'img_url',
        'description',
        'birthday'
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
        return $this->belongsToMany(Song::class, 'song_artists', 'artist_id', 'song_id');
    }
}
