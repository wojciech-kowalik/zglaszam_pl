
/**
 * Common admin/frontend objects
 * 
 * @author w.kowalik 
 * @package web\js
 * @access public
 * @copyright visualnet.pl
 */

$(document).ready(function(){
                          
    /* ------------------------------------------- */
    /* ajax request trigger */
    /* ------------------------------------------- */                      
                  
    $.ajaxSetup({
        beforeSend: function() {
            $('#loader').show();
        },
        complete: function(){
            $('#loader').hide();
        },
        success: function() {}
    });                           

    /* ------------------------------------------- */
    /* automatic logout */
    /* ------------------------------------------- */             
             
    if($("#timer").length){   
        
        new Visualnet.Timer(
            {sessionTimeout: 15}, 
            Routing.generate("AdminBundle_logout")
        ).make();
            
    }
          
    /* ------------------------------------------- */
    /* fonts */
    /* myriad.font.js
    /* ------------------------------------------- */
    
    if(typeof Cufon != "undefined"){
        Cufon.replace("#header #description-content .header"); 
    }
                
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
    /* modal boxes */
    /* ------------------------------------------- */

    $(".modal-handler").on("click", function(e){
        
        e.preventDefault();
        e.stopPropagation();
                    
        modal.generate($(this), false, true);
    });
       
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
                   
                    modal.generate(_this, "Błędne logowanie <br /> Proszę sprawdzić wpisane dane");
                }
            },

            error:function() {
                modal.generate(_this, "Wystąpił błąd w aplikacji");
            }
        });

    });   
        
    /* ------------------------------------------- */
    /* 3rd parties */
    /* ------------------------------------------- */

    jQuery.ajaxSetup({
        beforeSend: function() {
            $('#loader').show()
        },
        complete: function(){
            $('#loader').hide()
        },
        success: function() {}
    });
    
    /* ------------------------------------------- */
    /* trigger on enter press in login form */
    /* ------------------------------------------- */    
    
    $("#form-login input").keypress(function(e) {
        if(e.which == 13) {
            $(this).closest("form").submit();
        }
    });    
         
    /* ------------------------------------------- */
    /* tip */
    /* ------------------------------------------- */

    $(".title").tipsy({
        live : false,
        gravity: 'w',
        opacity: 1
    });

    /* ------------------------------------------- */
    /* validate */
    /* ------------------------------------------- */

    if($("#form-validate").length){
        $("#form-validate").validationEngine({scroll: false});
    }  
    
    /* ------------------------------------------- */
    /* slider */
    /* ------------------------------------------- */    
    
    if($('#description-content').length){
    
        $('#description-content').bjqs({
            animation : 'slide',
            width : 500,
            height : 200,
            showMarkers : true,
            showControls : false,
            centerMarkers : false,
            keyboardNav: true,
            rotationSpeed: 6000
        }); 
    
    }    
   
});

/* ------------------------------------------- */
/* images lazy loading */
/* ------------------------------------------- */

$("img.lazy-load").lazyload();  


/* ------------------------------------------- */
/* simply method to change comma with dot */
/* ------------------------------------------- */

function commaChanger(object){
    
    var value = object.val();
    
    if(value.search(',') != -1){
        object.val(value.replace(',','.'))
    }       
}

/* ------------------------------------------- */
/* simply method to count remain words in input */
/* ------------------------------------------- */

function wordCounter(object, limit){
    
    var charCount = $("#counter-"+object.attr("id"));
    
    if (object.val().length > limit){
      object.val(object.val().substring(0,limit));  
    } 
    if (charCount){
      charCount.html(limit - object.val().length);  
    } 
    
    return true;
}

/* ------------------------------------------- */
/* buttons section */
/* ------------------------------------------- */

var icons = {
    header: "ui-icon-locked",
    headerSelected: "ui-icon-locked"
};
$("#accordion").accordion({
    icons: icons
}); 

$(".button-back-to-list").button({
    icons: {
        primary: "ui-icon-person"
    }
});

$(".button-generate-login").button({
    icons: {
        primary: "ui-icon-refresh"
    }
});

$(".button-new").button({
    icons: {
        primary: "ui-icon-circle-plus"
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

if($('select.change').length){

    $('select.change').selectmenu({
        maxHeight: 150,
        width: 100,
        handleWidth: 200,
        menuWidth: 250
    }
    );
    
}

/* ------------------------------------------- */
/* enable tabs */
/* ------------------------------------------- */    

$(".tabs").tabs();     

/* ------------------------------------------- */
/* global binders */
/* ------------------------------------------- */   

// change recruitment binder
$(".recruitment-select").on("change", function(){

    if($(this).val() != ''){
        location.href = $(this).find(":selected").data("href"); 
    }

});

// button learn more binder
$(".button-learn").on("click", function(){

    $("html, body").animate({
        scrollTop: $("#notice").offset().top
    }, 2000);            

});  

// register the same address data binder
$("#data-the-same").on("click", function(){
   
   // array with object data
   var data = [
       
       {prefix: "user", suffix: "street"},
       {prefix: "user", suffix: "flat"},
       {prefix: "user", suffix: "city"},
       {prefix: "user", suffix: "postcode"}
   ];
   
   // if checked
   if($(this).is(":checked")){
       
       // copy data from field to field
       for(i in data){
           $('#'+data[i].prefix+'_group_'+data[i].suffix).val($('#'+data[i].prefix+'_'+data[i].suffix).val());
       }
       
   }else{ // after unchecked clean data
       
       for(i in data){
           $('#'+data[i].prefix+'_group_'+data[i].suffix).val('');
       }
   }
   
});

// remind password binder
$("#remind-password-button").on("click", function(){
   
   if($("#form-validate").validationEngine('validate')){
   
      var email = $("#email").val();
      
        $.ajax({
            type: "POST",
            url: $("#form-validate").attr("action"),
            dataType: "json",
            data: {email: email},
            async: false,
            success: function(data) {

                modal.monit(data.message);

            },
            error: function(data) {
                modal.error("Wystąpił błąd w aplikacji");
            }
        });     
   
   }
      
});

/**
* jqGrid initialize method
* 
* @param url String
* @param routingNames Object
* @param colNames Array
* @param colModels Array
* @param sortName String
* @param config Object
* @return jqGrid
*/
function jqGridInit(url, routingNames, colNames, colModels, sortName, config) {
    
    // resize handler
    $(window).bind("resize", function() {
        $("#list").setGridWidth($(".content").width());
    }).trigger("resize");    
    
    var _multiselect = false;
    
    // get config object
    if(config instanceof Object){
        
        if(config.multiselect){
            _multiselect = config.multiselect;
        }
    }
    
    return $("#list").jqGrid({
        url: url,
        datatype: 'json',
        shrinkToFit:true,
        colNames: colNames,
        colModel: colModels,
        pager: '#pager',
        gridview: false,
        autowidth: true,
        height: '100%',
        sortorder: 'asc',
        viewrecords: true,
        ignoreCase: true,
        emptyrecords: "Brak rekordów do wyświetlenia",
        caption: "Lista",
        mtype: 'POST',
        scrollOffset:0,
        multiselect: _multiselect,
        
        gridComplete: function(){ 
                        
            // set counter in title
            if($('.title-counter').length == 0){
                $('.ui-jqgrid-title').append($('<span>').attr('class', 'title-counter').html(' ('+$(this).getGridParam('records')+') '));
            }

            // external callbacks
            if(typeof recruitment != "undefined"){
                
                $(".cbox").on("click", function(){
                    recruitment.setQualify($(this));
                });
                
                globalChecked = recruitment.getQualified();
                
                if(globalChecked.length > 0){
                
                    // iterate over global checked values
                    $.each(globalChecked, function(i, value){

                        if($("#jqg_list_"+value)){
                            $("#jqg_list_"+value).attr("checked", true);
                        }

                    });
                
                }
                
            }
            
            // internal callbacks
            jqGridValueManipulate(routingNames);
        }         
            
    });
    
}

/**
* jqGrid manipulate data method
* 
* @param routingNames Object
* @return void
*/
function jqGridValueManipulate(routingNames){
    
    var ids = jQuery("#list").jqGrid('getDataIDs'), numberOfPages = parseInt($("#sp_1_pager").text()), // total pages
              numberOfItems = ids.length, actualPage = parseInt($(".ui-pg-input").val()), // actual page
              i;    
                
    for(i = 0; i < numberOfItems; i++){ 
                
        var cl = ids[i],
        _edit = _show = _delete = _order = _question = _sort = _preview =  '';
        
        // check if value is qualified
        if($("#"+cl+" .ui-icon-circle-check" ).length == 1){
            $("#jqg_list_"+cl).attr("disabled", true);
        }        
        
        if(routingNames.sort != undefined){
                     
            if( i == 0 ){ // check first row if sort up is available

                if (numberOfPages == 1 
                    || actualPage == 1){ // if is only one data page
                    _sort += "<a class=\"button-new\"></a>";
                }else{
                    _sort += sortHelper(cl, 0, routingNames);
                }                
                
            }else{ // for others rows
                _sort += sortHelper(cl, 0, routingNames);               
            }
            
            if(i == (numberOfItems - 1)){ // for last row
                
                if(numberOfPages == 1 
                    || actualPage == numberOfPages){ // if is only one data page
                    _sort += "<a class=\"button-new\"></a>";
                }else{
                    _sort += sortHelper(cl, 1, routingNames); 
                }
                
            }else{
                _sort += sortHelper(cl, 1, routingNames); 
            }
                                        
        }
                
        if(routingNames.edit != undefined){
                    
             var title;   
                
             if(routingNames.edit.title){
                title = routingNames.edit.title;
             }                     
                    
            _edit = "<a class=\"button-new ui-button ui-widget ui-button-text-icon-primary\"";
            _edit += " onclick=\"javascript: modal.generate($(this), false, true);\" data-height=\""+routingNames.edit.height+"\" data-width=\""+routingNames.edit.width+"\" data-title=\""+routingNames.edit.title+"\"";

            if(routingNames.edit.mainID){
                _edit += "data-href=\""+Routing.generate(routingNames.edit.name, {
                    id: cl, 
                    mainID: routingNames.edit.mainID
                })+"\"";  
            }else{
                _edit += "data-href=\""+Routing.generate(routingNames.edit.name, {
                    id: cl
                })+"\"";                         
            }
                    
            _edit += " role=\"button\" aria-disabled=\"false\">";
            _edit += "<span class=\"ui-button-icon-primary ui-icon ui-icon-pencil\" title=\"Edytuj\"></span>";
            _edit += "<span class=\"ui-button-text\"> </span>";
            _edit += "</a>";

        }
                
        if(routingNames.del != undefined){
                    
            _delete = "<a data-title=\"Komunikat\" data-height=\""+routingNames.del.height+"\" data-width=\""+routingNames.del.width+"\"  onclick=\"javascript: modal.del($(this));\" ";
                    
            if(routingNames.del.mainID){
                _delete += "data-href=\""+Routing.generate(routingNames.del.name, {
                    id: cl, 
                    mainID: routingNames.del.mainID
                })+"\"";  
            }else{
                _delete += "data-href=\""+Routing.generate(routingNames.del.name, {
                    id: cl
                })+"\"";                         
            }                    
                    
            _delete += " class=\"button-new ui-button ui-widget ui-button-text-icon-primary\"";
            _delete += " role=\"button\" aria-disabled=\"false\">";
            _delete += "<span class=\"ui-button-icon-primary ui-icon ui-icon-close\" title=\"Usuń\"></span>";
            _delete += "<span class=\"ui-button-text\"> </span>";
            _delete += "</a>";                                       
        }
                                
        if(routingNames.question != undefined){
                                
            _question = "<a class=\"button-new ui-button ui-widget ui-button-text-icon-primary\"";
            _question += " href=\""+Routing.generate(routingNames.question.name, {
                id: cl
            })+".html"+"\" role=\"button\" aria-disabled=\"false\">";
            _question += "<span class=\"ui-button-icon-primary ui-icon ui-icon-comment\" title=\"Pytania\"></span>";
            _question += "<span class=\"ui-button-text\"> </span>";
            _question += "</a>";
                
        }     
                
        if(routingNames.date != undefined){
                
            _question = "<a class=\"button-new ui-button ui-widget ui-button-text-icon-primary\"";
            _question += " href=\""+Routing.generate(routingNames.date.name, {
                id: cl
            })+".html"+"\" role=\"button\" aria-disabled=\"false\">";
            _question += "<span class=\"ui-button-icon-primary ui-icon ui-icon-calendar\" title=\"Terminy\"></span>";
            _question += "<span class=\"ui-button-text\"> </span>";
            _question += "</a>";
                
        }
                
        if(routingNames.show != undefined){
                
             var title;   
                
             if(routingNames.show.title){
                title = routingNames.show.title;
             }                
                
            _show = "<a class=\"button-new ui-button ui-widget ui-button-text-icon-primary\"";
            _show += " onclick=\"javascript: modal.generate($(this), false, true);\" data-height=\""+routingNames.show.height+"\" data-width=\""+routingNames.show.width+"\" data-title=\""+routingNames.show.title+"\" ";

            _show += "data-href=\""+Routing.generate(routingNames.show.name, {
                id: cl
            })+".html"+"\"";                         
                    
            _show += " role=\"button\" aria-disabled=\"false\">";
            _show += "<span class=\" ui-button-icon-primary ui-icon ui-icon-person\" title=\"Podgląd danych\"></span>";
            _show += "<span class=\"ui-button-text\"> </span>";
            _show += "</a>";                
                
        }  
        
        if(routingNames.preview != undefined){
                
             var title;   
                
             if(routingNames.preview.title){
                title = routingNames.preview.title;
             }                 
                
            _preview = "<a class=\"button-new ui-button ui-widget ui-button-text-icon-primary\"";
            _preview += " onclick=\"javascript: modal.generate($(this), false, true);\" data-height=\""+routingNames.preview.height+"\" data-width=\""+routingNames.preview.width+"\" data-title=\""+routingNames.preview.title+"\" ";

            _preview += "data-href=\""+Routing.generate(routingNames.preview.name, {
                id: cl
            })+".html"+"\"";                         
                    
            _preview += " role=\"button\" aria-disabled=\"false\">";
            _preview += "<span class=\" ui-button-icon-primary ui-icon ui-icon-contact\" title=\"Podgląd danych\"></span>";
            _preview += "<span class=\"ui-button-text\"> </span>";
            _preview += "</a>";                
                
        }                
                
        // set actions into grid        
        jQuery("#list").jqGrid('setRowData',ids[i],{
            actions: _show+_edit+_question+_sort+_order+_preview+_delete
        }); 
    }    
    
}

/**
 * Sort helper, DRY function
 * 
 * @param id
 * @param dir
 * @param routingNames Object
 * @return string
 */    
function sortHelper(id, dir, routingNames){
    
   var msg = "Przesuń w dół";
   var type = 's';
    
    if(dir == 0){
        msg = "Przesuń do góry";
        type = 'n';
    }
    
    _sort = "<a class=\"button-new ui-button ui-widget ui-button-text-icon-primary\"";
    _sort += " onclick=\"javascript: modal.confirm($(this));\" data-height=\""+routingNames.sort.height+"\" data-width=\""+routingNames.sort.width+"\"";

    if(routingNames.sort.mainID){

        _sort += "data-href=\""+Routing.generate(routingNames.sort.name, {
            id: id, 
            direction: dir,
            mainID: routingNames.sort.mainID
        })+"\"";  

    }else{
        _sort += "data-href=\""+Routing.generate(routingNames.sort.name, {
            id: id, 
            direction: dir
        })+"\"";  
    } 

    _sort += " role=\"button\" aria-disabled=\"false\">";
    _sort += "<span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-"+type+"\" title=\""+msg+"\"></span>";
    _sort += "<span class=\"ui-button-text\"> </span>";
    _sort += "</a>";   
    
    return _sort;
    
}

/**
 * jqGrid sortable trigger
 * 
 * @param routingNames Object
 * @return void
 */        
function jqGridSortable(routingNames){

    function fixHelper(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };  

    $( "#list" ).sortable({
          
        helper:                 "fixHelper",  
        opacity:                0.5,
        fx:                     200,
        axis:                   "y",
        items: "tr",
        handle: ".grid-drag",
        forceHelperSize: true,
        forcePlaceholderSize: false,

        start: function(event, ui) {
            var start_pos = ui.item.index();
            ui.item.data("start-position", start_pos);
        },
    
        change: function(event, ui) {
        
            var start_pos = ui.item.data("start-position");
            var index = ui.placeholder.index();
        
            if (start_pos < index) {
                previous = $("#list tr:nth-child(" + index + ")").attr("id");
            } else {

                previous = $("#list tr:eq(" + (index + 1) + ")").attr("id");
            }
        },

        stop: function(event, ui) {
            
            current = ui.item.attr("id");
            _this = $(this);
            
            $.ajax({
                type: "POST",
                url: Routing.generate(routingNames.order),
                data: {
                    current: current, 
                    previous: previous
                },
                success: function(data) {

                },
                error: function(data) {
                    modal.generate(_this, "Wystąpił błąd w aplikacji");
                }
            });
            
        }
        
    }).disableSelection();

}

/* ------------------------------------------- */
/* jqGrid Formaters */
/* ------------------------------------------- */

/**
 * Boolean grid formater
 * 
 * @return DOMObject
 */
function booleanFormater(cellvalue, options, cellobject) {
      
    var _class = new String();  
      
    if(cellvalue == 1){
        _class = "ui-icon ui-icon-circle-check";
        _value = 1;
    }else{
        _class = "ui-icon ui-icon-circle-close";
        _value = 0;
    }
      
    return "<div class=\"center "+_class+"\">"+_value+"</div>";
}

/**
 * Email grid formater
 * 
 * @return DOMObject
 */
function emailFormater(cellvalue, options, cellobject) {
            
    return "<a style=\"text-decoration: underline;\" href=\"mailto: "+cellvalue+"\">"+cellvalue+"</a>";
}

/**
 * URL grid formater
 * 
 * @return DOMObject
 */
function urlFormater(cellvalue, options, cellobject) {
            
    return "<a target=\"_blank\" style=\"text-decoration: underline;\" href=\""+cellvalue+"\">"+cellvalue+"</a>";
}
