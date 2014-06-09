<?php
if(Sentry::check() && Sentry::getUser()->hasAccess('write')){
    $categoryRepository = $entityManager->getRepository('Category');
    if(isset($_POST['submit'])){
        $category = $categoryRepository->find($_POST['id']);
    }
    elseif (isset($_POST['submit2'])) {
        try {
            $category = $categoryRepository->find($_POST['id']);
            $name = filter_var($_POST['name']);
            $descripcion = strip_tags($_POST['descripcion']);

            $category->setName($name);
            $category->setDescripcion($descripcion);

            $entityManager->persist($category);
            $entityManager->flush();
            header("location: /categorias/");
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    else {
        throw new Exception();
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
                    <h1 class="Titles">Modificar Categoria</h1>
                    <form class ="row" action="/addCategory/" method="post">
                        <input type="hidden" name="id" value="<?php echo $category->getId(); ?>">
                        <label for="name">Nombre:</label>
                        <input id="name" type="text" name="name" value="<?php echo $category->getName(); ?>"/>
                        <label for="descripcion">Descripcion:</label>
                        <textarea id="descripcion" name="descripcion"><?php echo $category->getDescripcion(); ?></textarea>
                        <input class="button radius round" type="submit" name="submit2" value="Registrar" />
                    </form>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>

<?php
}
else {
}
?>