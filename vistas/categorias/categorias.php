<?php
use Doctrine\ORM\Tools\Pagination\Paginator;
try{
    if(isset($_GET['page'])){
        $page = (int)$_GET['page'];
    }
    else {
        $page = 1;
    }

    $categoryRepository = $entityManager->getRepository('Category');
    $query = $categoryRepository->getPag($page);
    $categorias = new Paginator($query, $fetchJoinCollection = true);
    $totalItems = count($categorias);
    $pagesCount = ceil($totalItems / 3);
    if($totalItems == 0){
       throw new Exception();
    }
}
catch(Exception $e){
    $categorias = false;
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
                    <h1 class="Titles">Categorías</h1>
                    <div class="panel">
                    <?php if($categorias): ?>
                        <?php foreach($categorias as $categoria): ?>
                            <h2 class="Titles"><a href="/skate/categoria/?id=<?php echo $categoria->getId(); ?>"><?php echo $categoria->getName(); ?></a></h2>
                            <br/>
                            <hr class="divider"/>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="panel alert radius">
                            <h2> No existen productos</h2>
                        </div>
                    <hr>
                    <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-center"><strong>Cantidad de páginas</strong></p>
                        <ul class="pagination">
                            <?php if ($page == 1): ?>
                                <li class="arrow unavailable"><a href="/categorias/?page=1">&laquo;</a></li>
                                <li class="current"><a href="/categorias/?page=1">1</a></li>
                                <?php if ($pagesCount > 1): ?>
                                    <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                        <li><a href="/categorias/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php endfor; ?>
                                    <li class="arrow"><a href="/categorias/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                <?php endif; ?>
                            <?php else: ?>
                                <li class="arrow"><a href="/categorias/?page=1">&laquo;</a></li>
                                <li><a href="/categorias/?page=1">1</a></li>
                                <?php if ($pagesCount > 1): ?>
                                    <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                        <?php if ($page == $i): ?>
                                            <li class="current"><a href="/categorias/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php else: ?>
                                            <li><a href="/categorias/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <?php if ($page == $i - 1): ?>
                                        <li class="arrow unavailable"><a href="/categorias/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                    <?php else: ?>
                                        <li class="arrow"><a href="/categoria/?page=<?php echo --$i; ?>">&raquo;</a></li>
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
    </body>
</html>