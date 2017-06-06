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

    getData(App.apiUrl+"/companies",function(company){
    	$.each(company, function(index, item){
    		$("select[name = company]").append("<option value="+item.id+">"+item.company+"</option>");
    	});
    });

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


	// for global filtering 
	function filterLocation () {
		$('#featured-job_by_location-list').DataTable().search(
			$('select[name=filter-location]').val()
			).draw();
	}



    var featured_job_table = $('#featured-job_by_location-list').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            "autoWidth":false,
            
            "ajax": {
                "url": App.pathUrl + "/admin/advertisements/get/featured_jobs_by_location",
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
                {
                	"targets": [ 8 ],
                	"visible": false,
                }
            ],
        });

    $("select[name=filter-location]").on("change", function(){
		filterLocation();
	});

 


    $(document).on("change", "select[name=company]", function(){
    	var id = $("option:selected", this).val();

    	getData(App.apiUrl + "/jobs?cid="+id, function(data){
    		$("select[name = job_position]").empty();
    		$.each(data, function(index, item){
    			$("select[name = job_position]").append("<option value="+item.id+">"+item.position+"</option>");
    		});
    	});
    });

    $(document).on("click","input[name=use_alt_position]", function(){
    	if($(this).is(':checked')){
    		$("input[name=alt_job_title]").prop("disabled",false);
    	}
    	else{
    		$("input[name=alt_job_title]").prop("disabled",true);
    	}
    });


    $("#job-by-location-form").submit(function(e){
		e.preventDefault();

		var comp_name = $.trim($("select[name=company]").val());
		var job_position = $.trim($("select[name=job_position]").val());
		var duration = $("select[name=duration]").val();
		var content = CKEDITOR.instances.featuredContent.getData();
		var ckb = $("#job-by-location-form input[name=use_alt_position]");
		var alt_position = $("input[name=alt_job_title]").val();
		
		if(ckb.is(":checked") && alt_position == ""){
			$.notify({
				title: " ",
				message: "<i class='fa fa-exclamation-triangle'></i>&nbspPlease Please provide alternative title"
			},{
				type: "danger",
				animate: {
					enter: 'animated fadeIn',
					exit: 'animated fadeOut'
				},  
			});
		}
		else{
			$("#btn-save-job").prop("disabled", true);
			$("#btn-save-job").html('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

			$.ajax({
				type: "POST",
				url: App.apiUrl + "/admin/featured_jobs_by_location",
				dataType: "JSON",
				data:{
					company: comp_name,
					job_position: job_position,
					duration: duration,
					job_content: content,
					alt_status: (ckb.is(":checked"))? 1 : 0,
					alt_position: alt_position
				},
				success:function(data){
					$.notify({
						title: " ",
						message: "<i class='fa fa-check-circle'></i> "+data.message,

					},{
						type: "success",
						delay: 5000,
						animate: {
							enter: 'animated fadeIn',
							exit: 'animated fadeOut'
						}
					});
					$('#job-by-location-form')[0].reset();
					$("#btn-save-job").prop("disabled", false);
					$("#btn-save-job").html('SAVE FEATURED JOB');
					$("input[name=alt_job_title]").prop("disabled",true);
					CKEDITOR.instances.featuredContent.setData('');
					featured_job_table.ajax.reload(null, false);
				},
				error: function(xhr, exception){
					$("#btn-save-job").html('SAVE FEATURED JOB');
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
		}
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
 									url: App.apiUrl+'/admin/featured_jobs_by_location',
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
 									url: App.apiUrl+'/admin/featured_jobs_by_location/activate',
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
 											delay: 5000,
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
 									url: App.apiUrl+'/admin/featured_jobs_by_location/deactivate',
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
 											delay: 5000,
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

        var data = getJSONDoc(App.apiUrl + "/admin/featured_jobs_by_location/id/"+fid);

       	html += '<div id="edit-featured-job">';	
	       	html += '<div class="form-group">';
		        html += '<label for="email" class="control-label required"><small>Company Name</small></label>';
		        html += '<select name="company" class="form-control select2-company" required tabindex="1"></select>';
	       	html += '</div>';
		    html += '<div class="form-group">';
			    html += '<label for="email" class="control-label required"><small>Job Position</small></label>';
			    html += '<select name="job_position" class="form-control" required tabindex="2" ></select>';
			     html += '<label class="custom-control custom-checkbox" >';
			    	html += '<input type="checkbox" name="use_alt_position" class="custom-control-input"  tabindex="4" value="1">';
			    	html += '<span class="custom-control-indicator"></span>';
			    	html += '<span class="terms-condition"></span>';
			    	html += '<span class="custom-control-description"><small>use alternative position</small></span>';
			    html += '</label>';
		    html += '</div>';

		    html += '<div class="form-group">';
		    	html += '<label> <small>Alternative title for the position </small></label>';
		    	html += '<input type="text" class="form-control" value="'+data.alternative_title+'"name="alt_job_title" tabindex="6" disabled>';
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

        	if(data.use_alternative == 1){
        		$("#edit-featured-job input[name='use_alt_position']").prop("checked", true);
        		$("#edit-featured-job input[name='alt_job_title']").prop("disabled", false);
        	}

        	getData(App.apiUrl+"/companies",function(company){
        		$.each(company, function(index, item){
        			var selected = (data.company_id == item.id)? "selected" : "";
        			$("#edit-featured-job select[name = company]").append("<option value="+item.id+" "+selected+">"+item.company+"</option>");
        		});
        	});
       		
       		CKEDITOR.instances.editorModal.setData(data.job_description);

       		$("#edit-featured-job select[name=duration] option").filter(function(e){
       			var temp = $.trim($(this).val());

       			return temp == data.duration;

       		}).prop('selected', true);
   
       		getData(App.apiUrl + "/jobs?cid="+data.company_id, function(positions){
       			$("#edit-featured-job select[name = job_position]").empty();
       			
       			$.each(positions, function(index, item){
       				
       				var selected = (data.position == item.id)? "selected" : "";
       			
       				$("#edit-featured-job select[name = job_position]").append("<option value="+item.id+" "+selected+">"+item.position+"</option>");
       			});
       		});
    });

    $(document).on("click", "#update-job", function(){
    	var comp_name = $.trim($("#edit-featured-job select[name=company]").val());
		var job_position = $.trim($("#edit-featured-job select[name=job_position]").val());
		var duration = $("#edit-featured-job select[name=duration]").val();
		var editContent = CKEDITOR.instances.editorModal.getData();
		var eckb = $("#edit-featured-job input[name=use_alt_position]");
		var alt_position = $("#edit-featured-job input[name=alt_job_title]").val(); 

		if(eckb.is(":checked") && alt_position == ""){
			$.notify({
				title: " ",
				message: "<i class='fa fa-exclamation-triangle'></i>&nbspPlease Please provide alternative title"
			},{
				type: "danger",
				animate: {
					enter: 'animated fadeIn',
					exit: 'animated fadeOut'
				},  
			});
		}
		else{
			$.ajax({
				url: App.apiUrl+'/admin/featured_jobs_by_location',
				type: 'PATCH',
				data:{
					id: fid,
					company: comp_name,
					job_position : job_position,
					duration: duration,
					job_content: editContent,
					alt_status: (eckb.is(":checked"))? 1 : 0,
					alt_position: alt_position
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
		}
    });

});