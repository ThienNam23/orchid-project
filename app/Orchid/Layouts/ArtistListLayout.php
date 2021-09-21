<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Artist;
use Orchid\Screen\Actions\Link;

class ArtistListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'artists';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('img_url', 'Image')
                ->render(function (Artist $artist) {
                    $src = $artist->img_url;
                    return "<img src='{$src}' alt='Artist Image' width='100' height='100'>";
                }),
                
            TD::make('name', 'Name')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Artist $artist) {
                    return Link::make($artist->name)
                                ->route('platform.artist.edit', $artist);
                }),

            TD::make('birthday', 'Birthday')
                ->render(function (Artist $artist) {
                    return $artist->birthday;
                }),

            TD::make('description', 'Description')
                ->render(function (Artist $artist) {
                    return $artist->description;
                }),

            TD::make('created_at', 'Created')
                ->render(function (Artist $artist) {
                    return date_format($artist->created_at, 'Y-m-d');
                }),
            TD::make('updated_at', 'Last edit')
                ->render(function (Artist $artist) {
                    return date_format($artist->updated_at, 'Y-m-d H:i:s');
                }),

        ];
    }
}
