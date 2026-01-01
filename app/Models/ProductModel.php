<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'status'
    ];

    protected $returnType = 'array';

    public function getAvailableProducts()
    {
        return $this->where('status', 'available')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
