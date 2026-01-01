<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table            = 'contacts';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'email', 'subject', 'message', 'status']; // Field yang boleh diisi
    protected $useTimestamps    = false; // Karena created_at sudah otomatis dari MySQL (current_timestamp)
}