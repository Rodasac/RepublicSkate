<?php
use Doctrine\ORM\Tools\Pagination\Paginator;

$perfilRepo = $entityManager->getRepository("Perfil");
    try {
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
        }
        else {
            $page = 1;
        }
        $ticketRepository = $entityManager->getRepository('Ticket');
        $ticket = $ticketRepository->getPag($page, 15);
        $pag = new Paginator($ticket, $fetchJoinCollection = true);
        $totalItems = count($pag);
        $pagesCount = ceil($totalItems / 15);
    }
    catch(Exception $e) {
        $error = $e->getMessage();
    }
?>
<!DOCTYPE html>
<html>
<?php require_once dirname(__FILE__)."/../head.php" ?>
<body>
<?php require_once dirname(__FILE__)."/../header.php" ?>
<?php require_once dirname(__FILE__)."/../aside.php" ?>
<section class="row">
    <article class="small-9 medium-9 large-9 columns">
        <div class="panel">
            <h1 class="Titles">Tickets de Compras</h1>
            <?php if(!isset($error)): ?>
                <?php foreach($pag as $ticket):
                    $json = json_decode($ticket->getProducts());?>
                    <div class="panel callout">
                        <h3><a href="/ticket/?id=<?php echo $ticket->getId(); ?>"><strong>Id del Ticket: </strong><?php echo $ticket->getId(); ?></a></h3>
                        <p>Cliente que efectuó la compra:
                            <em>
                                <?php
                                    $user = Sentry::findUserByLogin($ticket->getUser());
                                    $perfil = $perfilRepo->findBy(array("user_id" => $user->id));
                                    if(isset($user) && isset($perfil)){
                                        echo "Nombre Completo ".$user->first_name." ".$user->last_name."<br/>".
                                            "C.I.: ".$perfil[0]->getCi().", RIF: ".$perfil[0]->getRif();
                                    }
                                    else{
                                        echo $ticket->getUser();
                                    }?>
                            </em>
                        </p>
                        <p>Fecha y Hora de la compra: <?php echo $ticket->getFecha()->format("d-m-Y T H:i:s P"); ?></p>
                        <div>
                            <p><strong>Productos de la compra: </strong></p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Productos</th>
                                        <th>Precio</th>
                                        <th>Cantidad Ordenada</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($json as $array):
                                        $products = get_object_vars($array);?>

                                    <tr>
                                        <?php if(isset($products['nombre'])): ?>
                                        <td>
                                            <strong>
                                                Nombre del Producto: <a href="/producto/?id=<?php echo $products['id']; ?>"><?php echo $products['nombre']; ?></a>
                                            </strong>
                                        </td>
                                        <td>
                                            <span>
                                                Bs. <?php echo $products['precio']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <?php echo $products['cantOrd']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                Bs. <?php echo $products['precio'] * $products['cantOrd']; ?>
                                            </span>
                                        </td>
                                        <?php endif ?>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="4">
                                            <span>
                                                <strong>
                                                    Total Bs. <?php if(isset($products['total'])):
                                                                echo $products['total']; ?>
                                                              <?php endif ?>
                                                </strong>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>
                                <span><strong>Estado del ticket:</strong>
                                    <?php if($ticket->getStatus() == 0 || $ticket->getStatus() == false){
                                        echo "Cerrado";
                                    }
                                    else {
                                        echo "Abierto";
                                    }?>
                                </span>
                            </p>
                        </div>
                        <a class="button secondary radius" href="/updateTicket/?id=<?php echo $ticket->getId(); ?>">Actualizar ticket</a>
                    </div>
                <? endforeach; ?>
                <div>
                    <p class="text-center"><strong>Cantidad de tickets:</strong> <?php echo $totalItems; ?></p>
                    <ul class="pagination">
                        <?php if ($page == 1): ?>
                            <li class="arrow unavailable"><a href="/tickets/?page=1">&laquo;</a></li>
                            <li class="current"><a href="/tickets/?page=1">1</a></li>
                            <?php if ($pagesCount > 1): ?>
                                <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                    <li><a href="/tickets/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endfor; ?>
                                <li class="arrow"><a href="/tickets/?page=<?php echo --$i; ?>">&raquo;</a></li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="arrow"><a href="/tickets/?page=1">&laquo;</a></li>
                            <li><a href="/tickets/?page=1">1</a></li>
                            <?php if ($pagesCount > 1): ?>
                                <?php for ($i = 2; $i <= $pagesCount; $i++): ?>
                                    <?php if ($page == $i): ?>
                                        <li class="current"><a href="/tickets/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php else: ?>
                                        <li><a href="/tickets/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <?php if ($page == $i - 1): ?>
                                    <li class="arrow unavailable"><a href="/tickets/?page=<?php echo $id ?>&page=<?php echo --$i; ?>">&raquo;</a></li>
                                <?php else: ?>
                                    <li class="arrow"><a href="/tickets/?page=<?php echo --$i; ?>">&raquo;</a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </article>
</section>
<?php require_once dirname(__FILE__)."/../footer.php" ?>
<?php require_once dirname(__FILE__)."/../scripts.php" ?>
</body>
</html>