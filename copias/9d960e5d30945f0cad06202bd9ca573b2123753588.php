<?php
    session_start();
    $emailMD5 = $_SESSION["verificacaotabela"];

    if(!empty($_POST['Enviar']))
	{
		$nomeserver = "localhost";
		$database = "teste_bd";
		$username = "root";
		$senha = "";
		$conexao = mysqli_connect($nomeserver, $username, $senha, $database);
		if (mysqli_connect_errno())
		{
			echo "Erro de Conexão: " . mysqli_connect_error();
		}

		//DADOS SIMULATIVOS DE UMA REDE SOCIAL
		$hash= $_POST['Senha'];
		$senha = md5($hash);
		
		
		$sql = "UPDATE usuarios SET senha = '$senha' WHERE verificacaotabela = '$emailMD5'"; //colocar codigo aleatorio pra identificar usuario
		if(mysqli_query($conexao,$sql) == true){
            $query = "drop event myevent";
            mysqli_query($conexao, $query);

            $query = "UPDATE usuarios SET verificacaotabela = null WHERE verificacaotabela = '$emailMD5'";
            mysqli_query($conexao, $query);
            unlink(__FILE__);
			header("Location: ../login.php");
		} else {
            echo "Erro no query!";
        }
  }


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="../layouts/reclayout.css">
    <title>🔒 Recuperar Senha 🔒</title>
</head>
<body>
    <header><h1>Esqueci minha senha</h1></header>
    <section>
    <h3>Insira a nova senha</h3>
     <form name="recsenha" enctype="multipart/form-data"  method="POST">
    <label> Nova senha: </label> <input type="password" name="Senha" placeholder="Digite sua senha" ><br>
        <input type="submit" name="Enviar">
    </form>
    </section>
</body>
</html>