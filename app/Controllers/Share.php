<?php
namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\UserModel;

class Share extends BaseController
{
    public function index($documentId)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('share', [
            'documentId' => $documentId,
            'users' => $users
        ]);
    }

    public function process($documentId)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $sharedWith = $this->request->getPost('shared_with');

        $documentModel = new DocumentModel();
        $documentModel->update($documentId, [
            'shared_with' => $sharedWith
        ]);

        return redirect()->to('/dashboard')->with('success', 'Document shared successfully!');
    }
}