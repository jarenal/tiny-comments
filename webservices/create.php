<?php

require_once dirname(__FILE__)."/../config/config.php";

$response = array();
$response['error'] = 0;
$response['data'] = array();
$response['message'] = "The request was executed successfully";

try
{
    if(!isset($_POST['token']) || !$_POST['token'])
        throw new Exception("The token is required.");

    if($_POST['token']!=$_SESSION['my_token'])
        throw new Exception("The token doesn't match.");

    if(!isset($_POST['name']) || !$_POST['name'])
        throw new Exception("The name is required.");

    if(!isset($_POST['email']) || !$_POST['email'])
        throw new Exception("The email is required.");

    $pattern = "/([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}/i";
    $exist = preg_match($pattern, $_POST['email'], $matches);

    if(!$exist)
        throw new Exception("The email is invalid.");

    if(!isset($_POST['message']) || !$_POST['message'])
        throw new Exception("The message is required.");

    if(!isset($_POST['number']) || !$_POST['number'])
        throw new Exception("The hidden number is required.");

    if($_POST['number'] != $_SESSION['hidden_number'])
        throw new Exception("The hidden number is wrong.");

    /* user exist? */
    $usersModel = MyManager::createUsersModel();
    $user = $usersModel->findByEmail($_POST['email']);
    MyDebug::log($user, 'user exist?');

    if($user)
    {
        $users_id = $user['id'];
        $usersModel->update($users_id, $_POST['name']);
    }
    else
    {
        $users_id = $usersModel->create($_POST['name'], $_POST['email']);
    }

    /* Save message */
    $messagesModel = MyManager::createMessagesModel();
    $messaes_id = $messagesModel->create($_POST['messages_id'], $users_id, $_POST['message']);
    $response['data']['message_id'] = $messaes_id;


}
catch (Exception $ex)
{
    $response['error'] = 1;
    $response['message'] = $ex->getMessage();
}

die(json_encode($response));

