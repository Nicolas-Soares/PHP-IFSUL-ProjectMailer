<?php
session_start();
	if(empty($_SESSION["Email"])||empty($_COOKIE["Logado"])){
		header("Location: login.php");  //acredito que isso se encaixe no parametro:
        //Deve utilizar controle de sessão para evitar o acesso indevido ao ambiente seguro.
        //vou confirmar o que este trecho faz, peguei do projeto de php  e confesso q n lembro mt bem, essa parte aq é cmg
        //so deixando anotado
        //PENDENTE
	}
	$nomeserver = "localhost"; 
		$database = "teste_bd";
		$username = "root";
		$senha = "";
		$link = mysqli_connect($nomeserver, $username, $senha, $database);
?>
<HTML>
	<HEAD>
		<TITLE> Facecopy- viva o hoje, esqueça o amanhã</TITLE>
		<link rel = "stylesheet" href="layout1.css"> <!-- confirmarei com o prof se a pagina interna pode ser somente isso
        ou se necessita realmente de conteudo-->
		<META CHARSET="UTF-8">
	</HEAD>
	<BODY>
		<HEADER>
				<H1 id="tit">PÁGINA INTERNA SEGURA - PARA TESTES</H1>
		</HEADER>
</HTML>