$(function () {  

 	var path = window.location.pathname;
    var seg = path.split('/');
    var temp = window.location.href;
    var urlSegment = temp.split('/');
    var urlParams = (window.location.search == "")? urlSegment[urlSegment.length -1]: urlSegment[urlSegment.length -2];
    var jobsCanvas = $("#jobs-container");
    

    var App = {
        
        pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api"
    }

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

    function loadJobs(jobs, selector)
    {   
       if(jobs.data != 0)
       {    
            selector.html("");
                
            $.each(jobs, function(index, item){
                var html = '';
                var salary = (item.salary != 0)? '₱'+item.salary :'Not available';
                var uri = encodeURIComponent(item.company);
                var temp = item.position.replace(/\//g, '');
                var job_title_uri = temp.replace(/\s+/g, '-').toLowerCase();

                html += '<div class="box box-widget jobs-container">';
                    html += '<div class="box-body">';
                        html += '<div class="row">';
                            html += '<div class="col-xs-6  col-md-3 job-info">';
                                html += '<h6 class="job-title"><a  href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'">'+item.position+'</a></h6>';
                    
                                html += '<p><a href="'+App.pathUrl + '/companies/'+uri+'-'+item.cid+'" target="'+item.company+'-'+item.cid+'"><small><strong>'+item.company+'</strong></small></a></p>';
                                html += '<p><small>' + item.location + '</small></p>';
                                html += '<p style="color:#cc6969;"><small>' + salary + '</small></p>';

                                html += '<a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'" class="btn btn-info btn-sm" style="margin-top:0.3125rem;">See More Details</a>';
                            html += '</div>';
                            html += '<div class="col-md-6 hidden-sm-down">';
                                html += '<small><p class="job-description"> '+item.job_description+'</p></small>';
                            html += '</div>';
                            html += '<div class="col-xs-3 col-md-3 logo-box">';
                                html += '<div class="company-logo-container">';
                                    html += '<img src="'+item.company_logo+'" alt="'+item.company+' logo" class="img-fluid"/>';
                                html += '</div>';
                                html += '<p><small class="text-muted"><strong>Posted</strong>: '+moment(item.open_date).format('MMMM D, YYYY')+' ('+moment(item.open_date).fromNow()+')</small></p>';
                                html += '<p><small class="text-muted"><strong>Until</strong>: '+moment(item.due_date).format('MMMM D, YYYY') + '</small></p>'; 
                                   
                            html += '</div>';
                        html += '</div>';
                    html += '</div>';   
                html += '</div>';

                selector.append(html);
            });
       }
    }


    function loadJobDetails(job)
    {
    
        if(job.status != false && job.status == 1)
        {
            var html = ' <button id="btn-action" data-method="withdraw" data-vid="'+job.vid+'" class="btn btn-warning btn-materialize btn-materialize-sm">Withdraw Application to this Job</button> ';

            
            $("#app-option").html("").append(html);
        }
        
        if(job.status != false && job.status == 2)
        {
            var html = ' <button id="btn-action" data-method="reapply" data-vid="'+job.vid+'" class="btn btn-primary btn-sm">Re-submit Application</button> ';
            
            $("#app-option").html("").append(html);
        }

        if(job.status != false && job.status == 3)
        {
            var html = '<label class="text-info"> Application still under review</label> ';
            
            $("#app-option").html("").append(html);
        }

        if(job.status != false && job.status == 4)
        {
            var html = '<label class="text-danger"> Application not considered</label> ';

            $("#app-option").html("").append(html);
        }

        if(job.status != false && job.status == 5)
        {
            var html = '<label class="text-success"><i class="fa fa-handshake-o"></i> For Interview</label> ';
            
            $("#app-option").html("").append(html);
        }

        
        var salary = (job.salary != 0)?'Salary: ₱'+job.salary:'<i class="fa fa-money" aria-hidden="true"></i> Salary not available';
        // display job details
        $("#job-opendate").html(moment(job.open_date).format('MMMM D, YYYY')+' ('+moment(job.open_date).fromNow()+')');
        $("#job-duedate").html(moment(job.due_date).format('MMMM D, YYYY'));
        $("#job-title").text(job.position);
        $("#company").html(job.company);
        $("#company").attr('href', App.pathUrl + '/companies/'+job.company+'-'+job.cid);
        $("#company").attr('target', job.company+'-'+job.cid);
        $("#location").html(job.location);
        $("#salary").html(salary);
        $("#job-category").text(job.category);
        $("#job-vacancy").text(job.vacancies);
        $("#educ-qualification").text(job.education_requirement);
        $("#preferred-course").text(job.course);
        $("#job-description").html(job.job_description);
        $("#company-details").html(job.company_details);
        $("#company-logo").attr('src', job.company_logo);
        $("#company-logo").attr('alt', job.company+' logo');
        document.title = job.position;
    }

    var job = getJSONDoc(App.apiUrl+'/jobs?job_id='+urlParams);

    loadJobDetails(job);

    //filtering jobs based on category
    getData(App.apiUrl+'/jobs?category='+job.cat_id+'&ex='+job.id+"&limit=3", function(jobs){
        loadJobs(jobs, jobsCanvas);
    });

    //For Applying job
    
    $(document).on("click", "#btn-apply", function(){
        $.ajax({
            type: "POST",
            url: App.apiUrl+"/jobs/apply",
            dataType: "JSON",
            data:{
                job_id:job.id
            },
            success:function(data){
               if(data.status == true)
               {
                    $("#app-option").html("").append(' <button id="btn-action" data-method="withdraw" data-job-id="'+job.id+'" class="btn btn-warning btn-materialize btn-materialize-sm">Withdraw Application to this Job</button> ');
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
                }
            },
            error:function(){

            }
        });
    });

    $(document).on("click", "#btn-action", function(){

        var vid = $(this).attr('data-vid');
        var method = $(this).data('method');
        var prompt_message = (method == "withdraw")? method.ucfirst()+' your application to this job?' : 'Re-submit Application to this job?' ;

        $.confirm({
            icon: ' ',
            alignMiddle: true,
            columnClass: 'col-md-4',   
            title: ' ',
            content: prompt_message,
            buttons: {
                confirm: {
                    btnClass: 'btn-success',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: App.apiUrl+"/jobs/"+method,
                            dataType: "JSON",
                            data:{
                                vid:vid
                            },
                            success:function(data){
                                if(data.status == true)
                                {
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
                                        // onClose: function(){
                                        //     setTimeout(function() {
                                        //         window.location.reload();
                                        //     }, 500);
                                        // }
                                    });

                                    var job = getJSONDoc(App.apiUrl+'/jobs?job_id='+urlParams);

                                    loadJobDetails(job);
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