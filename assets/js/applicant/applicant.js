 $(document).ready(function(){  

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

 	var path = window.location.pathname;
 	var seg = path.split('/');
    var currentPath = '/'+seg[2]+'/'+seg[3]+'/'+seg[4];
 	var penPaginationSelector = $("#pending-app-pagination");
 	

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

 	function delete_cookie(name) {
 		document.cookie = name +'=; path=/'+seg[1]+'; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
 	}

 	String.prototype.ucfirst = function(){
        return this.charAt(0).toUpperCase() + this.slice(1);
    }
    
    //console.log($('ul.dashboard-menu').parent().parent())

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

    function loadJobs(jobs, containerSelector)
    {   
        if(jobs.length != 0)
        {
            containerSelector.html("");
        
            $.each(jobs, function(index, item){
                var html = '';
                var salary = (item.salary != 0)? '₱'+item.salary :'Not available';
                var uri = encodeURIComponent(item.company);
                var temp = item.position.replace(/\//g, '');
                var job_title_uri = temp.replace(/\s+/g, '-').toLowerCase();

                html += '<div class="box box-widget">';
                    html += '<div class="box-header with-border">';
                            html += '<div class="job-title-container"><h6 class="job-title" style="margin-bottom:0;"><a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'" target="'+item.id+'">'+item.position+'</a></h6></div>';
                        html += '<div class="job-date-info">';
                            html += '<p><small class="text-muted"><strong>Posted</strong>: '+moment(item.date_posted).format('MMMM D, YYYY')+' ('+moment(item.date_posted).fromNow()+')</small></p>';
                            html += '<p><small class="text-muted"><strong>Deadline</strong>: '+item.due_date + '</small></p>';
                        html += '</div>';
                    html += '</div>';
                    html += '<div class="box-body">';
                        html += '<div class="row">';
                            html += '<div class="col-md-8" style="margin-bottom:1rem;">';
                                html += '<p><a href="'+App.pathUrl + '/companies/'+uri+'-'+item.cid+'" target="'+item.company+'-'+item.cid+'"><small><strong>'+item.company+'</strong></small></a></p>';
                                html += '<p><small>' + item.location + '</small></p>';
                                html += '<p style="color:#cc6969;"><small>' + salary + '</small></p>'; 
                                html += '<div class="row">';
                                    html += '<div class="dashboard-btn-group">';
                                        html += '<a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'" target="'+item.id+'" class="btn btn-primary btn-materialize btn-materialize-sm">See Details</a>';
                                    html += '</div>';  
                                            if(item.status == 1)
                                            {
                                                html += '<div class="dashboard-btn-group">';
                                                    html += ' <button id="btn-action" data-method="withdraw" data-verification-id="'+item.vid+'" class="btn btn-secondary btn-materialize btn-materialize-sm">Withdraw Application</button> ';
                                                html += '</div>';  
                                            }
                                            else if(item.status == 2)
                                            {
                                                html += '<div class="dashboard-btn-group">';
                                                    html += ' <button id="btn-action" data-method="reapply" data-verification-id="'+item.vid+'" class="btn btn-secondary btn-materialize btn-materialize-sm">Re-Apply</button> ';
                                                html += '</div>';
                                                html += '<div class="dashboard-btn-group">';
                                                    html += ' <button id="btn-action" data-method="delete" data-verification-id="'+item.vid+'" class="btn btn-danger btn-materialize btn-materialize-sm">Delete</button> ';
                                                html += '</div>';
                                            }
                                            else if(item.status == 3)
                                            {
                                                html += '<div class="dashboard-btn-group">';
                                                    html += ' <button id="btn-action" data-method="withdraw" data-verification-id="'+item.vid+'" class="btn btn-secondary btn-materialize btn-materialize-sm">Withdraw Application</button> ';
                                                html += '</div>';
                                            }
                                            else if(item.status == 4)
                                            {
                                                html += '<div class="dashboard-btn-group">';
                                                    html += ' <button id="btn-action" data-method="delete" data-verification-id="'+item.vid+'" class="btn btn-danger btn-materialize btn-materialize-sm">Delete</button> ';
                                                html += '</div>';   
                                            }     
                                            else{
                                                html += '<div class="dashboard-btn-group">';
                                                    html += ' <button id="btn-action" data-method="withdraw" data-verification-id="'+item.vid+'" class="btn btn-secondary btn-materialize btn-materialize-sm">Withdraw Application</button> ';
                                                html += '</div>';
                                            }          
                                html += '</div>';              
                            html += '</div>';
                            html += '<div class="col-md-4">';
                                html += '<div class="company-logo-container">';
                                    html += '<img src="'+item.company_logo+'" alt="'+item.company+' logo" class="img-fluid"/>';
                                html += '</div>';  
                            html += '</div>';
                        html += '</div>';
                    html += '</div>';
                    // html += '<div class="box-footer">';
                       
                    //     html += '<small class="text-muted pull-right">Posted: '+moment(item.date_posted).format('MMMM Do YYYY, h:mm:ss a')+' ('+moment(item.date_posted).fromNow()+')</small>';
                    // html += '</div>';
                html += '</div>';

                containerSelector.append(html);
            });
        }
        else
        {
            var html = '<center><h6 class="text-muted-light">No corresponding Job Application to display.</h6></center';
        
            containerSelector.html(html);
        }
    }
    //for seen status

    $(".profile-img-overlay").hover(function(){
        $('.upload-frame-overlay').css('display','block');
    }, function(){  
        $('.upload-frame-overlay').css('display','none');
    });

  
    var pendingURL = App.apiUrl+'/applicants/application?status=1&limit=10';
    var withdrawnURL = App.apiUrl+'/applicants/application?status=2&limit=10';
    var reviewedURL = App.apiUrl+'/applicants/application?status=3&limit=10';
    var unsuccessfulURL = App.apiUrl+'/applicants/application?status=4&limit=10';
    var interviewURL = App.apiUrl+'/applicants/application?status=5&limit=10';

    function loadBadges() {
        
        rev = getJSONDoc(reviewedURL);
        uns = getJSONDoc(unsuccessfulURL);
        int = getJSONDoc(interviewURL);


        if(rev.length !=0){
            $("#review-badge").html(rev['0'].totalFiltered);
        }
        if(uns.length != 0){
            $("#reject-badge").html(uns['0'].totalFiltered);
        }
        if(int.length != 0){
            $("#interview-badge").html(int['0'].totalFiltered);
        }
    }
    
 
    /** Pending Application*/
    function loadPendingApp()
    {
        var pendingApplication = getJSONDoc(pendingURL);
        var pendingAppSelector = $("#pending-app");
        var penPaginationSelector = $("#pending-app-pagination");
       
        
        if(pendingApplication.status != false)
        {
            loadJobs(pendingApplication, pendingAppSelector);
            
            if(pendingApplication.length != 0)
            {
                var plimit = pendingApplication[0]['limit'];
                var ptotalJobs = pendingApplication[0]['totalFiltered'];
                var ptemp_pages = Math.round( ptotalJobs / plimit);
                var pPages = (ptemp_pages == 0)? 1 : ptemp_pages;

                

                penPaginationSelector.bootpag({
                    total: pPages,
                    page: 1,
                    maxVisible: 5,
                    leaps: true
                }).off().on("page", function(event, num){
                    offset = (num - 1) * plimit;
                    page_url = pendingURL +'&offset=' + offset;
                    paginatedJobs = getJSONDoc(page_url);
                    loadJobs(paginatedJobs, pendingAppSelector);
                });
            }
            else if(pendingApplication.length == 0)
            {
                $("#pending-badge").html("0");
                penPaginationSelector.html("");
            }
        }    
    }

    function loadWithdrawnApp()
    {
        var withdrawnApplication = getJSONDoc(withdrawnURL);
        var withdrawnAppSelector = $("#withdrawn-app");
        var withPaginationSelector = $("#withdrawn-app-pagination");

        if(withdrawnApplication.status != false)
        {   
            loadJobs(withdrawnApplication, withdrawnAppSelector);

            if(withdrawnApplication.length != 0)
            {
                $("#withdraw-badge").html(withdrawnApplication.length);
                var wlimit = withdrawnApplication[0]['limit'];
                var wtotalJobs = withdrawnApplication[0]['totalFiltered'];
                var wtemp_pages = Math.round(wtotalJobs / wlimit);
                var wpages = (wtemp_pages == 0)? 1: wtemp_pages;


                withPaginationSelector.bootpag({
                    total: wpages,
                    page: 1,
                    maxVisible: 5,
                    leaps: true
                }).off().on("page", function(event, num){
                    offset = (num - 1) * wlimit;
                    console.log(offset)
                    page_url = withdrawnURL +'&offset=' + offset;
                    paginatedJobs = getJSONDoc(page_url);
                    loadJobs(paginatedJobs, withdrawnAppSelector);
                });
            }
            else if(withdrawnApplication.length == 0)
            {
                $("#withdraw-badge").html("0");
               
                withPaginationSelector.html(""); 
            }
        }    
    }

    function loadReviewedApp()
    {
        var reviewedApplication = getJSONDoc(reviewedURL);
        var revAppSelector = $("#reviewed-app");
        var revPaginationSelector = $("#reviewed-app-pagination");

        if(reviewedApplication.status != false)
        {
           

            loadJobs(reviewedApplication, revAppSelector);

            if(reviewedApplication.length != 0)
            {
                $("#review-badge").html(reviewedApplication.length);
                var revlimit = reviewedApplication[0]['limit'];
                var revtotalJobs = reviewedApplication[0]['totalFiltered'];
                var revtemp_pages = Math.round( revtotalJobs / revlimit);
                var revPages = (revtemp_pages == 0)? 1 : revtemp_pages;  
               

                revPaginationSelector.bootpag({
                    total: revPages,
                    page: 1,
                    maxVisible: 5,
                    leaps: true
                }).off().on("page", function(event, num){
                    offset = (num - 1) * revlimit;
                    page_url = reviewedURL +'&offset=' + offset;
                    paginatedJobs = getJSONDoc(page_url);
                    loadJobs(paginatedJobs, revAppSelector);
                });
            }
            else if(reviewedApplication.length == 0)
            {
                $("#review-badge").html("0");
                
                revPaginationSelector.html(""); 
            }
        }   
    }

    function loadRejectedApp()
    {
        var unsuccessfulApp = getJSONDoc(unsuccessfulURL);
        var rejectAppSelector = $("#reject-app");
        var rejectPaginationSelector = $("#reject-app-pagination");

        if(unsuccessfulApp.status != false)
        {
            loadJobs(unsuccessfulApp, rejectAppSelector);

            if(unsuccessfulApp.length != 0)
            {
                $("#reject-badge").html(unsuccessfulApp.length);
                var rejlimit = unsuccessfulApp[0]['limit'];
                var rejtotalJobs = unsuccessfulApp[0]['totalFiltered'];
                var rejtemp_pages = Math.round( rejtotalJobs / rejlimit);
                var rejPages = (rejtemp_pages == 0)? 1 : rejtemp_pages;  
               

                rejectPaginationSelector.bootpag({
                    total: rejPages,
                    page: 1,
                    maxVisible: 5,
                    leaps: true
                }).off().on("page", function(event, num){
                    offset = (num - 1) * rejlimit;
                    page_url = unsuccessfulURL +'&offset=' + offset;
                    paginatedJobs = getJSONDoc(page_url);
                    loadJobs(paginatedJobs, rejectAppSelector);
                });
            }
            else if(unsuccessfulApp.length == 0)
            {
                $("#reject-badge").html("0");
                
                rejectPaginationSelector.html(""); 
            }
        }   
    }

    function loadForInterviewApp()
    {
        var interviewApp = getJSONDoc(interviewURL);
        var interviewAppSelector = $("#ivw-app");
        var interviewPaginationSelector = $("#ivw-app-pagination");

        if(interviewApp.status != false)
        {
            loadJobs(interviewApp, interviewAppSelector);

            if(interviewApp.length != 0)
            {
                $("#interview-badge").html(interviewApp.length);

                var ivwlimit = interviewApp[0]['limit'];
                var ivwtotalJobs = interviewApp[0]['totalFiltered'];
                var ivwtemp_pages = Math.round( ivwtotalJobs / ivwlimit);
                var ivwPages = (ivwtemp_pages == 0)? 1 : ivwtemp_pages;  
              
                interviewPaginationSelector.bootpag({
                    total: ivwPages,
                    page: 1,
                    maxVisible: 5,
                    leaps: true
                }).off().on("page", function(event, num){
                    offset = (num - 1) * ivwlimit;
                    page_url = interviewURL +'&offset=' + offset;
                    paginatedJobs = getJSONDoc(page_url);
                    loadJobs(paginatedJobs, interviewAppSelector);
                });
            }
            else if(interviewApp.length == 0)
            {
                $("#interview-badge").html("0");
                
                interviewPaginationSelector.html(""); 
            }
        } 
    }

    function loadNotification()
    {
        getData(App.apiUrl +"/applicants/notifications",function(data){
            var html = "";
            var new_notif = 0;
            $("#notif-list").html("");
            console.log(data);
            if(data.length != ""){
                $.each(data, function (index, item){
                    new_notif = (item.status == 1)? new_notif = new_notif + 1 : new_notif;
                    notif_class = (item.status == 1)? "new-notif" : "";
                    html += "<li class='"+notif_class+"'>";
                        html += "<a href='"+item.link+"'>";
                            html += "<div class='dropdown-item dropdown-notif-item'>";
                                html += item.notification_html;
                                html += "<p class='text-muted fs-11'>"+moment(item.date_created).format('MMMM D, YYYY')+' ('+moment(item.date_created).fromNow()+")</p>";
                            html += "</div>";    
                        html += "</a>";    
                    html += "</li>";
                });

                if(new_notif != 0){
                    $("#notif-badge").css("display","block");
                    $("#notif-badge").css("right","24px");
                    $("#notif-badge").html(new_notif);
                }

                $("#notif-list").append(html);
                
            }
            else{
                html += '<div class="dropdown-item">';
                    html += '<p class="fs-13 text-muted-light text-center">No notifications right now</p>';
                html += '</div>';

                $("#notif-list").append(html);
            }
        });
    }

    function loadAllJobs(){
        switch(currentPath){
            case "/applicant/applications/for-interview":
            loadForInterviewApp();
            break;

            case "/applicant/applications/pending":
            loadPendingApp();
            break;

            case "/applicant/applications/withdrawn":
            loadWithdrawnApp();
            break;

            case "/applicant/applications/declined":
            loadRejectedApp();
            break;

            case "/applicant/applications/reviewed":
            loadReviewedApp();
            break;
        };
    }

    function reloadJobs(){
        loadForInterviewApp();
        loadPendingApp();
        loadWithdrawnApp();
        loadRejectedApp();
        loadReviewedApp();
        loadNotification();
    }

    loadBadges();
    loadAllJobs();
    loadNotification();
    

    var pusher = new Pusher('2a2530e2a6d4fc64f74f',{
            authEndpoint: App.pathUrl + '/notification/auth',
            auth: {
              headers: {
                'X-CSRF-Token': "123456",
            },
            authTransport: 'jsonp'
        }
    });

    var notificationsChannel = pusher.subscribe("private-"+getCookie("_u"));

    notificationsChannel.bind('private-'+getCookie("_u")+'-notification', function(notification){
        
        reloadJobs();

        var message = notification.message;
        var name = notification.name;
        var redirect = function(){
            window.open(notification.link);
        };
        
        var options = {
            title: "jobfair-online.net",
            options: {
              body: message,
              icon: App.pathUrl + "/assets/images/app/jfo_logo_mini.png",
              lang: 'en-US',
              onClick: redirect
          }
      };

      $("#easyNotify").easyNotify(options);


        // $.notify({
        //     title: " ",//<strong>"+name+"</strong>
        //     message: message
        // },{
        //     type: "default",
        //     delay: 80000,
        //     placement: {
        //         from: "bottom",
        //         align: "left"
        //     },
        //     animate: {
        //         enter: 'animated fadeIn',
        //         exit: 'animated fadeOut'
        //     }
        // });
    });
    
    
    //Button Functions
    $(document).on("click", "#btn-action", function(){

        var vid = $(this).attr('data-verification-id');
        var method = $(this).data('method');
        var prompt_message = (method == "withdraw")? method.ucfirst()+' your application to this job?' : (method == "delete")? method.ucfirst()+' your application to this job?'  :'Re-apply to this job?' ;
        var resource_url = (method == "delete")? App.apiUrl+"/applicants/application_delete" :App.apiUrl+"/jobs/"+method;
        
        $.confirm({
            icon: '',
            alignMiddle: true,
            columnClass: 'col-md-4',   
            title: '',
            content: prompt_message,
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: resource_url,
                            dataType: "JSON",
                            data:{
                                vid:vid
                            },
                            success:function(data){
                                if(data.status == true)
                                {
                                    $.notify({
                                        title: " ",
                                        message: "<i class='fa fa-check-circle'></i>"+data.message,

                                    },{
                                        type: "success",
                                        delay: 1400,
                                        animate: {
                                            enter: 'animated fadeIn',
                                            exit: 'animated fadeOut'
                                        },
                                    });

                                    loadAllJobs();
                                }
                            },
                            error:function(){

                            }
                        });
                    }
                },
                cancel: function () {

                }
            }
        });
    });

 }); 	