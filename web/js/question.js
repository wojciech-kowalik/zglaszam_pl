
/**
 * Question constructor object
 * 
 * @author w.kowalik 
 * @package web\js
 * @access public
 * @copyright visualnet.pl
 */

$(document).ready(function(){

    /**
    * Question constructor
    * @author Wojciech Kowalik
    */
    Visualnet.Question = function(){

        var validationElement = "validation_rule";
        var answerElement = "answers";
        var limitElement = "limit";
         
        /**
        * Init method after create instance
        */         
        (function init() {
            })();           
         
        /**
        * Manipulate form
        * 
        * @return void
        */
        this.validationType = function(object){
         
            switch(object.val()){
                
                case 'text': 
                case 'textarea':
                    unblindValidation();
                    unblindLimit();
                    blindAnswers(); 
                    break;
                
                case 'checkbox': 
                case 'radio':
                case 'dropdown':    
                    blindValidation();
                    blindLimit();
                    unblindAnswers(); 
                    break;  
                
                case 'header':{
                    blindAnswers(); 
                    blindValidation(); 
                }
                break;
                                   
                default: {
                        
                    blindAnswers();     
                    blindValidation();
                        
                }
                break;
                
            }
         
        };
        
        unblindValidation = function(){
            
            $("#"+validationElement).removeClass("question-blind");
            $("#question_"+validationElement+"_optional").attr("disabled", false);  
            
            $("#"+validationElement+"_select").removeClass("question-blind");
            $("#question_"+validationElement+"_predefined").attr("disabled", false);             
            
        };
        
        blindValidation = function(){
            
            $("#"+validationElement).val('');
            $("#question_"+validationElement+"_predefined").val('');
            
            $("#"+validationElement).addClass("question-blind");
            $("#question_"+validationElement+"_optional").attr("disabled", true);  
            
            $("#"+validationElement+"_select").addClass("question-blind");
            $("#question_"+validationElement+"_predefined").attr("disabled", true);   
                        
        };        
        
        unblindAnswers = function(){
            
            $("#"+answerElement).removeClass("question-blind");
            $("#question_"+answerElement).attr("disabled", false);  
                        
        };
        
        unblindLimit = function(){
            
            $("#"+limitElement).removeClass("question-blind");
            $("#question_"+limitElement).attr("disabled", false);  
                        
        };        
        
        blindLimit= function(){
            
            $("#"+limitElement).addClass("question-blind");
            $("#question_"+limitElement).attr("disabled", true);  
                          
        };         
        
        blindAnswers = function(){
            
            $("#"+answerElement).addClass("question-blind");
            $("#question_"+answerElement).attr("disabled", true);  
                          
        };          

    }; 

    // make instance of Question
    question = new Visualnet.Question();
    question.validationType($("#question_type"));

});

// BINDERS

$("#question_type").on("change", function(){
    
    question.validationType($(this));
   
});

$("#question_validation_rule_predefined").on("change", function(){
    
    $("#question_validation_rule_optional").val(''); 

});

$("#question_validation_rule_optional").on("focus", function(){
    
    $("#question_validation_rule_predefined").val(''); 
   
});

