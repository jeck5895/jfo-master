$(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
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

    function loadApplicants(applicants)
    {   
        $("#total-applicants").text(applicants.length);
        $("#public-applicants-container").html("");
        if(applicants.data != 0)
        {
            
            $("#public-applicant-badge").html(applicants[0].totalRecords);
            $("#public-applicant-badge").css("background-color","rgb(154, 30, 30)");

             
        
            $.each(applicants, function(index, item){
                var html = '';
                var desired_positions ='';

                html += '<div class="list-group-item">';
                                html += '<div class="box-app">';
                                    //FOR ADDING PROSPECT APPLICANT
                                     html += '<div class="box-header">';
                                    //     html += '<label class="custom-control custom-checkbox">';
                                    //         html += '<input type="checkbox" class="custom-control-input" name="app_ckb">';
                                    //         html += '<span class="custom-control-indicator"></span>';
                                    //         html += '<span class="custom-control-description"></span>';
                                    //     html += '</label>';
                                    html += '</div>';
                                    //END
                                    html += '<div class="col-xs-12 col-md-3" style="padding:0;">';
                                        html += '<div class="info-container">';
                                            html += '<div class="user-image">';
                                                html += '<img src="'+item.profile_img+'" class="img-fluid" alt="User Image">';
                                            html += '</div>';
                                            html += '<div class="user-info fs-12" style="margin-left: 8px!important;">';
                                                
                                                // html += '<label class="user-name"><a href="#profileModal" id="view_app_profile" data-toggle="modal" data-target="#profileModal" data-aid="'+item.id+'">'+item.first_name+" "+item.last_name+'</a></label>  ';
                                                html += '<label class="user-name"><a href="'+App.pathUrl+'/applicants/'+item.id+'" target="'+item.id+'">'+item.first_name+" "+item.last_name+'</a></label>';
                                                html += '<ul class="list-unstyled">';
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
                                            html += "<center><i><small>"+app_name.ucfirst()+" doesn't have work history.</small></i></center>";
                                        }
                                    html += '</div>';
                                html += '</div>';
                           
                        
                html += '</div>';    
                
                $("#public-applicants-container").append(html);
            });
        }
        else
        {
            var html = '';
            html += '<div class="box box-widget">';
                html += '<div class="box-body">';
                   html += '<div class="empty-message-box text-center">';
                        html += '<h5 class="header"> No applicant(s) found</h5>';
                    html += '</div>';
                html += '</div>';
            html += '</div>';
            $("#public-applicants-container").append(html);
        }
    }

    function paginateData(applicants)
    {
        loadApplicants(applicants);
        var limit = (applicants.data != 0)? applicants[0]['limit'] : applicants.limit;
        var totalFiltered = (applicants.data != 0)? applicants[0]['totalFiltered'] : applicants.totalFiltered;
        var temp_pages = Math.ceil(totalFiltered / limit);
        var pages = (temp_pages == 0)? 1 : temp_pages;


        $('#app-pagination').bootpag({
            total: pages,
            page: 1,
            maxVisible: 5,
            leaps: true
        }).off().on("page", function(event, num){
            offset = (num - 1) * limit;
            var page_url = "";

            if(keyword != '' && location == '' && category =='')
            {   
                page_url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&offset=" + offset;
            }
            else if((keyword && location) != '' && category =='')
            {
                page_url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location+"&offset=" + offset;
            }
            else if((keyword && category) != '' && location =='')
            {
                page_url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&category="+category+"&offset=" + offset;
            }
            else if((category && location) != '' && keyword =='')
            {
                page_url = pathUrl + "/api/applicants/profiles?category="+category+"&region="+location+"&offset=" + offset;
            }
            else if(location != '' && keyword == '' && category == '')
            {
                page_url = pathUrl + "/api/applicants/profiles?region="+location+"&offset=" + offset;
            }
            else if(category != '' && location == '' && keyword == '')
            {
                page_url = pathUrl + "/api/applicants/profiles?category="+category+"&offset=" + offset;
            }
            else if((keyword && location && category) != ''){
                page_url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location+"&category="+category+"&offset=" + offset;
            }
            else{
                page_url = pathUrl + "/api/applicants/profiles?offset=" + offset;   
            }

            paginatedApplicants = getJSONDoc(page_url);

            loadApplicants(paginatedApplicants);
        });
        
    }

    /** Loading adn Paginating All Applicants */
    var public_applicants = getJSONDoc(pathUrl + "/api/applicants/profiles");

    paginateData(public_applicants);    
    /** END */


    /** Search Public Applicants */

    $("#search-public-applicants").on("keyup", function(){
        
        keyword = $(this).val();

        if(keyword == "")
        {
            $.ajax({
                type: "GET",
                url: pathUrl + "/api/applicants/profiles",
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
            url = pathUrl + "/api/applicants/profiles?keyword="+keyword;
        }
        else if((keyword && location) != '' && category =='')
        {
            url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location;
        }
        else if((keyword && category) != '' && location =='')
        {
            url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&category="+category;
        }
        else if((category && location) != '' && keyword =='')
        {
            url = pathUrl + "/api/applicants/profiles?category="+category+"&region="+location;
        }
        else if(location != '' && keyword == '' && category == '')
        {
            url = pathUrl + "/api/applicants/profiles?region="+location;
        }
        else if(category != '' && location == '' && keyword == '')
        {
            url = pathUrl + "/api/applicants/profiles?category="+category;
        }
        else if((keyword && location && category) != ''){
            url = pathUrl + "/api/applicants/profiles?keyword="+keyword+"&region="+location+"&category="+category;
        }
        else{
            url = pathUrl + "/api/applicants/profiles";   
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
        location = ""; category=""; keyword="";

        $.ajax({
            type: "GET",
            url: pathUrl + "/api/applicants/profiles",
            dataType: "JSON",
            success: function(data)
            {
                paginateData(data);
            },
            error: function(){

            }
        });

    });
});