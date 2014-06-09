<?php
try{
    if(isset($_GET['id'])){
        $categoryRepository = $entityManager->getRepository('Category');
        $categories = $categoryRepository->findAll();
        $productRepository = $entityManager->getRepository('Product');
        $product = $productRepository->find($_GET['id']);
    }
    else {
        throw new Exception();
    }
}
catch(Exception $e){
    $categories= false;
    $products = false;
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
            <h1 class="Titles"><?php echo $product->getName(); ?></h1>
            <div class="panel">
                <?php if($product): ?>
                        <img class="th radius" width="300px" src="/uploads<?php echo $product->getImagen(); ?>"/>
                        <p><?php echo $product->getDescripcion(); ?></p>
                        <p>
                            <span class="label"><?php echo $product->getPrecio(); ?>Bs.</span>
                            <span class="label"><?php echo $product->getCantidad(); ?> Productos disponibles.</span>
                            <em>Categoría: </em><span class="label secondary"><a href="/categoria/?id=<?php echo $product->getCategoria()->getId(); ?>"><?php echo $product->getCategoria()->getName(); ?></a></span>
                        </p>
                        <?php if( Sentry::check()):?>
                            <div class="row">
                                <form id="carrito" class="left" action="/carrito/" method="post">
                                    <input name="idprod" type="hidden" value="<?php echo $product->getId();?>">
                                    <label for="cant">Cantidad</label>
                                    <input id="cant" name="cantidad" type="number" min="0" placeholder="Ingrese la cantidad"><br>
                                    <input id="submitcar" class="button success round" name="submitcar" type="submit" value="Agregar al carrito">
                                </form>
                            <?php if ($user->hasAccess('write')): ?>
                                <form class="right" action="/upproducto/" method="post">
                                    <input name="id" type="hidden" value="<?php echo $product->getId();?>">
                                    <input class="button round" name="submit" type="submit" value="Modificar">
                                </form>
                                <form class="right" action="/delproducto/" method="post">
                                    <input name="id" type="hidden" value="<?php echo $product->getId();?>">
                                    <input class="button alert round" name="submit" type="submit" value="Borrar">
                                </form>
                            <?php endif; ?>
                            </div>
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