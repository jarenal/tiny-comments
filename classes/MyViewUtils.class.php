<?php

class MyViewUtils {

    public static function generateMessagesList($messages)
    {
        MyDebug::log($messages, 'messages');
        $html = "";
        foreach($messages as $message)
        {
            $pattern = '/(?:https\:\/\/|http\:\/\/|www\.)?[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(?:\??)[a-zA-Z0-9\-\._\?\,\'\/\\\+&%\$#\=~]+/';
            $mensaje = preg_replace_callback($pattern, function($matches){
                $result = "";
                foreach($matches as $match)
                {
                    if(strpos($match, "http")===false)
                        $match = "http://".$match;
                    $result .= "<a href=\"$match\" target=\"_blank\">$match</a>";
                }

                return $result;
            }, $message['message']);
            $html .= <<<EOF
            <li>
                <div class="m-box">
                    <div class="m-header">{$message['name']} (<a href="mailto:{$message['email']}">{$message['email']}</a>) <div class="m-date">{$message['created_at']}</div></div>
                    <div class="m-body">{$mensaje}</div>
                    <div class="m-footer"><div class="m-id">#{$message['id']}</div><div class="m-reply"><a href="#" class="btn-reply" data-idreply="{$message['id']}">Reply</a></div></div>
                </div>

EOF;
            if($message['childs'])
            {
                $html .= "<ul>".self::generateMessagesList($message['childs'])."</ul></li>";
            }


        }

        return $html;
    }
}