<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      background: linear-gradient(135deg, #89f7fe, #66a6ff);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }
    .profile-container {
      background: #fff;
      width: 100%;
      max-width: 600px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 40px;
      animation: fadeIn 0.5s ease-in-out;
    }
    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
      font-weight: 600;
    }
    fieldset {
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      margin-bottom: 25px;
      padding: 20px;
    }
    legend {
      font-weight: 600;
      padding: 0 10px;
      color: #444;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
      color: #555;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"] {
      width: 100%;
      padding: 10px 12px;
      font-size: 14px;
      border: 1px solid #ddd;
      border-radius: 6px;
      margin-bottom: 15px;
      transition: border-color 0.3s;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="file"]:focus {
      border-color: #66a6ff;
      outline: none;
    }
    .profile-photo {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      display: block;
      margin: 0 auto 15px;
      border: 3px solid #66a6ff;
    }
    button {
      width: 100%;
      padding: 15px;
      background-color: #66a6ff;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #89f7fe;
    }
    .back-btn {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #66a6ff;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }
    .back-btn:hover {
      color: #89f7fe;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.98); }
      to { opacity: 1; transform: scale(1); }
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h1>Edit Your Profile</h1>
    <?php if(session()->getFlashdata('error')): ?>
      <p style="color:red; text-align:center;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
      <p style="color:green; text-align:center;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <form action="/profile/update" method="post" enctype="multipart/form-data">
      <fieldset>
        <legend>Profile Information</legend>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= esc($user['name']) ?>" required>
        
        <label for="email">Email:</label>
        <!-- Email is read-only for identity consistency -->
        <input type="email" id="email" name="email" value="<?= esc($user['email']) ?>" readonly>
        
        <label for="department">Department:</label>
        <input type="text" id="department" name="department" value="<?= esc($user['department']) ?>" readonly>
        
        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?= esc($user['role']) ?>" readonly>
      </fieldset>
      
      <fieldset>
        <legend>Change Password</legend>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password">
        
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password">
      </fieldset>
      
      <fieldset>
        <legend>Profile Photo</legend>
        <?php if(isset($user['photo']) && $user['photo']): ?>
          <img src="<?= esc($user['photo']) ?>" alt="Profile Photo" class="profile-photo">
        <?php else: ?>
          <img src="/images/default-avatar.png" alt="Default Profile Photo" class="profile-photo">
        <?php endif; ?>
        <label for="photo">Upload New Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*">
      </fieldset>
      
      <button type="submit">Save Changes</button>
      <a href="/dashboard" class="back-btn">Back to Dashboard</a>
    </form>
  </div>
</body>
</html>
