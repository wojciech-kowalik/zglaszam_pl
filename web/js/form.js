
/**
 * Form constructor object
 * 
 * @author w.kowalik 
 * @package web\js
 * @access public
 * @copyright visualnet.pl
 */

$(document).ready(function(){
 
    Visualnet.Element = null;
 
    /**
    * Form constructor
    * @author Wojciech Kowalik
    */
    Visualnet.Form = function(){
         
        var _cache = {};
        var _lastXhr;
        var _minLength = 2
        var _delay = 0;

        /**
        * Init method after create instance
        */         
        (function init() {
            
            $("#button-add-searched").button({
                icons: {
                    primary: "ui-icon-search"
                },
                disabled: true
            });             
            
        })();  
         
        /**
        * Add question to form
        * 
        * @return void
        */         
        this.addQuestion = function(object){
                                
            urlNew = urlCheck = null;
                                                                           
            if(Visualnet.Element === null){
                return;
            }
                
            urlNew = Routing.generate("FormBundle_question_new", {
                id: Visualnet.Element.id, 
                mainID: object.data("form-id")
            });

            object.data("href", urlNew);
            modal.generate(object, false, true);

        }; 
         
        /**
        * Search for questions
        * 
        * @return void
        */
        this.search = function(object){

            object.autocomplete({
                
                minLength: _minLength,
                delay: _delay,
                
                focus: function(event, ui ){
                  
                object.val( ui.item.label );
                    
                },
                
                close: function (event, ui){
                    
                $("#button-add-searched").button( "option", "disabled", false );
                object.removeClass("ui-autocomplete-loading" );
                },
                
                select: function (event, ui){
                    
                $("#button-add-searched").button( "option", "disabled", false );
                    
                Visualnet.Element = ui.item;
                object.removeClass("ui-autocomplete-loading" );
                },
                
                source: function( request, response ) {
                    
                var term = request.term;
                    
                if ( term in _cache ) {
                response( _cache[ term ] );
                return;
                }

                _lastXhr = $.getJSON( object.data("url"), request, function( data, status, xhr ) {
                    _cache[ term ] = data;
                    if ( xhr === _lastXhr ) {
                    response( data );
                    }
                    });
                }
                
                }).data( "autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a><span style='font-weight: bold; font-style: italic'>" + item.label + "</span><br />" + item.desc + "</a>" )
                .appendTo( ul );
            };
         
        };
        
       
    }; 

    if($("#question-searcher").length){

        // make instance of Form
        form = new Visualnet.Form();  
        form.search($("#question-searcher"));
    
    }
    
});

// BINDERS

$("#question-searcher").on("autocompleteclose autocompleteopen keyup focusout", function(){
    
    $("#button-add-searched").button( "option", "disabled", true );
    
});

$(".question-add").on("click", function(event){
    
    state = true;
    _this = $(this);
    
    if($(this).is(":checked")){
        Visualnet.Element = new Object();
        Visualnet.Element.id = _this.data("id");
    }
    
    urlCheck = Routing.generate("FormBundle_question_check", {
        id: Visualnet.Element.id, 
        mainID: _this.data("form-id")
    });    
    
    $.ajax({
        type: "GET",
        url: urlCheck,
        dataType: "json",
        async: false,
        success: function(data) {

            if(data.state == false){
                        
                monit = $("<div></div>");
                monit.data("height", 80);
                monit.data("width", 200);
                monit.data("title", "Komunikat");
                      
                modal.generate(monit, data.message, false, false, monit);

                state = false;
            }

        },
        error: function(data) {
            state = false;
            modal.error("Wystąpił błąd w aplikacji");
        }
    });    
    
    if(state){
        form.addQuestion(_this);
    }

});
