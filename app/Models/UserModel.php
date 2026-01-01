<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'avatar',
        'reset_token',      // Tambahkan ini
        'reset_expires_at'  // Tambahkan ini
    ];
}