<?php
$perfilRepo = $entityManager->getRepository("Perfil");
try {
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    elseif(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    else {
        throw new Exception("Debes especificar un id");
    }
    $ticketRepository = $entityManager->getRepository('Ticket');
    $ticket = $ticketRepository->find($id);
}
catch(Exception $e){
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
            <h1 class="Titles">Ticket</h1>
            <?php if(!isset($error)):
                    $json = json_decode($ticket->getProducts());?>
                    <div class="panel callout">
                        <h3><strong>Id del Ticket: </strong><?php echo $ticket->getId(); ?></h3>
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
            <?php else: ?>
                <div class="panel callout">
                    <p>No existen tickets para tus criterios de búsqueda</p>
                </div>
            <?php endif; ?>
        </div>
    </article>
</section>
<?php require_once dirname(__FILE__)."/../footer.php" ?>
<?php require_once dirname(__FILE__)."/../scripts.php" ?>
</body>
</html>