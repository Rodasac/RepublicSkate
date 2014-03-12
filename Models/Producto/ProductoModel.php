<?php
include_once __DIR__ . "/../../modulos/DB/Model.php";

class ProductoModel extends Model {
    protected $TABLE = "productosmodel";

    public function getForNombre($nombre){
        return $this->objetos->selectWhereID($this->TABLE, 'nombre', $nombre);
    }

    public function create($datos_raw){
        if($this->objetos->save($this->TABLE, "nombre, descripcion, categoria, imagenes, cantidad, precio", $datos_raw)){
            return $this->get();
        }
        else{
            return "No se ha creado nada";
        }
    }
    public function modify($id, $datos_raw, $mode = 1){
        $datos = "$datos_raw";
        if($mode == 1){
            if($this->objetos->modifyOne($this->TABLE, $datos, $id)){
                return $this->get($id);
            }
            else{
                return "No se ha creado nada";
            }
        }
    }
} 