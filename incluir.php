<?php
    $msg = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST')  
    {
        $numero = $_POST["numero"];
        $pergunta = $_POST["pergunta"];
        $opcao1 = $_POST["opcao1"];
        $opcao2 = $_POST["opcao2"];
        $opcao3 = $_POST["opcao3"];
        $opcao4 = $_POST["opcao4"];
        $opcao5 = $_POST["opcao5"];
        $gabarito = $_POST["gabarito"];
        $msg = "";
        
        if (!file_exists("perguntas.txt"))
        {
            $arqDisc = fopen("perguntas.txt","w") or die("erro ao criar arquivo");
            $linha = "numero;pergunta;opcao1;opcao2;opcao3;opcao4;opcao5;gabarito\n";
            fwrite($arqDisc, $linha);
            fclose($arqDisc);
        }
        $arqDisc = fopen("perguntas.txt","a") or die("erro ao Abrir o arquivo");
        $linha = $numero . ";" . $pergunta . ";" . $opcao1 . ";".$opcao2.";" . $opcao3 .";" . $opcao4 .";" . $opcao5 .";" . $gabarito ."\n";
        fwrite($arqDisc, $linha);
        fclose($arqDisc);
        $msg = "Pergunta criada com sucesso!";        
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Incluir pergunta multipla escolha</title>
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

        <h1>Criar nova pergunta multipla escolha</h1>
        <form method="POST">
            Numero da pergunta: <input type="text" name="numero" required>
            <br><br>
            Pergunta: <input type="text" name="pergunta" required>
            <br><br>
            Opção 1: <input type="text" name="opcao1" required>
            <br><br>
            Opção 2: <input type="text" name="opcao2" required>
            <br><br>
            Opção 3: <input type="text" name="opcao3" required>
            <br><br>
            Opção 4: <input type="text" name="opcao4" required>
            <br><br>
            Opção 5: <input type="text" name="opcao5" required>
            <br><br>
            Gabarito: <input type="text" name="gabarito" required>
            <br><br>
            <input type="submit" value="Criar pergunta">
        </form>
        
        <p><?php echo $msg ?></p>
        <br>
    </body>
</html>