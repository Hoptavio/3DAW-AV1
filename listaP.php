<?php
    $msg = "";
    $perguntas = [];

    if (file_exists("perguntas.txt")) 
    {
        $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo.");
        while (($linha = fgets($arqDisc)) !== false) 
        {
            $perguntas[] = explode(";", trim($linha));
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
                $perguntas = array_filter($perguntas, function($pergunta) use ($numero) 
                {
                    return $pergunta[0] == $numero;
                });

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
        <title>Lista de Perguntas</title>
    </head>
    <body>
        <header>
            <nav>
                <a href="incluirUsuario.php">Incluir usuario</a> |
                <a href="incluirPergunta.php">Incluir pergunta</a> |
                <a href="alterarPergunta.php">Alterar pergunta</a> |
                <a href="excluirPergunta.php">Excluir pergunta</a> |
                <a href="listaPergunta.html">Listar pergunta</a>
            </nav>
        </header>

        <h1>Lista de perguntas</h1>

        <table border="1">
            <?php
                $i =0;
                if (!empty($perguntas)) {
                    foreach ($perguntas as $pergunta) 
                    {
                        while(feof($arqDisc)){
                        
                        echo "<td>{$pergunta[$i]}</td>";
                        $i++;
                        echo "</tr>";
                        }
                       
                    }
                }
            ?>
        </table>

        <?php if (!empty($msg)) { echo "<p>$msg</p>"; } ?>

        <br>
        <a href="listaP.html">Voltar</a>
    </body>
</html>
