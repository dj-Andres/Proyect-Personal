<?php

    include_once '../modelo/usuario.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Load Composer's autoloader
    require '../vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    $usuario=new usuario();

    if($_POST['funcion']=='recuperar_clave') {
        $cedula=$_POST['cedula'];
        $correo=$_POST['correo'];

        $usuario->recuperar_clave($cedula,$correo);
    }

    if($_POST['funcion']=='generar') {
        $cedula=$_POST['cedula'];
        $correo=$_POST['correo'];

        $codigo=generar(10);

        echo $codigo;
        $usuario->reemplazar($codigo,$correo,$cedula);
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp-mail.outlook.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'diego96jimenez@outlook.com';                     // SMTP username
            $mail->Password   = '619andres';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('diego96jimenez@outlook.com', 'Sistema Administrativo');
            $mail->addAddress($correo);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Restablecer contraseña';
            $mail->Body    = 'La nueva contrasena es: <b>'.$codigo.'</b>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->SMTPDebug=false;
            $mail->do_debug=false;
            $mail->send();
            echo 'enviado';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }

    function generar($longitud){
        $key="";
        $patron="1234567890abcdefghijklnñmopqrszws";
        $max=strlen($patron)-1;
        for($i=0;$i < $longitud;$i++)
        {
            $key.=$patron[rand(0,$max)];
        }
        return $key;

    }
