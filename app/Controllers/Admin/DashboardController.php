<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('is_admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Dashboard Admin | AgriConnect',
            'nama' => session()->get('admin_nama'),
            'role' => session()->get('admin_role'),
            'active' => 'dashboard'
        ];

        return view('admin/dashboard/index', $data);
    }
}