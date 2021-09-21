<?php

namespace App\Orchid\Screens;

use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Category;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
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
use Orchid\Attachment\Models\Attachment;

class SongEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Song';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Song Edit';

    /**
     * 
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Song $song, Album $album): array
    {
        $this->exists = $song->exists;

        if ($this->exists) {
            $this->name = 'Edit Song';
        }

        $song->load(['artists', 'attachment']);
        return [
            'song' => $song
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
            Button::make('Create song')
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
                Input::make('song.name')
                    ->title('Name')
                    ->placeholder('Song name')
                    ->help('Enter your song name')
                    ->required(),

                Cropper::make('song.img_url')
                    ->targetRelativeUrl()
                    ->title('Large song image')
                    ->width(500)
                    ->height(500),

                Relation::make('song.album_id')
                    ->fromModel(Album::class, 'name')
                    ->title('Choose album'),

                Relation::make('song.artists.')
                        ->multiple()
                        ->fromModel(Artist::class, 'name')
                        ->title('Select Artist'),
                    
                Relation::make('song.categories.')
                        ->multiple()
                        ->fromModel(Category::class, 'name')
                        ->title('Select Category'),

                Upload::make('song.attachment')
                    ->maxFiles(1)
                    ->acceptedFiles('.mp3')
                    ->targetRelativeUrl()
                    ->title('Song file'),
            ]),
        ];
    }

    /**
     * 
     */
    public function createOrUpdate(Song $song, Request $request)
    {
        $song->fill($request->get('song'));
        $file = Attachment::find($request->input('song.attachment'))->first();
        $song->song_url = $file->getRelativeUrlAttribute();
        
        if ($song->img_url == '') {
            $song->img_url = '/storage/music-default.png';
        }
        $song->save();
        $song->artists($song->id)->sync(optional($request->get('song'))['artists']);
        $song->categories($song->id)->sync(optional($request->get('song'))['categories']);

        $song->attachment()->syncWithoutDetaching(
            $request->input('song.attachment', [])
        );
        Alert::info($this->exists ? "Song created" : "Song updated");
        return redirect()->route('platform.song.list');
    }

    public function remove(Song $song)
    {
        $song->delete();

        Alert::info('Song deleted');

        return redirect()->route('platform.song.list');
    }
}
