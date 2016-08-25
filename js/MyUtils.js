var $ = (function(){


    var MyUtils = function(selector){

        this.elements = [];

        if(selector)
        {
            occurrences = document.querySelectorAll(selector);

            for(i=0;i<occurrences.length;i++)
            {
                this.elements.push(occurrences[i]);
            }

        }

        this.addEvent = function(event, callback){
            for(i=0; i<this.elements.length; i++)
            {
                this.elements[i].addEventListener(event, callback);
            }

        };

        this.addClass = function(classname){
            for(i=0; i<this.elements.length; i++)
            {
                this.elements[i].classList.add(classname);
            }
        };

        this.removeClass = function(classname){
            for(i=0; i<this.elements.length; i++)
            {
                this.elements[i].classList.remove(classname);
            }
        };

        this.getValue = function(){
            return this.elements[0].value;
        };

        this.setValue = function(value){
            this.elements[0].value = value;
        };

        this.setInnerHTML = function(value){
            this.elements[0].innerHTML = value;
        };

        this.ajaxRequest = function(url, method, params, success, error){

            var http_request = false;
            var paramsList = [];

            for (var prop in params) {
                if(params.hasOwnProperty(prop)){
                    paramsList.push(prop + "=" + encodeURIComponent(params[prop]));
                }
            }

            var query = paramsList.join("&");

            if(window.XMLHttpRequest)
            {
                http_request = new XMLHttpRequest();
            }
            else if (window.ActiveXObject)
            {
                try
                {
                    http_request = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (ex1)
                {
                    try
                    {
                        http_request = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch (ex2)
                    {
                        alert("We can't create an XMLHTTP instance.");
                    }
                }
            }

            if(!http_request)
            {
                alert("We can't create an XMLHTTP instance.");
            }

            http_request.onreadystatechange = function(){

                if(http_request.readyState == 4)
                {
                    if(http_request.status == 200)
                    {
                        success(http_request.responseText);
                    }
                    else
                    {
                        error();
                    }
                }

            };

            http_request.open(method, url, true);
            http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            http_request.send(query);
        };

        return this;
    };

    return MyUtils;
})();

window.$ = $;