<?php
namespace App\Controllers;

use App\Models\UserModel;

class Signup extends BaseController
{
    public function index()
    {
        return view('signup');
    }

    public function process()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'        => 'required|min_length[3]',
            'email'       => 'required|valid_email|is_unique[users.email]',
            'password'    => 'required|min_length[6]',
            'department'  => 'required',
            'designation' => 'required'  // ✅ fixed from 'Designation'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Block Super User signups
        $role = $this->request->getPost('role');
        if ($role === 'Super User') {
            return redirect()->back()->with('error', 'Super User role cannot be assigned.');
        }

        $userModel = new UserModel();
        $userModel->save([
            'name'        => $this->request->getPost('name'),
            'email'       => $this->request->getPost('email'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'department'  => $this->request->getPost('department'),
            'designation' => $this->request->getPost('designation') // ✅ fixed from 'Designation'
        ]);

        return redirect()->to('/login')->with('success', 'Signup successful!');
    }
}
