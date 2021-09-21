<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Artist;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Cropper;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class ArtistEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Artist';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Artist Edit';

    /**
     * 
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Artist $artist): array
    {
        $this->exists = $artist->exists;

        if ($this->exists) {
            $this->name = 'Edit Artist';
        }

        return [
            'artist' => $artist
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
            Button::make('Create Artist')
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
                Input::make('artist.name')
                    ->title('Name')
                    ->placeholder('Artist name')
                    ->help('Enter your artist name')
                    ->required(),

                TextArea::make('artist.description')
                    ->rows(5)
                    ->title('Description')
                    ->placeholder('Artist description')
                    ->help('Enter your artist Description'),

                DateTimer::make('artist.birthday')
                    ->title('Birthday')
                    ->format('d-m-Y')
                    ->allowInput(),

                Cropper::make('artist.img_url')
                    ->title('Large artist image')
                    ->targetRelativeUrl()
                    ->width(500)
                    ->height(500),

            ]),
        ];
    }

    /**
     * 
     */
    public function createOrUpdate(Artist $artist, Request $request)
    {
        $artist->fill($request->get('artist'));
        // Default value
        if ($artist->img_url == '') {
            $artist->img_url = '/storage/artist-default.png';
        }
        if ($artist->description == '') {
            $artist->description = 'Không có mô tả';
        }
        $artist->save();
        Alert::info($this->exists ? "Artist created" : "Artist updated");
        return redirect()->route('platform.artist.list');
    }

    public function remove(Artist $artist)
    {
        $artist->delete();

        Alert::info('Artist deleted');

        return redirect()->route('platform.artist.list');
    }
}
