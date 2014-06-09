<?php
$categoryRepository = $entityManager->getRepository('Category');
$categories = $categoryRepository->findAll();
try{
    if(isset($_POST['submit'])){
        $product = $entityManager->find('Product', $_POST['id']);
    }
    elseif(isset($_POST['submit2'])){
        $product = $entityManager->find('Product', $_POST['id']);
        if(isset($_FILES['imagen']) && $_FILES['imagen'] != null){
            try {
            unlink($uploaddir . $product->getImagen());
            } catch (Exception $e) {
                $error = 1;
            }
            $uploadfile = $uploaddir . '/productos/'. $_FILES['imagen']['name'];
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile)){
                throw new Exception("La imagen no se pudo subir");
            }
            $file = $_FILES['imagen'];
            $product->setImagen('/productos/'.basename($file['name']));
        }

        if(isset($_POST['categoria']) && $_POST['categoria'] != null){
            $categoria = strip_tags($_POST['categoria']);
            $findcat = $entityManager->find("Category", $categoria);
            $product->setCategoria($findcat);
        }

        $name = filter_var($_POST['name']);
        $descripcion = strip_tags($_POST['descripcion']);
        $precio = strip_tags($_POST['precio']);
        $cantidad = strip_tags($_POST['cantidad']);

        $product->setName($name);
        $product->setDescripcion($descripcion);
        $product->setPrecio($precio);
        $product->setCantidad($cantidad);
        $product->setSavedAt(new DateTime("now"));
        $entityManager->persist($product);
        $entityManager->flush();
        header("location: /producto/?id=".$product->getId());
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
                    <h1 class="Titles">Modificar Producto</h1>
                    <?php if(isset($error)): ?>
                    <div>
                        <div data-alert class="alert-box alert round">
                            Error al guardar el Producto.
                            <p><?php echo $error; ?></p>
                            <a href="#" class="close">&times;</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <form class ="row" action="/upproducto/" enctype="multipart/form-data" method="post">
                        <input name="id" type="hidden" value="<?php echo $_POST['id']; ?>"/>
                        <label for="name">Nombre:</label>
                        <input id="name" type="text" name="name" value="<?php echo $product->getName(); ?>"/>
                        <label for="descripcion">Descripcion:</label>
                        <textarea id="descripcion" name="descripcion"><?php echo $product->getDescripcion(); ?>
                        </textarea>
                        <label for="image">Imagen:</label>
                        <p>Actualmente: <a href="/uploads<?php echo $product->getImagen(); ?>"><?php echo "/uploads".$product->getImagen(); ?></a></p>
                        <input id="image" type="file" name="imagen"/>
                        <label for="select">Categoria:</label>
                        <select id="select" name="categoria">
                            <option value="">No modificar si no se desea cambiar</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="precio">Precio:</label>
                        <input id="precio" type="number" name="precio" value="<?php echo $product->getPrecio(); ?>"/>
                        <label for="cantidad">Cantidad:</label>
                        <input id="cantidad" type="number" name="cantidad" value="<?php echo $product->getCantidad(); ?>"/>
                        <input class="button round" type="submit" name="submit2" value="Modificar" />
                    </form>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>