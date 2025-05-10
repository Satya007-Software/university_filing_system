<?php
// Dashboard.php (Controller)
namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\NotificationModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $documentModel = new DocumentModel();
        $userModel = new UserModel();
        $notificationModel = new NotificationModel();
        $approvalModel = new \App\Models\ApprovalModel();

        $userId = $session->get('id');
        $role = $session->get('role');
        $department = $session->get('department');
        $userName = $session->get('name');

        // Fetch documents based on role and approval status
        if ($role === 'Super User') {
            // Super Admin should see all documents, including those pending approval
            $documents = $documentModel->findAll();
        } elseif ($role === 'Management') {
             $documents = $documentModel->whereIn('department', ['HR', 'Admin', 'Faculty'])->findAll();
        } elseif ($role === 'HR') {
             $documents = $documentModel->whereIn('department', ['Admin', 'Faculty'])->findAll();
        } else {
            $documents = $documentModel->where('uploaded_by', $userId)->orWhere('shared_with', $userId)->findAll();
        }

        // Fetch uploader and approver details (adjust based on your needs)
        foreach ($documents as &$doc) {
            $doc['uploader'] = $userModel->find($doc['uploaded_by']) ?? null;
            if ($doc['status'] === 'Approved') {
                $approval = $approvalModel->where('document_id', $doc['id'])->first();
                if ($approval) {
                    $approverUser = $userModel->find($approval['approved_by']);
                    $doc['approver'] = $approverUser ? [
                        'name' => $approverUser['name'],
                        'department' => $approverUser['department']
                    ] : null;
                } else {
                    $doc['approver'] = null;
                }
            } else {
                $doc['approver'] = null;
            }
        }

        // Fetch notifications
        $notifications = $notificationModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        // Fetch users (only for Super User)
        $users = $role === 'Super User' ? $userModel->findAll() : [];

        // Calculate counts for stats (adjust based on what stats you want to show to Super Admin)
        $documentCount = $documentModel->countAll();
        $approvedCount = $documentModel->where('status', 'Approved')->countAllResults();
        $pendingCount = $documentModel->where('status', 'Pending')->countAllResults();
        $userCount = $userModel->countAll();

        return view('dashboard', [
            'documents' => $documents,
            'users' => $users,
            'notifications' => $notifications,
            'role' => $role,
            'department' => $department,
            'userName' => $userName,
            'documentCount' => $documentCount,
            'approvedCount' => $approvedCount,
            'pendingCount' => $pendingCount,
            'userCount' => $userCount,
        ]);
    }

    public function addUser()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') != 'Super User') {
            return redirect()->to('/dashboard'); // Redirect if not logged in or not Super User
        }
        $data['departments'] = ['HR', 'Admin', 'Faculty', 'Student']; 
        $data['roles']    = ['Super User', 'Admin', 'HR', 'Faculty', 'Student'];
        return view('dashboard/addUser',$data);
    }

    public function processAddUser()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') != 'Super User') {
            return redirect()->to('/dashboard'); // Redirect if not logged in or not Super User
        }
        
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'role'     => 'required|in_list[Super User,Admin,HR,Faculty,Student]',
            'department' => 'required|in_list[HR,Admin,Faculty,Student]',
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $userModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'department' => $this->request->getPost('department'),
            'role'     => $this->request->getPost('role')
        ]);

        return redirect()->to('/dashboard')->with('success', 'User added!');
    }

    public function profile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find($session->get('id'));

        return view('dashboard/profile', ['user' => $user]);
    }

    public function updatePassword()
    {
        $userModel = new UserModel();
        
        try {
            $success = $userModel->updatePassword(
                'super@univ.edu', 
                '$2y$10$mLeVfoC7y2lbyLythKcL..Kg5LE3Fc5J1XU81DJKkRzRZ5gIArHo6'
            );
            
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        
        if ($success) {
            echo "Password updated successfully";
        } else {
            echo "Password update failed";
        }
    }
    
    public function userDocuments($userId) {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $documentModel = new DocumentModel();
        $userModel = new UserModel();
        
        $user = $userModel->find($userId);
        if(!$user){
             return redirect()->to('/dashboard')->with('error', 'User Not Found');
        }

        $documents = $documentModel->where('uploaded_by', $userId)->findAll();
        
         foreach ($documents as &$doc) {
            // Fetch uploader details
            $doc['uploader'] = $userModel->find($doc['uploaded_by']) ?? null;
    
            // Fetch approver details (if document is approved)
            if ($doc['status'] === 'Approved') {
                $approvalModel = new \App\Models\ApprovalModel();
                $approval = $approvalModel->where('document_id', $doc['id'])->first();
                if ($approval) {
                    $approverUser = $userModel->find($approval['approved_by']);
                    // Ensure approver data is properly structured
                    $doc['approver'] = $approverUser ? [
                        'name' => $approverUser['name'],
                        'department' => $approverUser['department']
                    ] : null;
                } else {
                    $doc['approver'] = null;
                }
            } else {
                $doc['approver'] = null;
            }
        }
        
        $data = [
            'documents' => $documents,
            'user' => $user,
        ];

        return view('dashboard/user_documents', $data);
    }

    public function notifications()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $notificationModel = new NotificationModel();
        $userId = $session->get('id');
        $notifications = $notificationModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        $data['notifications'] = $notifications;
        return view('dashboard/notifications', $data);
    }

    public function markNotificationsAsRead()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        $notificationModel = new NotificationModel();
        $userId = $session->get('id');

        // Mark all notifications for the current user as read
        $notificationModel->where('user_id', $userId)->set(['is_read' => 1])->update();

        return redirect()->to('/dashboard/notifications'); // Redirect back to notifications page
    }
    
     public function archive($documentId)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $documentModel = new DocumentModel();
        $document = $documentModel->find($documentId);

        if (!$document) {
            return redirect()->to('/dashboard')->with('error', 'Document not found.');
        }

        $documentModel->update($documentId, ['status' => 'Archived']);
        return redirect()->to('/dashboard')->with('success', 'Document archived successfully.');
    }

    public function delete($documentId)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $documentModel = new DocumentModel();
        $document = $documentModel->find($documentId);

        if (!$document) {
            return redirect()->to('/dashboard')->with('error', 'Document not found.');
        }

        $documentModel->delete($documentId);
        return redirect()->to('/dashboard')->with('success', 'Document deleted successfully.');
    }

    public function reviewDocument($documentId)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $documentModel = new DocumentModel();
        $userModel = new UserModel();
        $document = $documentModel->find($documentId);

         if (!$document) {
            return redirect()->to('/dashboard')->with('error', 'Document not found.');
        }
        
        $data = [
            'document' => $document,
            'user' => $userModel->find($document['uploaded_by']),
        ];

        return view('dashboard/review_document', $data);
    }
    
     public function requestApproval($documentId)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $documentModel = new DocumentModel();
        $document = $documentModel->find($documentId);

        if (!$document) {
            return redirect()->to('/dashboard')->with('error', 'Document not found.');
        }
        if($document['status'] != 'Uploaded'){
             return redirect()->to('/dashboard')->with('error', 'Document status is invalid.');
        }

        $documentModel->update($documentId, ['status' => 'Pending']);
        return redirect()->to('/dashboard')->with('success', 'Approval requested.');
    }

    public function processRequestApproval()
    {
        //  dd($this->request->getPost());
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $documentId = $this->request->getPost('document_id');
        $approverId   = $this->request->getPost('approver_id');
        $action = $this->request->getPost('action');
        
        $documentModel = new DocumentModel();
        $approvalModel = new \App\Models\ApprovalModel(); // Make sure to load the model
        
        $document = $documentModel->find($documentId);
        if (!$document) {
            return redirect()->to('/dashboard')->with('error', 'Document not found.');
        }
        
         if ($action == 'approve') {
            $documentModel->update($documentId, ['status' => 'Approved']);
            
             // Create an approval record
            $approvalData = [
                'document_id' => $documentId,
                'approved_by' => $approverId,
                'approved_at' => date('Y-m-d H:i:s'), // Use CodeIgniter's time helper
            ];
            $approvalModel->insert($approvalData);
            
            return redirect()->to('/dashboard')->with('success', 'Document approved.');
        } elseif ($action == 'reject') {
            $documentModel->update($documentId, ['status' => 'Rejected']);
            return redirect()->to('/dashboard')->with('success', 'Document rejected.');
        } elseif ($action == 'sendBack') {
             $documentModel->update($documentId, ['status' => 'Uploaded']);
             return redirect()->to('/dashboard')->with('success', 'Document sent back to uploader.');
        }
        
        return redirect()->to('/dashboard')->with('error', 'Invalid action.');
    }
}
