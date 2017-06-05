$(document).ready(function(){
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

	var jobdesc = CKEDITOR.replace('featuredContent',{
        toolbar: "basic",
        wordcount : {
            showCharCount : true,
            showWordCount : true,

            // maxWordCount: 300,
            countSpacesAsChars: true,
            maxCharCount: 6000,
        }
    });

    var featured_job_table = $('#featured-job-list-table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            "autoWidth":false,
            
            "ajax": {
                "url": App.pathUrl + "/admin/advertisements/get/featured_jobs",
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


    $("#featured-job-form").submit(function(e){
		e.preventDefault();

		var comp_name = $.trim($("input[name=company_name]").val());
		var job_position = $.trim($("input[name=job_position]").val());
		var job_link = $.trim($("input[name=job_link]").val());
		var comp_link = $.trim($("input[name=comp_link]"));
		var duration = $("select[name=duration]").val();
		var content = CKEDITOR.instances.featuredContent.getData();

		

		$("#btn-save-job").prop("disabled", true);
		$("#btn-save-job").html('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

		$.ajax({
			type: "POST",
			url: App.apiUrl + "/admin/featured_jobs",
			dataType: "JSON",
			data:{
				company_name: comp_name,
				job_position: job_position,
				job_link: job_link,
				comp_link: comp_link,
				duration: duration,
				job_content: content
			},
			success:function(data){
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
				$('#featured-job-form')[0].reset();
				$("#btn-save-job").prop("disabled", false);
				$("#btn-save-job").html('SAVE FEATURED JOB');
				CKEDITOR.instances.featuredContent.setData('');
				featured_job_table.ajax.reload(null, false);
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


    var fid = null;	
	$(document).on("click","#btn-edit, #btn-view, #btn-delete, #btn-activate, #btn-deactivate", function(){
 		btn_id = $(this).attr('id');
 		fid = $(this).data('id');
 		job_position = $(this).data('title');

 		switch(btn_id){
 			case "btn-delete": 
 				
 				$.confirm({
 					icon: ' ',
 					alignMiddle: true,
 					columnClass: 'col-md-4',   
 					title: ' ',
 					content: 'Are you sure to delete '+job_position+'?',
 					buttons: {
 						confirm: {
 							btnClass: 'btn-success btn-materialize btn-materialize-sm',
 							action: function () {

 								$.ajax({
 									type: 'DELETE',
 									url: App.apiUrl+'/admin/featured_jobs',
 									dataType: 'JSON',
 									data:{
 										fid : fid,
 									},
 									success: function(data){
 									
 										featured_job_table.ajax.reload(null, false);
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
 					content: 'Are you sure to activate '+job_position+'?',
 					buttons: {
 						confirm: {
 							btnClass: 'btn-success btn-materialize btn-materialize-sm',
 							action: function () {

 								$.ajax({
 									type: 'POST',
 									url: App.apiUrl+'/admin/featured_jobs/activate',
 									dataType: 'JSON',
 									data:{
 										id : fid,
 									},
 									success: function(data){
 									
 										featured_job_table.ajax.reload(null, false);
 										$.notify({
 											title: " ",
 											message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6>",

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
 					content: 'Are you sure to deactivate '+job_position+'?',
 					buttons: {
 						confirm: {
 							btnClass: 'btn-success btn-materialize btn-materialize-sm',
 							action: function () {

 								$.ajax({
 									type: 'POST',
 									url: App.apiUrl+'/admin/featured_jobs/deactivate',
 									dataType: 'JSON',
 									data:{
 										id : fid,
 									},
 									success: function(data){
 									
 										featured_job_table.ajax.reload(null, false);
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

        var data = getJSONDoc(App.apiUrl + "/admin/featured_jobs/id/"+fid);

       	html += '<div id="edit-featured-job">';	
	       	html += '<div class="form-group">';
		        html += '<label for="email" class="control-label required"><small>Company Name</small></label>';
		        html += '<input type="text" name="company_name" class="form-control" value="'+data.company+'" required tabindex="1" autofocus>';
	       	html += '</div>';
		    html += '<div class="form-group">';
			    html += '<label for="email" class="control-label required"><small>Job Position</small></label>';
			    html += '<input type="text" name="job_position" class="form-control" value="'+data.position+'" placeholder="" required tabindex="2" >';
		    html += '</div>';

		    html += '<div class="row">';
		    	html += '<div class="form-group col-md-6">';
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
		    html += '</div>';
		        
		    html += '<div class="form-group">';
			  	html += '<label> <small>Link </small></label>';
			   	html += '<input type="url" class="form-control" name="job_link" value="'+data.job_url+'" tabindex="5" placeholder="" required>';
		    html += '</div>';

		     html += '<div class="form-group">';
			  	html += '<label> <small>Company Website </small></label>';
			   	html += '<input type="url" class="form-control" name="comp_link" value="'+data.company_url+'" tabindex="5" placeholder="" required>';
		    html += '</div>';

		    html += '<div class="form-group">';
		       	html += '<label for="email" id="jobdesc-label" class="control-label"><small>Job Qualification & Description</small></label>';
		       	html += '<textarea class="form-control ignore" id="editorModal" name="editorModal" minlength="150" rows="10" tabindex="12" ></textarea>';
		    html += '</div>';
		html += '</div>';

	        $(this).find('.modal-title').text("Edit Featured Job");
        	$(this).find('.modal-body').append(html);
        	$(this).find('.btn-primary').attr('id', 'update-job');

        	var jobdesc = CKEDITOR.replace('editorModal',{
        		toolbar: "basic",
        		wordcount : {
        			showCharCount : true,
        			showWordCount : true,


        			countSpacesAsChars: true,
        			maxCharCount: 6000,
        		}
        	});
       		
       		CKEDITOR.instances.editorModal.setData(data.job_description);
       		$("select[name=duration] option").filter(function(e){
       			var temp = $.trim($(this).val());

       			return temp == data.duration;

       		}).prop('selected', true);
    });

    $(document).on("click", "#update-job", function(){
    	var comp_name = $.trim($("#edit-featured-job input[name=company_name]").val());
		var job_position = $.trim($("#edit-featured-job input[name=job_position]").val());
		var job_link = $.trim($("#edit-featured-job input[name=job_link]").val());
		var duration = $("#edit-featured-job select[name=duration]").val();
		var comp_link = $("#edit-featured-job input[name=comp_link]").val();
		var editContent = CKEDITOR.instances.editorModal.getData(); 

		$.ajax({
			url: App.apiUrl+'/admin/featured_jobs',
			type: 'PATCH',
			data:{
				id: fid,
				company_name: comp_name,
				company_url: comp_link,
				job_position : job_position,
				job_link: job_link,
				duration: duration,
				job_content: editContent
			},
			dataType:"JSON",
			success: function(data){

				if(data.status == true)
				{
					$("#dynamicModal").modal('hide');
					featured_job_table.ajax.reload(null, false);

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