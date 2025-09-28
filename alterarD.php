<?php
    $msg = "";
    $perguntas = [];

    if (file_exists("perguntasD.txt")) 
    {
        $arqDisc = fopen("perguntasD.txt", "r") or die("erro ao abrir o arquivo");
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
        $numPergunta = $_POST["numero_pergunta"];
        $novoNumero = $_POST["numero"];
        $novaPergunta = $_POST["pergunta"];
        $novaResp = $_POST["resp"];
        
        for ($i = 0; $i < count($perguntas); $i++) 
        {
            if ($perguntas[$i][0] == $numPergunta) 
            {
                $perguntas[$i] = [$novoNumero, $novaPergunta, $novaResp];
                break;
            }
        }

        $arqDisc = fopen("perguntasD.txt", "w") or die("Erro ao abrir o arquivo.");
        fwrite($arqDisc, "numero;pergunta;resp\n");
        foreach ($perguntas as $pergunta) 
        {
            $linha = implode(";", $pergunta) . "\n";
            fwrite($arqDisc, $linha);
        }
        fclose($arqDisc);

        $msg = "Pergunta discursiva atualizada com sucesso!";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alterar pergunta discursiva</title>
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
        
        <h1>Alterar Pergunta Discursiva</h1>
        <form method="POST">
            <label for="numero_pergunta">Numero da pergunta a ser alterada:</label>
            <input type="text" name="numero_pergunta" required><br><br>

            <label for="numero">Novo numero:</label>
            <input type="text" name="numero" required><br>

            <label for="pergunta">Nova Pergunta:</label>
            <input type="text" name="pergunta" required><br><br>

            <label for="resp">Nova Resposta:</label>
            <input type="text" name="resp" required><br><br>

            <input type="submit" value="Atualizar Pergunta">
        </form>
        
        <p><?php echo $msg; ?></p>
    </body>
</html>