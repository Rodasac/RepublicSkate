<?php

function generar_valores($valores){
    $datos = "";
    $cont = count($valores);
    $it = 0;
    foreach ($valores as $valor){
        $it++;
        $datos .= "$valor";
        if ($it == $cont){
            break;
        }
        else {
            $datos .= ", ";
        }
    }
    return $datos;
}

function generar_valores_2($valores){
    $datos = "";
    $cont = count($valores);
    $it = 0;
    foreach ($valores as $valor){
        $it++;
        $key= key($valores);
        next($valores);
        $datos .= "$key = $valor";
        if ($it == $cont){
            break;
        }
        else {
            $datos .= ", ";
        }
    }
    return $datos;
}