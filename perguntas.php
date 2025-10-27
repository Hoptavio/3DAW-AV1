<?php
require 'auth.php';

if (!adm()) {
    header('Location: index.php');
    exit;
}

$msg = '';

if ($_POST) {
    if ($_POST['acao'] == 'add') {
        $numero = trim($_POST['numero']);
        $pergunta_texto = trim($_POST['pergunta']);
        $tipo = $_POST['tipo'];
        
        if (empty($numero) || empty($pergunta_texto)) {
            $msg = 'Número e pergunta são obrigatórios!';
        } else {
            if ($tipo == 'multipla') {
                $opcoes_raw = $_POST['opcoes'] ?? [];
                $opcoes = [];
                foreach ($opcoes_raw as $opcao) {
                    $opcao_limpa = trim($opcao);
                    if (!empty($opcao_limpa)) {
                        $opcoes[] = $opcao_limpa;
                    }
                }
                
                $gab = $_POST['gab'] ?? '';
                if (count($opcoes) < 2) {
                    $msg = 'Múltipla escolha precisa de pelo menos 2 opções!';
                } elseif (empty($gab) || $gab < 1 || $gab > count($opcoes)) {
                    $msg = 'Gabarito inválido!';
                } else {
                    $opcoes_json = json_encode($opcoes);
                    $stmt = $conn->prepare("INSERT INTO perguntas (numero, pergunta, tipo, opcoes, gab) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $numero, $pergunta_texto, $tipo, $opcoes_json, $gab);
                    
                    if ($stmt->execute()) {
                        $msg = 'Pergunta de múltipla escolha adicionada!';
                    } else {
                        $msg = 'Erro ao salvar!';
                    }
                    $stmt->close();
                }
            } else {
                $resp = trim($_POST['resp'] ?? '');
                if (empty($resp)) {
                    $msg = 'Resposta é obrigatória!';
                } else {
                    $stmt = $conn->prepare("INSERT INTO perguntas (numero, pergunta, tipo, resp) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $numero, $pergunta_texto, $tipo, $resp);
                    
                    if ($stmt->execute()) {
                        $msg = 'Pergunta discursiva adicionada!';
                    } else {
                        $msg = 'Erro ao salvar!';
                    }
                    $stmt->close();
                }
            }
        }
    }
    
    if ($_POST['acao'] == 'del') {
        $id = (int)$_POST['id'];
        $stmt = $conn->prepare("DELETE FROM perguntas WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $msg = 'Pergunta removida!';
        } else {
            $msg = 'Erro ao remover!';
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM perguntas ORDER BY id DESC");
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
        <div class="msg <?= strpos($msg, 'Erro') !== false ? 'error' : 'success' ?>"><?= $msg ?></div>
    <?php endif; ?>

    <h2>Nova Pergunta</h2>
    <form method="POST" id="formPergunta">
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
            <select name="tipo" id="tipo" onchange="mudarTipo()" required>
                <option value="multipla">Múltipla Escolha</option>
                <option value="discursiva">Discursiva</option>
            </select>
        </div>
        
        <div id="multipla">
            <h3>Opções de Resposta:</h3>
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <div class="form-group">
                <label>Opção <?= $i ?>:</label><br>
                <input type="text" name="opcoes[]" class="opcao-input" placeholder="Digite a opção <?= $i ?>">
            </div>
            <?php endfor; ?>
            <div class="form-group">
                <label>Gabarito:</label><br>
                <select name="gab" id="gab-select" required>
                    <option value="">Selecione a opção correta</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>">Opção <?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        
        <div id="discursiva" style="display:none;">
            <div class="form-group">
                <label>Resposta Esperada:</label><br>
                <textarea name="resp" class="resp-input"></textarea>
            </div>
        </div>
        
        <button type="submit">Adicionar Pergunta</button>
    </form>

    <h2>Lista de Perguntas (<?= count($perguntas) ?>)</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Número</th>
            <th>Pergunta</th>
            <th>Tipo</th>
            <th>Data</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($perguntas as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['numero']) ?></td>
            <td><?= htmlspecialchars(substr($p['pergunta'], 0, 50)) ?>...</td>
            <td><?= $p['tipo'] == 'multipla' ? 'Múltipla' : 'Discursiva' ?></td>
            <td><?= date('d/m/Y', strtotime($p['data_criacao'])) ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="acao" value="del">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <button type="submit" onclick="return confirm('Excluir esta pergunta?')">Excluir</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script>
    function mudarTipo() {
        var tipo = document.getElementById('tipo').value;
        var multipla = document.getElementById('multipla');
        var discursiva = document.getElementById('discursiva');
        
        if (tipo === 'multipla') {
            multipla.style.display = 'block';
            discursiva.style.display = 'none';
            document.querySelectorAll('.opcao-input').forEach(function(input) {
                input.required = true;
            });
            document.getElementById('gab-select').required = true;
            document.querySelector('.resp-input').required = false;
        } else {
            multipla.style.display = 'none';
            discursiva.style.display = 'block';
            document.querySelectorAll('.opcao-input').forEach(function(input) {
                input.required = false;
            });
            document.getElementById('gab-select').required = false;
            document.querySelector('.resp-input').required = true;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        mudarTipo();
    });
    </script>
</body>
</html>
