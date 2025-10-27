<?php
require 'auth.php';

if (!adm()) {
    header('Location: index.php');
    exit;
}

$msg = '';

if ($_POST) {
    if ($_POST['acao'] == 'add') {
        $user = trim($_POST['user']);
        $pass = trim($_POST['pass']);
        $nome = trim($_POST['nome']);
        $tipo = $_POST['tipo'];
        
        $stmt = $conn->prepare("INSERT INTO users (user, pass, nome, tipo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user, $pass, $nome, $tipo);
        
        if ($stmt->execute()) {
            $msg = 'Usuário adicionado!';
        } else {
            $msg = 'Erro ao adicionar!';
        }
        $stmt->close();
    }
    
    if ($_POST['acao'] == 'del') {
        $id = (int)$_POST['id'];
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $msg = 'Usuário removido!';
        } else {
            $msg = 'Erro ao remover!';
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM users ORDER BY id");
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Usuários</title>
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

    <h1>Usuários</h1>

    <?php if ($msg): ?>
        <div class="msg success"><?= $msg ?></div>
    <?php endif; ?>

    <h2>Novo</h2>
    <form method="POST">
        <input type="hidden" name="acao" value="add">
        <div class="form-group">
            <label>Usuário:</label><br>
            <input type="text" name="user" required>
        </div>
        <div class="form-group">
            <label>Senha:</label><br>
            <input type="text" name="pass" required>
        </div>
        <div class="form-group">
            <label>Nome:</label><br>
            <input type="text" name="nome" required>
        </div>
        <div class="form-group">
            <label>Tipo:</label><br>
            <select name="tipo">
                <option value="aluno">Aluno</option>
                <option value="adm">Adm</option>
            </select>
        </div>
        <button type="submit">Add</button>
    </form>

    <h2>Lista</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= $u['user'] ?></td>
            <td><?= $u['nome'] ?></td>
            <td><?= $u['tipo'] ?></td>
            <td>
                <?php if ($u['id'] != $_SESSION['user']['id']): ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="acao" value="del">
                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                    <button type="submit" onclick="return confirm('Del?')">Del</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
