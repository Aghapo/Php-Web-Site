<?php 

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{   
    protected $id;
    protected $group_id;
    protected $first_name;
    protected $sur_name;
    protected $email;
    protected $password;
    protected $verif_key;
    protected $verif_code;
    protected $bio;
    protected $status;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'id'         => 'integer',
        'group_id'   => '?integer',
        'verif_code' => '?integer',
    ];

    // ==========================================
    // SETTER (MUTATOR) METOTLARI
    // ==========================================

    /**
     * Şifre atandığında otomatik olarak hash'lenmesini sağlar.
     */
    public function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function setGroupId(?int $groupId)
    {
        $this->attributes['group_id'] = $groupId;
        return $this;
    }

    public function setFirstName(string $firstName)
    {
        $this->attributes['first_name'] = trim($firstName);
        return $this;
    }

    public function setSurName(string $surName)
    {
        $this->attributes['sur_name'] = trim($surName);
        return $this;
    }

    public function setEmail(string $email)
    {
        $this->attributes['email'] = trim($email);
        return $this;
    }

    public function setVerifKey(?string $verifKey)
    {
        $this->attributes['verif_key'] = $verifKey;
        return $this;
    }

    public function setVerifCode(?int $verifCode)
    {
        $this->attributes['verif_code'] = $verifCode;
        return $this;
    }

    public function setBio(?string $bio)
    {
        $this->attributes['bio'] = $bio !== null ? trim($bio) : null;
        return $this;
    }

    public function setStatus(string $status)
    {
        $this->attributes['status'] = $status;
        return $this;
    }

    // ==========================================
    // GETTER (ACCESSOR) METOTLARI
    // ==========================================

    public function getID()
    {
        return $this->attributes['id'] ?? null;
    }

    public function getGroupID()
    {
        return $this->attributes['group_id'] ?? null;
    }

    public function getFirstName()
    {
        return $this->attributes['first_name'] ?? null;
    }

    public function getSurname()
    {
        return $this->attributes['sur_name'] ?? null;
    }

    public function getFullName()
    {
        return trim(($this->attributes['first_name'] ?? '') . ' ' . ($this->attributes['sur_name'] ?? ''));
    }

    public function getEmail()
    {
        return $this->attributes['email'] ?? null;
    }

    public function getVerifKey()
    {
        return $this->attributes['verif_key'] ?? null;
    }

    public function getVerifCode()
    {
        return $this->attributes['verif_code'] ?? null;
    }

    public function getBio()
    {
        return $this->attributes['bio'] ?? null;
    }

    public function getStatus()
    {
        return $this->attributes['status'] ?? null;
    }

    /**
     * Oluşturulma tarihini döndürür.
     * $humanize = true ise "30 dakika önce", "2 saat önce" gibi göreceli zaman metni döner.
     * $humanize = false ise belirtilen $format biçiminde (örn: 26.08.2026 15:30) döner.
     */
    public function getCreatedAt(bool $humanize = true, string $format = 'd.m.Y H:i')
    {
        if (empty($this->attributes['created_at'])) {
            return null;
        }

        $date = $this->mutateDate($this->attributes['created_at']);

        return $humanize ? $date->humanize() : $date->format($format);
    }

    /**
     * Güncellenme tarihini döndürür.
     */
    public function getUpdatedAt(bool $humanize = true, string $format = 'd.m.Y H:i')
    {
        if (empty($this->attributes['updated_at'])) {
            return null;
        }

        $date = $this->mutateDate($this->attributes['updated_at']);

        return $humanize ? $date->humanize() : $date->format($format);
    }

    // ==========================================
    // YARDIMCI METOTLAR
    // ==========================================

    public function isActive(): bool
    {
        return ($this->attributes['status'] ?? '') === 'ACTIVE';
    }

    public function isPending(): bool
    {
        return ($this->attributes['status'] ?? '') === 'PENDING';
    }

    public function isPassive(): bool
    {
        return ($this->attributes['status'] ?? '') === 'PASSIVE';
    }
}