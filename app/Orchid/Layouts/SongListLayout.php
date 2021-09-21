<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Song;
use App\Models\Album;
use Orchid\Screen\Actions\Link;

class SongListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'songs';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('img_url', 'Image')
                ->render(function (Song $song) {
                    $src = $song->img_url;
                    return "<img src='{$src}' alt='Song Image' width='100' height='100'>";
                }),
            TD::make('name', 'Name')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Song $song) {
                    return Link::make($song->name)
                                ->route('platform.song.edit', $song);
                }),
            TD::make('song_url', 'Song URL')
                ->render(function (Song $song) {
                    $src = $song->song_url;
                    return $src;
                }),
            TD::make('frequency', 'Image')
                ->render(function (Song $song) {
                    return $song->frequency;
                }),
            TD::make('album_id', 'Album')
                ->render(function (Song $song) {
                        $albumid = $song->album_id;
                        $album = Album::find($albumid);
                        $albumname = is_null($album) ? "Chưa có" : $album->name;
                        return $albumname;
                    }),
            TD::make('created_at', 'Created')
                ->render(function (Song $song) {
                    return date_format($song->created_at, 'Y-m-d');
                }),
            TD::make('updated_at', 'Last edit')
                ->render(function (Song $song) {
                    return date_format($song->updated_at, 'Y-m-d H:i:s');
                }),

        ];
    }
}
