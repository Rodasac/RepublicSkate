<?php
use Doctrine\ORM\Tools\Pagination\Paginator;
    try{

        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
        }
        else {
            $page = 1;
        }
        $productRepository = $entityManager->getRepository('Novedades');
        $query = $productRepository->getPaginationDesc($page);
        $novedades = new Paginator($query);
        $totalItems = count($novedades);
        $pagesCount = ceil($totalItems / 10);
    }
    catch(Exception $e){
        $productRepository = $entityManager->getRepository('Novedades');
        $query = $productRepository->getPaginationDesc($page);
        $novedades = new Paginator($query);
        $totalItems = count($novedades);
        $pagesCount = ceil($totalItems / 10);
    }
?>
<!DOCTYPE html>
<html>
    <?php require_once dirname(__FILE__)."/head.php" ?>
    <body>
        <?php require_once dirname(__FILE__)."/header.php" ?>
        <?php require_once dirname(__FILE__)."/aside.php" ?>
        <section class="row">
            <article class="small-9 medium-9 large-9 columns">
                <div class="panel">
                    <h1 class="Titles">Novedades</h1>
                    <hr/>
                    <div>
                        <?php if(!is_bool($novedades) && $novedades != array()): ?>
                            <?php foreach($novedades as $novedad): ?>
                                <div>
                                    <h2 class="Titles"><a href="/novedad/?id=<?php echo $novedad->getId(); ?>"><?php echo $novedad->getName(); ?></a></h2>
                                </div>
                                <hr class="divider">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="panel alert radius">
                                <h2> No existen novedades registradas</h2>
                            </div>
                            <hr>
                        <?php endif; ?>

                        <div>
                            <p class="text-center"><strong>Cantidad de artículos:</strong> <?php echo $totalItems; ?></p>
                            <p class="text-center"><strong>Cantidad de páginas</strong></p>
                            <ul class="pagination">
                                <?php if ($page == 1): ?>
                                    <li class="arrow unavailable"><a href="/productos/?page=1">&laquo;</a></li>
                                    <li class="current"><a href="/productos/?page=1">1</a></li>
                                    <?php if ($pagesCount > 1): ?>
                                        <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                            <li><a href="/productos/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endfor; ?>
                                        <li class="arrow"><a href="/productos/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <li class="arrow"><a href="/productos/?page=1">&laquo;</a></li>
                                    <li><a href="/productos/?page=1">1</a></li>
                                    <?php if ($pagesCount > 1): ?>
                                        <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                            <?php if ($page == $i): ?>
                                                <li class="current"><a href="/productos/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                            <?php else: ?>
                                                <li><a href="/productos/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <?php if ($page == $i - 1): ?>
                                            <li class="arrow unavailable"><a href="/productos/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                        <?php else: ?>
                                            <li class="arrow"><a href="/productos/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/footer.php" ?>
        <?php require_once dirname(__FILE__)."/scripts.php" ?>
    </body>
</html>