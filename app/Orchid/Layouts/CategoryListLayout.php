<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Category;
use Orchid\Screen\Actions\Link;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Name')
                ->sort()
                ->filter(TD::FILTER_TEXT)
                ->render(function (Category $category) {
                    return Link::make($category->name)
                                ->route('platform.category.edit', $category);
                }),

            TD::make('description', 'Description')
                ->render(function (Category $category) {
                    return $category->description;
                }),

            TD::make('created_at', 'Created')
                ->render(function (Category $category) {
                    return date_format($category->created_at, 'Y-m-d');
                }),
            TD::make('updated_at', 'Last edit')
                ->render(function (Category $category) {
                    return date_format($category->updated_at, 'Y-m-d H:i:s');
                }),

        ];
    }
}
