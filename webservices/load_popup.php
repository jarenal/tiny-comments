<?php
require_once dirname(__FILE__)."/../config/config.php";

$_SESSION['my_token'] = md5(time());

$current_number = rand(1,1000);
$list = array();
$hide_position = rand(0,3);
$jump = rand(1,3);

for($i=0;$i<4;$i++)
{
    if($hide_position==$i)
    {
        $_SESSION['hidden_number']= $current_number;
        $list[] = "*";
    }
    else
    {
        $list[] = $current_number;
    }

    $current_number = $current_number + $jump;
}
?>
<div id="p-background" class="p-background"></div>
<div class="form-container">
    <h3>New message</h3>
    <div class="f-box">
        <form method="post" action="">
            <input id="messages_id" type="hidden" name="messages_id" value=""/>
            <input id="token" type="hidden" name="token" value="<?php echo $_SESSION['my_token'] ?>"/>
            <fieldset>
                <label for="post_name">Name:</label>
                <input id="post_name" type="text" name="post[name]"/>
            </fieldset>
            <fieldset>
                <label for="post_email">Email:</label>
                <input id="post_email" type="text" name="post[email]"/>
            </fieldset>
            <fieldset>
                <label for="post_message">Message:</label><br><br>
                <textarea id="post_message" name="post[message]" cols="3" rows="6"></textarea>
            </fieldset>
            <fieldset>
                <p><?php echo implode(", ", $list) ?></p>
                <label for="post_message">Which is the hidden number?:</label>
                <input id="post_number" type="text" name="post[number]" class="post_number"/>
            </fieldset>
            <p>
                <input id="btn-cancel" class="btn-cancel" type="button" name="cancel" value="Cancel"/>
                <input id="btn-send" class="btn-send" type="button" name="send" value="Send!"/>
            </p>
        </form>
    </div>
</div>