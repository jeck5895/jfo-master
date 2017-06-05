$(document).ready(function() {

	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var current_url = window.location.href; 

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

    function loadBadgeData()
    {
    	var  pending_jobs =  getJSONDoc(pathUrl +"/api/jobs/index/status/pending");
    	// var  published_jobs =  getJSONDoc(pathUrl +"/api/jobs/index/status/published");
    	// var  declined_jobs =  getJSONDoc(pathUrl +"/api/jobs/index/status/declined");
    	// var  trash_jobs =  getJSONDoc(pathUrl +"/api/jobs/index/status/trash");

    	if(pending_jobs.length != 0)
    	{
    		$("#admin-review-badge, .jobs-badge").html(pending_jobs.length);
    		$("#admin-review-badge, .jobs-badge").css("background-color","rgb(154, 30, 30)");
    	}
    	else
    	{
    		$("#admin-review-badge, .jobs-badge").html("0");
    		$("#admin-review-badge, .jobs-badge").css("background-color","#999999");
    	}
    }

    var admin_table_approval = $('#admin-review-job-table').DataTable({ 
           	"order": [[ 7, "desc" ]],
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            
            "ajax": {
                "url": pathUrl + "/admin/jobs/pending",
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
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

	var admin_published_table = $('#admin-published-table').DataTable({ 
           	
           	"order": [[ 7, "desc" ]],
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            
            "ajax": {
                "url": pathUrl + "/admin/jobs/published",
                "type": "POST",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var totalPuFiltered = json.recordsFiltered;

                    if(totalPuFiltered != 0)
                    {
                        $(".published-badge").html(totalPuFiltered);
                        $(".published-badge").css("background-color","rgb(154, 30, 30)");
                    }
                    else
                    {
                        $(".published-badge").html("0");
                        $(".published-badge").css("background-color","#999999");
                    }
                    
                    return JSON.stringify( json ); 
                }
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

	var admin_declined_table = $('#admin-declined-table').DataTable({ 
           	
           	"order": [[ 7, "desc" ]],
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            
            "ajax": {
                "url": pathUrl + "/admin/jobs/declined",
                "type": "POST",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var totalDeFiltered = json.recordsFiltered;

                    if(totalDeFiltered != 0)
                    {
                        $(".declined-badge").html(totalDeFiltered);
                        $(".declined-badge").css("background-color","rgb(154, 30, 30)");
                    }
                    else
                    {
                        $(".declined-badge").html("0");
                        $(".declined-badge").css("background-color","#999999");
                    }
                    
                    return JSON.stringify( json ); 
                }
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

	var admin_trash_table = $('#admin-trash-table').DataTable({ 
           	
           	"order": [[ 7, "desc" ]],
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            
            "ajax": {
                "url": pathUrl + "/admin/jobs/trash",
                "type": "POST",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var totalTrFiltered = json.recordsFiltered;

                    if(totalTrFiltered != 0)
                    {
                        $(".trash-badge").html(totalTrFiltered);
                        $(".trash-badge").css("background-color","rgb(154, 30, 30)");
                    }
                    else
                    {
                        $(".trash-badge").html("0");
                        $(".trash-badge").css("background-color","#999999");
                    }
                    
                    return JSON.stringify( json ); 
                }
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

	// Admin Dashboard Applicant Tables
    var job_ids = [];

    $("input[name=select-all-admin-pending-job]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-pending-job]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-pending-job]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });

    $("input[name=select-all-admin-published-job]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-published-job]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-published-job]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });

    $("input[name=select-all-admin-declined-job]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-declined-job]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-declined-job]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });

    $("input[name=select-all-admin-trash-job]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-trash-job]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-trash-job]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });

    $(document).on("click", "#btn-admin-approve-job, #btn-admin-decline-job, #btn-admin-trash-job, #btn-admin-delete-job, #btn-admin-review-job", function(){
        
        var action = $(this).data('action');
        var scope = $(this).data('scope');
        var prompt = (action == "review")? "Tag for Review" : $(this).data('title');
        var method = (action == "approve")? "approve" : (action == "decline")? "decline" : (action == "trash")? "trash" : (action == "delete")? "delete" : (action == "review")? "review" :"undefined";
        
        if(action == "approve" && scope == "review-tab")
        {
            job_ids = [];

            $("input[name=select-admin-pending-job]").each(function (index) {
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    job_ids.push(applicant_id);
                }
            });
        }

        else if(action == "approve" && scope == "declined-tab")
        {
            job_ids = [];

            $("input[name=select-admin-declined-job]").each(function (index) {
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    job_ids.push(applicant_id);
                }
            });
        }

        else if(action == "decline" && scope == "review-tab")
        {
            job_ids = [];

            $("input[name=select-admin-pending-job]").each(function (index) {
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    job_ids.push(applicant_id);
                }
            });
        }

        else if(action == "decline" && scope == "published-tab")
        {
            job_ids = [];

            $("input[name=select-admin-published-job]").each(function (index) {
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    job_ids.push(applicant_id);
                }
            });
        }

        else if(action == "trash")
        {
            job_ids = []; 

            $("input[name=select-admin-declined-job]").each(function (index) {
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    job_ids.push(applicant_id);
                }
            });
        }
        else if(action == "delete")
        {
            job_ids = []; 

            $("input[name=select-admin-trash-job]").each(function (index) {
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    job_ids.push(applicant_id);
                }
            });
        }
        else if(action == "review" && scope == "published-tab")
        {
            job_ids = []; 

            $("input[name=select-admin-published-job]").each(function (index) {
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    job_ids.push(applicant_id);
                }
            });
        }

        else if(action == "review" && scope == "declined-tab")
        {
            job_ids = []; 

            $("input[name=select-admin-declined-job]").each(function (index) {
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    job_ids.push(applicant_id);
                }
            });
        }

        if(job_ids.length != 0)
        {
            if(job_ids.length == 1)
            {
                $.confirm({
                    icon: '',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: '<small>JOBFAIR-ONLINE says</small>',
                    content: prompt+' this job?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {
                                //console.log(job_ids);
                                $.ajax({
                                    url: pathUrl + "/api/jobs/"+method,
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data:{
                                        id : job_ids,
                                    },
                                    success: function(data){
                                        console.log(data);
                                        //reload();
                                        admin_table_approval.ajax.reload(null, false);
                                        admin_published_table.ajax.reload(null, false);
                                        admin_declined_table.ajax.reload(null, false);
                                        admin_trash_table.ajax.reload(null, false);
                                        

                                        $("input[name=select-all-admin-pending-job]").prop("checked",false);// unchecked header checkbox

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
                        },
                        cancel:{
                            btnClass: 'btn btn-secondary btn-materialize btn-materialize-sm',
                            action: function () {

                            }
                        }
                    }
                });
            }
            else{
                $.confirm({
                    icon: '',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: '<small>JOBFAIR-ONLINE says</small>',
                    content: prompt+' these jobs?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {
                                //console.log(job_ids)
                                $.ajax({
                                    type: 'POST',
                                    url: pathUrl + "/api/jobs/"+method,
                                    dataType: 'JSON',
                                    data:{
                                        id : job_ids,
                                    },
                                    success: function(data){
                                        console.log(data);
                                        admin_table_approval.ajax.reload(null, false);
                                        admin_published_table.ajax.reload(null, false);
                                        admin_declined_table.ajax.reload(null, false);
                                        admin_trash_table.ajax.reload(null, false);
                                       

                                        $("input[name=select-all-admin-pending-job]").prop("checked",false);// unchecked header checkbox

                                        $.notify({
                                            title: " ",
                                            message: "<i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small>",

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
            }   
        }
        else{
            $.notify({
                title: " ",
                message: "<i class='fa fa-exclamation-triangle'></i>&nbspPlease check at least 1 Job Post",

            },{
                type: "danger",
                allow_dismiss: false,
                animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOut'
                }
            });
        }
    });

    $('#jobModal').on('shown.bs.modal', function (evt) {
        object = $(evt.relatedTarget);
        job_id = object.data('id');
        
        
        $.ajax({
            type: 'GET',
            url: pathUrl + "/api/jobs/index/job_id/"+job_id,
            dataType: 'json',
            success: function(data){
                var uri = encodeURIComponent(data.company);
                $("#job-modal-body").html("");
            
                var html = '';
                $("#job-modal-title").text(data.position);
                // html += '<div class="row">';                 
                    html += '<div class="col-xs-12 col-md-12">';
                        // html += '<h5>'+data.position+'</h5>';
                        html += '<ul class="list-inline">';
                            html += '<li class="list-inline-item"><small><a id="company" href="'+pathUrl + '/companies/'+uri+'-'+data.cid+'" target="'+data.company+'-'+data.cid+'"><i class="fa fa-building-o"></i> '+data.company+'</a></small></li>'; 
                            html += '<li class="list-inline-item"><small><i class="fa fa-map-marker"></i> '+data.location+'</small></li>'; 
                        html += '</ul>';

                        html += '<h6>Job Qualifications </h6>';
                        html += '<dl class="col-md-12">';
                            html += '<div class=row>';
                                html += '<dt class="col-md-5 normalize" style="/*width: auto; */font-weight: normal;">Educational Attainment:</dt>';
                                html += '<dd id="educ-qualification" style="font-weight: bold;" class="col-md-7">'+data.education_requirement+'</dd>';
                            html +='</div>';
                            html += '<div class=row>';
                                html += '<dt class="col-sm-5 normalize" style="/*width: auto; */font-weight: normal;">Preffered Course:</dt>';
                                var course = (data.course != "")? data.course : '<i>Not Specified</i>';
                                html += '<dd id="preferred-course" style="font-weight: bold;" class="col-sm-7">'+course+'</dd>';
                            html +='</div>';
                        html += '</dl>';

                        html += '<h6>Job Information </h6>';
                        html += '<dl class="col-md-12">';
                            html += '<div class=row>';
                                html += '<dt class="col-md-5 normalize" style="/*width: auto; */font-weight: normal;">No. of Vacancies:</dt>';
                                html += '<dd id="educ-qualification" style="font-weight: bold;" class="col-md-7">'+data.vacancies+'</dd>';
                            html +='</div>';
                            html += '<div class=row>';
                                html += '<dt class="col-sm-5 normalize" style="/*width: auto; */font-weight: normal;">Job Category:</dt>';
                                html += '<dd id="preferred-course" style="font-weight: bold;" class="col-sm-7">'+data.category+'</dd>';
                            html +='</div>';
                        html += '</dl>';
                       
                        html += '<div class="row">';
                            html += '<div class="col-md-12">';
                                html += '<h6 class="card-title"><strong><a href="#job-description" data-toggle="collapse" aria-expanded="false">Job Description <i class="fa fa-caret-down"></i></a></strong></h6>';
                                html += '<div id="job-description" class="collapse" style="margin-bottom: 1rem; overflow-wrap:break-word;">'+data.job_description+'</div>';

                                 html += '<h6 class="card-title"><strong>About '+data.company+'</strong></h6>';
                                html += '<div>'+data.company_details+'</div>';
                            html += '</div>';
                       html += '</div>';

                    html += '</div>';
                // html += '</div>';

                $("#job-modal-body").append(html);
                // //clear modal content when hidden
                $('#jobModal').on('hidden.bs.modal', function (evt) {

                    var img = '';
                        img += '<center>';
                        img += '<img src="'+pathUrl+'/assets/images/app/ring.gif" style="">';
                        img += '</center>';
                    //$("#job-modal-img").attr("src", pathUrl+"/assets/images/app/ring.gif");
                    $("#job-modal-title").html('<img src="'+pathUrl+'/assets/images/app/ring.gif" style="width: 100%;max-width: 75px; height: auto;">');
                    $("#job-modal-body").html(img);

                });
                
                
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){ 
                console.log(errorThrown);
            }
        });
    });
});    