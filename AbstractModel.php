<?php
require('DBConnection.php');

/**
* AbstractModel
* 
* Extend this class to do CRUD operations on a single record.
* Uses mysqli db connection.
* 
* @abstract
*/
abstract class AbstractModel {
	protected $data;
	protected $conn;
    protected $_table;
    protected $_pk;

	function __construct() {
        $this->conn = DBConnection::get();
        $this->data = array();
	}

    /**
    * Save a record to the database;
    *
    * @return AbstractModel|false Model object if saved, false otherwise
    */
	public function save(){

	   if( empty($this->data)) {
	       echo( "No data to save\n");
	       return false;
	   }

	   if(array_key_exists($this->_pk, $this->data)) {
	      $this->doUpdate();
       } else {
	      $this->data[$this->_pk] = $this->doInsert();
       }

       return $this;
    }

    /**
    * Load a record from the database.
    *
    * @param int $id primary key id of record to load.
    *
    * @return AbstractModel|false Model object if loaded, false otherwise.
    */
	public function load($id){

	   $qry = "SELECT * FROM $this->_table WHERE $this->_pk = $id";
       $rslt = $this->query($qry, "Load error: ");

       if($rslt){
          $this->data = $rslt->fetch_assoc();
          return $this;
       } else {
          return false;
       }
	}

    /**
    * Delete the currently loaded record from the database;
    *
    * @return AbstractModel
    */
	public function delete(){

       $pk_val = $this->data[$this->_pk];
       $qry = "DELETE FROM $this->_table WHERE $this->_pk = $pk_val";
       $this->query($qry, "Delete error: ");

       return $this;
	}

    /**
    * Get the currently loaded record information
    *
    * @param string $key Optional. Key to get value for.
    *
    * @return array|string|false All loaded data if no key is passed in.
    *                            Value for key if key exists. False otherwise.
    */
	public function getData($key=false){

       if( $key == false ) {
          return $this->data;
       } elseif(array_key_exists($key,$this->data)) {
          return $this->data[$key];
       } else {
          return false;
       }
	}

    /**
    * Set the current record.
    * 
    * @param array|string $arr Key name of value if value is passed in, 
    *                          entire record otherwise.
    * @param string $value Optional. Value to set $arr key to.
    */
	public function setData($arr, $value=false) {

	   if($value != false ) {
	      $this->data[$arr] = $value;
       } else {
	     $this->data = $arr; 
       }

	   return $this;
    }

    /**
    * Wrap mysqli_query and error checks
    * 
    * @param string $value Optional. Value to set $arr key to.
    * @param string $value Optional. Value to set $arr key to.
    */
    private function query($qry, $mssg_pre="Database error: "){

       $rtn = false;

	   try {
         $rtn = mysqli_query($this->conn, $qry);
       } catch(Exception $e) {
          echo $mssg_pre . $e->getMessage();
       }

       return $rtn;
    }

    /**
    * Format insert statement and do insert.
    *
    * @return int New db id of inserted item if successful, 
    *             mysqli error otherwise.
    */
    private function doInsert() {

       $ins = "INSERT INTO $this->_table (`";
       $vals = " values( '";

       foreach( $this->data as $key=>$val) {
           if( end($this->data) == $val) {
              $ins .= $key . "`)";
              $vals .= $val . "')";
           } else {
              $ins .= $key . "`,`";
              $vals .= $val . "','";
           }
       }

       $qry = $ins.$vals;
       $this->query($qry, "Insert error: ");
       return $this->conn->insert_id;
    }
    
    /**
    * Format update statement and do update.
    *
    */
    private function doUpdate() {

       $upd = "UPDATE $this->_table set ";

       foreach( $this->data as $key=>$val) {
           // don't put primary key in the update statement
           if( $key != $this->_pk ) { 
              $upd .= $key ." = '$val',";
           }
       }

       // remove that last comma
       $upd = rtrim($upd,',');

       $pk_val = $this->data[$this->_pk];
       $upd .= " where $this->_pk = $pk_val";
       $this->query($upd, "Update error: ");
    }
}
