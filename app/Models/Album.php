<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Laravel\Scout\Searchable;
use App\Orchid\Presenters\AlbumPresenter;
use App\Models\Song;

class Album extends Model
{
    use HasFactory, AsSource, Attachable, Filterable, Searchable;

    /**
     * 
     */
    protected $fillable = [
        'name',
        'img_url',
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

    /**
     * Get the presenter for the model.
     *
     * @return IdeaPresenter
     */
    public function presenter()
    {
        return new AlbumPresenter($this);
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

    public function songs() {
        return $this->hasMany(Song::class);
    }
}
