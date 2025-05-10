<?php

namespace App\Controllers;

use App\Models\DocumentModel;

class Upload extends BaseController
{
    public function index()
{
    // Check if the user is logged in
    $session = session();
    if (!$session->get('isLoggedIn')) {
        return redirect()->to('/login ')->with('error', 'Please login to upload documents.');
    }

    // Fetch users for sharing
    $userModel = new \App\Models\UserModel(); // Assuming you have a UserModel
    $data['users'] = $userModel->findAll(); // Fetch all users

    // Load the upload form view
    return view('upload', $data);
}

    public function process()
{
    // Check if the user is logged in
    $session = session();
    if (!$session->get('isLoggedIn')) {
        return redirect()->to('/login')->with('error', 'Please login to upload documents.');
    }

    // Validate the form data
    $validation = \Config\Services::validation();
    $validation->setRules([
        'document_name' => 'required|min_length[3]',
        'department' => 'required',
        'shared_with' => 'required|integer',
        'document' => 'uploaded[document]|max_size[document,10240]|mime_in[document,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain,image/jpeg,image/png]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        // Validation failed, show errors
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Handle the file upload
    $file = $this->request->getFile('document');
    if ($file->isValid() && !$file->hasMoved()) {
        // Create department-specific folder
        $department = $this->request->getPost('department');
        $uploadPath = WRITEPATH . 'uploads/' . $department . '/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Save the file
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        // Save document details to the database
        $documentModel = new DocumentModel();
        $documentModel->save([
            'document_name' => $this->request->getPost('document_name'),
            'uploaded_by' => $session->get('id'),
            'department' => $department,
            'file_path' => 'uploads/' . $department . '/' . $newName,
            'status' => 'Pending',
            'shared_with' => $this->request->getPost('shared_with') // Save the user ID to share with
        ]);
        

        // Redirect to the dashboard with a success message
        return redirect()->to('/dashboard')->with('success', 'Document uploaded successfully!');
    }

    // File upload failed
    return redirect()->back()->withInput()->with('error', 'Failed to upload the document.');
}
}