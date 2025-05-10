<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Document</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .share-container { max-width: 600px; margin: 0 auto; }
        .share-container h1 { margin-bottom: 20px; }
        .share-container label { display: block; margin: 10px 0 5px; }
        .share-container select, .share-container button { width: 100%; padding: 10px; margin: 5px 0; }
    </style>
</head>
<body>
    <div class="share-container">
        <h1>Share Document</h1>
        <form action="<?= base_url("document/share/$documentId/process") ?>" method="post">
            <label for="shared_with">Select User to Share With:</label>
            <select id="shared_with" name="shared_with" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= esc($user['name']) ?> (<?= esc($user['department']) ?>)</option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Share</button>
        </form>
    </div>
</body>
</html>