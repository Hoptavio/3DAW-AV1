<?php
    $msg = "";
    $perguntas = [];

    if (file_exists("perguntas.txt")) 
    {
        $arqDisc = fopen("perguntas.txt", "r") or die("erro ao abrir o arquivo");
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
        $novaOpcao1 = $_POST["opcao1"];
        $novaOpcao2 = $_POST["opcao2"];
        $novaOpcao3 = $_POST["opcao3"];
        $novaOpcao4 = $_POST["opcao4"];
        $novaOpcao5 = $_POST["opcao5"];
        $novoGabarito = $_POST["gabarito"];

        for ($i = 0; $i < count($perguntas); $i++) 
        {
            if ($perguntas[$i][0] == $numPergunta) 
            {
                $perguntas[$i] = [$novoNumero, $novaPergunta, $novaOpcao1, $novaOpcao2, $novaOpcao3, $novaOpcao4, $novaOpcao5, $novoGabarito];
                break;
            }
        }

        $arqDisc = fopen("perguntas.txt", "w") or die("Erro ao abrir o arquivo.");
        fwrite($arqDisc, "numero;pergunta;opcao1;opcao2;opcao3;opcao4;opcao5;gabarito\n");
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
        <title>Alterar pergunta multipla escolha</title>
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
        
        <h1>Alterar Pergunta Multipla Escolha</h1>
        <form method="POST">
            <label for="numero_pergunta">Numero da pergunta a ser alterada:</label>
            <input type="text" name="numero_pergunta" required><br><br>

            <label for="numero">Novo numero:</label>
            <input type="text" name="numero" required><br>

            <label for="pergunta">Nova Pergunta:</label>
            <input type="text" name="pergunta" required><br><br>

            <label for="opcao1">Nova opcao 1:</label>
            <input type="text" name="opcao1" required><br>

            <label for="opcao2">Nova opcao 2:</label>
            <input type="text" name="opcao2" required><br>

            <label for="opcao3">Nova opcao 3:</label>
            <input type="text" name="opcao3" required><br>

            <label for="opcao4">Nova opcao 4:</label>
            <input type="text" name="opcao4" required><br>

            <label for="opcao5">Nova opcao 5:</label>
            <input type="text" name="opcao5" required><br><br>

            <label for="gabarito">Novo Gabarito:</label>
            <input type="text" name="gabarito" required><br><br>

            <input type="submit" value="Atualizar Pergunta">
        </form>
        
        <p><?php echo $msg; ?></p>
    </body>
</html>