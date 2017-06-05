 $(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];

 	console.log(seg[4]);
 	function getJSONDoc(url) {
 		var response = $.ajax({
 			type: "GET",
 			url: url,
 			dataType: "json",
 			global: false,
 			async: false,
 			success: function (data) {
 				return data;
 			}
 		}).responseText;
 		return $.parseJSON(response);
 	}
 	$('#reset-password-form').validate({
            rules:{
                newPassword:{
                    required: true,
                    minlength: 8
                },
                confirmPassword:{
                    required: true,
                    equalTo: "#newPassword"
                   
                }
            },
            messages:{
                newPassword: {
                        required: "This field is required",
                        minlength: "Password must be at least 8 characters"

                        
                },      
                confirmPassword:{
                        required: "This field is required",
                        equalTo: "Your password doesn't match"
                         
                }       
            },
            tooltip_options:{
                newPassword:{
                    trigger: 'focus',
                    placement: 'right',
                    html: true,

                },
                confirmPassword:{
                    trigger: 'focus',
                    placement: 'right',
                    html: true
                }
            },
            submitHandler:function(form){
              var newPassword = $('input[name = newPassword]').val();
              var code = seg[4] ;
             
                $.ajax({
                    type: "POST",
                    url: pathUrl + '/Authenticate/reset_password'+code,
                    dataType: "json",
                    data:{
                          newPassword : newPassword,
                        },
                    success: function (data) {
                        // localStorage.setItem('status','1');
                        $('#myModal').modal('show');
                    },
                    error: function(){
                
                    }
                });
            }
            
        }); 

 });	