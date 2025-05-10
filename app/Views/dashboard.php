<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGVU - University Filing System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --sgvu-blue: #003366;
            --sgvu-gold: #FFD700;
            --sgvu-light: #F8F9FA;
            --sgvu-dark: #212529;
        }
        
        body {
            background: linear-gradient(rgba(0, 51, 102, 0.85), rgba(0, 51, 102, 0.9)), 
                        url('https://www.gyanvihar.org/wp-content/uploads/2021/03/Gyan-Vihar-University-Jaipur.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .dashboard-sidebar {
            width: 280px;
            background: rgba(0, 51, 102, 0.95);
            color: white;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            height: 100vh;
            transition: all 0.3s;
            z-index: 1000;
        }

        .dashboard-main {
            margin-left: 280px;
            flex: 1;
            padding: 20px;
            transition: all 0.3s;
        }

        .university-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .university-logo img {
            max-width: 180px;
            margin-bottom: 10px;
        }

        .university-logo h4 {
            color: var(--sgvu-gold);
            font-weight: 600;
            margin-bottom: 0;
        }

        .university-logo small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, 0.8) !important;
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            background: var(--sgvu-gold);
            color: var(--sgvu-blue) !important;
            transform: translateX(5px);
        }

        .nav-link-custom i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .header-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title h2 {
            color: var(--sgvu-blue);
            font-weight: 700;
            margin-bottom: 0;
        }

        .header-title small {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-profile img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid var(--sgvu-gold);
            object-fit: cover;
        }

        .user-info small {
            display: block;
            color: #6c757d;
            font-size: 0.8rem;
        }

        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            transition: transform 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        .card-header-custom {
            background: var(--sgvu-blue);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        .card-body-custom {
            padding: 20px;
        }

        .table-custom th {
            background: var(--sgvu-blue);
            color: white;
            font-weight: 500;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .status-approved { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .status-pending { background: #fff3cd; color: #856404; }

        .btn-sgvu {
            background: var(--sgvu-blue);
            color: white;
            border: none;
            padding: 8px 15px;
            font-weight: 500;
        }

        .btn-sgvu:hover {
            background: #002244;
            color: white;
        }

        .btn-sgvu-outline {
            border: 1px solid var(--sgvu-blue);
            color: var(--sgvu-blue);
            background: transparent;
        }

        .btn-sgvu-outline:hover {
            background: var(--sgvu-blue);
            color: white;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--sgvu-blue);
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--sgvu-blue);
            margin-bottom: 5px;
        }

        .stat-title {
            color: #6c757d;
            font-size: 0.9rem;
        }

        @media (max-width: 992px) {
            .dashboard-sidebar {
                width: 80px;
                overflow: hidden;
            }
            
            .dashboard-sidebar .nav-text {
                display: none;
            }
            
            .dashboard-main {
                margin-left: 80px;
            }
            
            .university-logo img {
                max-width: 50px;
            }
            
            .university-logo h4, .university-logo small {
                display: none;
            }
            
            .nav-link-custom {
                text-align: center;
                padding: 15px 5px;
            }
            
            .nav-link-custom i {
                margin-right: 0;
                font-size: 1.3rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .dashboard-main {
                margin-left: 0;
            }
            
            .quick-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Side Navigation -->
        <div class="dashboard-sidebar">
            <div class="university-logo">
                <img src="https://www.gyanvihar.org/wp-content/uploads/2020/03/logo-gvu.png" alt="SGVU Logo">
                <h4>Suresh Gyan Vihar University</h4>
                <small>Filing System</small>
            </div>
            
            <nav class="nav flex-column mt-4">
                <a href="/dashboard" class="nav-link-custom active">
                    <i class="bi bi-speedometer2"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="/upload" class="nav-link-custom">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <span class="nav-text">Upload Documents</span>
                </a>
                <a href="/documents" class="nav-link-custom">
                    <i class="bi bi-files"></i>
                    <span class="nav-text">My Documents</span>
                </a>
                <a href="/shared" class="nav-link-custom">
                    <i class="bi bi-share"></i>
                    <span class="nav-text">Shared With Me</span>
                </a>
                <?php if ($role === 'Super Admin' || $role === 'Admin'): ?>
                <a href="/users" class="nav-link-custom">
                    <i class="bi bi-people"></i>
                    <span class="nav-text">User Management</span>
                </a>
                <a href="/reports" class="nav-link-custom">
                    <i class="bi bi-graph-up"></i>
                    <span class="nav-text">Reports</span>
                </a>
                <?php endif; ?>
                <a href="/profile" class="nav-link-custom">
                    <i class="bi bi-person"></i>
                    <span class="nav-text">My Profile</span>
                </a>
                <a href="/settings" class="nav-link-custom">
                    <i class="bi bi-gear"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </nav>
            
            <div class="mt-auto p-3 text-center" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
                <small class="text-white-50">SGVU Filing System v2.0</small>
            </div>
        </div>

        <!-- Main Content -->
        <div class="dashboard-main">
            <!-- Header -->
            <div class="header-bar">
                <div class="header-title">
                    <h2>Welcome, <?= esc($userName) ?></h2>
                    <small><?= date('l, F j, Y') ?></small>
                </div>
                
                <div class="user-profile">
                    <img src="<?= esc(session()->get('profile_pic') ?? 'https://ui-avatars.com/api/?name='.urlencode($userName).'&background='.substr(str_replace('#', '', '#003366'), 0, 6).'&color=ffffff') ?>" 
                                             alt="Profile" 
                                             class="profile-hover">
                    <div class="user-info">
                        <strong><?= esc($userName) ?></strong>
                        <small><?= esc($role) ?></small>
                    </div>
                    <a href="/logout" class="btn btn-sm btn-danger">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="stat-number"><?= $documentCount ?></div>
                    <div class="stat-title">Total Documents</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-number"><?= $approvedCount ?></div>
                    <div class="stat-title">Approved</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="stat-number"><?= $pendingCount ?></div>
                    <div class="stat-title">Pending</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-number"><?= $userCount ?></div>
                    <div class="stat-title">Active Users</div>
                </div>
            </div>

            <!-- Recent Documents -->
            <div class="card card-custom mb-4">
                <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-file-earmark-text me-2"></i> Recent Documents</span>
                    <a href="/documents" class="btn btn-sm btn-sgvu-outline">View All</a>
                </div>
                <div class="card-body card-body-custom">
                    <div class="table-responsive">
                        <table class="table table-hover table-custom">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>Department</th>
                                    <th>Uploaded By</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($documents as $doc): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($doc['document_name']) ?></strong>
                                        <small class="d-block text-muted"><?= esc($doc['document_type']) ?></small>
                                    </td>
                                    <td><?= esc($doc['department']) ?></td>
                                    <td><?= isset($doc['uploader']) ? esc($doc['uploader']['name']) : 'System' ?></td>
                                    <td><?= date('M j, Y', strtotime($doc['created_at'])) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($doc['status']) ?>">
                                            <?= esc($doc['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="/document/view/<?= $doc['id'] ?>" 
                                               class="btn btn-sm btn-sgvu-outline">
                                               <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if (in_array($role, ['Super Admin', 'Admin', 'Management', 'HR'])): ?>
                                                <?php if ($doc['status'] === 'Pending'): ?>
                                                    <button onclick="handleApproval('approve', <?= $doc['id'] ?>)" 
                                                            class="btn btn-sm btn-success">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                    <button onclick="handleApproval('reject', <?= $doc['id'] ?>)" 
                                                            class="btn btn-sm btn-danger">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- User Management (Admin Only) -->
            <?php if ($role === 'Super Admin' || $role === 'Admin'): ?>
            <div class="card card-custom">
                <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-people me-2"></i> User Management</span>
                    <button onclick="showAddUserModal()" class="btn btn-sm btn-sgvu">
                        <i class="bi bi-plus-circle"></i> Add User
                    </button>
                </div>
                <div class="card-body card-body-custom">
                    <div class="table-responsive">
                        <table class="table table-hover table-custom">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=<?= substr(str_replace('#', '', '#003366'), 0, 6) ?>&color=ffffff" 
                                                 width="30" height="30" 
                                                 class="rounded-circle">
                                            <?= esc($user['name']) ?>
                                        </div>
                                    </td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td><?= esc($user['department']) ?></td>
                                    <td><?= esc($user['role']) ?></td>
                                    <td>
                                        <?php if ($user['last_login'] && ((time() - strtotime($user['last_login'])) < 300)): ?>
                                            <span class="badge bg-success">Online</span>
                                        <?php elseif ($user['last_login']): ?>
                                            <span class="badge bg-info">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button onclick="editUser(<?= $user['id'] ?>)" 
                                                    class="btn btn-sm btn-sgvu-outline">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button onclick="resetPassword(<?= $user['id'] ?>)" 
                                                    class="btn btn-sm btn-warning">
                                                <i class="bi bi-key"></i>
                                            </button>
                                            <?php if ($user['id'] != session()->get('user_id')): ?>
                                                <button onclick="confirmDeleteUser(<?= $user['id'] ?>)" 
                                                        class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add User Modal (Hidden by default) -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-sgvu-blue text-white">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department" required>
                                <option value="">Select Department</option>
                                <option value="Management">Management</option>
                                <option value="HR">HR</option>
                                <option value="Admin">Admin</option>
                                <option value="Faculty">Faculty</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Management">Management</option>
                                <option value="HR">HR</option>
                                <option value="Faculty">Faculty</option>
                                <?php if ($role === 'Super Admin'): ?>
                                <option value="Super Admin">Super Admin</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sgvu" onclick="submitAddUserForm()">Add User</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Document Approval/Rejection
        function handleApproval(action, docId) {
            Swal.fire({
                title: `Confirm ${action.charAt(0).toUpperCase() + action.slice(1)}`,
                text: `Are you sure you want to ${action} this document?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/document/${action}/${docId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Success!',
                                `Document has been ${action}d.`,
                                'success'
                            ).then(() => window.location.reload())
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message || 'Something went wrong.',
                                'error'
                            )
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'Failed to process request.',
                            'error'
                        )
                    })
                }
            })
        }

        // User Management Functions
        function showAddUserModal() {
            var modal = new bootstrap.Modal(document.getElementById('addUserModal'))
            modal.show()
        }

        function submitAddUserForm() {
            const form = document.getElementById('addUserForm')
            const formData = new FormData(form)
            
            fetch('/users/add', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Success!',
                        'User added successfully.',
                        'success'
                    ).then(() => window.location.reload())
                } else {
                    Swal.fire(
                        'Error!',
                        data.message || 'Failed to add user.',
                        'error'
                    )
                }
            })
        }

        function editUser(userId) {
            Swal.fire({
                title: 'Edit User',
                text: 'Feature coming soon!',
                icon: 'info'
            })
        }

        function resetPassword(userId) {
            Swal.fire({
                title: 'Reset Password',
                text: 'Are you sure you want to reset this user\'s password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/users/reset-password/${userId}`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Success!',
                                'Password has been reset to default.',
                                'success'
                            )
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message || 'Failed to reset password.',
                                'error'
                            )
                        }
                    })
                }
            })
        }

        function confirmDeleteUser(userId) {
            Swal.fire({
                title: 'Delete User',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/users/delete/${userId}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                            ).then(() => window.location.reload())
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message || 'Failed to delete user.',
                                'error'
                            )
                        }
                    })
                }
            })
        }

        // Show alerts for flash messages
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= session()->getFlashdata('success') ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            })
        <?php elseif (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= session()->getFlashdata('error') ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            })
        <?php endif; ?>
    </script>
</body>
</html>