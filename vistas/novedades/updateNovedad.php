<?php
try{
    if(isset($_POST['submit'])){
        $novedad = $entityManager->find('Novedades', $_POST['id']);
    }
    elseif(isset($_POST['submit2'])){
        $novedad = $entityManager->find('Novedades', $_POST['id']);
        if(isset($_FILES['imagen']) && $_FILES['imagen'] != null){
        	try {
        	unlink($uploaddir . '/novedades/'. $novedad->getImagen());
        	} catch (Exception $e) {
        		$error = 1;
        	}
            $uploadfile = $uploaddir . '/novedades/'. $_FILES['imagen']['name'];
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile)){
                throw new Exception("La imagen no se pudo subir");
            }
            $file = $_FILES['imagen'];
            $novedad->setImagen('/novedades/'.$file['name']);
        }

        $name = filter_var($_POST['name']);
        $descripcion = strip_tags($_POST['descripcion']);

        $novedad->setName($name);
        $novedad->setDescripcion($descripcion);
        $novedad->setUpdateAt(new DateTime("now"));
        $entityManager->persist($novedad);
        $entityManager->flush();
        header("location: /novedad/?id=".$novedad->getId());
    }
    else {
        throw new Exception();
    }
}
catch (Exception $e){
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
    <?php require_once dirname(__FILE__) . "/../head.php" ?>
    <body>
        <?php require_once dirname(__FILE__)."/../header.php" ?>

        <section class="row">
            <article class="large-9 columns">
                <div class="panel">
                    <h1 class="Titles">Modificar Novedad</h1>
                    <?php if(isset($error)): ?>
                    <div>
                        <div data-alert class="alert-box alert round">
                            Error al guardar el Producto.
                            <p><?php echo $error; ?></p>
                            <a href="#" class="close">&times;</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <form class ="row" action="/upnovedad/" enctype="multipart/form-data" method="post">
                        <input name="id" type="hidden" value="<?php echo $_POST['id']; ?>"/>
                        <label for="name">Titulo:</label>
                        <input id="name" type="text" name="name" value="<?php echo $novedad->getName(); ?>"/>
                        <label for="descripcion">Descripcion:</label>
                        <textarea id="descripcion" name="descripcion"><?php echo $novedad->getDescripcion(); ?>
                        </textarea>
                        <label for="image">Imagen:</label>
                        <p>Actualmente: <a href="/uploads<?php echo $novedad->getImagen(); ?>"><?php echo "/uploads".$novedad->getImagen(); ?></a></p>
                        <input id="image" type="file" name="imagen"/>
                        <input class="button round" type="submit" name="submit2" value="Modificar" />
                    </form>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>