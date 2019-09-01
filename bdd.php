<?php


class bdd extends PDO
{

   private $db_charset;

   private $db_name;
   private $db_host;
   private $db_user;
   private $db_pass;

   private $pdo;


    public function __construct(){

        $this->db_charset = "UTF8";
        $this->db_host = "127.0.0.1";
        $this->db_name = "agenda";
        $this->db_pass = "root";
        $this->db_user = "root";

        $this->pdo = new PDO("mysql:dbname=$this->db_name;host=$this->db_host;charset=$this->db_charset", $this->db_user, $this->db_pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


    }

    public function get_pdo(){
        return $this->pdo;
    }
}