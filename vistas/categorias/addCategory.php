<?php
if (isset($_POST['submit'])) {
    try {
        $category = new Category();
        $name = filter_var($_POST['name']);
        $descripcion = strip_tags($_POST['descripcion']);

        $category->setName($name);
        $category->setDescripcion($descripcion);

        $entityManager->persist($category);
        $entityManager->flush();

        if(isset($_POST['next']) && $_POST['next'] == "addp"){
            header("location: /addProduct/");
        }
        header("location: /categorias/");
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
                    <h1 class="Titles">Agregar Categoria</h1>
                    <form class ="row" action="/addCategory/" method="post">
                        <?php if(isset($_GET['next'])): ?>
                            <input type="hidden" name="next" value="<?php echo $_GET['next'] ?>"/>
                        <?php endif; ?>
                        <label>Nombre:</label>
                        <input type="text" name="name" placeHolder="Escriba el nombre"/>
                        <label>Descripcion:</label>
                        <textarea name="descripcion" placeHolder="Escriba la descripcion"></textarea>
                        <input class="button [radius round]" type="submit" name="submit" value="Registrar" />
                    </form>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>