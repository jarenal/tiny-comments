var onReady = function(){

    $('#link-new-message').addEvent('click', function(e){
        e.preventDefault();
        loadPopup(function(responseText){
            $('#popup-form').setInnerHTML(responseText);
            setPopupListeners();
            $('#popup-form h3').setInnerHTML("Create new message");
            $('#popup-form').addClass('on');
        }, function(){
            alert('Error trying to create formulary.');
        });
    });

    reloadMessages();

};

var reloadMessages = function(){
    $().ajaxRequest('webservices/get_messages_list.php', 'GET', {}, function(responseText){
        $('.container').setInnerHTML(responseText);
        setBtnReplyListener();
    }, function(){
        alert("Error trying to reload messages.");
    });
};

var setBtnReplyListener = function(){
    $('.btn-reply').addEvent('click', function(e){
        e.preventDefault();
        var idreply = this.dataset.idreply;
        loadPopup(function(responseText){
            $('#popup-form').setInnerHTML(responseText);
            setPopupListeners();
            $('#messages_id').setValue(idreply);
            $('#popup-form h3').setInnerHTML("In reply to #"+idreply+" message");
            $('#popup-form').addClass('on');
        }, function(){
            alert("Error trying to create formulary");
        });
    });
};

var loadPopup = function(success, error) {
    $().ajaxRequest('webservices/load_popup.php', 'GET', {}, success, error);
};

var setPopupListeners = function(){
    $('#btn-cancel,#p-background').addEvent('click', function(e){
        e.preventDefault();
        // Clean form
        $('#messages_id').setValue("");
        $('#post_name').setValue("");
        $('#post_email').setValue("");
        $('#post_message').setValue("");
        $('#popup-form').removeClass('on');
    });

    $('#btn-send').addEvent('click', function(e){
        e.preventDefault();
        var params = {};
        params.token = $('#token').getValue();
        params.messages_id = $('#messages_id').getValue();
        params.name = $('#post_name').getValue();
        params.email = $('#post_email').getValue();
        params.message = $('#post_message').getValue();
        params.number = $('#post_number').getValue();

        try
        {
            if(!params.name)
            {
                throw('The name is required.');
            }

            if(!params.email)
            {
                throw('The email is required.');
            }

            if(!params.email.match(/([\w\.\-_]+)?\w+@[\w-_]+(\.\w+){1,}/i))
            {
                throw('The email is not valid.');
            }

            if(!params.message)
            {
                throw('The message is required.');
            }

            if(!params.number)
            {
                throw('The hidden number is required.');
            }
        }
        catch(ex)
        {
            alert(ex);
            return false;
        }

        $().ajaxRequest('webservices/create.php', 'POST', params, function(responseText){
            response = JSON.parse(responseText);
            if(response.error)
            {
                alert(response.message);
                return false;
            }

            // Clean form
            $('#messages_id').setValue("");
            $('#post_name').setValue("");
            $('#post_email').setValue("");
            $('#post_message').setValue("");

            alert("Your message was created successfully!");
            // Close popup
            $('#popup-form').removeClass('on');

            reloadMessages();

        }, function(){
            alert("Error trying to create message.");
        });
    });
};


