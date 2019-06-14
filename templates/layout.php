<!DOCTYPE html>
<html lang="ru">
<?php include __DIR__ . '/partials/head.php'; ?>
<body>
<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
        <?php echo $content; ?>
        <?php include __DIR__ . '/partials/sidebar.php'; ?>
    </tr>
    <tr>
        <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
    </tr>
</table>
</body>
</html>
