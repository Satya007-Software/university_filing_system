<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        // Load the login form view
        return view('login');
    }

    public function process()
    {
        // Validate the form data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed, show errors
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Check if the user exists
        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getPost('email'))->first();

        if (!$user) {
            // User not found
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        // Verify the password
        if (!password_verify($this->request->getPost('password'), $user['password'])) {
            // Password is incorrect
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        // Login successful, set session data
        $session = session();
        $session->set([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'department' => $user['department'],
            'role' => $user['role'],
            'isLoggedIn' => true
        ]);

        // Redirect to the dashboard
        return redirect()->to('/dashboard')->with('success', 'Login successful!');
    }

    public function logout()
    {
        // Destroy the session and log the user out
        $session = session();
        $session->destroy();
        return redirect()->to('/login')->with('success', 'Logout successful!');
    }
}