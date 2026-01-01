<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\BlogCategoryModel;

class Blog extends BaseController
{
    public function index()
    {
        $blogModel = new BlogModel();
        $catModel  = new BlogCategoryModel();

        $category = $this->request->getGet('category');

        return view('pages/blog', [
            'featured'       => $blogModel->getFeatured(),
            'blogs'          => $blogModel->getPublished($category),
            'categories'     => $catModel->where('is_active', 1)->findAll(),
            'activeCategory' => $category,
            'is_logged_in'   => session()->get('isLoggedIn')
        ]);
    }


    public function detail($slug)
    {
        $blogModel = new BlogModel();
        $blog = $blogModel->getBySlug($slug);

        if (!$blog) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('pages/blog_detail', [
            'blog' => $blog,
            'is_logged_in' => session()->get('isLoggedIn')
        ]);
    }

    public function read($slug)
    {
        $blogModel = new \App\Models\BlogModel();

        $blog = $blogModel->getBySlug($slug);

        if (!$blog) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['error' => 'Article not found']);
        }

        return $this->response->setJSON($blog);
    }
}
