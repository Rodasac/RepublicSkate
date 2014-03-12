<?php
include_once __DIR__."/../../modulos/DB/Model.php";

class UserModel extends Model {
    const TABLE = "usermodel";
    public function create($datos_raw){
        if($this->objetos->save(self::TABLE, 'user, pass, nombre, admin', $datos_raw)){
            return $this->get();
        }
        else{
            return "No se ha creado nada";
        }
    }
    public function modify($id, $datos_raw){
        $datos = "$datos_raw";
        if($this->objetos->modify(self::TABLE, 'dato', $datos, $id)){
            return $this->get($id);
        }
        else{
            return "No se ha creado nada";
        }
    }
} 