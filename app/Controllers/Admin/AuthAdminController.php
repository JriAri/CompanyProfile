<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AuthAdminController extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function login()
    {
        if (session()->get('is_admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        $data = [
            'title' => 'Login Admin | AgriConnect',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/auth/login', $data);
    }

    public function attemptLogin()
    {
        $validation = $this->validate([
            'username' => 'required',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->getAdminByUsername($username);

        if (!$admin) {
            return redirect()->back()->withInput()->with('error', 'Username tidak ditemukan');
        }

        if (!$this->adminModel->verifyPassword($admin, $password)) {
            return redirect()->back()->withInput()->with('error', 'Password salah');
        }

        $sessionData = [
            'admin_id' => $admin['id'],
            'admin_username' => $admin['username'],
            'admin_nama' => $admin['nama'],
            'admin_role' => $admin['role'],
            'is_admin_logged_in' => true
        ];
        session()->set($sessionData);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->remove([
            'admin_id', 
            'admin_username', 
            'admin_nama', 
            'admin_role',
            'is_admin_logged_in'
        ]);
        return redirect()->to('/admin/login')->with('success', 'Anda berhasil logout');
    }
}