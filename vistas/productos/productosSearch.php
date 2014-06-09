<?php
use Doctrine\ORM\Tools\Pagination\Paginator;
    try{
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
        }
        else {
            $page = 1;
        }
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        if(!isset($_SESSION['search'])){
            $_SESSION['search'] = array();
        }

        if(isset($_POST['submit'])){
            if($_POST['cat'] || $_GET['cat']){
                if(isset($_SESSION['search']['nombre'])){
                    unset($_SESSION['search']['nombre']);
                }
                $_SESSION['search']['cat'] = $_POST['cat'];
            }
            elseif(isset($_POST['name'])){
                if(isset($_SESSION['search']['cat'])){
                    unset($_SESSION['search']['cat']);
                }
                $_SESSION['search']['nombre'] = $_POST['name'];
            }
        }

        if(isset($_SESSION['search']['cat'])){
            $productRepository = $entityManager->getRepository('Product');
            $query = $productRepository->searchCat($_SESSION['search']['cat'], $page, 6);
            $products = new Paginator($query, $fetchJoinCollection = true);
            $totalItems = count($products);
            $pagesCount = ceil($totalItems / 6);
            if($totalItems === null || $totalItems === 0){
                $error2 = true;
            }
        }
        elseif (isset($_SESSION['search']['nombre'])) {
            $productRepository = $entityManager->getRepository('Product');
            $query = $productRepository->searchName($_SESSION['search']['nombre'], $page);
            $products = new Paginator($query, $fetchJoinCollection = true);
            $totalItems = count($products);
            $pagesCount = ceil($totalItems / 6);

            if($totalItems === null || $totalItems === 0){
                $error2 = true;
            }
        }

        else {
            throw new Exception();
        }
    }
    catch(Exception $e){
        $error = $e->getMessage();
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
                    <?php if(isset($products) && !isset($error2)): ?>
                    <h1 class="Titles">Productos - Resultados de búsqueda</h1>
                    <div class="panel">
                        <?php foreach($products as $product): ?>
                            <a href="/producto/?id=<?php echo $product->getId(); ?>"><img width="200px" src="/uploads<?php echo $product->getImagen(); ?>"/></a>
                            <h4 class="Titles"><a href="/producto/?id=<?php echo $product->getId(); ?>"><?php echo $product->getName(); ?></a></h4>
                            <p>
                                <span class="label"><?php echo $product->getPrecio(); ?>Bs.</span>
                                <span class="label"><?php echo $product->getCantidad(); ?> Productos dispnibles.</span>
                                <em>Categorías: </em><span class="label"><?php echo $product->getCategoria()->getName(); ?></span>
                            </p>
                            <br/>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <div class="alert-box alert round">
                            <h2>No existen producto(s) que concuerden con tu busqueda!</h2>
                            <a href="#" class="close">&times;</a>
                        </div>
                    <hr>
                    <?php endif; ?>
                    <div>
                        <p class="text-center"><strong>Cantidad de productos:</strong> <?php echo $totalItems; ?></p>
                        <p class="text-center"><strong>Cantidad de páginas</strong></p>
                        <ul class="pagination">
                            <?php if ($page == 1): ?>
                                <li class="arrow unavailable"><a href="/prodsearch/?page=1">&laquo;</a></li>
                                <li class="current"><a href="/prodsearch/?page=1">1</a></li>
                                <?php if ($pagesCount > 1): ?>
                                    <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                        <li><a href="/prodsearch/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php endfor; ?>
                                    <li class="arrow"><a href="/prodsearch/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                <?php endif; ?>
                            <?php else: ?>
                                <li class="arrow"><a href="/prodsearch/?page=1">&laquo;</a></li>
                                <li><a href="/prodsearch/?page=1">1</a></li>
                                <?php if ($pagesCount > 1): ?>
                                    <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                        <?php if ($page == $i): ?>
                                            <li class="current"><a href="/prodsearch/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php else: ?>
                                            <li><a href="/prodsearch/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <?php if ($page == $i - 1): ?>
                                        <li class="arrow unavailable"><a href="/prodsearch/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                    <?php else: ?>
                                        <li class="arrow"><a href="/prodsearch/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
        <script>
            $(document).on("ready", function(){
                $(".close").click(function(e){
                    e.preventDefault();
                    $(".alert-box").fadeOut();
                });
            });
        </script>
    </body>
</html>