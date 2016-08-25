<?php

class MyUsersModel {

    private $dh;

    public function setDatabaseHandler($dh)
    {
        $this->dh = $dh;
    }

    public function findByEmail($email)
    {
        $this->dh->connect();
        $sql = "SELECT * FROM ".TB_USERS." WHERE LOWER(email)='%s'";
        $params = array(strtolower($email));
        $result = $this->dh->executeQuery($sql, $params);
        $data = $result->fetch_assoc();
        $this->dh->close();
        return $data;
    }

    public function create($name, $email)
    {
        $this->dh->connect();
        $sql = "INSERT INTO ".TB_USERS." (`name`,`email`) VALUES ('%s','%s')";
        $params = array($name, strtolower($email));
        $result = $this->dh->executeQuery($sql, $params);

        if($result)
            $last_id = $this->dh->getLastId();
        else
            $last_id = false;

        $this->dh->close();
        return $last_id;
    }

    public function update($iduser, $name)
    {
        $this->dh->connect();
        $sql = "UPDATE ".TB_USERS." SET name='%s' WHERE id=%s";
        $params = array($name, $iduser);
        $result = $this->dh->executeQuery($sql, $params);
        $this->dh->close();
        return $result;
    }


}