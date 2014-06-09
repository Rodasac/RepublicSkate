<?php
try{
    if(Sentry::check() && Sentry::getUser()->hasAccess('write')){
        if(isset($_POST['submit'])){
            $novedad = $entityManager->find('Novedades', $_POST['id']);
            $entityManager->remove($novedad);
            try {
                unlink($uploaddir . $novedad->getImage());
            } catch (Exception $e) {
                $error = 1;
            }
            $entityManager->flush();
            header("location: /");
        }
        else {
            throw new Exception();
        }
    }
    header("location: /");
}
catch (Exception $e){
    echo $e->getMessage();
}