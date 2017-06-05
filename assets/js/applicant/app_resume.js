$(function () {  

 	var path = window.location.pathname;
    var seg = path.split('/');
    var App = {
        pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api",
    }
 	
    function postData(url, method, data, callback)
    {

        $.ajax({
            type: method,
            url : url,
            dataType: "JSON",
            data:data,
            success: callback,
            error:function(jqXHR, exception){

                $.notify({
                    title: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+jqXHR.responseJSON.message+"</small></h6> ",
                    message: "",
                    allow_dismiss:false,
                    timer: 5000

                },{
                    type: "danger"  
                });
            }
        });
    }

    function getData(url, callback)
    {
        $.ajax({
            type: "GET",
            url : url,
            dataType: "JSON",
            success: callback,
            error:function(){
                alert("error");
            }
        });
    }

    function loadResume(){
        getData(App.apiUrl +"/applicants/profiles", function(data){
            var file_name = (data.resume != "")? data.resume :"No File found";
            $("#resume-file-name").text(file_name);
        });
    }

    loadResume();

});