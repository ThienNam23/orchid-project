<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Artist;
use App\Orchid\Layouts\ArtistListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;

class ArtistListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Artist List';
    
    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Artist List';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'artists' => Artist::filters()->paginate()
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
                ->route('platform.artist.edit')
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
            ArtistListLayout::class,
        ];
    }
}
