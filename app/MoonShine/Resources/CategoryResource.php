<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use MoonShine\Fields\Date;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Fields\Textarea;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Category>
 */
class CategoryResource extends ModelResource
{
    protected string $model = Category::class;

    protected string $title = 'Категории';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function indexFields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'title'),
                Slug::make('ЧПУ', 'slug'),
                Date::make('Created at', 'created_at'),
                Date::make('Updated at', 'updated_at'),
            ]),
        ];
    }
    public function detailFields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'title'),
                Slug::make('ЧПУ', 'slug'),
                Textarea::make('Описание', 'description'),
                Date::make('Created at', 'created_at'),
                Date::make('Updated at', 'updated_at'),
            ]),
        ];
    }
    public function formFields(): array
    {
        return [
            Block::make([
                Text::make('Название', 'title'),
                Slug::make('ЧПУ', 'slug'),
                Textarea::make('Описание', 'description'),
            ]),
        ];
    }

    /**
     * @param Category $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
