
/**
 * Modalbox constructor object
 * 
 * @author w.kowalik 
 * @package web\js
 * @access public
 * @copyright visualnet.pl
 */

$(document).ready(function(){
  
    /**
    * Modalbox constructor
    * @author Wojciech Kowalik
    */
    Visualnet.Modalbox = function(){

        /**
        *  variables
        */
        var _modal = true;
        var _resizable = true;
        var _width = "auto";
        var _height = "auto";
        var _minHeight = 400;
        var _title = "Komunikat";
        var _element = {};

        /**
        * Init method after create instance
        */         
        (function init() {
            $(".dialog").attr("title", '');
        })();  

        /**
        * Set element
        * 
        * @param object DOMelement
        * @return void
        */
        var _set = function(element){
            
            if(element === undefined){    
                
                _element = $(".dialog");
                
            }else{
                
                _element = element;
            }  
        };

        /**
        * Make modalbox
        * 
        * @param object DOMelement
        * @param mixed content
        * @param boolean isAjax
        * @return void
        */
        this.generate = function(object, content, isAjax, buttons, element){     
                     
            _set(element);         
                        
            _element.html("");
                           
            if(typeof(isAjax) === undefined){
                isAjax = false;
            }
                        
            if(object.data("width")){
                _width = object.data("width");
            }
            
            if(object.data("height")){
                _height = object.data("height");
            }    
            
            if(object.data("title")){
                _title = object.data("title");
            }           
                                                
            if(isAjax){
                     
                _element.load(object.data("href"), function(response, status, xhr) {
                    if (status == "error") {
                        alert("Wystąpił błąd w aplikacji");
                        return;
                    }
                });
            
            }else{
                _element.html(content);
            }
            
            params = {
                
                modal: _modal, 
                resizable: _resizable, 
                width: _width, 
                height: _height,
                buttons: buttons,
                minHeight: _minHeight,
                title: _title
                
            };

            // reinit timer logout
            new Visualnet.Timer({}, Routing.generate("AdminBundle_logout")).make();

            return _element.dialog(params);        

        };
                
        /**
        * Close modalbox
        * 
        * @return void
        */
        this.close = function(){
            
            $(".dialog").dialog("close");
            $("#list").trigger("reloadGrid");
            $(".dialog").dialog("destroy");
        };
        
        /**
        * Error message
        * 
        * @return void
        */        
        this.error = function(message){
            
            element = $("<div></div>");
            element.data("height", 120);
            
            buttons = {
                "Ok": function() {
                    $( this ).dialog( "close" );
                }
            };              
            
            this.generate(element, message, false, buttons, element);  
            
            return false;
        };
        
       /**
        * Wrapper for better code marked
        * 
        * @return void
        */          
        this.monit = function(message){
            this.error(message);
        };
        
       /**
        * Confirm box after action
        * 
        * @return void
        */          
        this.confirm = function(object){
                        
            _this = this;
            
            $.ajax({
                type: "GET",
                dataType: "json",
                url: object.data("href"),
                success: function(data) {
                    
                    if(data.state == false){
                        _this.error(data.message);
                    }else{
                        $("#list").trigger("reloadGrid");
                    }
                },
                error: function(data) {
                    _this.error("Wystąpił błąd w aplikacji");
                }
            });

        };
        
        /**
        * Delete modal box
        * 
        * @param object DOMelement
        * @return void
        */        
        this.del = function(element){
            
            uri = element.data("href");
            
            element.data("title", "Komunikat");

            var buttons = {
                "Tak": function() {
                    
                    $.get(element.data("href"), function(data) {
 
                        $(".dialog").dialog("close");
                        $("#list").trigger("reloadGrid");
 
                    }, "json");
              
                },
                "Nie": function() {
                    $( this ).dialog( "close" );
                }
            };        

            this.generate(element, "Czy jeste\u015b tego pewien?",false, buttons);            
            
        };

    }; 

    // make instance of Modalbox 
    modal = new Visualnet.Modalbox();  
    
});    

// BINDERS

$(".button-close").on("click", function(){
    modal.close();
});

$(".button-thanks").on("click", function(){
   
    $.ajax({
        type: "POST",
        url: $(this).data("href"),
        async: false,
        success: function(data) {
            modal.close(); 
        },
        error: function(data) {
            modal.error("Wystąpił błąd w aplikacji");
        }
    }); 
        
});
        
$(".button-save").on("click", function(){
              
    _form = $("form"); 
    subModal = $("<div></div>");
    _this = $(this);
    var buttons;   
    
    // clean errors classes
    $("form input.error").removeClass("error");
    $("#global-errors").html('example').addClass("hidden");
    
    // check if CKEDITOR instance exists
    if(typeof CKEDITOR != "undefined"){

        //this is the foreach loop
        for(var i in CKEDITOR.instances) {

            // this updates the value of the textarea from the CK instances
            CKEDITOR.instances[i].updateElement();

            // set textarea values from instances
            $("#"+CKEDITOR.instances[i].name).html(CKEDITOR.instances[i].getData());

        }

    }
    
    $.post(_form.attr("action"), _form.serialize(),
        function(data){
            
            // get data
            if(data.errors){
                
                // parse json objects
                errors = $.parseJSON(data.errors);
                        
                if(errors == null){
                    errors = data.errors;
                }        
                        
                $.each(errors, function(i, val) {

                    if($.isNumeric(i)){
                        
                        $("#global-errors").removeClass("hidden").html(val);
                        
                    }else{
                        
                        $('#'+i).addClass("error");
                        $("#"+i).attr("placeholder", val);                        
                        
                    }
                    
                });
                
                buttons = {
                    "Ok": function() {
                        $( this ).dialog( "close" );
                    }
                };                 
            
            }else{
                
                buttons = {
                    "Ok": function() {
                        $( this ).dialog( "close" );
                        modal.close();
                    }
                };                
                
            }

            modal.generate(_this, data.message, false, buttons, subModal);
             
        }, "json");
   
});    
    
