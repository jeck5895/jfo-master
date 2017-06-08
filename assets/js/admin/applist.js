$(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var currentPath = '/'+seg[2]+'/'+seg[3]+'/'+seg[4];
    var reviewSelector = $("#for-review-applicants-container");
    var paginateRevSelector = $('#review-app-pagination');
    var badgeRevSelector = $('.admin-review-badge');

    var publicSelector = $("#public-applicants-container");
    var paginatePubSelector = $('#public-app-pagination');
    var badgePubSelector = $('.admin-public-badge');

    var privateSelector = $("#private-applicants-container");
    var paginatePriSelector = $('#private-app-pagination');
    var badgePriSelector = $('.admin-private-badge');

    var inactiveSelector = $("#inactive-applicants-container");
    var paginateIncSelector = $('#inactive-app-pagination');
    var badgeIncSelector = $('.admin-inactive-badge');

    /** Search Public Applicants */
    var keyword = '';
    var location =  '';
    var category = '';

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

    function loadApplicants(applicants, selector, badgeSelector, type)
    {   
        if(applicants.data != 0)
        {
            selector.html("");   
            badgeSelector.html(applicants[0].totalRecords);
            // badgeSelector.css("background-color","rgb(154, 30, 30)");

             
        
            $.each(applicants, function(index, item){
                var html = '';
                var fname = item.first_name.toLowerCase();
                
                html += '<div class="list-group-item">';

                    html += '<div class="box-app">';
                        html += '<div class="box-header">';
                            html += '<label class="custom-control custom-checkbox">';
                                html += '<input type="checkbox" class="custom-control-input" name="select-admin-'+type+'-applicant" data-id="'+item.id+'" data-app-name="'+fname+'">';
                                html += '<span class="custom-control-indicator"></span>';
                                html += '<span class="custom-control-description"></span>';
                            html += '</label>';
                        html += '</div>';

                        html += '<div class="col-xs-12 col-md-3" style="padding:0;">';
                            html += '<div class="info-container fs-12">';
                                html += '<div class="user-image">';
                                    html += '<img src="'+item.profile_img+'" class="img-fluid" alt="User Image">';
                                html += '</div>';
                                html += '<div class="user-info" style="margin-left: 8px!important;">';

                                    html += '<label class="user-name"><a href="'+App.pathUrl+'/applicants/'+item.id+'" target="'+item.id+'">'+item.first_name+" "+item.last_name+'</a></label>  ';
                                    html += '<ul class="list-unstyled mb-1">';
                                        html += '<li>'+item.gender+' '+item.age+' y/o</li>';
                                        html += '<li ><i class="fa fa-map-marker"></i> '+item.address+'</li>';
                                        html += '<li>'+item.mobile+'</li>';
                                    html += '</ul>';
                                    
                                html += '</div>';
                            html += '</div>';
                            
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

                        html += '<div class="col-xs-12 col-md-4 hidden-sm-down" style="position:relative;">';
    
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
                            html += "<center><i><small>"+app_name.ucfirst()+" doesn't have work history.</small></i></center>";
                        }
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
          
                   html += '<div class="empty-message-box text-center">';
                        html += '<h5 class="header"> No applicants found</h5>';
                    html += '</div>';
        
            selector.html("").append(html);
        }
    }

    function paginateData(applicants, containerSelector, paginateSelector, badgeSelector, type)
    {
        loadApplicants(applicants, containerSelector, badgeSelector, type);
        
        var limit = (applicants.data != 0)? applicants[0]['limit'] : applicants.limit;
        var totalFiltered = (applicants.data != 0)? applicants[0]['totalFiltered'] : applicants.totalFiltered;
        var temp_pages = Math.ceil(totalFiltered / limit);
        var pages = (temp_pages == 0)? 1 : temp_pages;

        paginateSelector.bootpag({
            total: pages,
            page: 1,
            maxVisible: 5,
            leaps: true
        }).off().on("page", function(event, num){
            offset = (num - 1) * limit;
            var page_url = "";


            if(keyword != '' && location == '' && category =='')
            {   
                page_url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&type="+type+"&offset=" + offset;
            }
            else if((keyword && location) != '' && category =='')
            {
                page_url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location+"&type="+type+"&offset=" + offset;
            }
            else if((keyword && category) != '' && location =='')
            {
                page_url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&category="+category+"&type="+type+"&offset=" + offset;
            }
            else if((category && location) != '' && keyword =='')
            {
                page_url = pathUrl + "/api/applicants/profiles?category="+category+"&region="+location+"&type="+type+"&offset=" + offset;
            }
            else if(location != '' && keyword == '' && category == '')
            {
                page_url = pathUrl + "/api/applicants/profiles?region="+location+"&type="+type+"&offset=" + offset;
            }
            else if(category != '' && location == '' && keyword == '')
            {
                page_url = pathUrl + "/api/applicants/profiles?category="+category+"&type="+type+"&offset=" + offset;
            }
            else if((keyword && location && category) != ''){
                page_url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location+"&category="+category+"&type="+type+"&offset=" + offset;
            }
            else{
                page_url = pathUrl + "/api/applicants/profiles?offset=" + offset +"&type="+type+"&offset=" + offset;  
            }

            paginatedApplicants = getJSONDoc(page_url);

           loadApplicants(paginatedApplicants, containerSelector, badgeSelector, type);
        });
        
    }

    function loadApplicantsList()
    {
        switch(currentPath){
            case "/admin/applicants/for-review":

                var review_applicants = getJSONDoc(pathUrl + "/api/applicants/profiles?type=review");
                paginateData(review_applicants, reviewSelector, paginateRevSelector, badgeRevSelector, "review");
            break;

            case "/admin/applicants/public":
                var public_applicants = getJSONDoc(pathUrl + "/api/applicants/profiles?type=public");
                paginateData(public_applicants, publicSelector, paginatePubSelector, badgePubSelector, "public");
            break;

            case "/admin/applicants/private":
                var private_applicants = getJSONDoc(pathUrl + "/api/applicants/profiles?type=private");        
                paginateData(private_applicants, privateSelector, paginatePriSelector, badgePriSelector, "private");
            break;

            case "/admin/applicants/inactive":
                var inactive_applicants = getJSONDoc(pathUrl + "/api/applicants/profiles?type=inactive");
                paginateData(inactive_applicants, inactiveSelector, paginateIncSelector, badgeIncSelector, "inactive");
            break;
        };
    }


    /** Loading and Paginating All Applicants */
    loadApplicantsList();


   
    $(document).on("click", "#btn-admin-search-app", function(){
       
        var type = $(this).data('scope');
        var url = '';

        if(type == "review")
        {
            // category = $("#filter-category-review option:selected").val();
            // location = $("#filter-location-review option:selected").val();
            keyword = $('#admin-search-applicants-review').val();
        }
        if(type == "public")
        {
            // category = $("#filter-category-public option:selected").val();
            // location = $("#filter-location-public option:selected").val();
            keyword = $('#admin-search-applicants-public').val();
        }
        if(type == "private")
        {
            category = $("#filter-category-private option:selected").val();
            location = $("#filter-location-private option:selected").val();
            keyword = $('#admin-search-applicants-private').val();
        }
        if(type == "inactive")
        {
            // category = $("#filter-category-inactive option:selected").val();
            // location = $("#filter-location-inactive option:selected").val();
            keyword = $('#admin-search-applicants-inactive').val();
        }

        if(keyword != '' && location == '' && category =='')
        {   
            url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&type="+type;
        }
        else if((keyword && location) != '' && category =='')
        {
            url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location+"&type="+type;
        }
        else if((keyword && category) != '' && location =='')
        {
            url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&category="+category+"&type="+type;
        }
        else if((category && location) != '' && keyword =='')
        {
            url = pathUrl + "/api/applicants/profiles?category="+category+"&region="+location+"&type="+type;
        }
        else if(location != '' && keyword == '' && category == '')
        {
            url = pathUrl + "/api/applicants/profiles?region="+location+"&type="+type;
        }
        else if(category != '' && location == '' && keyword == '')
        {
            url = pathUrl + "/api/applicants/profiles?category="+category+"&type="+type;
        }
        else if((keyword && location && category) != ''){
            url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location+"&category="+category+"&type="+type;
        }
        else{
            url = pathUrl + "/api/applicants/profiles?type="+type;   
        }

        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function(data)
            {
                if(type == "review")
                {
                    //loadApplicants(data, reviewSelector, badgeRevSelector, "review");
                    paginateData(data, reviewSelector, paginateRevSelector, badgeRevSelector, "review");
                }
                else if(type == "public")
                {
                    //loadApplicants(data, publicSelector, badgePubSelector, "public");
                    paginateData(data, publicSelector, paginatePubSelector, badgePubSelector, "public");
                }
                else if(type == "private")
                {
                    //loadApplicants(data, privateSelector,  badgePriSelector, "private");
                    paginateData(data, privateSelector, paginatePriSelector, badgePriSelector, "private");
                }
                else
                {
                    //loadApplicants(data, inactiveSelector, badgeIncSelector, "inactive");
                    paginateData(data, inactiveSelector, paginateIncSelector, badgeIncSelector, "inactive");
                }
            },
            error: function(){

            }
        });

    });

    // Set Active / Inactive Applicants
    var app_ids = [];

    $("input[name=select-all-admin-review-applicants]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-review-applicant]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-review-applicant]").each(function (index) {
                $(this).prop("checked", false);
            });
      }

    });

    $("input[name=select-all-admin-public-applicants]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-public-applicant]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-public-applicant]").each(function (index) {
                $(this).prop("checked", false);
            });
      }

    });

    $("input[name=select-all-admin-private-applicants]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-private-applicant]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-private-applicant]").each(function (index) {
                $(this).prop("checked", false);
            });
      }

    });

    $("input[name=select-all-admin-inactive-applicants]").on('click', function () {
      
      if ($(this).is(':checked')) {
            $("input[name=select-admin-inactive-applicant]").each(function (index) {
                $(this).prop("checked", true);
            });
      } else {
            $("input[name=select-admin-inactive-applicant]").each(function (index) {
                $(this).prop("checked", false);
            });
      }

    });

    $(document).on("click", "#btn-set-active-applicants, #btn-set-inactive-applicants",function(){
        
        var action = $(this).data('action');
        var classification = $(this).data('title');
        var url = pathUrl + "/api/applicants/set_"+action.toLowerCase();
        
        // app_ids = [];

        if(classification == "review")
        {
            app_ids = [];

            $("input[name = select-admin-review-applicant]").each(function(index){
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    app_ids.push(applicant_id);
                }
            });
            
        }
        else if(classification == "public")
        {
            app_ids = [];

            $("input[name = select-admin-public-applicant]").each(function(index){
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    app_ids.push(applicant_id);
                }
            });
            
        }
        else if(classification == "private")
        {
            app_ids = [];

            $("input[name = select-admin-private-applicant]").each(function(index){
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    app_ids.push(applicant_id);
                }
            });

        }
        else{
            app_ids = [];

            $("input[name = select-admin-inactive-applicant]").each(function(index){
                if($(this).is(":checked"))
                {
                    var applicant_id = $(this).data("id");
                    app_ids.push(applicant_id);
                }
            });
            
        }

        //console.log(app_ids.length)
        if(app_ids.length != 0)
        {
            if(app_ids.length == 1)
            {
                $.confirm({
                    icon: ' ',
                    alignMiddle: true,
                    columnClass: 'col-md-4',   
                    title: ' ',
                    content: 'Set this applicant as '+action+'?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {
                                //console.log(app_ids);
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data:{
                                        id : app_ids,
                                    },
                                    success: function(data){
                                        //reload();

                                        $("input[name=select-all-admin-public-applicants], input[name=select-all-admin-private-applicants], input[name=select-all-admin-review-applicants], input[name=select-all-admin-inactive-applicants]").prop("checked",false);// unchecked header checkbox

                                        $.notify({
                                            title: " ",
                                            message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6>",

                                        },{
                                            type: "success",
                                            delay: 1200,
                                            animate: {
                                                enter: 'animated fadeIn',
                                                exit: 'animated fadeOut'
                                            },
                                            // onClose: function(){
                                            //     setTimeout(function() {
                                            //         window.location.reload();
                                            //     }, 500);
                                            // }
                                        });

                                        loadApplicantsList();
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
                    content: 'Set these applicants as '+action+'?',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-success btn-materialize btn-materialize-sm',
                            action: function () {
                                console.log(app_ids)
                                $.ajax({
                                    type: 'POST',
                                    url: url,
                                    dataType: 'JSON',
                                    data:{
                                        id : app_ids,
                                    },
                                    success: function(data){

                                        $("input[name=select-all-admin-applicants]").prop("checked",false);// unchecked header checkbox

                                        $.notify({
                                            title: " ",
                                            message: "<i class='fa fa-exclamation-triangle'></i>&nbsp"+data.message,

                                        },{
                                            type: "success",
                                            delay: 1200,
                                            animate: {
                                                enter: 'animated fadeIn',
                                                exit: 'animated fadeOut'
                                            },
                                            // onClose: function(){
                                            //     setTimeout(function() {
                                            //         window.location.reload();
                                            //     }, 500);
                                            // }
                                        });
                                        loadApplicantsList();
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
                title: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>Please check at least 1 Applicant</small></h6> ",
                message: "",

            },{
                type: "danger",
                animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOut'
                }
            });
        }
    });

    $(document).on("click", "#btn-delete-acct", function (){
        app_ids = [];

        $("input[name = select-admin-inactive-applicant]").each(function(index){
            if($(this).is(":checked"))
            {
                var applicant_id = $(this).data("id");
                app_ids.push(applicant_id);
            }
        });

        if(app_ids.length != 0)
        {   
            $.confirm({
                icon: ' ',
                alignMiddle: true,
                columnClass: 'col-md-4',   
                title: ' ',
                content: 'Delete applicant account(s)?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success btn-materialize btn-materialize-sm',
                        action: function () {

                            $.ajax({
                                url: App.apiUrl+"/applicants/accounts",
                                type: 'DELETE',
                                dataType: 'JSON',
                                data:{
                                    id : app_ids,
                                },
                                success: function(data){


                                    $("input[name=select-all-admin-public-applicants], input[name=select-all-admin-private-applicants], input[name=select-all-admin-review-applicants], input[name=select-all-admin-inactive-applicants]").prop("checked",false);// unchecked header checkbox

                                    loadApplicantsList();
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
            $.notify({
                title: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>Please check at least 1 Applicant</small></h6> ",
                message: "",

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

