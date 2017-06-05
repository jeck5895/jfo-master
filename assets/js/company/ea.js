$(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var temp = [];
    var keyword = '';
    var location =  '';
    var category = '';
    
    String.prototype.ucfirst = function(){
        return this.charAt(0).toUpperCase() + this.slice(1);
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

    function loadJobApplicants(applicants)
    {   
        $("#job-applicants-container").html("");
        if(applicants.data != 0)
        {    
            $.each(applicants, function(index, item){
                var html = '';
                var fname = item.first_name.toLowerCase();
                var fClass = (item.stat_id == 5)? "text-success" : (item.stat_id == 3)? "text-info" : "";
                var bgClass = (item.stat_id == 5)? "bg-success" : (item.stat_id == 3)? "bg-info" : "";

                html += '<div class="list-group-item pt-4">';

                    html += '<div class="box-tools">';
                        html += '<p class="fs-12"><small class="text-muted"><strong>Date Applied</strong>: '+moment(item.date_applied).format('MMMM D, YYYY')+' ('+moment(item.date_applied).fromNow()+')</small></p>';
                    html += '</div>';

                    html += '<div class="box-app">';
                        html += '<div class="box-header">';
                            html += '<label class="custom-control custom-checkbox">';
                                html += '<input type="checkbox" class="custom-control-input" name="select-emp-applicant" data-id="'+item.vid+'" data-app-name="'+fname+'" data-uid="'+item.apl_id+'">';
                                html += '<span class="custom-control-indicator"></span>';
                                html += '<span class="custom-control-description"></span>';
                            html += '</label>';
                        html += '</div>';

                        html += '<div class="col-xs-12 col-md-3" style="padding:0;">';
                            html += '<div class="info-container">';
                                html += '<div class="user-image">';
                                    html += '<img src="'+item.profile_photo+'" class="img-fluid" alt="User Image">';
                                html += '</div>';
                                html += '<div class="user-info fs-12" style="margin-left: 8px!important;">';

                                    //html += '<label class="user-name"><a href="#profileModal" id="view_app_profile" data-toggle="modal" data-target="#profileModal" data-aid="'+item.id+'">'+item.first_name+" "+item.last_name+'</a></label>  ';
                                    html += '<label class="user-name"><a href="'+App.pathUrl+'/applicants/'+item.apl_id+'" target="'+item.apl_id+'">'+item.first_name+" "+item.last_name+'</a></label>  ';
                                    html += '<ul class="list-unstyled mb-0">';
                                        html += '<li>'+item.gender+' '+item.age+' y/o</li>';
                                        html += '<li ><i class="fa fa-map-marker"></i> '+item.address+'</li>';
                                        html += '<li>'+item.mobile+'</li>';
                                        html += '<li class="fs-13"><div class="stat-box '+bgClass+'"></div>&nbsp&nbsp<label class="'+fClass+'">'+item.status+'</label></li>';
                                    html += '</ul>';
                                html += '</div>';
                            html += '</div>';
                            html += '<div class="application-info-box">';
                                html += '<small><label class="header">Position Applied:</label></small>';
                                html += '<small><p >'+item.applied_position+'</p></small>';
                            html += '</div>'
                        html += '</div>';

                        html += '<div class="col-xs-12 col-md-4 hidden-sm-down">';
                            html += '<div class="user-info">';     
                                html += '<label class="user-name">'+item.degree+'</label>  ';
                                html += '<ul class="list-unstyled">';
                                    html += '<li>'+item.school+'</li>';
                                    html += '<li>'+item.attainment+'</li>';
                                    html += '<li>'+item.year_entered +' - '+item.year_graduated+'</li>';
                                html += '</ul>';
                            html += '</div>';

                        html += '</div>';

                        html += '<div class="col-xs-12 col-md-4 hidden-sm-down">';
                        if(item.work_history.length != 0)
                        {
                            html += '<div class="user-info">';
                            $.each(item.work_history, function(index, item){
                                html += '<label class="user-name"> '+item.company_name + '</label>';
                                html += '<ul class="list-unstyled">';
                                html += '<li> '+item.position + '<li>';
                                html += '<li> '+item.start_date +' - '+item.end_date + '<li>';
                                html += '</ul>';       
                            });
                            html += '</div>';
                        }
                        else{
                            var temp_name = item.first_name.split(" ");
                            var app_name = temp_name[0].toLowerCase();
                            html += "<center style='margin-top:4rem;'><i><small>"+app_name.ucfirst()+" doesn't have work history.</small></i></center>";
                        }
                        html += '</div>';
                    html += '</div>';
                html += '</div>';    
                
                $("#job-applicants-container").append(html);
            });
        }
        else
        {
            var html = '<center><h6 class="text-muted-light"> No applicants to display </h6><p class="text-muted-light fs-12"><a href="'+App.pathUrl+'/applicants">Search </a>Public Candidates</p></center';
                    
            $("#job-applicants-container").append(html);
        }
    }

    function paginateData(applicants)
    {
        loadJobApplicants(applicants);
        var limit = (applicants.data != 0)? applicants[0]['limit'] : applicants.limit;
        var totalFiltered = (applicants.data != 0)? applicants[0]['totalFiltered'] : applicants.totalFiltered;
        var temp_pages = Math.ceil(totalFiltered / limit);
        var pages = (temp_pages == 0)? 1 : temp_pages;


        $('#job-app-pagination').bootpag({
            total: pages,
            page: 1,
            maxVisible: 5,
            leaps: true
        }).off().on("page", function(event, num){
            offset = (num - 1) * limit;
            var page_url = "";

            if(keyword != '' && location == '' && category =='')
            {   
                page_url = pathUrl + "/api/companies/job_applicants?keyword="+keyword+"&offset=" + offset;
            }
            else if((keyword && location) != '' && category =='')
            {
                page_url = pathUrl + "/api/companies/job_applicants?keyword="+keyword+"&region="+location+"&offset=" + offset;
            }
            else if((keyword && category) != '' && location =='')
            {
                page_url = pathUrl + "/api/companies/job_applicants?keyword="+keyword+"&category="+category+"&offset=" + offset;
            }
            else if((category && location) != '' && keyword =='')
            {
                page_url = pathUrl + "/api/companies/job_applicants?category="+category+"&region="+location+"&offset=" + offset;
            }
            else if(location != '' && keyword == '' && category == '')
            {
                page_url = pathUrl + "/api/companies/job_applicants?region="+location+"&offset=" + offset;
            }
            else if(category != '' && location == '' && keyword == '')
            {
                page_url = pathUrl + "/api/companies/job_applicants?category="+category+"&offset=" + offset;
            }
            else if((keyword && location && category) != ''){
                page_url = pathUrl + "/api/companies/job_applicants?keyword="+keyword+"&region="+location+"&category="+category+"&offset=" + offset;
            }
            else{
                page_url = pathUrl + "/api/companies/job_applicants?offset=" + offset;   
            }

            paginatedApplicants = getJSONDoc(page_url);

            loadJobApplicants(paginatedApplicants);
        });
    }

    function reload()
    {
        getData(pathUrl + "/api/companies/job_applicants", function(data){
            paginateData(data);
        });
    }

    //applicants
    getData(pathUrl + "/api/companies/job_applicants", function(data){
        paginateData(data);
    });

    //load select box
    getData(pathUrl + "/api/companies/jobs", function(data){
        var html = "";
        $.each(data, function(index, item){
            html += "<option value='"+item.id+"'>"+item.position+"</option>";
        });

        $("select[name=filter-position]").append(html);
    });

    getData(pathUrl + "/api/jobs/job_status", function(data){
        var html = "";
        $.each(data, function(index, item){
            html += "<option value='"+item.id+"'>"+item.status+"</option>";
        });

        $("select[name=filter-status]").append(html);
    });

    var posVal = "";
    var statVal = "";

    $("select[name=filter-position], select[name=filter-status]").on("change", function(){
        var element = $(this).attr('name')
        var query = "";//(statVal != "")? "job_id="+posVal+"&status="+statVal : "job_id="+posVal
        
        
        if(element == "filter-position"){
            posVal = $("option:selected", this).val();
        }
        if(element == "filter-status"){
            statVal = $("option:selected", this).val();
        }
        
        if(posVal != "" && statVal != ""){
            query = "job_id="+posVal+"&status="+statVal;
        }
        if(posVal != "" && statVal == ""){
            query = "job_id=" + posVal;
        }
        if(posVal == "" && statVal != ""){
            query = "status="+statVal;
        }
       
        $.ajax({
            type: "GET",
            url: pathUrl + "/api/companies/job_applicants?"+query,
            dataType: "JSON",
            success: function(data)
            {
                paginateData(data);
                
            },
            error: function(){

            }
        });
    });

    $("#search-applicants").on("keyup", function(){
        
        keyword = $(this).val();

        if(keyword == "")
        {
            $.ajax({
                type: "GET",
                url: pathUrl + "/api/companies/job_applicants",
                dataType: "JSON",
                success: function(data)
                {
                    paginateData(data);
                },
                error: function(){

                }
            });
        }
    });

    $("select[name=filter-location]").on("change", function(){
       
        location = $(this).val();
    });

    $("select[name=filter-category]").on("change", function(){
       
        category = $(this).val();
    });

    $("#btn-search-app").on("click", function(){

        //var url = (keyword != '' && location == '')? pathUrl + "/api/applicants/profiles?keyword="+keyword : (keyword == '' && location != '')? pathUrl + "/api/applicants/profiles?region="+location: ((keyword && location) != '')? pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location: pathUrl + "/api/applicants/profiles";
        var url = '';
        if(keyword != '' && location == '' && category =='')
        {   
            url = pathUrl + "/api/companies/job_applicants?keyword="+keyword;
        }
        else if((keyword && location) != '' && category =='')
        {
            url = pathUrl + "/api/companies/job_applicants?keyword="+keyword+"&region="+location;
        }
        else if((keyword && category) != '' && location =='')
        {
            url = pathUrl + "/api/companies/job_applicants?keyword="+keyword+"&category="+category;
        }
        else if((category && location) != '' && keyword =='')
        {
            url = pathUrl + "/api/companies/job_applicants?category="+category+"&region="+location;
        }
        else if(location != '' && keyword == '' && category == '')
        {
            url = pathUrl + "/api/companies/job_applicants?region="+location;
        }
        else if(category != '' && location == '' && keyword == '')
        {
            url = pathUrl + "/api/companies/job_applicants?category="+category;
        }
        else if((keyword && location && category) != ''){
            url = pathUrl + "/api/companies/job_applicants?keyword="+keyword+"&region="+location+"&category="+category;
        }
        else{
            url = pathUrl + "/api/companies/job_applicants";   
        }

        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function(data)
            {
                paginateData(data);
            },
            error: function(){

            }
        });

    });
    //clear filters
    $("#btn-clear-filter").on("click", function(){
       
        $("select[name=filter-category], select[name=filter-location], #search-public-applicants").val("");
        $("select[name=filter-location]").val('').trigger('change');
        $("#search-applicants").val('');
        location = ""; category=""; keyword="";

        $.ajax({
            type: "GET",
            url: pathUrl + "/api/companies/job_applicants",
            dataType: "JSON",
            success: function(data)
            {
                paginateData(data);
            },
            error: function(){

            }
        });
        
    });

 
    //employer applicants on job post
    var verification_ids = []; //this is for verification ids
    var applicant_ids = [];
    var app_name ;
    $("input[name=select-all-emp-applicants]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-emp-applicant]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-emp-applicant]").each(function (index) {
                $(this).prop("checked", false);
            });
      }
    });
    //tag applicants as reviewd
    $("#btn-review-applicants, #btn-interview-applicants, #btn-reject-applicants").on("click", function(){
        verification_ids = [];// clear array first 
        applicant_ids = [];
        var action = $(this).data('action');
        var prompt_message = $(this).data('title'); 
        var method = (action == "tag_review")?'tag_as_reviewed': (action == "tag_interview")?"tag_for_interview":(action == "tag_reject")?"tag_as_reject": null;
        var url = pathUrl +'/api/companies/applicants/'+method;

        $("input[name=select-emp-applicant]").each(function (index) {
            if($(this).is(":checked"))
            {
                var verification_id = $(this).data("id");
                var applicant_id = $(this).data('uid');
                verification_ids.push(verification_id);
                applicant_ids.push(applicant_id);
                app_name = $(this).attr('data-app-name');
            }
        });
       
        if(verification_ids.length != 0)
        {
            if(verification_ids.length == 1)
            {
                $.confirm({
                    icon: ' ',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: ' ',
                    content: 'Are you sure to tag '+app_name.ucfirst()+' '+prompt_message+'?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {
                                $.ajax({
                                    type:"POST",
                                    url: App.pathUrl +"/notification/new_notification",
                                    dataType:"JSON",
                                    data:{
                                        id : applicant_ids,
                                        vid: verification_ids,
                                        method: method
                                    },
                                    success:function(){
                                        $.ajax({
                                            url: url,
                                            type: 'POST',
                                            dataType: 'JSON',
                                            data:{
                                                id : verification_ids
                                            },
                                            success: function(data){
                                                reload();

                                                $("input[name=select-all-emp-applicants]").prop("checked",false);

                                                $.notify({
                                                    title: " ",
                                                    message: "<i class='fa fa-exclamation-triangle'></i>&nbsp"+data.message,

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
                                                    message: "<i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+xhr.responseJSON.message
                                                },{
                                                    type: "danger",
                                                    animate: {
                                                        enter: 'animated fadeIn',
                                                        exit: 'animated fadeOut'
                                                    },  
                                                });
                                            }

                                        });  
                                    },
                                    error: function(xhr, exception){
                                        console.log(exception)
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
                    icon: ' ',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: ' ',
                    content: 'Are you sure to tag these applicants '+prompt_message+'?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {
                                $.ajax({
                                    type:"POST",
                                    url: App.pathUrl +"/notification/new_notification",
                                    dataType:"JSON",
                                    data:{
                                        id : applicant_ids,
                                        vid: verification_ids,
                                        method: method
                                    },
                                    success:function(){
                                        $.ajax({
                                            url: url,
                                            type: 'POST',
                                            dataType: 'JSON',
                                            data:{
                                                id : verification_ids
                                            },
                                            success: function(data){
                                                reload();

                                                $("input[name=select-all-emp-applicants]").prop("checked",false);

                                                $.notify({
                                                    title: " ",
                                                    message: "<i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message,

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
                                    },
                                    error: function(xhr, exception){
                                        console.log(exception);
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
                message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>Please check at least 1 Applicant</small></h6>",

            },{
                type: "danger",
                animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOut'
                }
            });
        }
    });
   
});