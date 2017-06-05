//alterntive function instead of using dataTable

$(function () { 

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

    function loadPendingJobsTable(jobs)
    {
    	var html = "";
    	$("#approval_job_table tbody").html("");

    	if(jobs.length != 0)
    	{
    		$.each(jobs, function(index, item){
    			html += "<tr>";
    				html += "<td>";
    					html += "<label class='custom-control custom-checkbox'>";
		    			html += "<input type='checkbox' class='custom-control-input' name='select-pending-job'>";
		    			html += "<span class='custom-control-indicator'></span>";
		    			html += "<span class='custom-control-description'></span>";
		    			html += "</label>";
	    			html += "</td>";
	    			html += "<td>"+item.position+"</td>";
	    			html += "<td>"+item.vacancies+"</td>";
	    			html += "<td>"+moment(item.open_date).format('MMMM D, YYYY')+"</td>";
	    			html += "<td>"+moment(item.due_date).format('MMMM D, YYYY')+"</td>";
	    			html += "<td>"+moment(item.date_created).format('MMMM D, YYYY')+"</td>";
	    			html += "<td> </td>";
    			html += "</tr>";
    		});

    		$("#approval_job_table tbody").append(html);
    	}   
    }

    function paginateData(jobs)
    {
    	loadPendingJobsTable(jobs);

        var limit = (jobs.data != 0)? jobs[0]['limit'] : jobs.limit;
        var totalJobs = (jobs.data != 0)? jobs[0]['totalFiltered']: jobs.totalFiltered;
        var temp_pages = Math.ceil( totalJobs / limit);
        var pages = (temp_pages == 0)? 1 : temp_pages;

        console.log('total: '+totalJobs+"; limit: "+limit)

        $('#jobs-pagination').bootpag({
            total: pages,
            page: 1,
            maxVisible: 5,
            leaps: true
        }).on("page", function(event, num){
                offset = (num - 1) * limit;
                
                page_url = (parameters == null)? url+'?offset='+offset: url+'&offset='+offset;
                paginatedJobs = getJSONDoc(page_url);

                loadJobs(paginatedJobs, jobsCanvas);
        });
    }
    
    getData(App.apiUrl + '/companies/jobs?status=pending', function(jobs){
    	paginateData(jobs);
    });
});