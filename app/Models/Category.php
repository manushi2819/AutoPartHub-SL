<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'status',
    ];

    // Parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Products under this category
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public static function getAllDescendantIds($categoryIds)
    {
        $allIds = [];
        $categories = self::whereIn('id', $categoryIds)->with('childrenRecursive')->get();

        $collectIds = function($cats) use (&$collectIds, &$allIds) {
            foreach ($cats as $cat) {
                $allIds[] = $cat->id;
                if ($cat->childrenRecursive->count()) {
                    $collectIds($cat->childrenRecursive);
                }
            }
        };

        $collectIds($categories);
        return array_unique($allIds);
    }
}
