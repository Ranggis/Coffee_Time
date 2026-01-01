<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table = 'gallery';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'image',
        'category',
        'is_active'
    ];

    protected $useTimestamps = true;
}
