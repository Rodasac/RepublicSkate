<?php
try{
    if(isset($_GET['id'])){
        $novedadRepository = $entityManager->getRepository('Novedades');
        $novedad = $novedadRepository->find($_GET['id']);
    }
    else {
        throw new Exception();
    }
}
catch(Exception $e){
    $novedad = false;
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
        <div class="panel">
            <h1 class="Titles"><?php echo $novedad->getName(); ?></h1>
            <div class="panel">
                <?php if($novedad): ?>
                        <img width="200px" src="/uploads<?php echo $novedad->getImagen(); ?>"/>
                        <p><?php echo $novedad->getDescripcion(); ?></p>
                        <?php if( Sentry::check()):?>
                            <?php if ($user->hasAccess('write')): ?>
                            <div class="row">
                                <form class="right" action="/upnovedad/" method="post">
                                    <input name="id" type="hidden" value="<?php echo $novedad->getId();?>">
                                    <input class="button round" name="submit" type="submit" value="Modificar">
                                </form>
                                <form class="right" action="/delnovedad/" method="post">
                                    <input name="id" type="hidden" value="<?php echo $novedad->getId();?>">
                                    <input class="button alert round" name="submit" type="submit" value="Borrar">
                                </form>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                <?php else: ?>
                    <div class="alert radius">
                        <h2> No existen productos</h2>
                    </div>
                    <hr>
                <?php endif; ?>
            </div>
        </div>
    </article>
</section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
<?php require_once dirname(__FILE__)."/../scripts.php" ?>
</body>
</html>