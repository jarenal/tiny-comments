<?php

require_once dirname(__FILE__)."/../config/config.php";

$messagesModel = MyManager::createMessagesModel();
$messages = $messagesModel->getMessages();

echo MyViewUtils::generateMessagesList($messages);

