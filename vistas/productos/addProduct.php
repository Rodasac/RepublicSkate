<?php
$categoryRepository = $entityManager->getRepository('Category');
$categories = $categoryRepository->findAll();

if (isset($_POST['submit'])) {
  try {
    $uploadfile = $uploaddir . '/productos/'. $_POST['name'];
    
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadfile)){
        throw new Exception("La imagen no se pudo subir");
    }
    
    $product = new Product();
    $name = filter_var($_POST['name']);
    $descripcion = strip_tags($_POST['descripcion']);
    $file = $_FILES['imagen'];
    $categoria = strip_tags($_POST['categoria']);
    $precio = strip_tags($_POST['precio']);
    $cantidad = strip_tags($_POST['cantidad']);
    
    $findcat = $entityManager->find("Category", $categoria);
    
    $product->setName($name);
    $product->setDescripcion($descripcion);
    $product->setImagen('/productos/'.$_POST['name']);
    $product->setPrecio($precio);
    $product->setCantidad($cantidad);
    $product->setSavedAt(new DateTime("now"));
    
    $product->setCategoria($findcat);
    $entityManager->persist($product);
    $entityManager->flush();
    header("location: /productos/");
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
                    <form class ="row" action="/addProduct/" enctype="multipart/form-data" method="post">
                        <label for="name">Nombre:</label>
                        <input id="name" type="text" name="name" placeHolder="Escriba el nombre"/>
                        <label for="descripcion">Descripcion:</label>
                        <textarea id="descripcion" name="descripcion" placeHolder="Escriba la descripcion" required></textarea>
                        <label for="image">Imagen:</label>
                        <input id="image" type="file" name="imagen" required/>
                        <label for="select">Categoria: <a name="Agregar Categoría" href="/addCategory/?next=addp">Agregar Categoría</a></label>
                        <select id="select" name="categoria" required>
                            <option value="">----</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label>Precio:</label>
                        <input type="text" name="precio" placeHolder="Escriba el precio"/>
                        <label>Cantidad:</label>
                        <input type="text" name="cantidad" placeHolder="Cantidad disponible"/>
                        <input class="button radius" type="submit" name="submit" value="Registrar" />
                    </form>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>