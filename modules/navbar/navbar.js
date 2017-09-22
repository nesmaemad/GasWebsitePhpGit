
  function signIn(){
    var params = {
        "email"         : $('#email').val(),
        "password"      : $('#Password').val(),
        "function_name" : "signIn"
    };  
    console.log("params inside signin");
    console.log(params);
    event.preventDefault();
    $.ajax({
        type        : "GET",
        url         : "handler/signInHandler.php", // Location of the service
        data        : params, //Data sent to server
        contentType : "application/json", // content type sent to server
        crossDomain : true,
        async       : false,
        success: function(data, success) {
            console.log("sign in successfully");
            console.log("data " +data);
            if ($.trim(data) === "failed") {
                swal(
                    'Oops...',
                    'Wrong Email or Password!',
                    'error'
                );
            }else if($.trim(data) === "confirm"){
                swal(
                    'Oops...',
                    'Please confirm your email first!',
                    'error'
                );
            }else{
                swal(
                    'Signed In Successfully',
                    'Welcome '+data,
                    'success'
                );
               
            }
            location.reload();
            $('#nav-collapse2').slideToggle();

        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in sign in");
        }
    });  
      
      
  }



