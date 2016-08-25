<?php

class MyDatabaseHandler {

    private static $instance;
    private $mysqli;

    public static function singleton()
    {
        if(!isset(self::$instance))
        {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        return self::$instance;
    }

    public function connect()
    {
        try {
            $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if($this->mysqli->connect_errno)
            {
                throw new Exception("Connection failure: ".$this->mysqli->connect_error);
            }

            return true;

        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function close()
    {
        try{
            $close = $this->mysqli->close();
            if($close===false)
            {
                throw new Exception("Closing failure.");
            }
        } catch (Exception $ex){
            throw $ex;
        }
    }

    public function executeQuery($sql, $params=array())
    {
        try {
            if($params && is_array($params))
            {
                $clean_params = array();
                foreach($params as $value)
                {
                    // Prevent SQL Injection
                    $clean_params[] = $this->mysqli->real_escape_string($value);
                }

                $sql = vsprintf($sql, $clean_params);
                MyDebug::log($sql, 'SQL');
            }

            $result = $this->mysqli->query($sql);

            return $result;

        } catch(Exception $ex) {
            throw $ex;
        }
    }

    public function getLastId()
    {
        return $this->mysqli->insert_id;

    }

}