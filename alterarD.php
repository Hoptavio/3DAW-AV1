<?php
    $msg = "";
    $perguntas = [];

    if (file_exists("perguntas.txt")) 
    {
        $arqDisc = fopen("perguntas.txt", "r") or die("erro ao abrir o arquivo");
        while (($linha = fgets($arqDisc)) !== false) {
            $perguntas[] = explode(";", trim($linha));
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

        $arqDisc = fopen("perguntas.txt", "w") or die("Erro ao abrir o arquivo.");
        foreach ($perguntas as $pergunta) 
        {
            $linha = implode(";", $pergunta) . "\n";
            fwrite($arqDisc, $linha);
        }
        fclose($arqDisc);

        $msg = "Pergunta atualizada com sucesso!";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Alterar pergunta</title>
    </head>
    <body>
        <header>
            <nav>
                <a href="Usuario.php">Incluir usuario</a> |
                <a href="incluir.php">Incluir pergunta multipla escolha</a> |
                <a href="incluirD.php">Incluir pergunta discursiva</a> |
                <a href="alterar.php">Alterar pergunta</a> |
                <a href="excluir.php">Excluir pergunta</a> |
                <a href="listaP.html">Listar pergunta</a>
            </nav>
        </header>
        
        <h1>Alterar Disciplina</h1>
        <form method="POST">
            <label for="numero_pergunta">Numero da pergunta a ser alterada:</label>
            <input type="text" name="numero_pergunta" required><br><br>

            <label for="numero">Novo numero:</label>
            <input type="text" name="numero" required><br>

            <label for="pergunta">Nova Pergunta:</label>
            <input type="text" name="pergunta" required><br><br>

            <label for="resp">Nova Resposta:</label>
            <input type="text" name="resp" required><br> 

            <input type="submit" value="Atualizar Pergunta">
        </form>
    </body>
</html>
