<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';

    // WAJIB DIDAFTARKAN SEMUA DI SINI
    protected $allowedFields = [
        'order_id',
        'product_id',
        'quantity',
        'price',    // Tambahkan ini agar tidak NULL
        'subtotal'
    ];

    protected $returnType = 'array';
}