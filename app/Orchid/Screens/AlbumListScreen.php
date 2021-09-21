<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Album;
use App\Orchid\Layouts\AlbumListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;

class AlbumListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Album List';
    
    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Album List';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'albums' => Album::filters()->paginate()
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
                ->route('platform.album.edit')
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
            AlbumListLayout::class,
        ];
    }
}
