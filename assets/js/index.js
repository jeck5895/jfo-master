$(function(){

    var path = window.location.pathname;
    var seg = path.split('/');
    var temp = window.location.href;
    var urlSegment = temp.split('/');
    var urlParams = urlSegment[urlSegment.length -1]; //[urlSegment.length -2 ] to access tge 2nd to the last index
    var jobsCanvas = $("#jobs-container");
    var App = {
        
        pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api/jobs"
    }
    var keyword = '';
    var location = '';
    var category = '';
    var parameters = getQueryParams(window.location.href);
    var url = (parameters == null)? App.apiUrl+'/jobs?&limit=10' :  App.apiUrl+'/jobs'+window.location.search+"&limit=10";
    var key = '';  

    console.log(window.location.search)
    window.onpopstate = function(e){
        if(e.state){
            jobsCanvas.html(e.state.html);
            document.title = e.state.id;
        }

        console.log(e.state)
    };


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

    function getQueryParams(url)
    {
        var url_query_params = url.split("?");
        var total_param = null;
        var query_parameter = []
        
        if(url_query_params.length === 1)
        {
            // return total_param;
            console.log(total_param)
        }
        else{
            var temp_params =  url ? url.split('?')[1] : window.location.search.slice(1);
            var parameters = temp_params.split("&");
            var key = [];
           
            $.each(parameters, function(index, item){
                temp = item.split("=");
                key.push(temp);
                
            });
            // console.log(JSON.stringify(key))
            console.log(parameters)
            return parameters;
            // return total_param = parameters.length;
        }
    }
    
    function loadJobs(jobs, selector)
    {   
       if(jobs.data != 0)
       {
            $("#total-jobs").text(jobs[0]['totalJobs'] +' total jobs');
            
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
                            html += '<div class="col-xs-12  col-md-4 job-info">';
                                html += '<h6 class="job-title"><a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'">'+item.position+'</a></h6>';
                    
                                html += '<p><a href="'+App.pathUrl + '/companies/'+uri+'-'+item.cid+'" target="'+item.company+'-'+item.cid+'"><small><strong>'+item.company+'</strong></small></a></p>';
                                html += '<p><small>' + item.location + '</small></p>';
                                html += '<p style="color:#cc6969;"><small>' + salary + '</small></p>';

                                html += '<a href="'+App.pathUrl+'/jobs/details/'+job_title_uri+'/'+item.id+'" target="'+item.id+'" class="btn btn-info btn-materialize btn-materialize-sm" style="margin-top:0.3125rem;">See More Details</a>';
                            html += '</div>';
                            html += '<div class="col-md-6">';
                                html += '<small><p class="job-description"> '+item.job_description+'</p></small>';
                            html += '</div>';
                            html += '<div class="col-xs-12 col-md-2 logo-box hidden-md-down">';
                                html += '<div class="company-logo-container">';
                                    html += '<a href="'+App.pathUrl + '/companies/'+uri+'-'+item.cid+'" target="'+item.company+'-'+item.cid+'">';
                                        html += '<img src="'+item.company_logo+'" alt="'+item.company+' logo" class="img-fluid"/>';
                                    html += '</a>';
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
       else{
            var html = '<div class="py-7"><center><h6 class="text-muted">No job(s) found.</h6></center></div>';
                      
            jobsCanvas.html("").append(html);
       }
    }

    function paginateData(jobs)
    {
        var limit = (jobs.data != 0)? jobs[0]['limit'] : jobs.limit;
        var totalJobs = (jobs.data != 0)? jobs[0]['totalFiltered']: jobs.totalFiltered;
        var temp_pages = Math.ceil( totalJobs / limit);
        var pages = (temp_pages == 0)? 1 : temp_pages;

        $('#jobs-pagination').bootpag({
            total: pages,
            page: 1,
            maxVisible: 5,
            leaps: true
        }).off().on("page", function(event, num){
                offset = (num - 1) * limit;
                
                //page_url = (parameters == null)? url+'?offset='+offset: url+'&offset='+offset;
                if(keyword != '' && location == '' && category =='')
                {   
                    url = App.pathUrl + "/api/jobs?keyword="+keyword+"&offset="+offset+"&limit=10";
                }
                else if((keyword && location) != '' && category =='')
                {
                    url = App.pathUrl + "/api/jobs?keyword="+keyword+"&reg="+location+"&offset="+offset+"&limit=10";
                }
                else if((keyword && category) != '' && location =='')
                {
                    url = App.pathUrl + "/api/jobs?keyword="+keyword+"&category="+category+"&offset="+offset+"&limit=10";
                }
                else if((category && location) != '' && keyword =='')
                {
                    url = App.pathUrl + "/api/jobs?category="+category+"&reg="+location+"&offset="+offset+"&limit=10";
                }
                else if(location != '' && keyword == '' && category == '')
                {
                    url = App.pathUrl + "/api/jobs?reg="+location+"&offset="+offset+"&limit=10";
                }
                else if(category != '' && location == '' && keyword == '')
                {
                    url = App.pathUrl + "/api/jobs?category="+category+"&offset="+offset+"&limit=10";
                }
                else if((keyword && location && category) != ''){
                    url = App.pathUrl + "/api/jobs?keyword="+keyword+"&reg="+location+"&category="+category+"&offset="+offset+"&limit=10";
                }
                else{
                    url = App.pathUrl + "/api/jobs?limit=10"+"&offset="+offset;   
                }
                paginatedJobs = getJSONDoc(url);

                loadJobs(paginatedJobs, jobsCanvas);
        });
    }
     
    var jobs = getJSONDoc(url);
    loadJobs(jobs, jobsCanvas);
    paginateData(jobs);
    
    if(parameters != null) //check if there are url query string
    {

        key = parameters[0].split("=");
        keyword = decodeURIComponent(key[1].replace(/\+/g, ' '));
        if(key[0] == 'keyword'){
            $("#search-jobs").val(decodeURIComponent(key[1].replace(/\+/g, ' ')));
        }
    }       

    /** Search Function */
    

    $("#search-jobs").on("keyup", function(){
        
        keyword = $(this).val();
    });

    $("select[name=filter-location]").on("change", function(){
        location = $(this).val();
    });

    $("select[name=filter-category]").on("change", function(){
        category = $(this).val();
    });


    $("#btn-i-search").on("click", function(){

        if(keyword != '' && location == '' && category =='')
        {   
            url = App.pathUrl + "/api/jobs?keyword="+keyword+"&limit=10";
        }
        else if((keyword && location) != '' && category =='')
        {
            url = App.pathUrl + "/api/jobs?keyword="+keyword+"&reg="+location+"&limit=10";
        }
        else if((keyword && category) != '' && location =='')
        {
            url = App.pathUrl + "/api/jobs?keyword="+keyword+"&category="+category+"&limit=10";
        }
        else if((category && location) != '' && keyword =='')
        {
            url = App.pathUrl + "/api/jobs?category="+category+"&reg="+location+"&limit=10";
        }
        else if(location != '' && keyword == '' && category == '')
        {
            url = App.pathUrl + "/api/jobs?reg="+location+"&limit=10";
        }
        else if(category != '' && location == '' && keyword == '')
        {
            url = App.pathUrl + "/api/jobs?category="+category+"&limit=10";
        }
        else if((keyword && location && category) != ''){
            url = App.pathUrl + "/api/jobs?keyword="+keyword+"&reg="+location+"&category="+category+"&limit=10";
        }
        else{
            url = App.pathUrl + "/api/jobs?limit=10";   
        }

        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function(data)
            {
                var new_url = url.replace("/api","");
                
                history.pushState({id: document.title}, '', new_url);
                
                loadJobs(data, jobsCanvas);
                paginateData(data);
            },
            error: function(){

            }
        });

    });

    $("#btn-clear-filter").on("click", function(){
       
        $("select[name=filter-category], select[name=filter-location], #search-public-applicants").val("");
        $("select[name=filter-location]").val('').trigger('change');
        $("#search-jobs").val('');
        location = ""; category=""; keyword="";

        $.ajax({
            type: "GET",
            url: App.apiUrl + "/jobs?limit=10",
            dataType: "JSON",
            success: function(data)
            {
                loadJobs(data, jobsCanvas);
                paginateData(data);
                var temp = url.substring(0, url.indexOf('?'));
                var new_url = temp.replace("/api/jobs","");
                
                history.pushState({id: document.title}, '', new_url);
               
            },
            error: function(){

            }
        });
    });

});