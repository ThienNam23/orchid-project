<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use App\Orchid\Presenters\SongPresenter;
use App\Models\Artist;
use App\Models\Category;
use App\Models\Album;


class Song extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    /**
     * 
     */
    protected $fillable = [
        'name',
        'img_url',
        'song_url',
        'album_id'
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
        'album_id',
        'name'
    ];

    /**
     * Get the presenter for the model.
     *
     * @return SongPresenter
     */
    public function presenter()
    {
        return new SongPresenter($this);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'song_artists', 'song_id', 'artist_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'song_categories', 'song_id', 'category_id');
    }

    public function album() {
        return $this->belongsTo(Album::class);
    }
}
