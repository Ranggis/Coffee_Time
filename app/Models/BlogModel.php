<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table      = 'blogs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'author_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'category_id',
        'excerpt',
        'read_time',
        'is_featured',
        'status'
    ];

    protected $useTimestamps = false;

    /* =========================
       QUERY HELPERS
    ========================= */

    // 🔥 Featured article (1)
    public function getFeatured()
    {
        return $this->select('
                blogs.*,
                blogs.slug AS blog_slug,
                blog_categories.name AS category_name,
                blog_categories.slug AS category_slug
            ')
            ->join('blog_categories', 'blog_categories.id = blogs.category_id', 'left')
            ->where('blogs.status', 'published')
            ->where('blogs.is_featured', 1)
            ->orderBy('blogs.created_at', 'DESC')
            ->first();
    }

    // 🔥 Semua artikel published (+ filter category slug)
    public function getPublished($categorySlug = null)
    {
        $builder = $this->select('
                blogs.*,
                blogs.slug AS blog_slug,
                blog_categories.name AS category_name,
                blog_categories.slug AS category_slug
            ')
            ->join('blog_categories', 'blog_categories.id = blogs.category_id', 'left')
            ->where('blogs.status', 'published')
            ->orderBy('blogs.created_at', 'DESC');

        if ($categorySlug) {
            $builder->where('blog_categories.slug', $categorySlug);
        }

        return $builder->findAll();
    }

    // 🔥 Detail artikel
    public function getBySlug($slug)
    {
        return $this->select('
                blogs.*,
                blog_categories.name AS category_name,
                blog_categories.slug AS category_slug
            ')
            ->join('blog_categories', 'blog_categories.id = blogs.category_id', 'left')
            ->where('blogs.slug', $slug)
            ->where('blogs.status', 'published')
            ->first();
    }
}
