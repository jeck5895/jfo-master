$(document).ready(function(){
	
	var boolean = false;


	function getData(url, callback)
    {
        $.ajax({
            type: "GET",
            url : url,
            dataType: "JSON",
            success: callback,
            error:function(){
               
            }
        });
    }

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

	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#ads-preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

	$("#logo-form").submit(function(e){
		e.preventDefault();

		var ads_title = $.trim($("input[name=ads_title]").val());
		var ads_link = $.trim($("input[name=ads_link]").val());
		var duration = $.trim($('select[name = duration]').val());
		var inputFile = $('input[name = userfile]');
		
        
	    if(inputFile.val()!=""){
        

	    	$("#btn-save-ad").prop("disabled", true);
	    	$("#btn-save-ad").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

	    	var fileToUpload = inputFile[0].files[0];
	    	var formData = new FormData();

	    	formData.append("ads_title", ads_title);
	    	formData.append("ads_link", ads_link);
	    	formData.append("duration", duration);
	    	formData.append("userfile", fileToUpload);

	    	$.ajax({
	    		url: App.apiUrl+'/admin/advertisement_logo',
	    		type: 'POST',
	    		data: formData,
	    		processData: false,
	    		contentType: false,
	    		success: function(data){

	    			if(data.status == true)
	    			{
	    				$.notify({
	    					title: " ",
	    					message: "<i class='fa fa-check-circle'></i> "+data.message,

	    				},{
	    					type: "success",
	    					delay: 2000,
	    					animate: {
	    						enter: 'animated fadeIn',
	    						exit: 'animated fadeOut'
	    					}
	    				});

	    				logo_table.ajax.reload(null, false);
	    				$('#logo-form')[0].reset();
	    				$("#ads-preview").attr("src","");
	    				$("#btn-save-ad").prop("disabled", false);
	    				$("#btn-save-ad").html('SAVE AD');
	    			}
	    		},
	    		error: function(xhr, exception){
	    			$.notify({
	    				title: " ",
	    				message: "<i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.message+"</small>"
	    			},{
	    				type: "danger",
	    				animate: {
	    					enter: 'animated fadeIn',
	    					exit: 'animated fadeOut'
	    				},  
	    			});
	    		}
	    	});
	        
        }
        else{
        	$(".bootstrap-filestyle input").tooltip({
        		title: "<i class=' '></i> Advertisement Image is required",
        		html: true,
        		placement: "top"
        	});
        	$(".bootstrap-filestyle input").tooltip("show");
        	$('html, body').animate({
        		scrollTop: $("input[name = userfile]").offset().top
        	}, 1000);
        }
	});

	$("input[name = userfile]").on("change", function(){ 
 		var mime = $(this)[0].files[0].type;
 		var type = mime.split("/");
 		var size = $(this)[0].files[0].size;
 		var input = $(this);	
 		var image = $("#ads-preview")[0];

 		
 	
 		if(type[0] == "image")
 		{
 			readURL(this);
 			boolean = true;
 			$(".bootstrap-filestyle input").tooltip("dispose");
 		}
 		else{
 			if(type[0] != "image"){
 				$.notify({
 					title: " ",
 					message: "<h6><i class='fa fa-exclamation-triangle'></i> Please upload valid image</h6>",
 					target: "_blank"
 				},{
 					type: "danger"
 				});
 				input.val("");		
 			}
 		}

 		image.onload = function(){  
 			
 			
 			if((this.naturalWidth < 150) && (this.naturalHeight < 150))
 			{
 				
 				input.val("");
 				$(".bootstrap-filestyle input").val("");
 				$.notify({
 					title: "",
 					message: "<i class='fa fa-exclamation-triangle'></i> &nbsp&nbspImage Dimension is 150 PIXELS to 150 PIXELS",
 					target: "_blank"
 				},{
 					type: "danger",
 					animate: {
 						enter: 'animated fadeIn',
 						exit: 'animated fadeOut'
 					},
 				});	
 				$("#ads-preview").attr("src","");
 			}
 		}

 	});

 	var logo_table = $('#logo-list-table').DataTable({ 
           	// "order": [[ 4, "desc" ]],
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            "autoWidth":false,
            
            "ajax": {
                "url": App.pathUrl + "/admin/advertisements/logo",
                "type": "POST",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var totalReFiltered = json.recordsFiltered;

                    if(totalReFiltered != 0)
                    {
                        $("#admin-review-badge, .jobs-badge").html(totalReFiltered);
                        $("#admin-review-badge, .jobs-badge").css("background-color","rgb(154, 30, 30)");
                    }
                    else
                    {
                        $("#admin-review-badge, .jobs-badge").html("0");
                        $("#admin-review-badge, .jobs-badge").css("background-color","#999999");
                    }
                    
                    return JSON.stringify( json ); 
                }
            },
            "language": {
                "processing": "<img src='"+App.pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

    var logo_id = null;
    var btn_id = "";
    $(document).on("click","#btn-edit, #btn-view, #btn-delete, #btn-activate, #btn-deactivate", function(){
        btn_id = $(this).attr('id');
        logo_id = $(this).data('id');
        slid_title = $(this).data('title');

        switch(btn_id){
            case "btn-delete": 
                
                $.confirm({
                    icon: ' ',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: ' ',
                    content: 'Are you sure to delete '+slid_title+'?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {

                                $.ajax({
                                    type: 'DELETE',
                                    url: App.apiUrl+'/admin/advertisement_logo',
                                    dataType: 'JSON',
                                    data:{
                                        id : logo_id,
                                    },
                                    success: function(data){
                                    
                                        logo_table.ajax.reload(null, false);

                                        $.notify({
                                            title: " ",
                                            message: "<i class='fa fa-check-circle'></i> "+data.message,

                                        },{
                                            type: "success",
                                            delay: 1200,
                                            animate: {
                                                enter: 'animated fadeIn',
                                                exit: 'animated fadeOut'
                                            }
                                        });
                                    },
                                    error:function(XMLHttpRequest, textStatus, errorThrown){ 
                                        console.log(textStatus);
                                    }
                                });
                            }
                        },
                        cancel:{
                            btnClass: 'btn btn-secondary btn-materialize btn-materialize-sm',
                            action: function () {

                            }
                        }
                    }
                });
            break;

            case "btn-activate":
                $.confirm({
                    icon: ' ',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: ' ',
                    content: 'Are you sure activate <strong>'+slid_title+'</strong>?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {

                                $.ajax({
                                    type: 'POST',
                                    url: App.apiUrl+'/admin/advertisement_logo/activate',
                                    dataType: 'JSON',
                                    data:{
                                        id : logo_id,
                                    },
                                    success: function(data){
                                    
                                        logo_table.ajax.reload(null, false);
                                        $.notify({
                                            title: " ",
                                            message: "<i class='fa fa-exclamation-triangle'></i>&nbsp"+data.message,

                                        },{
                                            type: "success",
                                            delay: 1200,
                                            animate: {
                                                enter: 'animated fadeIn',
                                                exit: 'animated fadeOut'
                                            }
                                        });
                                    },
                                    error:function(XMLHttpRequest, textStatus, errorThrown){ 
                                        console.log(textStatus);
                                    }
                                });
                            }
                        },
                        cancel:{
                            btnClass: 'btn btn-secondary btn-materialize btn-materialize-sm',
                            action: function () {

                            }
                        }
                    }
                });
            break;

            case "btn-deactivate":
                $.confirm({
                    icon: ' ',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: ' ',
                    content: 'Are you sure deactivate <strong>'+slid_title+'</strong>?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {

                                $.ajax({
                                    type: 'POST',
                                    url: App.apiUrl+'/admin/advertisement_logo/deactivate',
                                    dataType: 'JSON',
                                    data:{
                                        id : logo_id,
                                    },
                                    success: function(data){
                                    
                                        logo_table.ajax.reload(null, false);
                                        $.notify({
                                            title: " ",
                                            message: "<i class='fa fa-exclamation-triangle'></i>&nbsp"+data.message,

                                        },{
                                            type: "success",
                                            delay: 1200,
                                            animate: {
                                                enter: 'animated fadeIn',
                                                exit: 'animated fadeOut'
                                            }
                                        });
                                    },
                                    error:function(XMLHttpRequest, textStatus, errorThrown){ 
                                        console.log(textStatus);
                                    }
                                });
                            }
                        },
                        cancel:{
                            btnClass: 'btn btn-secondary btn-materialize btn-materialize-sm',
                            action: function () {

                            }
                        }
                    }
                });
            break;
        }
    });

    $(document).on('shown.bs.modal', '#dynamicModal', function (evt) {
        var html = '';
        $(this).find('#ref').removeClass('modal-sm');
        $(this).find('.modal-body').html("");     
        var data = getJSONDoc(App.apiUrl + "/admin/advertisement_logo/id/"+logo_id);
        
        if(btn_id == "btn-edit")
        {
            
            
            html += '<div id="edit-ads">';  
                html += '<div class="form-group">';
                    html += '<label for="email" class="control-label required"><small>Ad Title</small></label>';
                    html += '<input type="text" name="ads_title" class="form-control" value="'+data.ads_title+'" placeholder="" required tabindex="2" >';
                html += '</div>';
                
                html += '<div class="form-group">';
                    html += '<label for="email" class="control-label "><small>Duration</small></label>';
                    html += '<select name="duration" class="form-control">';
                        html += '<option value="7">1 week</option>';
                        html += '<option value="14">2 weeks</option>';
                        html += '<option value="21">3 weeks</option>';
                        html += '<option value="30">1 month</option>';
                        html += '<option value="60">2 months</option>';
                        html += '<option value="90">3 months</option>';
                    html += '</select>';
                html += '</div>';

                html += '<div class="form-group">';
                    html += '<label> <small>Link </small></label>';
                    html += '<input type="url" class="form-control" name="ads_link" value="'+data.ads_url+'" tabindex="5" placeholder="" required>';
                html += '</div>';
            html += '</div>';

            $(this).find('.modal-title').text("Edit Advertisement Logo");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'update-ads');

            $("select[name=duration] option").filter(function(e){
                var temp = $.trim($(this).val());

                return temp == data.duration;

            }).prop('selected', true);
       
        }
        if(btn_id == "btn-view")
        {
            html += '<div class="ads-preview-box">';
                html += '<img id="ads-preview" src="'+data.path+'" alt="" class="img-responsive" />';
            html += '</div>';

            $(this).find('.modal-title').text(data.ads_title);
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').css('display', 'none');
        }
    });

    $(document).on("click", "#update-ads", function(){
        var ads_title = $.trim($("#edit-ads input[name=ads_title]").val());
        var ads_link = $.trim($("#edit-ads input[name=ads_link]").val());
        var duration = $.trim($('#edit-ads select[name = duration]').val());

        $.ajax({
            url: App.apiUrl+'/admin/advertisement_logo',
            type: 'PATCH',
            data:{
                ads_id: logo_id,
                title : ads_title,
                ads_link: ads_link,
                duration: duration
            },
            dataType:"JSON",
            success: function(data){

                if(data.status == true)
                {
                    $("#dynamicModal").modal('hide');
                    logo_table.ajax.reload(null, false);

                    $.notify({
                        title: " ",
                        message: "<i class='fa fa-check-circle'></i> "+data.message,

                    },{
                        type: "success",
                        delay: 2000,
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        }
                    });
                    $('#logo-form')[0].reset();
                    $("#ads-preview").attr("src","");
                }
            },
            error: function(xhr, exception){
                $.notify({
                    title: " ",
                    message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.message+"</small></h6>"
                },{
                    type: "danger",
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    },  
                });
            }
        });
    });

});