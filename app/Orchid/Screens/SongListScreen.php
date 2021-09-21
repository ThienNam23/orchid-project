<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Song;
use App\Orchid\Layouts\SongListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;

class SongListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Song List';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Song List';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'songs' => Song::filters()->defaultSort('name')->paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.song.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            SongListLayout::class,
        ];
    }
}
