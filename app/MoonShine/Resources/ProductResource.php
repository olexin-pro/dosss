<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

use MoonShine\Fields\Image;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Field;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Product>
 */
class ProductResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Товары';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function indexFields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Titile', 'title'),
            ]),
        ];
    }
    public function formFields(): array
    {
        return [
            Block::make([
                Image::make('Image', 'slug'),
                Slug::make('Slug', 'slug'),
                Text::make('Titile', 'title'),
            ]),
        ];
    }

    /**
     * @param Product $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
