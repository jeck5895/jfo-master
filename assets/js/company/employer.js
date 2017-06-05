 $(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
 	var userAction;

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

    /*
    *FOR PUSHING NOTIFICATION

    */
    $("#send-message").click(function(){
        $.ajax({
            type:"POST",
            url: App.pathUrl +"/notification/trigger_event",
            dataType:"JSON",
            success:function(data){
                console.log(data)
            },
            error:function(data){
                console.log(data)
            }

        });

    });

 });	