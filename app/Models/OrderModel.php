<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    // WAJIB DIDAFTARKAN SEMUA DI SINI
    protected $allowedFields = [
        'user_id',
        'order_code',
        'customer_name',  // Tambahkan ini
        'service_type',   // Tambahkan ini
        'location',       // Tambahkan ini
        'total_amount',
        'tax_amount',      // Tambahkan ini
        'payment_method',
        'notes',          // Tambahkan ini
        'status'
    ];

    protected $useTimestamps = false; // Set true jika pakai kolom created_at otomatis
    protected $returnType = 'array';
}