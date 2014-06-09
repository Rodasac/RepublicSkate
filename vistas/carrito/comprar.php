<?php
try {
    if(isset($_POST['submit'])) {
        session_start();
        $user = Sentry::getUser();

        $categoryRepository = $entityManager->getRepository('Category');
        $categories = $categoryRepository->findAll();
        $productRepository = $entityManager->getRepository('Product');
        $products = array();

        for($i = 0; $i < count($_POST['id']); $i++){
            $product = $productRepository->find($_POST['id'][$i]);
            $products[$i] = array(
                "id" => $product->getId(),
                "nombre" => $product->getName(),
                "disp" => $product->getCantidad(),
                "precio" => $product->getPrecio(),
                "cantOrd" => $_POST['cantOrd'][$i]);

        }
        $products[] = array("total" => $_POST['total']);

        $jprod = json_encode($products, JSON_FORCE_OBJECT);
        $ticket = new Ticket();
        $ticket->setUser($user->email);
        $ticket->setStatus(true);
        $ticket->setProducts($jprod);

        /*
        Cabeceras donde se especifica a quien va dirigido (To),
        el remitente (From),
        A quien responder (Reply to),
        se envia copia a algunamigo@gmail.com (CC),
        una copia oculta a otroamigo@gmail.com (Bcc).
        */

        $cabeceras = 'To: ' .$user->email. " \r\n" .
            'From: admin@republicskate.tk' . "\r\n" .
            'Reply-To: admin@republicskate.tk' . "\r\n".
            'Cc: republicskate@outlook.com' . "\r\n".
            'X-Mailer: PHP/' . phpversion();

        $mensaje = "Hola ". $user->first_name . " " . $user->last_name .
            " Escribir el mensaje aquí";
        $mensaje = wordwrap($mensaje, 70, "\r\n");

        $asunto = "Compra en Republic Skate";



        if(mail($user->email,$asunto,$mensaje,$cabeceras))
            $seEnvio = true;
        else
            $seEnvio = false;

        if($seEnvio == true)
        {
            $entityManager->persist($ticket);
            $entityManager->flush();
            unset($_SESSION['carrito']);
        }
        else
        {
            throw new Exception();
        }
        $cabecerasAdmin = 'To: republicskate@outlook.com'. " \r\n" .
            'From: admin@republicskate.tk' . "\r\n" .
            'Reply-To: admin@republicskate.tk' . "\r\n".
            'Cc: republicskate@outlook.com' . "\r\n".
            'X-Mailer: PHP/' . phpversion();

        $mensajeAdmin = "Hola administrador se ha solicitado una nueva compra<br/>".
            "El id del ticket es: ". $ticket->getId();
        $asuntoAdmin = "Compra en Republic Skate";
        if(mail("republicskate@outlook.com",$asuntoAdmin,$mensajeAdmin,$cabecerasAdmin))
            header('Location: /?email=true');
        else
            throw new Exception();
    }
    else{
        header('Location: /');
    }
}
catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<?php if(isset($error)): ?>
    <!DOCTYPE html>
    <html>
    <?php require_once dirname(__FILE__) . "/../head.php" ?>
    <body>
    <?php require_once dirname(__FILE__)."/../header.php" ?>
    <?php require_once dirname(__FILE__)."/../aside.php" ?>
    <section class="row">
        <article class="small-9 medium-9 large-9 columns">
            <div class="panel round">
                <div class="alert-box alert round">
                    <h1>Error</h1>
                    <p>
                        No se pudo enviar el email.
                        <span><?php echo $error; ?></span>
                    </p>
                </div>
            </div>
        </article>
    </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
    <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
    </html>
<?php endif; ?>