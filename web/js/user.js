
/**
 * User binders
 * 
 * @author w.kowalik 
 * @package web\js
 * @access public
 * @copyright visualnet.pl
 */

$(document).ready(function(){

    // BINDERS

    $(".button-generate-login").on("click", function(){

        _this = $(this);
        name = $("#user_name").val();
        surname = $("#user_surname").val();
        
        if(name == '' || surname == ''){
            modal.error("Wymagane jest podanie imienia i nazwiska");
            return;
        }

        $.ajax({
            url: _this.data("url"),
            type:"POST",
            dataType: "json",
            data: {
                name: name,
                surname: surname
            },
            async: true,
           
            success:function(data){
                
                if(data.state){
                    $("#user_username").val(data.login);
                }else{
                    modal.error("Wystąpił błąd podczas generowania loginu");
                    return;                    
                }
                
            },

            error:function() {
                modal.error("Wystąpił błąd w aplikacji");
                return;                  
            }
        });

    });  

});

