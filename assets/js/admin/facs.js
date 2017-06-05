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

	var featured_company_table = $('#featured-job-list-table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            "autoWidth":false,
            
            "ajax": {
                "url": App.pathUrl + "/admin/advertisements/get/featured_companies",
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

	var cid = null;	
	$(document).on("click","#btn-edit, #btn-delete, #btn-activate, #btn-deactivate", function(){
 		btn_id = $(this).attr('id');
 		cid = $(this).data('id');
 		company = $(this).data('title');

 		switch(btn_id){
 			case "btn-delete": 
 				
 				$.confirm({
 					icon: ' ',
 					alignMiddle: true,
 					columnClass: 'col-md-4',   
 					title: ' ',
 					content: 'Are you sure to remove <strong>'+company+'</strong> from featured companies?',
 					buttons: {
 						confirm: {
 							btnClass: 'btn-success btn-materialize btn-materialize-sm',
 							action: function () {

 								$.ajax({
 									type: 'DELETE',
 									url: App.apiUrl+'/admin/featured_companies',
 									dataType: 'JSON',
 									data:{
 										id : cid,
 									},
 									success: function(data){
 									
 										featured_company_table.ajax.reload(null, false);
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
 					content: 'Are you sure activate <strong>'+company+'</strong>?',
 					buttons: {
 						confirm: {
 							btnClass: 'btn-success btn-materialize btn-materialize-sm',
 							action: function () {

 								$.ajax({
 									type: 'POST',
 									url: App.apiUrl+'/admin/featured_companies/activate',
 									dataType: 'JSON',
 									data:{
 										id : cid,
 									},
 									success: function(data){
 									
 										featured_company_table.ajax.reload(null, false);
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
 					content: 'Are you sure deactivate <strong>'+company+'</strong>?',
 					buttons: {
 						confirm: {
 							btnClass: 'btn-success btn-materialize btn-materialize-sm',
 							action: function () {

 								$.ajax({
 									type: 'POST',
 									url: App.apiUrl+'/admin/featured_companies/deactivate',
 									dataType: 'JSON',
 									data:{
 										id : cid,
 									},
 									success: function(data){
 									
 										featured_company_table.ajax.reload(null, false);
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

       	var data = getJSONDoc(App.apiUrl + "/admin/featured_companies/id/"+cid);

        html += '<div id="edit-featured-company">'; 
           
            
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
           
           
        html += '</div>';

        $(this).find('.modal-title').text("");
        $(this).find('.modal-body').append(html);
        $(this).find('.btn-primary').attr('id', 'update-featured-company');

        $("select[name=duration] option").filter(function(e){
        	var temp = $.trim($(this).val());

        	return temp == data.duration;
        }).prop('selected', true);

    });

    $(document).on("click", "#update-featured-company", function(){
    	
		var duration = $("#edit-featured-company select[name=duration]").val();

		$.ajax({
			url: App.apiUrl+'/admin/featured_companies',
			type: 'PATCH',
			data:{
				id: cid,
				duration: duration,
			},
			dataType:"JSON",
			success: function(data){

				if(data.status == true)
				{
					$("#dynamicModal").modal('hide');
					featured_company_table.ajax.reload(null, false);

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