<?php
require 'auth.php';

$result = $conn->query("SELECT * FROM perguntas ORDER BY numero");
$perguntas = [];
while ($row = $result->fetch_assoc()) {
    if ($row['opcoes']) {
        $row['opcoes'] = json_decode($row['opcoes'], true);
    }
    $perguntas[] = $row;
}
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
