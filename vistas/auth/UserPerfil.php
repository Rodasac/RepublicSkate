<?php
try{

$user3 = Sentry::getUser();
$perfilRepository = $entityManager->getRepository('Perfil');
$perfil = $perfilRepository->findOneBy(array("user_id" => $user3->id));
}
catch(Exception $e){
    $user2 = false;
}


?>
<!DOCTYPE html>
<html>
    <?php require_once dirname(__FILE__) . "/../head.php" ?>
    <body>
        <?php require_once dirname(__FILE__)."/../header.php" ?>
        <?php require_once dirname(__FILE__)."/../aside.php" ?>
        <section class="row">
            <article class="small-9 medium-9 large-9 columns">
                <?php if(!isset($_POST['confirm'])): ?>
                <div class="panel">
                    <h1 class="Titles">Perfil de Usuario</h1>
                    <div class="panel">
                        <h3>Usuario: <?php echo $user3->email; ?></h3>
                        <p>Nombre Completo: <span> <?php echo $user3->first_name. " " .$user3->last_name; ?></span></p>
                        <p>Cédula: <span> <?php echo $perfil->getCi(); ?></span></p>
                        <p>RIF: <span> <?php echo $perfil->getRif(); ?></span></p>
                        <hr />
                        <form action="/perfil/">
                            <label>Desea eliminar su cuenta?</label>
                            <input id="conf" type="hidden" name="confirm" value="1">
                            <input class="button radius" type="submit" value="Eliminar">
                        </form>
                    </div>
                </div>
                <?php else: ?>
                    <form action="/deleteuser/">
                            <label>¿Quiere continuar?</label>
                            <input type="hidden" name="id" value="<?php echo $user3->id; ?>">
                            <a class="button radius" href="/">Cancelar</a>
                            <input class="button radius" name="submit" type="submit" value="Continuar">
                        </form>
                <?php endif; ?>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>