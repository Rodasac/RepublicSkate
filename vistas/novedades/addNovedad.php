<?php
if (isset($_POST['submit'])) {
  try {
    $uploadfile = $uploaddir . '/novedades/'. $_POST['name'];
    
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile)){
        throw new Exception("La imagen no se pudo subir");
    }
    
    $product = new Novedades();
    $name = filter_var($_POST['name']);
    $descripcion = strip_tags($_POST['descripcion']);
    $file = $_FILES['imagen'];
    
    $product->setName($name);
    $product->setDescripcion($descripcion);
    $product->setImagen('/novedades/'.$_POST['name']);

    $entityManager->persist($product);
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
            <article class="large-9 columns">
                <div class="panel">
                    <h1 class="Titles">Agregar Producto</h1>
                    <form class ="row" action="/addNovedad/" enctype="multipart/form-data" method="post">
                        <label for="name">Título:</label>
                        <input id="name" type="text" name="name" placeHolder="Escriba el nombre"/>
                        <label for="descripcion">Descripcion:</label>
                        <textarea id="descripcion" name="descripcion" placeHolder="Escriba la descripcion" required></textarea>
                        <label for="image">Quiere mostrar una imagen?</label>
                        <input id="image" type="file" name="imagen" required/>
                        <input class="button radius" type="submit" name="submit" value="Registrar" />
                    </form>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>