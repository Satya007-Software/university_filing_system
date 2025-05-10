<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        body { padding: 20px; }
        form { max-width: 400px; }
        input, select { width: 100%; padding: 8px; margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Add User</h1>
    <form action="/dashboard/processAddUser" method="post">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="department" required>
            <option value="Management">Management</option>
            <option value="HR">HR</option>
            <option value="Admin">Admin</option>
            <option value="Faculty">Faculty</option>
        </select>
        <select name="role" required>
            <option value="Management">Management</option>
            <option value="HR">HR</option>
            <option value="Admin">Admin</option>
            <option value="Faculty">Faculty</option>
        </select>
        <button type="submit">Add User</button>
    </form>
</body>
</html>