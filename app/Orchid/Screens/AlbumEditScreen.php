<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Album;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Cropper;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AlbumEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Album';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Album Edit';

    /**
     * 
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Album $album): array
    {
        $this->exists = $album->exists;

        if ($this->exists) {
            $this->name = 'Edit Album';
        }

        return [
            'album' => $album
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
            Button::make('Create Album')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Delete')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
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
            Layout::rows([
                Input::make('album.name')
                    ->title('Name')
                    ->placeholder('Album name')
                    ->help('Enter your album name')
                    ->required(),

                TextArea::make('album.description')
                    ->rows(5)
                    ->title('Description')
                    ->placeholder('Album description')
                    ->help('Enter your album Description'),

                Cropper::make('album.img_url')
                    ->title('Large album image')
                    ->targetRelativeUrl()
                    ->width(500)
                    ->height(500),

            ]),
        ];
    }

    /**
     * 
     */
    public function createOrUpdate(Album $album, Request $request)
    {
        $album->fill($request->get('album'));
        // Default value
        if ($album->img_url == '') {
            $album->img_url = '/storage/album-default.png';
        }
        if ($album->description == '') {
            $album->description = 'Không có mô tả';
        }
        $album->save();
        Alert::info($this->exists ? "Album created" : "Album updated");
        return redirect()->route('platform.album.list');
    }

    public function remove(Album $album)
    {
        $album->delete();

        Alert::info('Album deleted');

        return redirect()->route('platform.album.list');
    }
}
