<?php
require_once "Adapter.php";

abstract class Model {
    public $objetos;
    protected $TABLE = 'prueba';

    public function __construct(){
        $this->objetos = new Adapter();
    }
    public function get($id=null){
        if(is_null($id)){
            return $this->objetos->selectAll($this->TABLE);
        }
        else{
            return $this->objetos->selectWhereID($this->TABLE,"id",$id);
        }
    }
    abstract public function create($datos_raw);
    abstract public function modify($id, $datos_raw);
} 