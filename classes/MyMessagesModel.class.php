<?php

class MyMessagesModel {

    private $dh;

    public function setDatabaseHandler($dh)
    {
        $this->dh = $dh;
    }

    public function create($messages_id, $users_id, $message)
    {
        $this->dh->connect();
        $messages_id = $messages_id ? $messages_id : "NULL";
        $sql = "INSERT INTO ".TB_MESSAGES." (`messages_id`,`users_id`,`message`) VALUES (%s,%s,'%s')";
        $params = array($messages_id, $users_id, $message);
        $result = $this->dh->executeQuery($sql, $params);

        if($result)
            $last_id = $this->dh->getLastId();
        else
            $last_id = false;

        $this->dh->close();
        return $last_id;
    }

    public function getMessages()
    {
        $this->dh->connect();
        $sql = "SELECT m.*, u.name, LOWER(u.email) email FROM ".TB_MESSAGES." m INNER JOIN ".TB_USERS." u ON m.users_id=u.id ORDER BY m.messages_id ASC, m.created_at ASC";
        $result = $this->dh->executeQuery($sql);
        $this->dh->close();

        $disordered_rows = array();
        $ordered_rows = array();

        while($row = $result->fetch_assoc())
        {
            $disordered_rows[] = $row;
        }

        if($disordered_rows && is_array($disordered_rows))
        {
            do {

                $row = array_shift($disordered_rows);
                $current_id = $row['id'];
                $ordered_rows[$current_id] = $row;
                $childs = findChilds($current_id, $disordered_rows);
                $ordered_rows[$current_id]['childs'] = $childs;
            } while (count($disordered_rows));
        }

        MyDebug::log($ordered_rows, 'ordered_rows');
        return $ordered_rows;
    }

}

function findChilds($parent_id, &$rows)
{
    $childs = array_filter($rows, function($element) use ($parent_id) { return ($parent_id==$element['messages_id']);});
    $clean_childs = array();
    $i=0;
    foreach($childs as $key => $row)
    {
        unset($rows[$key]);
        $clean_childs[$i]=$row;
        $clean_childs[$i]['childs'] = findChilds($row['id'], $rows);
        $i++;
    }

    return $clean_childs;
}
