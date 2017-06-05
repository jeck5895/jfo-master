$(function () {  

 	var path = window.location.pathname;
    var seg = path.split('/');
    var App = {
        pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api"
    }
 	
 	function guid() {
	    function _p8(s) {
	        var p = (Math.random().toString(16) + "000000000").substr(2, 8);
	        return s ? "-" + p.substr(0, 4) + "-" + p.substr(4, 4) : p;
	    }
	    var guid = _p8() + _p8(true) + _p8(true) + _p8();
	    return guid.toUpperCase();
	}

    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
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
               
            }
        });
    }

    function loadFormData()
    {
        getData(App.apiUrl +"/applicants/profiles", function(data){
            //general info
            $("input[name=firstname]").val(data.first_name);
            $("input[name=middlename]").val(data.middle_name);
            $("input[name=lastname]").val(data.last_name);
            $("input[name=birthdate]").val(data.birthdate);
            $("input[name=street]").val(data.street);
            $("input[name=permanent-address]").val(data.address);
            $("input[name=region_id]").val(data.rid);
            $("input[name=city_id]").val(data.cid);

            $("select[name=civilStatus] > option").each(function(){
                (this.value == data.civil_status)? $(this).attr('selected','selected'):null;     
            });
            
            $("select[name=religion] > option").each(function(){
                (this.value == data.religion)? $(this).attr('selected','selected'):null;     
            });

            $("select[name=gender] > option").each(function(){
                (this.value == data.gender)? $(this).attr('selected','selected'):null;     
            });

            //load job interest form
            $("select[name=work-experience] > option").each(function(){
                (this.value == data.experience)? $(this).attr('selected','selected'):null;
            });

            $("select[name=jobCategory] > option").each(function(){
                (this.text == data.category)? $(this).attr('selected','selected'):null;     
            });

            var cid = $("select[name=jobCategory] option:selected").val();
            var app_pos = data.desired_positions;
            var pos_arr = app_pos.split(',')
            
            getData(App.apiUrl +"/jobs/positions/cid/"+cid, function(data){
                $('#job-role').empty();
                $.each(data, function(index, position){
                    var selected = (inArray(position.name, pos_arr))? "selected": null;
                    $('#job-role').append('<option value="'+position.id+'" '+selected+'> '+position.name+'</option>');
                });

            });

            //Resume section
            var file_name = (data.resume != "")? data.resume :"No File uploaded";
            if(data.resume != ""){
                var html = '<button id="btn-update-resume" data-action="update" class="btn btn-primary btn-materialize btn-materialize-sm" disabled>Save New File</button>';
                $("#btn-resume-box").html("").append(html);
                $("#resume-file-name").attr('data-ruid', data.ruid);
                $("#btn-remove-resume").css('display','block');
                $("#resume-box-tools").css("display","block");
            }
            else{
                $("#btn-resume-box").html('<input type="submit" id="btn-save-resume" data-action="upload" value="Save File" class="btn btn-primary btn-materialize btn-materialize-sm" disabled>');
                $("#btn-remove-resume").data('ruid', data.ruid);
                $("#btn-remove-resume").css('display','none');
                $("#resume-box-tools").css("display","none");
            }

            $("#resume-file-name").html(file_name);
           

            //load education form
            var attainment = data.attainment;
            var course = data.degree;
            var school = data.school;
            var year_graduated = data.year_graduated;
            var year_entered = data.year_entered;

            $("input[name=course]").val(course);
            $("input[name=school]").val(school);
            $("input[name=year_entered]").val(year_entered);
            $("input[name=year_graduated]").val(year_graduated);
            $("select[name=educ-attainment] > option").each(function(){
                (this.value == attainment)? $(this).attr('selected','selected'):null;
            });
         
            switch ($("select[name=educ-attainment] option:selected").index()){
                case 1:
                $('.degree-container').css('display','block');
                $('input[name=year_entered], input[name=year_graduated]').prop('disabled', false);

                break;

                case 3:
                $('.degree-container').css('display','block');
                $('input[name=year_entered], input[name=year_graduated]').prop('disabled', false);
                break;

                case 0:
                $('.degree-container').css('display','none');
                $('input[name=year_entered], input[name=year_graduated]').prop('disabled', false);
                break;

                case 2:
                $('.degree-container').css('display','block');
                $('input[name=year_entered], input[name=year_graduated]').prop('disabled', true);
                break;
            }

            //load work history
            var container = $("#work-history-container");

            if(data.work_history.length != 0)
            {
                var html = '';
                
                $.each(data.work_history, function(index, item){
                  
                    html +='<div class="work-history-content-box">';
                        html +='<div class="work-btn-box">';
                            html +='<a class="btn btn-success btn-sm btn-materialize-sm" id="btn-edit-wh" data-id="'+item.wid+'" data-toggle="modal" href="#whistoryModal" data-action="edit">Edit</a> <button class="btn btn-danger btn-sm btn-materialize-sm" id="btn-delete-wh" data-id="'+item.wid+'"  data-action="delete">Delete</button>';
                        html +='</div>';
                        html +='<div class="row" > ';
                            html +='<div class="col-sm-3"> <p class="label-sm">Position:</p></div>';
                            html +='<div class="col-sm-9"> <label>'+item.position+'</label></div>';

                            html +='<div class="col-sm-3"> <p class="label-sm">Company:</p></div>';
                            html +='<div class="col-sm-9"> <label>'+item.company_name+'</label></div>';

                            html +='<div class="col-sm-3"> <p class="label-sm"></p></div>';
                            html +='<div class="col-sm-9"> <label>'+item.start_date+' - '+item.end_date+'</label></div>';

                            html +='<div class="col-sm-3"> <p class="label-sm">Work Description:</p></div>';
                            html +='<div class="col-sm-12">';
                                html +='<p style="text-indent: 1.5rem;">'+item.work_description+'</p>';
                            html +='</div>';
                        html +='</div> ';     
                    html +='</div>';

                    container.html("").append(html);
                });
            }
            else{
                html = "<center>";
                    html += "<label class='text-muted-light'>No work history to display</label>";
                html += "</center>";    

                container.html("").append(html);
            }

        });   
    }

    loadFormData(); //load all form

    /** JOB INTEREST*/
  
    $("#form-job-interest").submit(function(e){
        e.preventDefault();
        var w_exp = $("select[name=work-experience]").val();
        var cid = $("select[name=jobCategory]").val();
        var jobRole = $("#job-role").val();
        var job_data = {
            workExp : w_exp,
            jobCategory: cid,
            jobRole: jobRole,
            op: "job_update"
        };

        $("#btn-save-job").prop("disabled", true);
        $("#btn-save-job").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>'); 
        postData(App.apiUrl + "/applicants/", "PATCH", job_data, function(response){

            if(response.status === true){

                $.notify({
                    title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                    message: "<small>"+response.message+"</small>",
                },{
                    type: "success",
                    delay: 1500,
                    animate: {
                        enter: 'animated fadeIn',
                        exit: 'animated fadeOut'
                    }
                });

                $("#btn-save-job").prop("disabled", false);
                $("#btn-save-job").html('Save Changes');
            }
        });
    })

    /** EDUCATION */
 
    var education = $("option:selected", $("select[name=educ-attainment]")).index();
    //tracking attainment to change appropriate form fileds
    $(document).on("change", "select[name=educ-attainment]",function(){
        education = $("option:selected", this).index();
        switch (education){
            case 1:
                $('.degree-container').css('display','block');
                $('input[name=year_entered], input[name=year_graduated]').prop('disabled', false);
              
            break;

            case 3:
            case 4:
                $('.degree-container').css('display','block');
                $('input[name=year_entered], input[name=year_graduated]').prop('disabled', false);
            break;

            case 0:
                $('.degree-container').css('display','none');
                $('input[name=year_entered], input[name=year_graduated]').prop('disabled', false);
            break;

            case 2:
               $('.degree-container').css('display','block');
               $('input[name=year_entered], input[name=year_graduated]').prop('disabled', true);
            break;
        }
            
    });
    //submit form based on attainment and filled up form
   
    $("#form-education").validate({
        rules:{
            course:{
                required: true
            },
            school:{
                required: true
            },
            year_entered:{
                required: true
            },
            year_graduated:{
                required: true
            }
        },
        submitHandler:function(form){
            var edata;

            if(education == 1 || education == 3 || education == 4){
                var course = $("input[name=course]").val();
                var school = $("input[name=school]").val();
                var year_entered = $("input[name=year_entered]").val();
                var year_grad = $("input[name=year_graduated]").val();
                var attainment = $("select[name=educ-attainment]").val();
                edata = {
                    attainment: attainment,
                    course: course,
                    school: school,
                    year_entered: year_entered,
                    year_graduated: year_grad,
                    op: "educ_update"
                };
            }
            if(education == 0){
                var course = $("input[name=course]").val();
                var school = $("input[name=school]").val();
                var year_entered = $("input[name=year_entered]").val();
                var year_grad = $("input[name=year_graduated]").val();
                var attainment = $("select[name=educ-attainment]").val();
                edata = {
                    attainment: attainment,
                    course: course,
                    school: school,
                    year_entered: year_entered,
                    year_graduated: year_grad,
                    op: "educ_update"
                };   
            }
            if(education == 2){
                var school = $("input[name=school]").val();
                var attainment = $("select[name=educ-attainment]").val();
                edata = {
                    attainment: attainment,
                    school: school,
                    op: "educ_update"
                };   
            }
            $("#btn-save-ed").prop("disabled", true);
            $("#btn-save-ed").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>'); 
            
            postData(App.apiUrl + "/applicants/", "PATCH", edata, function(response){

                if(response.status === true){

                    $.notify({
                        title: " ",
                        message: "<i class='fa fa-check-circle'></i> "+response.message,
                    },{
                        type: "success",
                        delay: 1500,
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        }
                    });

                    $("#btn-save-ed").prop("disabled", false);
                    $("#btn-save-ed").html('Save Changes');
                }
            });
        }
    });
        
        


    /** WORK HISTORY */
    var wid = false;
    var action = false;

    $(document).on("click", "#btn-add-wh, #btn-edit-wh, #btn-delete-wh", function(){
        action = $(this).attr('data-action');
        wid = $(this).attr('data-id');

        if(action == "delete"){
            data = {
                    wid: wid
                };

            $.confirm({
                icon: 'fa fa-exclamation-circle',
                alignMiddle: true,
                columnClass: 'col-md-4',   
                title: 'JobFair Online says:',
                content: 'Are you sure to permanently remove this record?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function () {

                            postData(App.apiUrl + "/applicants/work_history", "DELETE", data, function(response){

                                if(response.status === true){
    
                                    loadFormData();

                                    $.notify({
                                        title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                                        message: "<small>"+response.message+"</small>",
                                    },{
                                        type: "success",
                                        delay: 1500,
                                        animate: {
                                            enter: 'animated fadeIn',
                                            exit: 'animated fadeOut'
                                        }
                                    });
                                }

                            });
                        }
                    },
                    cancel: function () {

                    }
                }
            });
        }
    });

    $('#add-work-history-form').submit(function(e){
        e.preventDefault();
        var workID = $('input[name = work_id]').val();
        var compName = $.trim($('input[name = company_name]').val());
        var position =  $.trim($('input[name = passed_position]').val());
        var work_description = $.trim($('textarea[name = work_description]').val());
        var start_date = $.trim($('input[name = start_date]').val());
        var end_date = $.trim($('input[name=end_date]').val());
        
        if(start_date > end_date){
            $.notify({
                title: " ",
                message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>Invalid Date</small></h6>",
                allow_dismiss:false,

            },{
                type: "danger",
            });
        }
        else{

            if(action == "add")
            {

                data = {
                    company : compName,
                    position : position,
                    work_description: work_description,
                    start_date : start_date,
                    end_date : end_date
                };

                postData(App.apiUrl + "/applicants/work_history", "POST", data, function(response){
                    
                    if(response.status === true){
                        $('#add-work-history-form')[0].reset();
                        $('#whistoryModal').modal('hide');

                        loadFormData();

                        $.notify({
                            title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                            message: "<small>"+response.message+"</small>",
                        },{
                            type: "success",
                            delay: 1500,
                            animate: {
                                enter: 'animated fadeIn',
                                exit: 'animated fadeOut'
                            }
                        });
                    }

                });
            }
            if(action == "edit"){

                data = {
                    wid: workID,
                    company : compName,
                    position : position,
                    work_description: work_description,
                    start_date : start_date,
                    end_date : end_date,
                };

                postData(App.apiUrl + "/applicants/work_history", "PATCH", data, function(response){
                   
                   if(response.status === true){
                        $('#add-work-history-form')[0].reset();
                        $('#whistoryModal').modal('hide');

                        loadFormData();

                        $.notify({
                            title: "<h6><i class='fa fa-check-circle'></i> Success</h6> ",
                            message: "<small>"+response.message+"</small>",
                        },{
                            type: "success",
                            delay: 1500,
                            animate: {
                                enter: 'animated fadeIn',
                                exit: 'animated fadeOut'
                            }
                        });
                    }
                });
            }
            
        }
    }); 

    $(document).on('shown.bs.modal', '#whistoryModal',function (evt) {
        var $this =  $(this);
        if(action == "edit")
        {

            $.ajax({
                url: App.apiUrl +"/applicants/work_history/wid/"+wid,
                type: "GET",
                dataType: "JSON",
                success:function(data)
                {
                    $this.find('input[name=work_id]').val(data.wid);
                    $this.find('input[name=company_name]').val(data.company_name);
                    $this.find('input[name=passed_position]').val(data.position);
                    $this.find('textarea[name=work_description]').val(data.work_description);
                    $this.find('input[name=start_date]').val(data.start_date);
                    $this.find('input[name=end_date]').val(data.end_date);
                },
                error:function(jqXHR, exception){
                    console.log(jqXHR.responseJSON.message);
                    $.notify({
                        title: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+jqXHR.responseJSON.message+"</small></h6> ",
                        message: "",
                        allow_dismiss:false,
                        timer: 5000

                    },{
                        type: "danger"  
                    });
                }
            })
        }   
    });

    $(document).on('hidden.bs.modal', '#whistoryModal',function (evt) {
        $('#add-work-history-form')[0].reset();
    });


    //form resume upload
    $(document).on("change", "input[name=userfile_resume]", function(){
        var valid_type = ["application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/pdf","application/msword"];
        var mime_type = $(this)[0].files[0].type; 
       
        if($(this).val() != "" && inArray(mime_type, valid_type) == true){
            $("#btn-save-resume, #btn-update-resume").prop('disabled',false);
            $("#form-error-text").text("");
            $("#resume-box-tools").css("display","block");
        }
        else{
            $("#form-error-text").html("Error: Invalid file format");
            $("#btn-save-resume").prop('disabled',true);
            $(".bootstrap-filestyle input").val("");
            $("input[name=userfile_resume]").val("");
        }
       
    });


    $(document).on("click","#btn-save-resume, #btn-update-resume, #btn-remove-resume", function(){
        var $this = $(this);
        var action = $(this).data('action');
        var url = App.apiUrl +"/applicants/resume";
        var inputFile = $("input[name=userfile_resume]");
        var old_file_name = $("#resume-file-name").data('ruid'); 

        var fileToUpload = inputFile[0].files[0];
        var formData = new FormData();

        
        if(action == "update" || action == "upload")
        {
            $(this).prop("disabled", true);
            $(this).html("").append('Uploading&nbsp<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only"></span>');

            formData.append('userfile', fileToUpload);
            formData.append('op',action);
            if(action == "update"){formData.append('old_file', old_file_name);}

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data){
                    loadFormData();
                    $(".bootstrap-filestyle input").val("");
                    inputFile.val("");
                    
                    if(action == "upload"){
                        $(this).html('SAVE FILE');
                    }
                    else{
                        $(this).html('SAVE NEW FILE');
                    }

                    $.notify({
                        title: " ",
                        message: "<i class='fa fa-check-circle'></i> "+data.message,

                    },{
                        type: "success",
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        }
                    });
                },
                error: function(xhr, exception){
                    console.log("error " +xhr + " " + exception)
                    $.notify({
                        title: "<h6><i class='fa fa-times-circle'></i> "+xhr.responseJSON.message+"</h6> ",
                        message: ""
                    },{
                        type: "danger",
                    });
                }
            }); 
        }
        if(action == "remove")
        {
            data = {old_file: old_file_name, op:action};

            $.confirm({
                icon: 'fa fa-exclamation-circle',
                alignMiddle: true,
                columnClass: 'col-md-4',   
                title: 'JobFair Online says:',
                content: 'Remove your current resume?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success',
                        action: function () {
                            
                            postData(url, "POST", data, function(response){

                                if(response.status === true){                                
                                    loadFormData();
                                    $.notify({
                                        title: " ",
                                        message: "i class='fa fa-check-circle'></i> "+response.message,
                                    },{
                                        type: "success",
                                        delay: 1500,
                                        animate: {
                                            enter: 'animated fadeIn',
                                            exit: 'animated fadeOut'
                                        }
                                    });
                                }

                            });
                        }
                    },
                    cancel: function () {

                    }
                }
            });
        }
    });

    //form general info
    $("#form-general-info").validate({
        rules:{
           
        },
        messages:{
           
        },
        tooltip_options:{
           
        },
        submitHandler:function(form){
            var fname = $("input[name=firstname]").val(); 
            var mname = $("input[name=middlename]").val();
            var lname = $("input[name=lastname]").val();
            var bdate = $("input[name=birthdate]").val();
            var religion = $("select[name=religion]").val();
            var cStatus = $("select[name=civilStatus]").val();
            var gender = $("select[name=gender]").val();
            var street = $("input[name=street]").val();
            var region_id = $("input[name = region_id]").val();
            var city_id = $("input[name = city_id]").val();
            var data = {
                first_name: fname,
                middle_name: mname,
                last_name: lname,
                birthdate: bdate,
                religion: religion,
                civil_status: cStatus,
                gender: gender,
                street: street,
                region_id: region_id,
                city_id: city_id,
                op: "general_update" 
            };

            $("#btn-save-gen-info").prop("disabled", true);
            $("#btn-save-gen-info").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');

            $.ajax({
                type: "PATCH",
                url: App.apiUrl + '/applicants/',
                dataType: "json",
                data:data,
                success: function (data) {
                    if(data.status == true)
                    {
                        $.notify({
                            title: " ",
                            message: "<i class='fa fa-check-circle'></i> "+data.message,

                        },{
                            type: "success",
                            animate: {
                                enter: 'animated fadeIn',
                                exit: 'animated fadeOut'
                            }
                        });
                        $("#btn-save-gen-info").prop("disabled", false);
                        $("#btn-save-gen-info").html('Save Changes'); 
                    }
                },
                error: function(xhr, exception){

                    $.notify({
                        title: "<h6><i class='fa fa-times-circle'></i> "+xhr.responseJSON.message+"</h6> ",
                        message: ""
                    },{
                        type: "danger",
                    });

                    $("#btn-save-mobile").prop('disabled', false);
                    $("#btn-save-mobile").html('Save Changes');
                }
            });
        }
    });

    
 	
}); 	