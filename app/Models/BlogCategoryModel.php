<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogCategoryModel extends Model
{
    protected $table = 'blog_categories';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'slug',
        'is_active'
    ];
}
