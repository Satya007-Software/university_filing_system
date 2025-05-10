<?php
namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\NotificationModel;
use App\Models\ApprovalModel;

class Approval extends BaseController
{
    public function approve($documentId)
{
    $session = session();
    if (!$session->get('isLoggedIn') || $session->get('role') !== 'Super User') {
        return redirect()->to('/login')->with('error', 'Unauthorized action.');
    }

    $documentModel = new DocumentModel();
    $approvalModel = new ApprovalModel();
    $userModel = new \App\Models\UserModel();

    // ✅ Check if the document exists
    $document = $documentModel->find($documentId);
    if (!$document) {
        return redirect()->to('/dashboard')->with('error', 'Document not found.');
    }

    // ✅ Get the uploader as the `requested_by`
    $requestedBy = $document['uploaded_by']; // Assuming `uploaded_by` is a column in `documents`
    
    // ✅ Ensure the `requested_by` user exists
    if (!$userModel->find($requestedBy)) {
        return redirect()->to('/dashboard')->with('error', 'The user who uploaded the document does not exist.');
    }

    // ✅ Ensure the approver exists
    $approvedBy = $session->get('id');
    if (!$userModel->find($approvedBy)) {
        return redirect()->to('/dashboard')->with('error', 'Approver does not exist.');
    }

    // ✅ Update document status to "Approved"
    $documentModel->update($documentId, ['status' => 'Approved']);

    // ✅ Insert into approvals with valid foreign key references
    $approvalModel->save([
        'document_id' => $documentId,
        'requested_by' => $requestedBy, // This was missing!
        'approved_by' => $approvedBy,
        'status' => 'Approved'
    ]);

    return redirect()->to('/dashboard')->with('success', 'Document approved!');
}

    public function reject($documentId)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login to reject documents.');
        }

        $documentModel = new DocumentModel();
        $document = $documentModel->find($documentId);

        // Check if the current user has authority to reject
        if (!$this->hasApprovalAuthority($session->get('role'), $document['department'])) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to reject this document.');
        }

        // Update document status
        $documentModel->update($documentId, ['status' => 'Rejected']);

        // Notify the uploader
        $notificationModel = new NotificationModel();
        $notificationModel->save([
            'user_id' => $document['uploaded_by'],
            'message' => "Document #$documentId rejected by " . $session->get('name') . ".",
            'status' => 'Unread'
        ]);

        return redirect()->to('/dashboard')->with('success', 'Document rejected!');
    }

    private function hasApprovalAuthority($userRole, $documentDepartment)
    {
        // Super User can approve/reject any document
        if ($userRole === 'Super User') {
            return true;
        }

        // Management can approve/reject HR, Admin, Faculty documents
        if ($userRole === 'Management' && in_array($documentDepartment, ['HR', 'Admin', 'Faculty'])) {
            return true;
        }

        // HR can approve/reject Admin, Faculty documents
        if ($userRole === 'HR' && in_array($documentDepartment, ['Admin', 'Faculty'])) {
            return true;
        }

        // Admin and Faculty can only manage their own documents
        return false;
    }
}