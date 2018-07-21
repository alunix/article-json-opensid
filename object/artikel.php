<?php
include_once '../config/settings.php';

class Artikel{

    // database connection and table name
    private $conn;
    private $table_name = "artikel";
    private $table_join1 = "kategori";
    private $table_join2 = "user";

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

        // select all query
        $query = "SELECT a.id AS idartikel,a.*,b.*,c.* FROM
                  ".$this->table_name." AS a
                  LEFT JOIN ".$this->table_join1." AS b ON a.id_kategori=b.id
                  LEFT JOIN ".$this->table_join2." AS c ON a.id_user=c.id
                  WHERE a.enabled='1' ORDER BY a.tgl_upload DESC LIMIT ".ARTIKEL_LIMIT;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // print_r($stmt->errorInfo());

        return $stmt;
    }

}
