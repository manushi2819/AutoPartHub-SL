<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'status',
        'image',
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


    public static function getCategoryTreeIds($categoryId)
    {
        $allIds = [];

        $category = self::with('parent')->find($categoryId);
        if (!$category) return $allIds;

        // 1️⃣ Add current category
        $allIds[] = $category->id;

        // 2️⃣ Add all descendants
        $allIds = array_merge($allIds, self::getAllDescendantIds([$category->id]));

        // 3️⃣ Add siblings (other categories under same parent)
        if ($category->parent_id) {
            $siblings = self::where('parent_id', $category->parent_id)
                            ->where('id', '!=', $category->id)
                            ->pluck('id')
                            ->toArray();
            $allIds = array_merge($allIds, $siblings);
        }

        return array_unique($allIds);
    }
    
}
