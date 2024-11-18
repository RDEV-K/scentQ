<?php

namespace App\Models;

use App\Helpers\MenuAble;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Product extends Model
{
    use Searchable, MenuAble;
    protected $guarded = ['id'];
    public static $types = ['perfume', 'cologne', 'women', 'men', 'both', 'makeup', 'skincare', 'personal-care', 'giftset', 'extras'];

    protected $appends = [
        'image',
        'avg_review_rating'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = $this->getPrimaryDatabase();
    }

    protected function getPrimaryDatabase(): string
    {
        // this system only applies for the UK domain

        $domain = getCurrentDomain();
        $database = 'mysql';

        // If it is scentq.co.uk
        if ($domain === 'scentq.co.uk') {
            $database = 'mysql_primary';
        }

        return $database ?? 'mysql';
    }

    function sub_type()
    {
        return $this->belongsTo(ProductSubType::class, 'product_sub_type_id', 'id');
    }

    function purchase_options()
    {
        return $this->hasMany(PurchaseOption::class, 'product_id', 'id');
    }

    function related_products()
    {
        return $this->hasMany(RelatedProduct::class, 'of_id', 'id');
    }

    function metas()
    {
        return $this->morphMany(Meta::class, 'holder');
    }

    function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    function getAvgReviewRatingAttribute()
    {
        $rating = $this->reviews()->avg('rate') ?? 0;
        return round($rating, 2);
        // return $this->review_ratings ?? 0;
    }

    // Product Data
    function terms()
    {
        return $this->belongsToMany(Term::class, 'product_term_relation');
    }

    function collections()
    {
        return $this->belongsToMany(Collection::class, 'product_collection_relation');
    }

    function families()
    {
        return $this->belongsToMany(Family::class, 'product_family_relation');
    }

    function labels()
    {
        return $this->belongsToMany(Label::class, 'product_label_relation');
    }

    function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    function notes()
    {
        return $this->belongsToMany(Note::class, 'product_note_relation');
    }

    function badges()
    {
        return $this->belongsToMany(Badge::class, 'product_badge_relation');
    }

    function line_items()
    {
        return $this->hasMany(LineItem::class, 'product_id', 'id');
    }

    function getImageAttribute()
    {
        if ($this->images && isset($this->images[0])) {
            $onlyImages = array_filter($this->images, function ($image) {
                return $image['type'] === 'image';
            });
            if (isset($onlyImages[0])) return $onlyImages[0];
        }
        return null;
    }

    function getItemText()
    {
        return $this->title;
    }

    function getItemUrl()
    {
        return route('product', ['productType' => $this->type, 'brandSlug' => $this->brand->slug, 'productSlug' => $this->slug]);
    }

    static function menurecords()
    {
        return self::query()->with('brand')->get();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {

        $this->loadAvg('reviews', 'rate');
        $this->load(['sub_type', 'terms', 'families', 'labels', 'brand', 'notes', 'badges']);
        $searchableArray = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'sub_title' => $this->sub_title,
            'type' => $this->type,
            'for' => $this->for,
            'content' => Str::limit($this->content, 500),
            'how_to_use' => $this->how_to_use,
            'ingredients' => $this->ingredients,
            'why_we_love_it' => $this->why_we_love_it,
            'how_it_works' => $this->how_it_works,
            'disclaimer' => $this->disclaimer,
            'status' => $this->status,
            'image' => $this->image,
            'brand_name' => $this->brand->name ?? null,
            'brand_slug' => $this->brand->slug ?? null,
            'sub_type' => $this->sub_type,
            'avg_review_rating' => $this->avg_review_rating,
        ];

        if ($this->terms) {
            $searchableArray['terms'] = $this->terms->pluck('name')->toArray();
        }

        if ($this->families) {
            $searchableArray['families'] = $this->families->pluck('name')->toArray();
        }

        if ($this->labels) {
            $searchableArray['labels'] = $this->labels->pluck('label')->toArray();
        }
        if ($this->notes) {
            $searchableArray['notes'] = $this->labels->pluck('name')->toArray();
        }
        if ($this->badges) {
            $searchableArray['badges'] = $this->labels->pluck('name')->toArray();
        }


        return $searchableArray;
    }

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return $this->status == 'published';
    }

    /**
     * get which item is top sell by order.
     *
     */
    public function topSell()
    {
        return $this->hasMany(LineItem::class, 'product_id', 'id');
    }
}
