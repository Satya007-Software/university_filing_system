<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
        .signup-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .signup-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .signup-container label {
            display: block;
            margin-bottom: 5px;
        }
        .signup-container input,
        .signup-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .signup-container button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .signup-container button:hover {
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
    <div class="signup-container">
        <h2>Signup</h2>
        <?php if (session()->has('errors')): ?>
            <?php foreach (session('errors') as $error): ?>
                <div class="error"><?= esc($error) ?></div>
            <?php endforeach ?>
        <?php endif ?>
        <?php if (session()->has('success')): ?>
            <div class="success"><?= esc(session('success')) ?></div>
        <?php endif ?>
        <form action="<?= base_url('signup/process') ?>" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="department">Department</label>
            <select id="department" name="department" required>
                <option value="Management">Management</option>
                <option value="HR">HR</option>
                <option value="Admin">Admin</option>
                <option value="Faculty">Faculty</option>
                <input type="text" name="designation" placeholder="Designation" required>


            <button type="submit">Signup</button>
        </form>
    </div>
</body>
</html>