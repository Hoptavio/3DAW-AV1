<?php
    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST')  
    {
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cargo = $_POST["cargo"];
        
        if (!file_exists("usuarios.txt"))
        {
            $arqUser = fopen("usuarios.txt","w") or die("erro ao criar arquivo");
            $linha = "id;nome;email;cargo\n";
            fwrite($arqUser, $linha);
            fclose($arqUser);
        }
        
        $arqUser = fopen("usuarios.txt","a") or die("erro ao Abrir o arquivo");
        $linha = $id . ";" . $nome . ";" . $email . ";" . $cargo . "\n";
        fwrite($arqUser, $linha);
        fclose($arqUser);
        $msg = "Usuário cadastrado com sucesso!";        
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar Usuário</title>
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

        <h1>Cadastrar Usuário</h1>
        <form method="POST">
            ID: <input type="text" name="id" required>
            <br><br>
            Nome: <input type="text" name="nome" required>
            <br><br>
            Email: <input type="email" name="email" required>
            <br><br>
            Cargo: <input type="text" name="cargo" required>
            <br><br>
            <input type="submit" value="Cadastrar Usuário">
        </form>
        
        <p><?php echo $msg ?></p>
    </body>
</html>