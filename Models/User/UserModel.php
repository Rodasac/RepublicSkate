<?php
include_once __DIR__."/../../modulos/DB/Model.php";

class UserModel extends Model {
    protected $TABLE = "usermodel";

    public function getForUser($user){
        return $this->objetos->selectWhereID($this->TABLE, 'user', $user);
    }

    public function create($datos_raw){
        if($this->objetos->save($this->TABLE, "user, pass, nombre, admin", $datos_raw)){
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