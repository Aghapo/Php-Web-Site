<?php

namespace App\Models;

use CodeIgniter\Model;

class OgrenciModel extends Model
{
    protected $table      = 'ogrenciler';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ad', 'soyad' , 'deleted_at' , 'foto'];

    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
    protected $dateFormat = 'datetime';
}