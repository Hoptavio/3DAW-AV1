<?php
    $msg = "";
    $perguntas = [];

    if (file_exists("perguntas.txt")) 
    {
        $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo.");
        $firstLine = true;
        while (($linha = fgets($arqDisc)) !== false) 
        {
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
    else 
    {
        $msg = "Arquivo de perguntas não encontrado";
    }

    if (isset($_GET['opcao'])) 
    {
        $opcao = $_GET['opcao'];

        if ($opcao == 'uma' && isset($_GET['numero'])) 
        {
            $numero = $_GET["numero"];
            if (!empty($numero)) 
            {
                $filtered = [];
                foreach ($perguntas as $pergunta) {
                    if ($pergunta[0] == $numero) {
                        $filtered[] = $pergunta;
                    }
                }
                $perguntas = $filtered;

                if (empty($perguntas)) 
                {
                    $msg = "Pergunta não encontrada";
                }
            } 
            else 
            {
                $msg = "Por favor, insira o numero da pergunta";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lista de Perguntas Multipla Escolha</title>
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

        <h1>Lista de perguntas multipla escolha</h1>

        <?php if (!empty($perguntas)): ?>
        <table border="1">
            <tr>
                <th>Número</th>
                <th>Pergunta</th>
                <th>Opção 1</th>
                <th>Opção 2</th>
                <th>Opção 3</th>
                <th>Opção 4</th>
                <th>Opção 5</th>
                <th>Gabarito</th>
            </tr>
            <?php foreach ($perguntas as $pergunta): ?>
            <tr>
                <td><?php echo htmlspecialchars($pergunta[0]); ?></td>
                <td><?php echo htmlspecialchars($pergunta[1]); ?></td>
                <td><?php echo htmlspecialchars($pergunta[2]); ?></td>
                <td><?php echo htmlspecialchars($pergunta[3]); ?></td>
                <td><?php echo htmlspecialchars($pergunta[4]); ?></td>
                <td><?php echo htmlspecialchars($pergunta[5]); ?></td>
                <td><?php echo htmlspecialchars($pergunta[6]); ?></td>
                <td><?php echo htmlspecialchars($pergunta[7]); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p>Nenhuma pergunta encontrada</p>
        <?php endif; ?>

        <?php if (!empty($msg)) { echo "<p>$msg</p>"; } ?>

        <br>
        <a href="listaP.html">Voltar</a>
    </body>
</html>