<?php
require 'auth.php';

$arquivo = 'perguntas.json';
$perguntas = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver</title>
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

    <h1>Perguntas</h1>

    <?php foreach ($perguntas as $p): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
        <h3>#<?= $p['numero'] ?> (<?= $p['tipo'] ?>)</h3>
        <p><?= $p['pergunta'] ?></p>
        
        <?php if ($p['tipo'] == 'multipla'): ?>
            <ol>
                <?php foreach ($p['opcoes'] as $op): ?>
                    <li><?= $op ?></li>
                <?php endforeach; ?>
            </ol>
            <p><strong>Gabarito:</strong> <?= $p['gab'] ?></p>
        <?php else: ?>
            <p><strong>Resposta:</strong> <?= $p['resp'] ?></p>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</body>
</html>