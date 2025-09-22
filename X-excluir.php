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
        $opcao4 = $_POST["opcao5"];
        $gabarito = $_POST["gabarito"];
        $novo =
        $msg = "";
        if (!file_exists("perguntas.txt"))
        {
            $arqDisc = fopen("perguntas.txt","w") or die("erro ao criar arquivo");
            $linha = "numero;pergunta;opcao1;opcao2;opcao3;opcao4;opcao5;gabarito\n";
            fwrite($arqDisc, $linha);
            fclose($arqDisc);
        }
        $arqDisc = fopen("perguntas.txt","a+") or die("erro ao Abrir o arquivo");
        $linha = "\n";
        while(!feof($arq)){
            
        }
        fwrite($arqDisc, $linha);
        fclose($arqDisc);
        $msg = "Deu tudo certo!!!";        
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Incluir pergunta</title>
    </head>
    <body>
        <header>
            <nav>
                <a href="Usuario.php">Incluir usuario</a> |
                <a href="incluir.php">Incluir pergunta multipla escolha</a> |
                 <a href="incluirD.php">Incluir pergunta discursiva</a> |
                <a href="alterar.php">Alterar pergunta</a> |
                <a href="excluir.php">Excluir pergunta</a> |
                <a href="lista.php">Listar pergunta</a>
            </nav>
        </header>

        <h1>Exclua uma pergunta</h1>
        <form action="incluir.php" method="POST">
                Numero da pergunta: <input type="text" name="numero">
                <input type="submit" value="Exclue pergunta">
        </form>
        
        <p><?php echo $msg ?></p>
        <br>
    </body>
</html>
