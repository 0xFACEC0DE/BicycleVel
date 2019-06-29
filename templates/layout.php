<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/partials/head.php'; ?>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>
    <div class="container">
        <?php echo $content ?? ''; ?>

        <?php if (!empty($errors)): ?>
            <div class="error center">
                <?php foreach ($errors as $message): ?>
                    <p><?= $message ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>