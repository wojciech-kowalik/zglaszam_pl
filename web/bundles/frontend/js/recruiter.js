$(document).ready(function(){

    /**
    * Modalbox class
    * @author Wojciech Kowalik
    */
    var Modalbox = function(){

       /**
        *  variables
        */
        var _modal = true;
        var _resizable = false;
        var _width = "auto";
        var _height = "auto";
        var _title = "Message";

        /**
        * Show spinner
        * @return void
        */
        Modalbox.spinner = function(){

            if($("#search-spinner").length){
                $("#search-spinner").show();
            }else{

                $("#dialog").html("<div id=\"search-spinner\" style=\"width: 100%; text-align:center; margin-top:50px;\";>\n\
                                        proszę czekać trwa ładowanie danych ...\n\
                                    </div>");
            }

        };

       /**
        * Make modal box
        * @param object DOMelement
        * @param mixed content
        * @param boolean isAjax
        * @return void
        */
        this.generate = function(object, content, isAjax){
            
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
            
                $.ajax({
                    url: object.attr("href"),
                    type:"GET",
                    async: true,
                    success:function(data){

                        if(data){
                            $("#dialog").html(data);
                        }
                    },

                    beforeSend: function(){
                        Modalbox.spinner();
                    },

                    error:function() {
                        alert("Wystąpił błąd w aplikacji");
                    }
                });  
            
            }else{
                $("#dialog").html(content);
            }
            
            $("#dialog").attr("title", _title);
            $("#dialog").dialog({modal: _modal, resizable: _resizable, width: _width, height: _height })

        };

    }; 

    // make instance of Modalbox 
    modal = new Modalbox();

    /* ------------------------------------------- */
    /* simulate placeholder*/
    /* ------------------------------------------- */

    if(!Modernizr.input.placeholder){

        $("input").each(
            function(){
                if($(this).val()=="" && $(this).attr("placeholder")!=""){
                    $(this).val($(this).attr("placeholder"));
                    $(this).focus(function(){
                        if($(this).val()==$(this).attr("placeholder")) $(this).val("");
                    });
                    $(this).blur(function(){
                        if($(this).val()=="") $(this).val($(this).attr("placeholder"));
                    });
                }
            });

    }    

    /* ------------------------------------------- */
    /* buttons section */
    /* ------------------------------------------- */



    $(".button-back-to-list").button({
        icons: {
            primary: "ui-icon-person"
        }
    });

    $(".button-new").button({
        icons: {
            primary: "ui-icon-circle-plus"
        }
    });

    $(".button-delete").button({
        icons: {
            primary: "ui-icon-circle-close"
        }
    });
    
    $(".button-delete").on("click", function(e){
      
        e.preventDefault();
	e.stopPropagation();
        
        if(confirm("Czy jesteś tego pewien?")){
            location.href = $(this).attr("href");
        }
    });  

    $(".button-save").button({
        icons: {
            primary: "ui-icon-circle-plus"
        }
    });

    $(".button-edit").button({
        icons: {
            primary: "ui-icon-pencil"
        }
    });
    
    $(".button-role").button({
        icons: {
            primary: "ui-icon-unlocked"
        }
    });    

    $(".button-login").button({
        icons: {
            primary: "ui-icon-locked"
        }
    });

    $(".button-show").button({
        icons: {
            primary: "ui-icon-person"
        }
    });

    /* ------------------------------------------- */
    /* modal boxes */
    /* ------------------------------------------- */

    $(".modalbox-handler").on("click", function(e){
        
        e.preventDefault();
	e.stopPropagation();
                    
        modal.generate($(this));
    })
    

    var icons = {
      header: "ui-icon-locked",
      headerSelected: "ui-icon-locked"
    };
    $("#accordion").accordion({
      icons: icons
    });


    /* ------------------------------------------- */
    /* validate */
    /* ------------------------------------------- */

    if($("#form-validate").length){
        $("#form-validate").validationEngine();
    }
    
    /* ------------------------------------------- */
    /* enable Hyphenator instance */
    /* ------------------------------------------- */    
    
    Hyphenator.config({
            displaytogglebox : false,
            minwordlength : 4
    });
    Hyphenator.run();    
    
    /* ------------------------------------------- */
    /* login method */
    /* ------------------------------------------- */

    $("#button-login").on("click", function(){

         _this = $(this);

        $.ajax({
            url: _this.parents("form").attr("action"),
            type:"POST",
            dataType: "json",
            data: {
                _username: $("#login").val(),
                _password: $("#pass").val()
            },
            async: true,
            success:function(data){

                if(data.state){
                    location.reload(true);
                }else{
                   
                    modal.generate(_this, "Błędne logowanie <br /> Proszę sprawdzić wpisane dane")
                }
            },

            error:function() {
                alert("Wystąpił błąd w aplikacji");
            }
        });

    });    
   
});









