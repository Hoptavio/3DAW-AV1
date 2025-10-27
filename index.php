<?php
require 'auth.php';

if (!logado()) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Início</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Início</a>
        <?php if (adm()): ?>
            <a href="users.php">Usuários</a>
            <a href="perguntas.php">Perguntas</a>
        <?php endif; ?>
        <a href="ver.php">Ver</a>
        <a href="?sair=true">Sair</a>
    </nav>

    <h1>Olá, <?= $_SESSION['user']['nome'] ?></h1>
    <p>Tipo: <?= $_SESSION['user']['tipo'] ?></p>
</body>
</html>