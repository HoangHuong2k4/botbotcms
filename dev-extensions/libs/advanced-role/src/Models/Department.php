<?php

namespace Dev\AdvancedRole\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use Dev\Base\Casts\SafeContent;

use Laratrust\Models\Team as LaratrustDepartment;

class Department extends LaratrustDepartment
{
    protected $table = 'app_departments';

    protected $fillable = [
        'name', // varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Sử dụng như Unique Code của Team, theo concept của gói phân quyền Laratrust',
        'display_name', // varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        'department_code', // varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT ' a đổi từ code sang department_code',
        'description', // text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ghi chú ngắn',
        'parent_id', // bigint(20) unsigned DEFAULT NULL,
        'author_id', // bigint(20) unsigned DEFAULT NULL,
        'author_type', // varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        'product_category_id', // bigint(20) unsigned DEFAULT NULL COMMENT 'LOAISP, anh đổi tên của các em từ "product_type_id", sang "product_category_id" ',
        'product_category_code', // varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Cột "Manhom" move từ mssql, để test, có thể xoá sau khi dùng product_category_id ổn định',
        'department_type', // int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Loai, moved từ MSSQM quan mysql, có thể không sử dung. xoá đĩ khi ổn định',
        'status', // varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published'
    ];

    protected $casts = [
        'name' => SafeContent::class,
        'display_name' => SafeContent::class,
        'description' => SafeContent::class
    ];

    /**
     * This will give model's Parent 
     * 
     * Get parent node
     * $department = Member::find(8); 
     * $parent = $department->parent; // 4
     * 
     * Get the grandparent
     * $department = Member::find(8); 
     * $parent = $department->parent()->parent; // 2
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id'); // ->withDefault();
    }

    /**
     * This will give model's Parent, Parent's parent, and so on until root.  
     * 
     * Get all the parent nodes (Tree structure)
     * $department = Member::find(8); 
     * $parent = $department->parentRecursive; // 4,2,1 as a tree structure
     * @return BelongsTo
     */
    public function parentRecursive(): BelongsTo
    {
        return $this->parent()->with('parentRecursive');
    }

    /**
     * Get current model's all recursive parents in a collection in flat structure.
     * 
     * Get all the parent nodes (Flat collection)
     * $department = Member::find(8); 
     * $parent = $department->parentRecursiveFlatten; // [4,2,1]
     */
    public function parentRecursiveFlatten()
    {
        $result = collect();
        $item = $this->parentRecursive;
        if ($item instanceof Member) {
            $result->push($item);
            $result = $result->merge($item->parentRecursiveFlatten());
        }
        return $result;
    }

    /**
     * @return HasMany
     * 
     * Get all Children
     * $department = Member::find(2); 
     * $parent = $department->children; // [4,5]
     * 
     * Get all Children
     * $department = Member::find(2); 
     * $parent = $department->childrenRecursive; // 4, 5, 8, 9, 10, 11
     * 
     * Get GrandChildren
     * 
     * $department = Member::find(2); 
     * $parent = $department->children()->children; // [4,5]
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * This will give model's Children, Children's Children and so on until last node. 
     * @return HasMany
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function deepParent($data = null)
    {
        $result = !blank($data) ? $data : $this;
        if (blank($result->parent->id)) {
            return $result;
        }
        return $result->deepParent($result->parent);
    }
}
