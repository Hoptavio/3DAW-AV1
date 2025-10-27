<?php
require 'auth.php';

if (!adm()) {
    header('Location: index.php');
    exit;
}

$arquivo = 'perguntas.json';
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}

$perguntas = json_decode(file_get_contents($arquivo), true);
$msg = '';

if ($_POST) {
    if ($_POST['acao'] == 'add') {
        $nova = [
            'id' => count($perguntas) + 1,
            'numero' => $_POST['numero'],
            'pergunta' => $_POST['pergunta'],
            'tipo' => $_POST['tipo'],
            'opcoes' => $_POST['opcoes'] ?? [],
            'resp' => $_POST['resp'] ?? '',
            'gab' => $_POST['gab'] ?? ''
        ];
        $perguntas[] = $nova;
        file_put_contents($arquivo, json_encode($perguntas));
        $msg = 'Adicionada';
    }
    
    if ($_POST['acao'] == 'del') {
        $id = $_POST['id'];
        $perguntas = array_filter($perguntas, function($p) use ($id) {
            return $p['id'] != $id;
        });
        file_put_contents($arquivo, json_encode(array_values($perguntas)));
        $msg = 'Removida';
    }
    
    $perguntas = json_decode(file_get_contents($arquivo), true);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Perguntas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Início</a>
        <a href="users.php">Usuários</a>
        <a href="perguntas.php">Perguntas</a>
        <a href="ver.php">Ver</a>
        <a href="?sair=true">Sair</a>
    </nav>

    <h1>Perguntas</h1>

    <?php if ($msg): ?>
        <div class="msg success"><?= $msg ?></div>
    <?php endif; ?>

    <h2>Nova</h2>
    <form method="POST">
        <input type="hidden" name="acao" value="add">
        <div class="form-group">
            <label>Número:</label><br>
            <input type="text" name="numero" required>
        </div>
        <div class="form-group">
            <label>Pergunta:</label><br>
            <textarea name="pergunta" required></textarea>
        </div>
        <div class="form-group">
            <label>Tipo:</label><br>
            <select name="tipo" onchange="mudarTipo()">
                <option value="multipla">Múltipla</option>
                <option value="discursiva">Discursiva</option>
            </select>
        </div>
        
        <div id="multipla">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="form-group">
                <label>Opção <?= $i ?>:</label><br>
                <input type="text" name="opcoes[]">
            </div>
            <?php endfor; ?>
            <div class="form-group">
                <label>Gabarito:</label><br>
                <input type="number" name="gab" min="1" max="5">
            </div>
        </div>
        
        <div id="discursiva" style="display:none;">
            <div class="form-group">
                <label>Resposta:</label><br>
                <textarea name="resp"></textarea>
            </div>
        </div>
        
        <button type="submit">Add</button>
    </form>

    <h2>Lista</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Número</th>
            <th>Pergunta</th>
            <th>Tipo</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($perguntas as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['numero'] ?></td>
            <td><?= substr($p['pergunta'], 0, 30) ?>...</td>
            <td><?= $p['tipo'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="acao" value="del">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <button type="submit" onclick="return confirm('Del?')">Del</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script>
    function mudarTipo() {
        var tipo = document.querySelector('[name="tipo"]').value;
        document.getElementById('multipla').style.display = tipo == 'multipla' ? 'block' : 'none';
        document.getElementById('discursiva').style.display = tipo == 'discursiva' ? 'block' : 'none';
    }
    </script>
</body>
</html>