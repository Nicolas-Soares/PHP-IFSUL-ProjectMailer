<?php
	session_start();
	$nomeserver = "localhost";
	$database = "teste_bd";
	$username = "root";
	$senha = "";
	$conexao = mysqli_connect($nomeserver, $username, $senha, $database);
	
	if (mysqli_connect_errno()) {
		echo "Erro de Conexão: " . mysqli_connect_error();
	}
	
	function verificalogin($conexao,$email,$senha) {
		$query = "SELECT * FROM usuarios WHERE email LIKE '$email' AND senha LIKE '$senha'";
		$resultado = mysqli_query($conexao,$query) or die(mysqli_error($conexao));
		if((mysqli_num_rows($resultado) > 0) && ($_SESSION["palavra"] === $_POST["palavra"])) //com este if ele sempre dá false if($resultado==true)// com este if ele sempre da true...
		{
			$_SESSION["Email"]= $_POST['Email'];//$Email
	     	setcookie("Logado", 1, time()+60*10);
			return true;
		}
		else {
			return false;
		}	
	}
	
	if(!empty($_POST['Enviar'])) {
		$email= $_POST['Email'];
		$senha= $_POST['Senha'];
		$senha = md5($senha);

		if(verificalogin($conexao,$email,$senha)){ 
			header("Location:paginainterna.php");
		}
		else {
			echo "Email, senha ou Captcha incorretos!";
		}
	}	
?>
<html>
	<head>
		<TITLE>Facecopy - Se conecte ao mundo</TITLE>
		<link rel = "stylesheet" href="./layouts/loginlayout.css">
		<META CHARSET="UTF-8">
	</head>
	<body>
		<header>
				<h1 id="tit">Facecopy - Login</h1>
		</header>
		<main>
			<section>
				<form name="login" enctype="multipart/form-data"  method="POST" action="login.php">
					
					<legend> Fazer Login </legend>
						<label> Email: </label> <input type="email" name="Email" placeholder="Digite seu e-mail" ><br>
						<label> Senha: </label> <input type="password" name="Senha" placeholder="Digite sua senha" ><br>

						<br><img src="captcha.php?l=200&a=55&tf=30&ql=5"><br>		
						<input type="text" name="palavra"/>
						<br>
						<input type="submit" name="Enviar" value="Logar">
						<a href="recsenha.php"><button type="button" name ="recuperaSenha"> Esqueci minha senha </button> </a> 
				</form>
			</section>
		</main>
	</body>
</html>
 