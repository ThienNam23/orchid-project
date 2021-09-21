<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Album;
use Orchid\Screen\Actions\Link;

class AlbumListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'albums';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('img_url', 'Image')
                ->render(function (Album $album) {
                    $src = $album->img_url;
                    return "<img src='{$src}' alt='Album Image' width='100' height='100'>";
                }),
            TD::make('name', 'Name')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Album $album) {
                    return Link::make($album->name)
                                ->route('platform.album.edit', $album);
                }),

            TD::make('description', 'Description')
                ->render(function (Album $album) {
                    return $album->description;
                }),

            TD::make('created_at', 'Created')
                ->render(function (Album $album) {
                    return date_format($album->created_at, 'Y-m-d');
                }),
            TD::make('updated_at', 'Last edit')
                ->render(function (Album $album) {
                    return date_format($album->updated_at, 'Y-m-d H:i:s');
                }),

        ];
    }
}
