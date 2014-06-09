<?php
    if(isset($_POST['submitcar'])){
        session_start();
        if(isset($_POST['vaciar'])){
            unset($_SESSION['carrito']);
            header("location: /?page=1&vaciar=true");
        }
        elseif(isset($_POST['idprod'])){
            $categoryRepository = $entityManager->getRepository('Category');
            $categories = $categoryRepository->findAll();
            $productRepository = $entityManager->getRepository('Product');
            $productCar = $productRepository->find($_POST['idprod']);
        }

        if(isset($_SESSION['carrito'])){
            $car = $_SESSION['carrito'];

            $coincidencias = false;
            $numero = 0;

            for($i = 0; $i<count($car); $i++){
                if($car[$i]['idprod'] == $_POST['idprod']) {
                    $coincidencias = true;
                    $numero = $i;
                }
            }
            if($coincidencias == true) {
                if(isset($_POST['act'])){
                    $car[$numero]['cantidad'] = (int)$car[$numero]['cantidad'] + (int)$_POST['act'];
                    $_SESSION['carrito'] = $car;
                }
                elseif(isset($_POST['dis'])){
                    $car[$numero]['cantidad'] = (int)$car[$numero]['cantidad'] - (int)$_POST['dis'];
                    $_SESSION['carrito'] = $car;
                }
                elseif(isset($_POST['quitar'])){
                    if(count($car) == 1){
                        unset($_SESSION['carrito']);
                    }
                    else{
                        unset($car[$numero]);
                        $_SESSION['carrito'] = $car;
                    }
                }
                else {
                    $car[$numero]['cantidad'] = $_POST['cantidad'];
                    $_SESSION['carrito'] = $car;
                }
            }
            else {
                if(isset($productCar)){
                    $datosNuevos = array("idprod" => $_POST['idprod'],
                        "nombre" => $productCar->getName(),
                        "precio" => $productCar->getPrecio(),
                        "imagen" => $productCar->getImagen(),
                        "cantidad" => $_POST['cantidad']);
                    array_push($car, $datosNuevos);
                    $_SESSION['carrito'] = $car;
                    header("location: /?page=1&addp=true");
                }
            }
        }
        else {
            if(isset($productCar)){
                $datosNuevos[] = array("idprod" => $_POST['idprod'],
                    "nombre" => $productCar->getName(),
                    "precio" => $productCar->getPrecio(),
                    "imagen" => $productCar->getImagen(),
                    "cantidad" => $_POST['cantidad']);

                $_SESSION['carrito'] = $datosNuevos;
                header("location: /?page=1&addp=true");
            }
        }
    }
    else {
        if(isset($_SESSION['carrito'])){
            $datos = $_SESSION['carrito'];
        }
        else {
            $errorCar = "No has seleccionado ningún producto";
        }
    }