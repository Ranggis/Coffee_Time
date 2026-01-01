<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\ProductModel;

class Gallery extends BaseController
{
    public function index()
    {
        $galleryModel = new GalleryModel();
        $productModel = new ProductModel();

        // Gallery selain product
        $interior = $galleryModel
            ->where('category', 'interior')
            ->where('is_active', 1)
            ->findAll();

        $brewing = $galleryModel
            ->where('category', 'brewing')
            ->where('is_active', 1)
            ->findAll();

        // Products dari tabel products
        $products = $productModel
            ->where('status', 'available')
            ->findAll();

        return view('pages/gallery', [
            'interior' => $interior,
            'brewing'  => $brewing,
            'products' => $products,
            'is_logged_in' => session()->get('is_logged_in')
        ]);
    }
}
