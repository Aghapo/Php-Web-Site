<?php

namespace App\Models;
use CodeIgniter\Model;

class DersModel extends Model
{
    protected $table = 'dersler';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['ders_adi'];
    
    // MS SQL Identity insert ayarı
    protected $useAutoIncrement = true;
}
