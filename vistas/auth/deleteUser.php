<?php
try
{
    if(isset($_POST['id'])){
        // Find the user using the user id
        if(Sentry::getUser()->hasAccess('write') || (Sentry::getUser()->id == $_POST['id'])){
            if((Sentry::getUser()->id == $_POST['id'])){
                Sentry::logout();
            }
            $user = Sentry::findUserById($_POST['id']);
            $perfilRepository = $entityManager->getRepository('Perfil');
            $perfil = $perfilRepository->findOneBy(array("user_id" => $user->id));
            // Delete the user
            $entityManager->remove($perfil);
            $entityManager->flush();
            $user->delete();
        }
        else{
            throw new Exception("Acceso Prohibido");
        }
    }
}
catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
{
    echo 'User was not found.';
}

header("location: /");