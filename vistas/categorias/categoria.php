<?php
use Doctrine\ORM\Tools\Pagination\Paginator;

$categoryRepository = $entityManager->getRepository('Category');
try{
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $categoria = $categoryRepository->find($id);
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
        }
        else {
            $page = 1;
        }
        $productRepository = $entityManager->getRepository('Product');
        $query = $productRepository->searchCat($id, $page, 3);
        $pag = new Paginator($query, $fetchJoinCollection = true);
        $totalItems = count($pag);
        $pagesCount = ceil($totalItems / 3);
    }
    else {
        throw new Exception();
    }
}
catch(Exception $e){
    $categoria = false;
    $pag = null;
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
                    <h1 class="Titles"><?php echo $categoria->getName(); ?></h1>
                    <p><?php echo $categoria->getDescripcion(); ?></p>
                    <?php if( Sentry::check()):?>
                        <?php if ($user->hasAccess('write')): ?>
                            <form class="right" action="/upcategoria/" method="post">
                                <input name="id" type="hidden" value="<?php echo $categoria->getId();?>">
                                <input class="button round" name="submit" type="submit" value="Modificar">
                            </form>
                            <form class="right" action="/delcategoria/" method="post">
                                <input name="id" type="hidden" value="<?php echo $categoria->getId();?>">
                                <input class="button alert round" name="submit" type="submit" value="Borrar">
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                    <hr/>
                    <div class="panel">
                        <h2 class="lead">Productos para esta categoria</h2>
                        <?php if(isset($pag) && $totalItems != 0): ?>
                            <?php foreach($pag as $product): ?>
                                <div class="left">
                                <a class="th radius" href="/producto/?id=<?php echo $product->getId(); ?>">
                                    <img width="200px" src="/uploads<?php echo $product->getImagen(); ?>"/>
                                </a>
                                <h4 class="Titles"><a href="/producto/?id=<?php echo $product->getId(); ?>"><?php echo $product->getName(); ?></a></h4>
                                <p>
                                    <span class="label"><?php echo $product->getPrecio(); ?>Bs.</span>
                                    <span class="label"><?php echo $product->getCantidad(); ?> Productos disponibles.</span>
                                    <em>Categoría: </em><span class="label secondary"><a href="/skate/categoria/?id=<?php echo $product->getCategoria()->getId(); ?>"><?php echo $product->getCategoria()->getName(); ?></a></span>
                                </p>
                                </div>
                                <?php if( Sentry::check()):?>
                                <div class="right">
                                    <form action="/carrito/" method="post">
                                        <input name="idprod" type="hidden" value="<?php echo $product->getId();?>">
                                        <label for="cant">Cantidad</label>
                                        <input id="cant" name="cantidad" type="number" min="0" placeholder="Ingrese la cantidad"><br>
                                        <input class="button success round" name="submitcar" type="submit" value="Agregar al carrito">
                                    </form>
                                </div>
                                <?php endif; ?>
                                <br/>
                                <hr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="panel callout radius">
                                <p> No existen productos para esta categoria</p>
                            </div>
                        <hr>
                        <?php endif; ?>
                        <div>
                            <p class="text-center"><strong>Cantidad de productos para esta categoría:</strong> <?php echo $totalItems; ?></p>
                            <p class="text-center"><strong>Cantidad de páginas</strong></p>
                            <ul class="pagination">
                                <?php if ($page == 1): ?>
                                    <li class="arrow unavailable"><a href="/categoria/?id=<?php echo $id ?>&page=1">&laquo;</a></li>
                                    <li class="current"><a href="/categoria/?id=<?php echo $id ?>&page=1">1</a></li>
                                    <?php if ($pagesCount > 1): ?>
                                        <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                                <li><a href="/categoria/?id=<?php echo $id ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endfor; ?>
                                        <li class="arrow"><a href="/categoria/?id=<?php echo $id ?>&page=<?php echo --$i; ?>">&raquo;</a></li>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <li class="arrow"><a href="/categoria/?id=<?php echo $id ?>&page=1">&laquo;</a></li>
                                    <li><a href="/categoria/?id=<?php echo $id ?>&page=1">1</a></li>
                                    <?php if ($pagesCount > 1): ?>
                                        <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                            <?php if ($page == $i): ?>
                                                <li class="current"><a href="/categoria/?id=<?php echo $id ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                            <?php else: ?>
                                                <li><a href="/categoria/?id=<?php echo $id ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <?php if ($page == $i - 1): ?>
                                            <li class="arrow unavailable"><a href="/categoria/?id=<?php echo $id ?>&page=<?php echo --$i; ?>">&raquo;</a></li>
                                        <?php else: ?>
                                            <li class="arrow"><a href="/categoria/?id=<?php echo $id ?>&page=<?php echo --$i; ?>">&raquo;</a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>