
  function signIn(){
    var params = {
        "email"      : $('#email').val(),
        "password"   : $('#Password').val()
    };  
    console.log("params inside signin");
    console.log(params);
    event.preventDefault();
    $.ajax({
        type        : "POST",
        url         : "SignIn", // Location of the service
        data        : JSON.stringify(params), //Data sent to server
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
            }else{
                swal(
                    'Signed In Successfully',
                    'Welcome '+data,
                    'success'
                );
               location.reload();
            }
            $('#nav-collapse2').slideToggle();

        },
        error : function (jqXHR, textStatus, errorThrown) {
            console.log("error in sign in");
        }
    });  
      
      
  }



