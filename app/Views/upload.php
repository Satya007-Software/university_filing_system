<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .upload-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .upload-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .upload-container label {
            display: block;
            margin-bottom: 5px;
        }
        .upload-container input,
        .upload-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .upload-container button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .upload-container button:hover {
            background-color: #555;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2>Upload Document</h2>
        <?php if (session()->has('errors')): ?>
            <?php foreach (session('errors') as $error): ?>
                <div class="error"><?= esc($error) ?></div>
            <?php endforeach ?>
        <?php endif ?>
        <?php if (session()->has('error')): ?>
            <div class="error"><?= esc(session('error')) ?></div>
        <?php endif ?>
        <?php if (session()->has('success')): ?>
            <div class="success"><?= esc(session('success')) ?></div>
        <?php endif ?>
        <form action="<?= base_url('upload/process') ?>" method="post" enctype="multipart/form-data">
    <input type="text" name="document_name" placeholder="Document Name" required>
    <select name="department" required>
    <option value="Management">Management</option>
                <option value="HR">HR</option>
                <option value="Admin">Admin</option>
                <option value="Faculty">Faculty</option>
        <!-- Add department options here -->
    </select>
    <select name="shared_with" required>
        <option value="">Select User to Share With</option>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <input type="file" name="document" required>
    <button type="submit">Upload</button>
</form>
    </div>
</body>
</html>