<?php
    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST')  
    {
        $numero = $_POST["numero"];
        $pergunta = $_POST["pergunta"];
        $resp = $_POST["resp"];
        $msg = "";
        if (!file_exists("perguntasD.txt"))
        {
            $arqDisc = fopen("perguntasD.txt","w") or die("erro ao criar arquivo");
            $linha = "numero;pergunta;resp;\n";
            fwrite($arqDisc, $linha);
            fclose($arqDisc);
        }
        $arqDisc = fopen("perguntasD.txt","a") or die("erro ao Abrir o arquivo");
        $linha = $numero . ";" . $pergunta . ";". $resp ."\n";
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
                <a href="listaP.html">Listar pergunta</a>
            </nav>
        </header>

        <h1>Criar nova pergunta</h1>
        <form action="incluir.php" method="POST">
                Numero da pergunta: <input type="text" name="numero">
                <br><br>
                Pergunta: <input type="text" name="pergunta">
                <br><br>
                Resposta: <input type="text" name="resp">
                <input type="submit" value="Criar pergunta">
        </form>
        
        <p><?php echo $msg ?></p>
        <br>
    </body>
</html>
