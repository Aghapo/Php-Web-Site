<?php

namespace App\Models;

use CodeIgniter\Model;

class NotModel extends Model
{
    protected $table            = 'notlar';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['ogrenci_id', 'ders_id', 'sinav_turu', 'puan', 'sinav_tarihi'];
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';
}
