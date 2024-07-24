<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Laravel\Scout\Searchable;

/**
 * Class Product
 *
 * @property integer $id
 * @property integer $category_id
 * @property Category $category
 * @property string $slug
 * @property string $title
 * @property string|null $description
 * @property string|null $search_keys
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $barcode
 * @property string|null $product_code
 * @property float $price
 * @property string|DateTimeInterface $created_at
 * @property string|DateTimeInterface $updated_at
 */
#[ScopedBy([ActiveScope::class])]
class Product extends Model
{
    use HasFactory;
    use Searchable;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'products';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => strval($this->id),
            'doc_id' => ($this->id),
            'category_id' => $this->category_id,
            'category' => $this->category->title,
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'search_keys' => $this->search_keys,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'barcode' => $this->barcode,
            'product_code' => $this->product_code,
            'price' => floatval($this->price),
            'created_at' => $this->created_at->getTimestamp(),
            'updated_at' => $this->updated_at->getTimestamp(),
        ];
    }
}
