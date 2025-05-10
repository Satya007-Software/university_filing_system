<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Approval</title>
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
        .approval-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .approval-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .approval-container label {
            display: block;
            margin-bottom: 5px;
        }
        .approval-container textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        .approval-container button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .approval-container button:hover {
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
    <div class="approval-container">
        <h2>Request Approval</h2>
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
        <form action="<?= base_url('approval/processRequest') ?>" method="post">
            <input type="hidden" name="document_id" value="<?= $documentId ?>">
            <label for="comments">Comments</label>
            <textarea id="comments" name="comments" rows="4"></textarea>
            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>