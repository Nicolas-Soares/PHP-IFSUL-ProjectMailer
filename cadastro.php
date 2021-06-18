<?php
	if(!empty($_POST['EnviarCadastro'])) {
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
		$email=$_POST['Email'];
		$hash= $_POST['Senha'];
		$senha=md5($hash);
		$nome = $_POST['Nome'];
		$idade = $_POST['Idade'];
			
		$sql = "INSERT INTO usuarios (nome, idade, email, senha) VALUES ('$nome', '$idade', '$email','$senha')";

		if(mysqli_query($conexao,$sql)==true){
			header("Location:login.php");
		} else {
			echo "Erro ao ir para a página de login";
		}	
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./layouts/loginlayout.css">
	<title>Cadastre-se</title>
</head>
<body>
	<header><h1>Cadastro</h1></header>
		<section>
			<form name="cadastro" enctype="multipart/form-data"  method="POST" action="cadastro.php">
				<label for="Email">Email: </label>
				<input type="email" name="Email"/>
  				<br>
				<label for="Email">Senha: </label>
				<input type="password" name="Senha"/>
				<br>
				<label for="Nome">Nome: </label>
				<input type="text" name="Nome"/>
				<br>
				<label for="Idade">Idade: </label>
				<input type="number" name="Idade"/>
				<br>
				<input type="submit" name="EnviarCadastro" value="Cadastrar">
			</form>
		</section>
</body>
</html>