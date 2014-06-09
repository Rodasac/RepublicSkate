<?php
$user2 = Sentry::getUser();
$perfilRepository = $entityManager->getRepository('Perfil');
$perfil = $perfilRepository->findBy(array("user_id" => $user2->id));
if (isset($_POST['submit'])) {

    // validate input and create user record
    // send activation code by email to user
    try {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $fname = strip_tags($_POST['first_name']);
        $lname = strip_tags($_POST['last_name']);
        $password = strip_tags($_POST['password']);

        $user2->email  = $email;
        if ($password != ""){
            $user2->password = $password;
        }
        $user2->first_name = $fname;
        $user2->last_name = $lname;

        $perfil[0]->setCi(strip_tags($_POST['ci']));
        $perfil[0]->setRif(strip_tags($_POST['rif']));

        $entityManager->persist($perfil[0]);
        $entityManager->flush();
        if ($user2->save())
        {
            header("location: /");
        }
        else
        {
            throw new Exception("Incluye datos correctos");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<?php require_once dirname(__FILE__) . "/../head.php" ?>
<body>
    <?php require_once dirname(__FILE__)."/../header.php" ?>
    <section class="row">
        <article class="large-12 columns">
            <div class="panel">
                <h1 class="Titles">Modificar datos</h1>
                <form class ="row" action="/update/" method="post">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" value="<?php echo $user2->email; ?>"/>
                    <label for="pass">Contraseña:</label>
                    <input id="pass" type="password" name="password" placeHolder="Escriba su contraseña aquí. Si no desea cambiarla dejar en blanco..."/>
                    <label for="name">Nombre:</label>
                    <input id="name" type="text" name="first_name" value="<?php echo $user2->first_name; ?>"/><br/>
                    <label for="apell">Apellido:</label>
                    <input id="apell" type="text" name="last_name" value="<?php echo $user2->last_name; ?>"/> <br/>
                    <label for="ci">Cédula de Identidad: <sub>sin puntos ni comas</sub></label>
                    <input id="ci" type="number" name="ci" value="<?php echo $perfil[0]->getCi(); ?>"/><br/>
                    <label for="rif">RIF:</label>
                    <input id="rif" type="text" name="rif" value="<?php echo $perfil[0]->getRif(); ?>"/> <br/>
                    <input class="button radius round" type="submit" name="submit" value="Actualizar datos" />
                </form>
            </div>
        </article>
    </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
    <?php require_once dirname(__FILE__)."/../scripts.php" ?>
</body>
</html>