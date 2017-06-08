$(function(){
    var path = window.location.pathname;
    var seg = path.split('/');
    var temp = window.location.href;
    var urlSegment = temp.split('/');
    var urlParams = urlSegment[urlSegment.length -1]; //[urlSegment.length -2 ] to access tge 2nd to the last index
    var jobsContainer = $("#recommended-jobs");
     var category = getCookie("_uc");
   
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
        	$("#total-jobs").html(jobs.length);
            $.each(jobs, function(index, item){
                var html = '';
                var salary = (item.salary != 0)? '₱'+item.salary :'Not available';
                var uri = encodeURIComponent(item.company);
                var temp = item.position.replace(/\//g, '');
                var job_title_uri = temp.replace(/\s+/g, '-').toLowerCase();

                html += '<div class="box box-widget">';
                    html += '<div class="box-header with-border">';
                            html += '<div class="job-title-container"><h6 class="job-title" style="margin-bottom:0;"><a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'">'+item.position+'</a></h6></div>';
                        html += '<div class="job-date-info">';
                            html += '<p><small class="text-muted"><strong>Posted</strong>: '+moment(item.open_date).format('MMMM D, YYYY')+' ('+moment(item.open_date).fromNow()+')</small></p>';
                            html += '<p><small class="text-muted"><strong>Deadline</strong>: '+moment(item.due_date).format('MMMM D, YYYY')+ '</small></p>';
                        html += '</div>';
                    html += '</div>';
                    html += '<div class="box-body">';
                        html += '<div class="row">';
                            html += '<div class="col-md-8" style="margin-bottom:1rem;">';
                                html += '<p><a href="'+App.pathUrl + '/company/'+uri+'-'+item.cid+'" target="'+item.company+'-'+item.cid+'"><small><strong>'+item.company+'</strong></small></a></p>';
                                html += '<p><small>' + item.location + '</small></p>';
                                html += '<p style="color:#cc6969;"><small>' + salary + '</small></p>'; 
                                html += '<div class="row">';
                                    html += '<div class="dashboard-btn-group">';
                                        html += '<a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'" class="btn btn-primary btn-materialize btn-materialize-sm">See Details</a>';
                                    html += '</div>';  
                                           
                                html += '</div>';              
                            html += '</div>';
                            html += '<div class="col-md-4">';
                                html += '<div class="company-logo-container">';
                                    html += '<img src="'+item.company_logo+'" alt="'+item.company+' logo" class="img-fluid"/>';
                                html += '</div>';  
                            html += '</div>';
                        html += '</div>';
                    html += '</div>';
                  
                html += '</div>';

                containerSelector.append(html);
            });
        }
        else
        {
            var html = '';
            html += '<div class="box box-widget">';
                html += '<div class="box-body">';
                    html += '<center><h6 class="text-muted"><i>No corresponding Jobs.</i></h6></center';
                html += '</div>';
            html += '</div>';     
            containerSelector.html(html);
        }
    }

  	function paginateData(jobs, containerSelector)
    {
        loadJobs(jobs, jobsContainer);

        var limit = (jobs.data != 0)? jobs[0]['limit'] : jobs.limit;
        var totalJobs = (jobs.data != 0)? jobs[0]['totalFiltered']: jobs.totalFiltered;
        var temp_pages = Math.ceil( totalJobs / limit);
        var pages = (temp_pages == 0)? 1 : temp_pages;

        $('#recommended-jobs-pagination').bootpag({
            total: pages,
            page: 1,
            maxVisible: 5,
            leaps: true
        }).off().on("page", function(event, num){
                offset = (num - 1) * limit;
                
                page_url = App.apiUrl + '/jobs?ec='+category+'&offset='+offset+"&limit=10";
                paginatedJobs = getJSONDoc(page_url);

                loadJobs(paginatedJobs, jobsContainer);
        });
        
    }

   
   	
    getData(App.apiUrl + "/jobs?ec="+category+"&limit=10", function(data){
    	paginateData(data);
    });
});