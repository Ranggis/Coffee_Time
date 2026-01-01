<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Menu extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        // Ambil kategori dari query string (?category=espresso-based)
        $activeCat = $this->request->getGet('category');

        // Base query (AMAN & KONSISTEN)
        $builder = $productModel
            ->select('products.*, categories.category_slug')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.status', 'available');

        // Jika ada filter kategori
        if (!empty($activeCat)) {
            $builder->where('categories.category_slug', $activeCat);
        }

        // Ambil data
        $products = $builder->findAll();

        return view('pages/menu', [
            'products'     => $products,
            'categories'   => $categoryModel->findAll(),
            'activeCat'    => $activeCat,
            'is_logged_in' => session()->get('is_logged_in') ?? false
        ]);
    }
}
