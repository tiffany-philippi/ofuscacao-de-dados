<?php
// Conexão ao Banco de Dados
include 'conecta_sql.php';

// Para salvar contato do usuario

  
        $nome = $_REQUEST['nome'];
        $email = $_REQUEST['email'];
        $telefone = $_REQUEST['telefone'];
        $assunto = $_REQUEST['texto'];

        $sql = "INSERT INTO `usuario`(`nome`, `email`, `telefone`, `assunto`)
        VALUES ('".$nome."', '".$email."', '".$telefone."', '".$assunto."')";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

?>