<?php

class MyManager {

    public static function createUsersModel()
    {
        $dh = MyDatabaseHandler::singleton();
        $um = new MyUsersModel();
        $um->setDatabaseHandler($dh);
        return $um;
    }

    public static function createMessagesModel()
    {
        $dh = MyDatabaseHandler::singleton();
        $um = new MyMessagesModel();
        $um->setDatabaseHandler($dh);
        return $um;
    }

}