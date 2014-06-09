<?php
try{
    if(Sentry::check() && Sentry::getUser()->hasAccess('write')){
        if(isset($_POST['submit'])){
            $product = $entityManager->find('Product', $_POST['id']);
            $entityManager->remove($product);
            try {
                unlink($uploaddir . $product->getImage());
            } catch (Exception $e) {
                $error = 1;
            }
            $entityManager->flush();
            header("location: /productos/");
        }
        else {
            throw new Exception();
        }
    }
    header("location: /productos/");
}
catch (Exception $e){
    echo $e->getMessage();
}