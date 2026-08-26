<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'yoneticiler';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kullanici_adi', 'sifre'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}