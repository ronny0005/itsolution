<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 15:37
 */

class Objet {
    public $db;
    public $table;
    public $id;
    public $idLib;
    public $userName;
    public $objetCollection;
    /**  Variable pour les données surchargées.  */
    public $data;
    public $list = Array();
    public $url;
    public $settings;
    public $class;


    function getFromApi($url){
        header('Access-Control-Allow-Origin: *');
        $this->settings = parse_ini_file("config/app.config", 1);
        $this->url = $this->settings["SERVICE_API"];
        $this->url =$this->url.$url;
        $response = file_get_contents($this->url);
        return $response;
    }

    function __construct($table,$id,$idLib,$db=null) {
        if($db!=null)
            $this->db =$db;
        else
            $this->db =new DB();
        $this->objetCollection = new ObjetCollector($this->db);
        $this->id = $id;
        $this->idLib = $idLib;
        $this->table = $table;
        $query = "  SELECT    * 
                    FROM      {$this->table} 
                    WHERE     {$this->idLib}='{$this->id}'";
        $result= $this->db->query($query);
        $this->data = $result->fetchAll(PDO::FETCH_OBJ);
    }



    public function setuserName($login,$mobile){
        $this->userName="";
        if($mobile==""){
            if(!isset($_SESSION))
                session_start();
            $this->userName = $_SESSION["id"];
        }else
        if($login!="")
            $this->userName = $login;
    }

    public function __get($name) {
        $query = "SELECT $name FROM $this->table WHERE ".$this->idLib."='".$this->id."'";
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->$name;
    }

    public function __set($name,$value) {
        $query = "UPDATE $this->table set $name='$value' where ".$this->idLib."='".$this->id."'";
        $this->db->query($query);
    }

    public function all(){
        //return $this->getFromApi($this->url.$this->class."/all");
        $query = "SELECT * FROM $this->table";
        $result= $this->db->query($query);
        $this->list = Array();
        $this->list = $result->fetchAll(PDO::FETCH_OBJ);
        return $this->list;
    }


    public function maj($name,$value){
        $query = "UPDATE $this->table set $name='$value' where ".$this->idLib."='".$this->id."'";
        $this->db->query($query);

    }

    public function majByCbMarq($name,$value,$cbMarq){
        $query = "UPDATE $this->table set $name='$value' where cbMarq=$cbMarq";
        $this->db->query($query);
    }

    public function majcbModification(){
        $query = "UPDATE $this->table set cbModification=GETDATE() where ".$this->idLib."='".$this->id."'";
        $this->db->query($query);
    }

    public function majNull($name){
        $query = "UPDATE $this->table set $name=NULL where ".$this->idLib."='".$this->id."'";
        $this->db->query($query);
    }

    public function getcbCreateurName(){
        $query = "SELECT Prot_User
                    FROM $this->table A
                    INNER JOIN F_PROTECTIONCIAL P ON A.cbCreateur = CAST(P.PROT_No AS VARCHAR(5))
                  WHERE A.cbMarq = {$this->cbMarq}";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if(sizeof($rows)>0)
            return $rows[0]->Prot_User;
    }

    public function delete(){
        $query = "DELETE FROM $this->table WHERE {$this->idLib}='{$this->id}'";
        $this->db->query($query);
    }

    public function formatDate($val){
        if($val==NULL)
            return null;
        else {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $val);
            return $date->format('Y-m-d');
        }
    }

    public function formatDateSage($val){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $val);
        return $date->format('dmy');
    }

    public function formatDateSageToDate($val){
        $date = DateTime::createFromFormat('dmy', $val);
        return $date->format('Y-m-d ');
    }
}
?>