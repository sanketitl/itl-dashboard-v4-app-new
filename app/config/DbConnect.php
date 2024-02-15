<?php
namespace ITL\Config;

class DbConnect 
{
    private $host;
    private $user;
    private $password;
    private $databaseName;
    private $dbMysqli;

    public function __construct($dbSlave) 
    {
        if($dbSlave == 'Master')
        {
            $this->host = $_SERVER['dHost'];
            $this->user = $_SERVER['dbUser'];
            $this->password = $_SERVER['dbPassword'];
            $this->databaseName = $_SERVER['dbDatabase'];
        }
        else if($dbSlave == 'Slave')
        {
            $this->host = $_SERVER['slaveDbHost'];
            $this->user = $_SERVER['slaveDbUser'];
            $this->password = $_SERVER['slaveDbPassword'];
            $this->databaseName = $_SERVER['slaveDbDatabase'];
        }
        else 
        {
            return;
        }
        $this->connect();
    }

    /**
     * Make connection with database
     */

    private function connect()
    {
        $dbTimeout = 30;
        $this->dbMysqli = mysqli_init();
        if (!$this->dbMysqli->options( MYSQLI_OPT_CONNECT_TIMEOUT, $dbTimeout )) {
            die("Connection failed: " . $this->dbMysqli->error);
        }

        if (!$this->dbMysqli->real_connect($this->host, $this->user, $this->password, $this->databaseName)) {
            die("Connection failed: " . $this->dbMysqli->error);
        }
        mysqli_set_charset($this->dbMysqli, 'utf8');
    }
    
    /**
     * Exectute the database query
     * @param $query
     */

    public function execute($query) 
    {
        return mysqli_query($this->dbMysqli, $query);  
    }
}