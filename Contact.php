<?php
require_once("./AbstractModel.php");
Class Contact extends AbstractModel
{
	protected $_table = "contacts";
	protected $_pk	  = "id";

    function __construct() {
        parent::__construct($this->_table);
    }   
}
