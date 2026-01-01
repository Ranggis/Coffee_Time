<?php

namespace App\Models;

use CodeIgniter\Model;

class StoryAtmosphereModel extends Model
{
    protected $table      = 'story_atmosphere_items';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'source_type',
        'source_id',
        'sort_order',
        'is_active'
    ];

    public function getAtmospheres()
    {
        return $this->db->table('story_atmosphere_items sai')
            ->select('
                sai.source_type,
                sai.source_id,
                g.image AS gallery_image,
                p.image AS product_image
            ')
            ->join('gallery g', 'g.id = sai.source_id AND sai.source_type = "gallery"', 'left')
            ->join('products p', 'p.id = sai.source_id AND sai.source_type = "product"', 'left')
            ->where('sai.is_active', 1)
            ->orderBy('sai.sort_order', 'ASC')
            ->get()
            ->getResultArray();
    }
}
