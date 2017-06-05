$(document).ready(function(){
	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
 	var current_url = window.location.href; 
    var userAction;
   
 	var App = {
        
        pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api"
    }

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

    function setHeight() {
        windowHeight = $(window).innerHeight();
        $('.wrapper').css('min-height', windowHeight);
    };

    setHeight();

    $(window).resize(function() {
        setHeight();
        
    });

    switch (document.readyState) {
        
        case "loading":
            break;
        case "interactive":
        
            setTimeout(function(){
                $('#load').css('visibility','hidden');
                // document.getElementById('load').style.visibility="hidden";
            },1000);
         
            break;
        case "complete":
            setTimeout(function(){
                $('#load').css('visibility','hidden');
                //document.getElementById('load').style.visibility="hidden";
            },100);
            console.log("complete")
            break;
    }
    console.log(document.readyState)
    var db = new localStorageDB("jfo", localStorage); 

    $(document).on('click', "ul.home.navbar-nav a",function(e) {
        var hash = this.hash;
        var hash_links = ["#home","#partners","#about-us","#contact-us"];

        pos = $(this.hash).offset().top -10;
        console.log(hash)
        $('html, body').animate({
            scrollTop: pos
        }, 1000, function(){

            window.location.hash = hash;
        }); 
    });


    $('.dataTables_info, .dataTables_paginate').addClass('fs-13');

    $('ul.navbar-nav li a[href="'+ current_url +'"]').addClass('active');
    $('ul.sidebar-nav li a[href="'+ current_url +'"]').addClass('active'); // addd active class to to current url

    $('ul.dashboard-menu > li > a[href="'+ window.location.href +'"]').addClass('active');

    $('.dashboard-menu a').each(function(){
        if($(this).hasClass('active')){
            $('.dashboard-menu').parent().parent().collapse('show');
        }
    });

    $('.maintenance-menu > li > a[href="'+ window.location.href +'"]').addClass('active');
    $('.maintenance-menu a').each(function(){
        if($(this).hasClass('active')){
            $('.maintenance-menu').parent().parent().collapse('show');
        }
    });

    $("#collapseSidebar").on("show.bs.collapse, shown.bs.collapse", function(){
        $("#sidebar-nav-collapse").addClass("active");
    });

    $("#collapseSidebarMaintenance").on("show.bs.collapse, shown.bs.collapse", function(){
        $("#sidebar-nav-collapse-maintenance").addClass("active");
    });

    $("#collapseSidebar").on("hide.bs.collapse", function(){
        $("#sidebar-nav-collapse").removeClass("active");
    });

    $("#collapseSidebarMaintenance").on("hide.bs.collapse", function(){
        $("#sidebar-nav-collapse-maintenance").removeClass("active");
    });

    $('.collapse').on('shown.bs.collapse', function(){
        $(this).parent().find(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
    }).on('hidden.bs.collapse', function(){
        $(this).parent().find(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
    });

    $(".jobrole").select2({
		placeholder: "",
        allowClear: true,
        maximumSelectionSize: 10,
	});

    $(".province").select2({
       placeholder:"Search Job via Location",
       allowClear: true,
       dropdownParent: $('body')
    });

    $('.select2-selection__placeholder').css('font-style','italic');
    $('.select2-container .select2-selection--single').addClass('select2-form-control');
    
    $('select[name=filter-category], select[name=filter-industry], select[name=filter-position], select[name=filter-status]').css({'font-style':'italic','color':'#999','font-family':'Montserrat'});
    $('select[name=filter-category], select[name=filter-industry], select[name=filter-position], select[name=filter-status]').on('click',function(){    
        var $this = $(this);
        $('option', $this).after().css({'font-style':'normal','color':'#464a4c'});
    });

    $("select[name=filter-category], select[name=filter-industry], select[name=filter-position], select[name=filter-status]").on("change", function(){
        if($(this).val() != ''){
            $(this).css({'font-style':'normal','color':'#464a4c'});
        }
        else{
            $(this).css({'font-style':'italic','color':'#999','font-family':'Montserrat'});
              
        }
        category = $(this).val();   
    });

    

	$('#phone').inputmask();
	$('#landline').inputmask();
	
	$("#modal-btn").on( "click", function() {
		$("#myModal").modal("show");
	});
	$(".filestyle").filestyle();

    $(document).on('show.bs.tab', '#jobseekers-tab, #employers-tab', function (evt) {
        $(this).attr('class', 'fadeInLeftBig');
    });

	$("#notification-box").fadeTo(1500, 1500).slideUp(1500, function () {
      $("#notification-box").alert('close');
   });

    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeIn();
    });

    $('.dropdown').on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeOut();
    });
    
    $(".carousel-control-prev").hover(function(){
           
            $(".carousel-control-prev-icon").css("background-image", "url('"+pathUrl+"/assets/images/app/Slider_Arrow_L_Hovered.png')");
            $(".carousel-control-prev-icon").css("transition-property", "background-image");
            $(".carousel-control-prev-icon").css("transition", "1s ease");

            $(".carousel-control-prev-icon-sm").css("background-image", "url('"+pathUrl+"/assets/images/app/L_small_hover.png')");
            $(".carousel-control-prev-icon-sm").css("transition-property", "background-image");
            $(".carousel-control-prev-icon-sm").css("transition", "1s ease");
        }, function(){
            $(".carousel-control-prev-icon").css("transition-property", "background-image");
            $(".carousel-control-prev-icon").css("transition", "1s ease");
            $(".carousel-control-prev-icon").css("background-image", "url('"+pathUrl+"/assets/images/app/Slider_Arrow_L_Neutral.png')");
            
            $(".carousel-control-prev-icon-sm").css("transition-property", "background-image");
            $(".carousel-control-prev-icon-sm").css("transition", "1s ease");
            $(".carousel-control-prev-icon-sm").css("background-image", "url('"+pathUrl+"/assets/images/app/L_small.png')");
    });

    $(".carousel-control-next").hover(function(){
            $(".carousel-control-next-icon").css("background-image", "url('"+pathUrl+"/assets/images/app/Slider_Arrow_R_Hovered.png')");
            $(".carousel-control-next-icon").css("transition-property", "background-image");
            $(".carousel-control-next-icon").css("transition", "1s ease");

            $(".carousel-control-next-icon-sm").css("background-image", "url('"+pathUrl+"/assets/images/app/R_small_hover.png')");
            $(".carousel-control-next-icon-sm").css("transition-property", "background-image");
            $(".carousel-control-next-icon-sm").css("transition", "1s ease");
        }, function(){
            $(".carousel-control-next-icon").css("transition-property", "background-image");
            $(".carousel-control-next-icon").css("transition", "1s ease");
            $(".carousel-control-next-icon").css("background-image", "url('"+pathUrl+"/assets/images/app/Slider_Arrow_R_Neutral.png')");

            $(".carousel-control-next-icon-sm").css("transition-property", "background-image");
            $(".carousel-control-next-icon-sm").css("transition", "1s ease");
            $(".carousel-control-next-icon-sm").css("background-image", "url('"+pathUrl+"/assets/images/app/R_small.png')");
    });


    //for populating select boxes employer and index
	var regions = getJSONDoc(pathUrl +"/api/location/regions");
    var categories = getJSONDoc(pathUrl + "/api/jobs/categories");
    var industries = getJSONDoc(pathUrl + "/api/companies/industries");

    $.each(regions, function(index, item){
        $("select[name = province]").append("<option value="+item.id+">"+item.region_name+"</option>");
        $("select[name = filter-location]").append("<option value="+item.id+">"+item.region_name+"</option>");
    });

    $.each(categories, function(index, item){
        $("select[name = filter-category]").append("<option value="+item.id+">"+item.category_name+"</option>");
        $('select[name=jobCategory]').append('<option value="'+item.id+'">'+item.category_name+' </option>');
    });

    $.each(industries, function(index, item){
        $("select[name = filter-industry]").append("<option value="+item.id+">"+item.industry_name+"</option>");
    });
    
    $("#c-search-form").submit(function(e){
        e.preventDefault();
        var keyword = $("input[name = c-keyword]").val();

        if(keyword == '')
        {
            window.location = App.pathUrl + "/jobs";
        }
        else{
            window.location = App.pathUrl + "/jobs?keyword="+keyword;   
        }
    });

    $(document).on("click focus", "input[name=permanent-address], input[name=permanentAddress]", function(){
        userAction = "setAddress";
        $('#dynamicModal').modal('show');
        $('#dynamicModal').on('shown.bs.modal', function (evt) {
            
            $(this).find('.modal-title').text("Select address");
            var provinceID = $("option:selected", $("select[name = province]")).val();
            
            $.ajax({
                type: 'GET',
                url: pathUrl + "/api/location/cities/rid/"+provinceID,
                dataType: 'json',
                success: function(data){
                    $('#city').empty();
                    $.each(data, function(index, item){
                        $('#city').append('<option value="'+item.id+'"> '+item.city_name+'</option>');
                    //console.log(item);
                });
                },
                error:function(){ 
                    console.log('error');
                }
            });
        });
    });

    $(document).on("click", "#save", function(){
        if(userAction == "setAddress"){
            var province = $("option:selected", $("select[name=province]")).text();
            var municipality = $("option:selected", $("select[name=city]")).text();
            var rid = $("option:selected", $("select[name=province]")).val();
            var cid = $("option:selected", $("select[name=city]")).val();

            $("input[name=permanentAddress], input[name=permanent-address]").val(municipality+","+province);
            $("input[name=permanentAddress]").data('region', rid);
            $("input[name=permanentAddress]").data('city', cid);
            $("input[name=region_id]").val(rid);
            $("input[name=city_id]").val(cid);
            $('#dynamicModal').modal('hide');
        }
    });

    $('select[name=province]').on("change",function(){

        var provinceID = $("option:selected", this).val();
        
        $.ajax({
            type: 'GET',
            url: pathUrl + "/api/location/cities/rid/"+provinceID,
            dataType: 'json',
            success: function(data){
                //console.log(data)
                $('#city').empty();
                $.each(data, function(index, item){
                    $('#city').append('<option value="'+item.id+'"> '+item.city_name+'</option>');
                    
                });
            },
            error:function(){ 
                console.log('error');
            }
        });             
    });

    $('select[name=jobCategory]').change(function(){
        var cid = $("option:selected", this).val();
        $.ajax({
            type: 'GET',
            url: pathUrl + "/api/jobs/positions/cid/"+cid,
            dataType: 'json',
            success: function(data){
                $('#job-role').empty();
                $.each(data, function(index, item){
                    $('#job-role').append('<option value="'+item.id+'"> '+item.name+'</option>');
                });
            },
            error:function(){ 
                console.log('error');
            }
        });             
    });
});
