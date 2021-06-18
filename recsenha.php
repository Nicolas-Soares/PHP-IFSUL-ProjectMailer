<?php
    session_start();

    require("PHPMailer-master/src/PHPMailer.php");
    require("PHPMailer-master/src/SMTP.php");
    require("PHPMailer-master/src/Exception.php");

    //CONEXAO COM O BD --------------------------------------------------

    $nomeserver = "localhost";
    $database = "teste_bd";
    $username = "root";
    $senha = "";
    $conexao = mysqli_connect($nomeserver, $username, $senha, $database);
    if (mysqli_connect_errno())
    {
        echo "Erro de Conexão: " . mysqli_connect_error();
    }

    //FUNÇÕES -----------------------------------------------------------

    function autoDelete($conexao, $resultadoMD5){
        $query = "set global event_scheduler= ON;";
        mysqli_query($conexao, $query);


        $query = "CREATE EVENT myevent ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 HOUR DO UPDATE usuarios SET verificacaotabela = null WHERE verificacaotabela = '$resultadoMD5'";
        mysqli_query($conexao, $query) or die (mysqli_error($conexao));
    }

    function enviarEmail($conexao){
        $email = $_POST['Email'];
        
        $queryEmail = "SELECT email FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($conexao, $queryEmail) or die (mysqli_error($conexao));
        
        if (mysqli_num_rows($resultado) > 0) {
            $resultadoMD5 = md5($email);
            $_SESSION["verificacaotabela"] = $resultadoMD5;

            $query = "UPDATE usuarios SET verificacaotabela = '$resultadoMD5' WHERE email = '$email'";
            mysqli_query($conexao, $query);

            $aleatorio = rand();
        } else {
            echo "Email não cadastrado! ";
            return false;
        }
        
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP();
        //configuração do gmail
        $mail->Port = '465'; //porta usada pelo gmail.
        $mail->Host = 'smtp.gmail.com';
        $mail->IsHTML(true);
        $mail->Mailer = 'smtp';
        $mail->SMTPSecure = 'ssl';
        //configuração do usuário do gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'facecopyrecuperacao@gmail.com'; // usuario gmail.
        $mail->Password = 'ifsul.123'; // senha do email.
        // configuração do email a ver enviado.
        $mail->From = "facecopyrecuperacao@gmail.com";
        $mail->FromName = "Facecopy RECUPERACAO DE SENHA";
        $mail->addAddress($email); // email do destinatario.
        $mail->Subject = "Facecopy RECUPERACAO DE SENHA";
        $mail->Body = "Link: localhost/realteraesnocodigo/copias/" . $resultadoMD5 . $aleatorio . ".php";

        
        if($mail->Send()){
            autoDelete($conexao, $resultadoMD5);

            $file = "trocasenha.php";
            $newFile = $resultadoMD5 . $aleatorio . ".php";
            
            if (!copy($file, "./copias/".$newFile)) {
                echo "Falha ao copiar $file";
            }

            $_SESSION["Email"] = $email;
            return true;
        }else{
            return false;
        }
        
        
    }


    //CONFIRMAÇÃO DO BOTÃO ---------------------------------------------------

    if (!empty($_POST['Enviaremail1'])) {
        if (enviarEmail($conexao) === true) {
            echo "Email de recuperação enviado! Cheque seu email.";
        } else {
            echo "DEU RUIM";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="./layouts/reclayout.css">
    <title>🔒 Recuperar Senha 🔒</title>
</head>
<body>
    <header><h1>Esqueci minha senha</h1></header>
    <section>
        <h3>Insira o e-mail da conta que deseja trocar a senha</h3>
        <form name="recsenha" enctype="multipart/form-data"  method="POST" action="recsenha.php">
            <input type="email" name="Email" placeholder="Seu email aqui"/>
            <input type="submit" name="Enviaremail1">
        </form>
    </section>
</body>
</html>