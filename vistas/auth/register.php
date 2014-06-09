<?php

if (isset($_POST['submit'])) {
  
    // validate input and create user record
    // send activation code by email to user
    try {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $fname = strip_tags($_POST['first_name']);
        $lname = strip_tags($_POST['last_name']);
        $password = strip_tags($_POST['password']);

        $perfil = new Perfil();
        $user = Cartalyst\Sentry\Facades\Native\Sentry::createUser(array(
            'email'    => $email,
            'password' => $password,
            'first_name' => $fname,
            'last_name' => $lname,
            'activated' => true,
            'permissions' => array('read' => 1, 'write' => -1)
        ));
        $perfil->setUserId($user->id);
        $perfil->setCi(strip_tags($_POST['ci']));
        $perfil->setRif(strip_tags($_POST['rif']));

        $entityManager->persist($perfil);
        $entityManager->flush();
        header("location: /");
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <?php require_once dirname(__FILE__) . "/../head.php" ?>
    <body>
        <?php require_once dirname(__FILE__)."/../header.php" ?>
        <section class="row">
            <article class="large-12 columns">
                <div class="panel">
                    <h1 class="Titles">Registrarse</h1>
                    <form class ="row" action="/registrarse/" method="post">
                        <label>Email:</label>
                        <input type="email" name="email" placeHolder="Escriba su email aquí"/>
                        <label>Contraseña:</label>
                        <input type="password" name="password" placeHolder="Escriba su contraseña aquí"/>
                        <label>Nombre:</label>
                        <input type="text" name="first_name" placeHolder="Escriba su nombre aquí"/><br/>
                        <label>Apellido:</label>
                        <input type="text" name="last_name" placeHolder="Escriba su apellido aquí"/><br/>
                        <label>Cédula de Identidad: <sub>sin puntos ni comas</sub></label>
                        <input type="number" name="ci" placeHolder="Escriba su cédula aquí"/><br/>
                        <label>RIF:</label>
                        <input type="text" name="rif" placeHolder="Escriba su RIF aquí"/> <br/>
                        <input class="button radius round" type="submit" name="submit" value="Registrar" />
                    </form>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>