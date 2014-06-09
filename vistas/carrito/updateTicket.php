<?php
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
    if(isset($_POST['submit2']) && isset($_POST['status'])){
        $productRepository = $entityManager->getRepository('Product');
        $json = json_decode($ticket->getProducts());

        foreach($json as $array){
            $vars = get_object_vars($array);
            if(isset($vars['id'])){
                $product = $productRepository->find($vars['id']);
                $cant = $product->getCantidad();
                $ord = $vars['cantOrd'];
                $product->setCantidad((int)$cant - (int)$ord);
                $entityManager->persist($product);
                $entityManager->flush();
            }
        }

        $ticket->setStatus(False);
        $entityManager->persist($ticket);
        $entityManager->flush();
        header("location: /ticket/?id=".$_POST['id']);
    }
    elseif(isset($_POST['submit2']) && !isset($_POST['status'])){
        $ticket->setStatus(True);
        $entityManager->persist($ticket);
        $entityManager->flush();
        header("location: /ticket/?id=".$_POST['id']);
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
<section class="row">
    <article class="large-9 columns">
        <div class="panel">
            <h1 class="Titles">Actualizar ticket</h1>
            <form class ="row" action="/updateTicket/" method="post">
                <input type="hidden" name="id" value="<?php echo $ticket->getId(); ?>">
                <label for="status">Desea cerrar el ticket:
                    <input id="status" type="checkbox" name="status" checked/>
                    <sub>* Si está marcado significa un "sí", sino un "no"</sub>
                </label>
                <input class="button radius round" type="submit" name="submit2" value="Actualizar" />
            </form>
        </div>
    </article>
</section>
<?php require_once dirname(__FILE__)."/../footer.php" ?>
<?php require_once dirname(__FILE__)."/../scripts.php" ?>
</body>
</html>