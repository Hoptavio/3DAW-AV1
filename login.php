<?php
require 'auth.php';

if (logado()) {
    header('Location: index.php');
    exit;
}

$erro = '';
if ($_POST) {
    if (login($_POST['user'], $_POST['pass'])) {
        header('Location: index.php');
        exit;
    } else {
        $erro = 'Erro';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    
    <?php if ($erro): ?>
        <div class="msg error"><?= $erro ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Usuário:</label><br>
            <input type="text" name="user" required>
        </div>
        <div class="form-group">
            <label>Senha:</label><br>
            <input type="password" name="pass" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
    
    <p>admin/admin ou aluno/aluno</p>
</body>
</html>