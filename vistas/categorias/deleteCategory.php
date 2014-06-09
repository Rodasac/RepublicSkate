<?php
try{
    if(Sentry::check() && Sentry::getUser()->hasAccess('write')){
        if(isset($_POST['submit'])){
            $category = $entityManager->find('Category', $_POST['id']);
            $products = $entityManager->getRepository('Product');
            $productsCat = $products->findBy(array("categoria" => $_POST['id']));
            $findcat = $entityManager->find("Category", 1);
            foreach($productsCat as $product){
                if($product->getCategoria()->getId() != 1){
                    $product->setCategoria($findcat);
                    $entityManager->flush();
                    $entityManager->persist($product);
                }
                else{
                    throw new Exception();
                }
            }
            $entityManager->remove($category);
            $entityManager->flush();
        }
        else {
            throw new Exception();
        }
    }
    header("location: /categorias/");
}
catch (Exception $e){
    $error = $e->getMessage();
}
?>
<?php if(isset($error)): ?>
<!DOCTYPE html>
<html>
    <?php require_once dirname(__FILE__) . "/../head.php" ?>
    <body>
        <?php require_once dirname(__FILE__)."/../header.php" ?>
        <?php require_once dirname(__FILE__)."/../aside.php" ?>
        <section class="row">
            <article class="small-9 medium-9 large-9 columns">
                <div class="panel round">
                    <div class="alert-box alert round">
                        <h1>Error</h1>
                        <p>
                            No se puede borrar esta categoria.
                            Contiene Productos dentro
                        </p>
                    </div>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>
<?php endif; ?>