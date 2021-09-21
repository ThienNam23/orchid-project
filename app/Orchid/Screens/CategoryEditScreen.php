<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Category;
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

class CategoryEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new Category';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Category Edit';

    /**
     * 
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category): array
    {
        $this->exists = $category->exists;

        if ($this->exists) {
            $this->name = 'Edit Category';
        }

        return [
            'category' => $category
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
            Button::make('Create Category')
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
                Input::make('category.name')
                    ->title('Name')
                    ->placeholder('Category name')
                    ->help('Enter your category name')
                    ->required(),

                TextArea::make('category.description')
                    ->rows(5)
                    ->title('Description')
                    ->placeholder('Category description')
                    ->help('Enter your category Description'),
            ]),
        ];
    }

    /**
     * 
     */
    public function createOrUpdate(Category $category, Request $request)
    {
        $category->fill($request->get('category'));
        // Default value
        if ($category->description == '') {
            $category->description = 'Không có mô tả';
        }
        $category->save();
        Alert::info($this->exists ? "Category created" : "Category updated");
        return redirect()->route('platform.category.list');
    }

    public function remove(Category $category)
    {
        $category->delete();

        Alert::info('Category deleted');

        return redirect()->route('platform.category.list');
    }
}
