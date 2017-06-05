$(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var keyword = '';
    var location =  '';
    var industry = '';
    var type
 	
    String.prototype.ucfirst = function(){
        return this.charAt(0).toUpperCase() + this.slice(1);
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

    $(document).ready(function(){
        $('.select2-container .select2-selection--single').removeClass('select2-form-control');
        $('.select2-container .select2-selection--single').addClass('select2-form-control-sm');
        $('.select2-container--default .select2-selection--single .select2-selection__rendered').addClass('select2-line-height-17');
    });

    function loadEmployers(employers, selector, badgeSelector, status)
    {   
        if(employers.data != 0)
        {
            selector.html("");   
            badgeSelector.html(employers[0].totalRecords);
            badgeSelector.css("background-color","rgb(154, 30, 30)");

             
        
            $.each(employers, function(index, item){
                var html = '';
                var desired_positions ='';
                var telephone_number = (item.telephone_number != "")? item.telephone_number : "<i>Not Available</i>";
                var website = (item.url != "")? item.url : "<i>Not Available</i>" ;
                var uri = encodeURIComponent(item.company);


                html += '<div class="list-group-item no-border-lr no-pad-lr">';
                    html += '<div class="box-app">';
                        html += '<div class="box-header">';
                            html += '<label class="custom-control custom-checkbox mt-4-th">';
                                html += '<input type="checkbox" class="custom-control-input" name="select-admin-'+status+'-employer" data-id="'+item.user_id+'">';
                                html += '<span class="custom-control-indicator"></span>';
                                html += '<span class="custom-control-description"></span>';
                            html += '</label>';
                        html += '</div>';

                        html += '<div class="col-xs-12 col-md-1 hidden-sm-down">';
                            html += '<div class="user-image mt-4-hf">';
                                html += '<img src="'+item.logo+'" alt="'+item.company+' logo" class="img-fluid">';
                            html += '</div>';
                        html += '</div>';

                        html += '<div class="col-xs-12 col-md-3" style="padding:0;">';
                            html += '<div class="info-container">';
                               
                                html += '<div class="user-info w-100" style="margin-left: 8px!important;">';

                                    html += '<label class="user-name"><a class="light-blue" href="'+pathUrl + '/companies/'+uri+'-'+item.id+'" target="'+item.company+'-'+item.cid+'">'+item.company+'</a></label>  ';
                                    html += '<ul class="list-unstyled">';
                                        html += '<li><label class="header">'+item.location+'</label></li>';
                                        html += '<li >'+item.industry+'</li>';
                                        html += '<li>'+telephone_number+'</li>';
                                        html += '<li>'+website+'</li>';
                                    html += '</ul>';

                                html += '</div>';
                            html += '</div>';
                            
                        html += '</div>';

                        html += '<div class="col-xs-12 col-md-3 hidden-sm-down">';
                            html += '<div class="user-info">';     
                                html += '<label class="user-name">'+item.contact_person_fName+' '+item.contact_person_mName+' '+item.contact_person_lName+'</label>  ';
                                html += '<ul class="list-unstyled">';
                                    html += '<li>'+item.contact_person_position+'</li>';
                                    html += '<li>'+item.mobile_no+'</li>';
                                    html += '<li>'+item.email+'</li>';
                                html += '</ul>';
                            html += '</div>';

                         
                        html += '</div>';

                        html += '<div class="col-xs-12 col-md-4 hidden-sm-down">';
                            html += '<h6 class="header">About '+item.company+'</h6>';
                            html+= '<p class="text-justify fs-13">'+item.company_description+'</p>';
                        html += '</div>';
                    html += '</div>';
                html += '</div>';
                
                selector.append(html);
            });
        }
        else
        {
            // $("#public-applicant-badge").html('0');
            // $("#public-applicant-badge").css("background-color","#999999")
            var html = '';
            html += '<div class="box box-widget">';
                html += '<div class="box-body">';
                    html += '<center><h1 class="lead"> <i>No Results found</i></h1></center';
                html += '</div>';
            html += '</div>';
            selector.html("").append(html);
        }
    }

    function paginateData(employers, containerSelector, paginateSelector, badgeSelector, status)
    {
        loadEmployers(employers, containerSelector, badgeSelector, status);  
        var limit = (employers.data != 0)? employers[0]['limit'] : employers.limit;
        var totalFiltered = (employers.data != 0)? employers[0]['totalFiltered'] : employers.totalFiltered;
        var temp_pages = Math.ceil(totalFiltered / limit);
        var pages = (temp_pages == 0)? 1 : temp_pages;

        paginateSelector.bootpag({
            total: pages,
            page: 1,
            maxVisible: 5,
            leaps: true
        }).off().on("page", function(event, num){
            offset = (num - 1) * limit;
            page_url = "";
            
            if(keyword != '' && location == '' && industry =='')
            {   
                page_url = pathUrl + "/api/companies/index?keyword="+keyword+"&status="+type+"&offset="+offset;
            }
            else if((keyword && location) != '' && industry =='')
            {
                page_url = pathUrl + "/api/companies/index?keyword="+keyword+"&region="+location+"&status="+type+"&offset="+offset;
            }
            else if((keyword && industry) != '' && location =='')
            {
                page_url = pathUrl + "/api/companies/index?keyword="+keyword+"&industry="+industry+"&status="+type+"&offset="+offset;
            }
            else if((industry && location) != '' && keyword =='')
            {
                page_url = pathUrl + "/api/companies/index?industry="+industry+"&region="+location+"&status="+type+"&offset="+offset;
            }
            else if(location != '' && keyword == '' && industry == '')
            {
                page_url = pathUrl + "/api/companies/index?region="+location+"&status="+type+"&offset="+offset;
            }
            else if(industry != '' && location == '' && keyword == '')
            {
                page_url = pathUrl + "/api/companies/index?industry="+industry+"&status="+type+"&offset="+offset;
            }
            else if((keyword && location && industry) != ''){
                page_url = pathUrl + "/api/companies/index?keyword="+keyword+"&region="+location+"&industry="+industry+"&status="+type+"&offset="+offset;
            }
            else{
                page_url = pathUrl + "/api/companies/index/status/"+type+"/offset/" + offset;   
            }
            // page_url = pathUrl + "/api/companies/index/offset/" + offset +"/status/"+status;
            paginatedEmployers = getJSONDoc(page_url);

            loadEmployers(paginatedEmployers, containerSelector, badgeSelector, status);
        });
       
    }

    function loadAllCompanies(){
        /** Loading adn Paginating All employers */
        var active_employers = getJSONDoc(pathUrl + "/api/companies/index/status/active");
        var inactive_employers = getJSONDoc(pathUrl + "/api/companies/index/status/inactive");
        var review_employers = getJSONDoc(pathUrl + "/api/companies/index/status/review");

        var activeEmpSelector = $("#active-employers-container");
        var inactiveEmpSelector = $("#inactive-employers-container");
        var reviewEmpSelector = $("#review-emp-container");

        var paginateActSelector = $('#active-emp-pagination');
        var paginateIncSelector = $('#inactive-emp-pagination');
        var paginateRevSelector = $('#review-emp-pagination');

        var badgeActSelector = $('.admin-active-emp-badge');
        var badgeIncSelector = $('.admin-inactive-emp-badge');
        var badgeRevSelector = $('.admin-review-emp-badge');
       
        /** Load companies*/

        
        paginateData(active_employers, activeEmpSelector, paginateActSelector, badgeActSelector, "active");    
        paginateData(inactive_employers, inactiveEmpSelector, paginateIncSelector, badgeIncSelector, "inactive");
        paginateData(review_employers, reviewEmpSelector, paginateRevSelector, badgeRevSelector, "review"); 
    }

    loadAllCompanies();

    /** END */


    /** Search Public companies */
    



    $(document).on("click", "#btn-admin-search-emp", function(){
        
        type = $(this).data('scope');
        var url = '';

        if(type == "active")
        {
            industry = $("#filter-industry-active option:selected").val();
            location = $("#filter-location-active option:selected").val();
            keyword = $('#admin-search-employers-active').val();
        }
        if(type == "inactive")
        {
            industry = $("#filter-industry-inactive option:selected").val();
            location = $("#filter-location-inactive option:selected").val();
            keyword = $('#admin-search-employers-inactive').val();
        }
        //console.log(keyword + "||" + location +"||"+industry)
        if(keyword != '' && location == '' && industry =='')
        {   
            url = pathUrl + "/api/companies/index?keyword="+keyword+"&status="+type;
        }
        else if((keyword && location) != '' && industry =='')
        {
            url = pathUrl + "/api/companies/index?keyword="+keyword+"&region="+location+"&status="+type;
        }
        else if((keyword && industry) != '' && location =='')
        {
            url = pathUrl + "/api/companies/index?keyword="+keyword+"&industry="+industry+"&status="+type;
        }
        else if((industry && location) != '' && keyword =='')
        {
            url = pathUrl + "/api/companies/index?industry="+industry+"&region="+location+"&status="+type;
        }
        else if(location != '' && keyword == '' && industry == '')
        {
            url = pathUrl + "/api/companies/index?region="+location+"&status="+type;
        }
        else if(industry != '' && location == '' && keyword == '')
        {
            url = pathUrl + "/api/companies/index?industry="+industry+"&status="+type;
        }
        else if((keyword && location && industry) != ''){
            url = pathUrl + "/api/companies/index?keyword="+keyword+"&region="+location+"&industry="+industry+"&status="+type;
        }
        else{
            url = pathUrl + "/api/companies/index/status/"+type;   
        }

        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function(data)
            {
                if(type == "active")
                {
                    paginateData(data, activeEmpSelector, paginateActSelector, badgeActSelector, "active");
                }
                else
                {
                    paginateData(data, inactiveEmpSelector, paginateIncSelector, badgeIncSelector, "inactive");
                }
            },
            error: function(){

            }
        });

    });

    // Set Active / Inactive Employers
    var emp_ids = [];
    

    $("input[name=select-all-admin-active-employers]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-active-employer]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-active-employer]").each(function (index) {
                $(this).prop("checked", false);
            });
      }

    });

    $("input[name=select-all-admin-inactive-employers]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-inactive-employer]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-inactive-employer]").each(function (index) {
                $(this).prop("checked", false);
            });
      }

    });

    $("input[name=select-all-admin-review-employers]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-review-employer]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-review-employer]").each(function (index) {
                $(this).prop("checked", false);
            });
      }

    });

    $(document).on("click", "#btn-admin-set-active-employers, #btn-admin-set-inactive-employers", function(){
        
        var action = $(this).data('action');
        var scope = $(this).data('scope');
        var url = pathUrl + "/api/companies/"+action.toLowerCase();

        if(scope == "active")
        {
            emp_ids = [];

            $("input[name = select-admin-active-employer]").each(function(index){
                if($(this).is(":checked"))
                {
                    var employer_id = $(this).data("id");
                    emp_ids.push(employer_id);
                }
            });
        }
        if(scope == "inactive")
        {
            emp_ids = [];

            $("input[name = select-admin-inactive-employer]").each(function(index){
                if($(this).is(":checked"))
                {
                    var employer_id = $(this).data("id");
                    emp_ids.push(employer_id);
                }
            });
        }
        if(scope == "review"){

            emp_ids = [];

            $("input[name = select-admin-review-employer]").each(function(index){
                if($(this).is(":checked"))
                {
                    var employer_id = $(this).data("id");
                    emp_ids.push(employer_id);
                }
            });
        }     

        if(emp_ids.length != 0)
        {
            if(emp_ids.length == 1)
            {
                $.confirm({
                    icon: ' ',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: ' ',
                    content: 'Set this company as '+action+'?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {
                                //console.log(emp_ids);
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data:{
                                        id : emp_ids,
                                    },
                                    success: function(data){

                                        $("input[name=select-all-admin-active-employers], input[name=select-all-admin-inactive-employers]").prop("checked",false);// unchecked header checkbox
                                        loadAllCompanies();

                                        $.notify({
                                            title: " ",
                                            message: "<i class='fa fa-check-circle'></i> "+data.message,

                                        },{
                                            type: "success",
                                            delay: 1200,
                                            animate: {
                                               enter: 'animated fadeIn',
                                               exit: 'animated fadeOut'
                                            },
                                            
                                        });

                                        
                                    },
                                    error:function(XMLHttpRequest, textStatus, errorThrown){ 
                                        console.log(errorThrown);
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
                    content:'Set these company as '+action+'?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {
                                
                                $.ajax({
                                    type: 'POST',
                                    url: url,
                                    dataType: 'JSON',
                                    data:{
                                        id : emp_ids,
                                    },
                                    success: function(data){
                                        console.log(data);
                                        //reload();

                                        $("input[name=select-all-admin-active-employers], input[name=select-all-admin-inactive-employers]").prop("checked",false);// unchecked header checkbox
                                       
                                        $.notify({
                                            title: " ",
                                            message: "<i class='fa fa-check-circle'></i> "+data.message,

                                        },{
                                            type: "success",
                                            delay: 1200,
                                            animate: {
                                                enter: 'animated fadeIn',
                                                exit: 'animated fadeOut'
                                            },
                                           
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
                title: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>Please check at least 1 Company</small></h6> ",
                message: "",

            },{
                type: "danger",
                animate: {
                    enter: 'animated bounceInRight',
                    exit: 'animated bounceOutRight'
                }
            });
        }

    });

    $(document).on("click", "#btn-admin-add-to-featured", function(){
        emp_ids = [];

        $("input[name = select-admin-active-employer]").each(function(index){
            if($(this).is(":checked"))
            {
                var employer_id = $(this).data("id");
                emp_ids.push(employer_id);
            }
        });


        if(emp_ids.length != 0){
            $("#dynamicModal").modal("show");
        }else{
            $.notify({
                title: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>Please check at least 1 Company</small></h6> ",
                message: "",

            },{
                type: "danger",
                animate: {
                    enter: 'animated bounceInRight',
                    exit: 'animated bounceOutRight'
                }
            });
        }
    });

    $(document).on('shown.bs.modal', '#dynamicModal', function (evt) {
        var html = '';

        $(this).find('#ref').removeClass('modal-sm');
        $(this).find('.modal-body').html("");     


        html += '<div id="add-featured-company">'; 
           
            
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
            $(this).find('.btn-primary').attr('id', 'save-to-featured-company');

    });

    $(document).on("click", "#save-to-featured-company", function(){
        var ids = emp_ids;
        var duration = $("#add-featured-company select[name=duration]").val();
        var data = {ids:ids, duration:duration};  
        
        $.ajax({
            url: App.apiUrl+'/admin/featured_companies',
            type: 'POST',
            data:{
                id: ids,
                duration: duration,
            },
            dataType:"JSON",
            success: function(data){

                if(data.status == true)
                {
                    $("#dynamicModal").modal('hide');

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

    $(document).on("click", "#btn-delete-acct", function (){
        emp_ids = [];

        $("input[name = select-admin-inactive-employer]").each(function(index){
            if($(this).is(":checked"))
            {
                var employer_id = $(this).data("id");
                emp_ids.push(employer_id);
            }
        });
        console.log(emp_ids)
        $.confirm({
            icon: ' ',
            alignMiddle: true,
            columnClass: 'col-md-4',   
            title: ' ',
            content: 'Delete employer(s) account ?',
            buttons: {
                confirm: {
                    btnClass: 'btn-success btn-materialize btn-materialize-sm',
                    action: function () {

                        $.ajax({
                            url: App.apiUrl + "/companies/accounts",
                            type: 'DELETE',
                            dataType: 'JSON',
                            data:{
                                id : emp_ids,
                            },
                            success: function(data){

                                        $("input[name=select-admin-inactive-employers], input[name=select-all-admin-inactive-employers]").prop("checked",false);// unchecked header checkbox
                                        loadAllCompanies();

                                        $.notify({
                                            title: " ",
                                            message: "<i class='fa fa-check-circle'></i> "+data.message,

                                        },{
                                            type: "success",
                                            delay: 1200,
                                            animate: {
                                               enter: 'animated fadeIn',
                                               exit: 'animated fadeOut'
                                           },

                                       });

                                        
                                    },
                                    error:function(XMLHttpRequest, textStatus, errorThrown){ 
                                        console.log(errorThrown);
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