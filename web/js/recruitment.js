
/**
 * Recruitment constructor object
 * 
 * @author w.kowalik 
 * @package web\js
 * @access public
 * @copyright visualnet.pl
 */

$(document).ready(function () {
        
    /**
    * Recruitment constructor
    * 
    * @author Wojciech Kowalik
    */
    Visualnet.Recruitment = function () {
                                                 
        /* get object instance */
        if (typeof Visualnet.Recruitment.instance === "undefined") {
            Visualnet.Recruitment.instance = this;
        } else {
            return Visualnet.Recruitment.instance;
        }             
                    
        /**
        * Set qualified users collection
        * 
        * @param Array
        */         
        var _qualified = []; 
        
        /**
        * Temporary selected items
        * 
        * @param Array
        */          
        var _checked = [];
        
        /**
        * Init method after create instance
        */         
        (function init() {
            })();        
               
        /**
        * Set qualified users collection
        * 
        * @return Array
        */  
        var _setQualified = function(qualified){
            _qualified = qualified;
        };    
        
        /**
        * If error occured show it
        * 
        * @param errors Array
        * @return void
        */
        var _showErrors = function(errors){
            
            jQuery.each(errors, function(i, val) {
            
                $("#error-data-"+i).html("<img src=\"/images/wrong.png\" alt=\"\" >&nbsp;"+val.join(', '));                
                $("#data-"+i).addClass("error");

            });
            
        };                
               
        /**
        * Get qualified users collection
        * 
        * @return Array
        */  
        this.getQualified = function(){
            return _qualified;
        }; 
                
        /**
        * Union selected data with actual
        * 
        * @return void
        */          
        this.addData = function(array){
            _qualified = _.union(_qualified, array);
        };
        
        /**
        * Remove value from qualified
        * 
        * @return void
        */          
        this.removeData = function(value){
            _qualified = _.without(_qualified, value);
        };    
        
        /**
        * Clean data after partial qualify
        * 
        * @return void
        */         
        this.cleanData = function(){
            _qualified = [];
            this.refreshCounter();
        };        
        
        /**
        * Actualize data counter
        * 
        * @return void
        */           
        this.refreshCounter = function(){
            $("#qualify-counter").html(this.getQualified().length);
        };
                
        /**
        * Qualify users to recruitment
        * 
        * @return void
        */         
        this.qualify = function(){
           
            if(this.getQualified().length == 0){
               
                modal.error("Brak uczestników do kwalifikacji");
                return;
            }
                       
            $.ajax({
                type: "POST",
                url: Routing.generate("RecruitmentBundle_users_qualify"),
                data: {
                    qualified: this.getQualified()
                },
                success: function(data) {

                    modal.monit(data.message);
                    $("#list").trigger("reloadGrid");
                    
                },
                error: function(data) {
                    modal.error("Wystąpił błąd w aplikacji");
                }
            });
           
            
        };          
         
        /**
        * Register method
        * 
        * @return void
        */
        this.register = function(form){
                                   
            var recruitmentDateId = {};                       
                                   
            // find recruitment date id                       
            recruitmentDateId = _.find(form.serializeArray(), 
            
                function(object){ 
                    return _.isEqual(object.name, "data[recruitmentDateId]"); 
                }
            
            );
                                            
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                dataType: "json",
                data: form.serialize(),
                async: false,
                success: function(data) {

                    if(data.state){
                            
                        // if user data has been save go to success page    
                        location.href = Routing.generate("FrontendBundle_recruitment_register_success", {recruitmentDateId: recruitmentDateId.value});                               
                            
                    }else{
                        
                        // clean previous errors
                        $("[id^=error-data]").html("");
                        $("[id^=data-]").removeClass("error");
                        
                        // if global error exists
                        if(data.errors._global){
                            modal.error(data.errors._global);
                        }else{
                            _showErrors(data.errors);
                        }
                        
                    }

                },
                error: function(data) {
                    modal.error("Wystąpił błąd w aplikacji");
                }
            });  
    
    
        };
        
        /**
        * Manipulate dates fields depends on checkbox
        * 
        * @return void
        */        
        this.notSetEventDate = function(object){

          var prefix = "recruitment_date_event_date";
          var datePicker = "ui-datepicker-trigger";
          
          if(object.is(":checked")){
              
              $("#"+prefix+"_from").val('').attr("disabled", true);
              $("#"+prefix+"_to").val('').attr("disabled", true);
              $("."+datePicker).addClass("display-none");
              
          }else{
              
              $("#"+prefix+"_from").attr("disabled", false);
              $("#"+prefix+"_to").attr("disabled", false);     
              $("."+datePicker).removeClass("display-none");
              
          }
          
        };
        
        /**
        * Set qualified
        * 
        * @return void
        */ 
        this.setQualify = function(object){
  
            // check if "check all" is checked
            if(object.attr("id") == "cb_list"){
            
                if(object.is(':checked')){
                    _checked = jQuery("#list").jqGrid('getGridParam','selarrrow');
                    this.addData(_checked);
                }else{
                    _setQualified(_.difference(this.getQualified(), _checked));
                }
                        
            }else{ // if other checkbox checked
       
                // get qualify id
                var id = object.attr("id").split('_')[2];

                if(object.is(":checked")){

                    this.addData(new Array(id));

                }else{

                    this.removeData(id);
                }
        
            }
       
            // refresh count data
            this.refreshCounter();
    
        };        
                        
    }; 
    
    // make instance of Recruitment
    recruitment = new Visualnet.Recruitment();  
    recruitment.notSetEventDate($("#recruitment_date_is_not_set_event_date"));

});

// BINDERS

$("#recruitment-register").on("click", function(){
    recruitment.register($(this).closest("form"));
});

$("#recruitment-qualify-users").on("click", function(){
    recruitment.qualify();
    recruitment.cleanData();
});

$("#recruitment_date_is_not_set_event_date").on("click", function(){
    recruitment.notSetEventDate($(this));
});

