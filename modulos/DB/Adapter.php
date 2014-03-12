<?php
include_once __DIR__."/../../settings.php";
include_once __DIR__."/../../util/funciones.php";
include_once "Conector.php";

class Adapter {
    protected static  $db = null;

    public function __construct(){
        self::$db = new Conector(PDO_DSN,PDO_USER_DB,PDO_PASS_DB,
            array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND =>
                'SET NAMES \'UTF8\'')
        );
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function selectAll($table){
        try {
            $sentecia = self::$db->prepare("SELECT * FROM $table");
            $sentecia->execute();
            $arr = $sentecia->fetchAll();
            $sentecia->closeCursor();
            return $arr;
        }
        catch (Exception $e){
            self::$db->rollBack();
            return False;
        }
    }
    public function selectWhere($table, $campo, $valor){
        try {
            $sentecia = self::$db->prepare("SELECT * FROM $table
             WHERE $campo = $valor");
            $sentecia->execute();
            $arr = $sentecia->fetchAll();
            $sentecia->closeCursor();
            return $arr;
        }
        catch (Exception $e){
            self::$db->rollBack();
            return False;
        }
    }
    public function selectWhereID($table, $campo, $valor){
        try {
            $sentecia = self::$db->prepare("SELECT * FROM $table
             WHERE $campo = $valor");
            $sentecia->execute();
            $arr = $sentecia->fetch();
            $sentecia->closeCursor();
            return $arr;
        }
        catch (Exception $e){
            self::$db->rollBack();
            return False;
        }
    }
    protected function insert($table, $campos, $valores){
        try {
            $sentecia = self::$db->prepare("insert into $table ($campos)
                values ($valores)", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

            if($sentecia->execute()){
                return True;
            }
            else {
                return False;
            }
        }
        catch (Exception $e){
            return False;
        }
    }
    protected function updateOne($table, $modify, $id){
        try {
            $sentecia = self::$db->prepare("UPDATE $table SET $modify
                WHERE id = $id");
            if($sentecia->execute()){
                return True;
            }
            else {
                return False;
            }
        }
        catch (Exception $e){
            return False;
        }
    }
    public function delete($table, $id){
        try {
            $sentecia = self::$db->prepare("DELETE FROM $table WHERE
            id = $id");
            $sentecia->execute();
            return True;
        }
        catch (Exception $e){
            self::$db->rollBack();
            return False;
        }
    }
    public function save($table, $campos, $valores){
        if($this->insert($table, $campos, $valores)){
            return True;
        }
        else {
            return False;
        }
    }
    public function modifyOne($table, $modify, $id){
        if($this->updateOne($table, $modify, $id)){
            return True;
        }
        else {
            return False;
        }
    }
}