<?php

class MyDiff_Database{

  public $adapter = 'PDO_MYSQL';
  public $server;
  public $name;
  public $username;
  private $password;

  protected $_db;
  protected $_tables;

  public function __construct($config = array())
  {
    $keys = array_merge(array_keys(get_object_vars($this)), array('password'));

    foreach($config AS $key => $value)
    {
      if(in_array($key, $keys))
        $this->$key = $value;
    }
  }

  public function connect()
  {
    if($this->_db === null)
    {
      $connect = array(
        'host' => $this->server,
        'dbname' => $this->name,
        'username' => $this->username,
        'password' => $this->password,
      );

      $this->_db = Zend_Db::factory($this->adapter, $connect);
      $this->_db->getConnection();
    }

    return $this;
  }
  
  public function getDb()
  {
    return $this->_db;
  }

  public function getTables()
  {
    if($this->_tables === null)
    {
      $this->connect();
      $dbTables = $this->_db->listTables();

      $tables = array();
      foreach($dbTables AS $tableName)
        $tables[$tableName] = new MyDiff_Table($this, $tableName);

      $this->_tables = $tables;
      unset($tables);
    }

    return $this->_tables;
  }
  
}
