<?php
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'nama', 'role'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAdminByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function verifyPassword($admin, $password)
    {
        return password_verify($password, $admin['password']);
    }
}