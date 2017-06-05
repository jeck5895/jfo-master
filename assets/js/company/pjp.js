$(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];

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

    var table_approval = $('#approval_job_table').DataTable({ 
            "order": [[ 5, "desc" ]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "autoWidth":false,
            
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": pathUrl + "/employer/jobs/pending",
                "type": "POST",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var totalReFiltered = json.recordsFiltered;
        
                    $("#approval-badge").html(totalReFiltered);
                
                    return JSON.stringify( json ); 
                }
            },
            "select": {
                "style":    "os",
                "selector": "td:first-child"
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], //last column
                  "orderable": false, //set not orderable
                },
            ],
        });


    var published_job_table = $('#published_job_table').DataTable({
            "order": [[ 5, "desc" ]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "autoWidth":false,
            
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": pathUrl + "/employer/jobs/published",
                "type": "POST",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var totalReFiltered = json.recordsFiltered;
        
                    $("#published-badge").html(totalReFiltered);
                
                    return JSON.stringify( json ); 
                }
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], //last column
                  "orderable": false, //set not orderable
                },
            ],
    });

    var declined_job_table = $('#declined_job_table').DataTable({
            "order": [[ 5, "desc" ]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "autoWidth":false,
            
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": pathUrl + "/employer/jobs/declined",
                "type": "POST",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var totalReFiltered = json.recordsFiltered;
        
                    $("#declined-badge").html(totalReFiltered);
                
                    return JSON.stringify( json ); 
                }
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], //last column
                  "orderable": false, //set not orderable
                },
            ],
    });

    var expired_job_table = $('#expired_job_table').DataTable({
        "order": [[ 5, "desc" ]],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "autoWidth":false,
            
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": pathUrl + "/employer/jobs/expired",
                "type": "POST",
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var totalReFiltered = json.recordsFiltered;
        
                    $("#expired-badge").html(totalReFiltered);
                
                    return JSON.stringify( json ); 
                }
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], //last column
                  "orderable": false, //set not orderable
                },
            ],
    });

    // $('#approval_job_table_filter input, #approval_job_table_length select').removeClass('form-control-sm');
    $('#approval_job_table tbody').on( 'mouseenter', 'td > a > img#edit, td > a > img#view, td > a > img#delete', function () {
        var id = $(this).attr('id');
        if(id == "edit"){
            $(this).attr('src',pathUrl+'/assets/images/app/EditDataTableIcon_Hover.png');
        }
        if(id == "view"){
            $(this).attr('src',pathUrl+'/assets/images/app/PreviewDataTableIcon_Hover.png');
        }
        if(id == "delete"){
            $(this).attr('src',pathUrl+'/assets/images/app/DeleteDataTableIcon_hover.png');   
        }
    });

    $("#approval_job_table tbody").on('mouseleave', 'td > a > img#edit, td > a > img#view, td > a > img#delete', function(){
        
        var id = $(this).attr('id');
        if(id == "edit"){
            $(this).attr('src',pathUrl+'/assets/images/app/EditDataTableIcon.png');
        }
        if(id == "view"){
            $(this).attr('src',pathUrl+'/assets/images/app/PreviewDataTableIcon.png');
        }
        if(id == "delete"){
            $(this).attr('src',pathUrl+'/assets/images/app/DeleteDataTableIcon.png');   
        }
    });

    var job_ids = [];
    
    //check all pending jobs
    $("input[name=select-all-emp-pending-job]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-pending-job]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-pending-job]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });

    //check all published jobs
    $("input[name=select-all-emp-published-job]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-published-job]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-published-job]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });

    //check all declined jobs
    $("input[name=select-all-emp-declined-job]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-declined-job]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-declined-job]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });

    //check all  expired jobs
    $("input[name=select-all-emp-expired-job]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-expired-job]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-expired-job]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });

    $(document).on("click","#btn-delete-job-post", function(){
        job_ids = [];
        var scope = $(this).data('scope');

        $("input[name=select-pending-job]").each(function (index) {
            if($(this).is(":checked"))
            {
                var jid = $(this).data("id");
                job_ids.push(jid);
            }
        });

        $("input[name=select-published-job]").each(function (index) {
            if($(this).is(":checked"))
            {
                var jid = $(this).data("id");
                job_ids.push(jid);
            }
        });

        $("input[name=select-declined-job]").each(function (index) {
            if($(this).is(":checked"))
            {
                var jid = $(this).data("id");
                job_ids.push(jid);
            }
        });

        $("input[name=select-expired-job]").each(function (index) {
            if($(this).is(":checked"))
            {
                var jid = $(this).data("id");
                job_ids.push(jid);
            }
        });

        if(job_ids.length != 0)
        {
            $.confirm({
                icon: 'fa fa-exclamation-circle',
                alignMiddle: true,
                columnClass: 'col-md-4',   
                title: 'JobFair Online says:',
                content: 'Delete this/these job(s)?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success btn-materialize btn-materialize-sm',
                        action: function () {
                            $.ajax({
                                url : pathUrl+'/api/jobs/delete',
                                type: 'POST',
                                dataType: 'JSON',
                                data:{
                                    id : job_ids,
                                },
                                success: function(data){
                                    console.log(data);
                                    //refresh table headers
                                    $("input[name=select-all-emp-pending-job]").prop("checked", false);
                                    $("input[name=select-all-emp-published-job]").prop("checked", false);
                                    $("input[name=select-all-emp-declined-job]").prop("checked", false);
                                    $("input[name=select-all-emp-expired-job]").prop("checked", false);
                                    //refresh datatables
                                    table_approval.ajax.reload(null, false);
                                    published_job_table.ajax.reload(null, false);
                                    declined_job_table.ajax.reload(null, false);
                                    expired_job_table.ajax.reload(null, false);

                                    $.notify({
                                        title: " ",
                                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6> ",

                                    },{
                                        type: "success",
                                        animate: {
                                            enter: 'animated fadeIn',
                                            exit: 'animated fadeOut'
                                        },
                                    });
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
            $.notify({
                title: " ",
                message: "<i class='fa fa-exclamation-triangle'></i>&nbspPlease check at least 1 Job to Delete",

            },{
                type: "danger",
                animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOut'
                }
            });
        }
    });

    $(document).on("click", "#delete-job",function(){
        var id = $(this).data('id');
        job_ids = [];
        
        job_ids.push(id);

        $.confirm({
            icon: 'fa fa-exclamation-circle',
            alignMiddle: true,
            columnClass: 'col-md-4',   
            title: 'JobFair Online says:',
            content: 'Are you sure you want to delete this job?',
            buttons: {
                confirm: {
                    btnClass: 'btn-success btn-materialize btn-materialize-sm',
                    action: function () {
                        $.ajax({
                            url : pathUrl+'/api/jobs/delete',
                            type: 'POST',
                            dataType: 'JSON',
                            data:{
                                id : job_ids,
                            },
                            success: function(data){
                                console.log(data);

                                table_approval.ajax.reload(null, false);
                                published_job_table.ajax.reload(null, false);
                                declined_job_table.ajax.reload(null, false);
                                expired_job_table.ajax.reload(null, false);

                                $.notify({
                                    title: " ",
                                    message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6> ",

                                },{
                                    type: "success",
                                    animate: {
                                        enter: 'animated fadeIn',
                                        exit: 'animated fadeOut'
                                    },
                                });
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
                },
                cancel:{
                    btnClass: 'btn btn-secondary btn-materialize btn-materialize-sm',
                    action: function () {

                    }
                }
            }
        });
    });
});