<?php
    $msg = "";
    $perguntas = [];
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'multipla';

    if ($tipo == 'multipla') {
        $arquivo = "perguntas.txt";
        $header = "numero;pergunta;opcao1;opcao2;opcao3;opcao4;opcao5;gabarito\n";
    } else {
        $arquivo = "perguntasD.txt";
        $header = "numero;pergunta;resp\n";
    }

    if (file_exists($arquivo)) 
    {
        $arqDisc = fopen($arquivo, "r") or die("erro ao abrir o arquivo");
        $firstLine = true;
        while (($linha = fgets($arqDisc)) !== false) {
            if ($firstLine) {
                $firstLine = false;
                continue;
            }
            if (trim($linha) != "") {
                $perguntas[] = explode(";", trim($linha));
            }
        }
        fclose($arqDisc);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        $numeroExcluir = $_POST["numero"];
        $tipo = $_POST["tipo"];
        
        $arquivo = ($tipo == 'multipla') ? "perguntas.txt" : "perguntasD.txt";
        $header = ($tipo == 'multipla') ? "numero;pergunta;opcao1;opcao2;opcao3;opcao4;opcao5;gabarito\n" : "numero;pergunta;resp\n";

        $novasPerguntas = array_filter($perguntas, function($pergunta) use ($numeroExcluir) {
            return $pergunta[0] != $numeroExcluir;
        });

        $arqDisc = fopen($arquivo, "w") or die("Erro ao abrir o arquivo.");
        fwrite($arqDisc, $header);
        foreach ($novasPerguntas as $pergunta) 
        {
            $linha = implode(";", $pergunta) . "\n";
            fwrite($arqDisc, $linha);
        }
        fclose($arqDisc);

        $msg = "Pergunta excluída com sucesso!";
        $perguntas = $novasPerguntas;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Excluir Pergunta</title>
    </head>
    <body>
        <header>
            <nav>
                <a href="Usuario.php">Incluir usuario</a> |
                <a href="incluir.php">Incluir pergunta multipla escolha</a> |
                <a href="incluirD.php">Incluir pergunta discursiva</a> |
                <a href="alterar.php">Alterar pergunta multipla escolha</a> |
                <a href="alterarD.php">Alterar pergunta discursiva</a> |
                <a href="excluir.php">Excluir pergunta</a> |
                <a href="listaP.html">Listar pergunta</a>
            </nav>
        </header>

        <h1>Excluir Pergunta</h1>
        
        <div>
            <a href="excluir.php?tipo=multipla">Perguntas Multipla Escolha</a> | 
            <a href="excluir.php?tipo=discursiva">Perguntas Discursivas</a>
        </div>
        
        <h2>Excluir Pergunta <?php echo $tipo == 'multipla' ? 'Multipla Escolha' : 'Discursiva'; ?></h2>
        
        <form method="POST">
            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
            <label for="numero">Número da pergunta a ser excluída:</label>
            <input type="text" name="numero" required>
            <input type="submit" value="Excluir Pergunta">
        </form>
        
        <p><?php echo $msg ?></p>
        
        <?php if (!empty($perguntas)): ?>
        <h3>Perguntas Existentes</h3>
        <table border="1">
            <tr>
                <th>Número</th>
                <th>Pergunta</th>
                <?php if ($tipo == 'multipla'): ?>
                <th>Gabarito</th>
                <?php else: ?>
                <th>Resposta</th>
                <?php endif; ?>
            </tr>
            <?php foreach ($perguntas as $pergunta): ?>
            <tr>
                <td><?php echo htmlspecialchars($pergunta[0]); ?></td>
                <td><?php echo htmlspecialchars($pergunta[1]); ?></td>
                <td><?php echo htmlspecialchars($tipo == 'multipla' ? $pergunta[7] : $pergunta[2]); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </body>
</html>