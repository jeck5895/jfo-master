 $(function () {  

 	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var App = {
        
        pathUrl : window.location.protocol + "//" + window.location.host + "/" + seg[1],
        apiUrl : window.location.protocol + "//" + window.location.host +"/"+seg[1]+"/api"
    }
    var jobDescStatus = false;
    var method = seg[4];
    var job_id = seg[6];
    var url = (seg[4] == "edit")? App.apiUrl + '/jobs/edit/id/'+job_id : App.apiUrl + '/jobs';
   
    /** Initializing CKEDITOR */
    var jobdesc = CKEDITOR.replace( 'jobDescription',{
        toolbar: "basic",
        wordcount : {
            showCharCount : true,
            showWordCount : true,

            // maxWordCount: 300,
            countSpacesAsChars: true,
            maxCharCount: 6000,
        }
    });

    //validate ckeditor on load
    CKEDITOR.on('instanceReady', function() { 
        
        var content = jobdesc.document.getBody().getText();
        var count = content.length;
        console.log(count)
        $("#char-count").text(count);

        if(content.length >= 150)
        {
            jobDescStatus = true;
            $("#char-label").css("color","#5cb85c");
            $("#char-count").css("color","#5cb85c");
            $("#cke_jobDescription").tooltip("dispose");
            $("#cke_jobDescription").css("border","1px solid #d1d1d1");
            $("#cke_jobDescription").css("box-shadow","0px 0px 0px 0px rgba(0,0,0,0)");
        }
        else if(content.length < 150){
            jobDescStatus = false;
            $("#cke_jobDescription").css("border","1px solid #d1d1d1");
            $("#cke_jobDescription").css("box-shadow","0px 0px 0px 0px rgba(0,0,0,0)");
        } 
    });
    

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

    function populateForm()
    {
        var job = getJSONDoc(App.apiUrl+'/jobs/full_details?job_id='+job_id);
        var jobCategories = getJSONDoc(pathUrl + "/api/jobs/categories");
        //repopulate the  select box 
        $.each(jobCategories, function(index, item){
            $('select[name=jobCategory]').append('<option value="'+item.id+'">'+item.category_name+' </option>');

        });
        //then assign the selected index
        $("select[name=jobCategory] option").filter(function(e){
            var temp = $.trim($(this).text());

            return temp == job.category;
            
        }).prop('selected', true);

        $("select[name=gender] option").filter(function(e){
            var temp = $.trim($(this).val());

            return temp == job.gender_requirement;
            
        }).prop('selected', true);

        $("select[name=civilStatus] option").filter(function(e){
            var temp = $.trim($(this).val());

            return temp == job.civil_status_requirement;
            
        }).prop('selected', true);

        $("select[name=jobDuration] option").filter(function(e){
            var temp = $.trim($(this).val());

            return temp == job.duration;
            
        }).prop('selected', true);

        $("select[name=educationalAttainment] option").filter(function(e){
            var temp = $.trim($(this).val());

            return temp == job.education_requirement;
            
        }).prop('selected', true);        

        if(job.show_salary != 1){
            $("input[name = displaySalary]").prop("checked", false);
        }

        $("input[name = jobTitle]").val(job.position);
        $("input[name = permanentAddress]").val(job.location);
        $("input[name = salary1]").val(job.salary_range1);
        $("input[name = salary2]").val(job.salary_range2);
        $("input[name = jobVacancy]").val(job.vacancies);
        $("input[name = add_requirements]").val(job.preferred_course);
        $("input[name=permanentAddress]").data('region', job.region_id);
        $("input[name=permanentAddress]").data('city', job.city_id)
        CKEDITOR.instances.jobDescription.setData(job.job_description);
    }
   
    
    if(seg[4] == "edit")
    {
        populateForm();
    }

    CKEDITOR.instances.jobDescription.on('change', function(e) {
        var self = this;    
        //var text = self.getData(); // html format
        
        setTimeout(function() {
            var content = self.document.getBody().getText();
            var count = content.length;
            $("#char-count").text(count);

            if(content.length >= 150)
            {
                jobDescStatus = true;
                $("#char-label").css("color","#5cb85c");
                $("#char-count").css("color","#5cb85c");
                $("#cke_jobDescription").tooltip("hide");
                $("#cke_jobDescription").css("border","1px solid #d1d1d1");
                $("#cke_jobDescription").css("box-shadow","0px 0px 0px 0px rgba(0,0,0,0)");
            }
            else if(content.length < 150){
                jobDescStatus = false;
                $("#cke_jobDescription").css("border","1px solid #d1d1d1");
                $("#cke_jobDescription").css("box-shadow","0px 0px 0px 0px rgba(0,0,0,0)");
            } 
        }, 10);
    }); 
    /**
        JOB POST 
        Fields with complex names (brackets, dots) just add quote "" to those names for validation
    */
    $('#create-job-post-form').validate({
        ignore: '.ignore', 
        onkeyup: false,
        rules:{
            jobTitle:{
                required: true
            },
            permanentAddress:{
                required: true
            },
            jobCategory:{
                required:true
            },
            jobVacancy:{
                required:true,
                min:1
            },
            jobDescription:{
                // required: true,
                // minlength:150
                // required: function(textarea) {
                //     CKEDITOR.instances.jobDescription.updateElement(); // update textarea
                //     var editorcontent = textarea.value.replace(/<^>*>/gi, ''); // strip tags
                //     return editorcontent.length === 0;
                //     console.log(editorcontent)
                // }
            },
            salary1:{
                required: true,
            },
            salary2:{
                required: true,
                salaryIsValid: true
            }
        },
        messages:{
            jobTitle: {
                required: "<i class='fa fa-exclamation-circle'></i> Job Title is required",
            },      
            permanentAddress:{
                required: "<i class='fa fa-exclamation-circle'></i> Job Location is required",
            },
            jobCategory:{
                required: "<i class='fa fa-exclamation-circle'></i> Job Category is required",
            },
            jobVacancy:{
                required: "<i class='fa fa-exclamation-circle'></i> Job Vacancy can't be empty",
                min: "<i class='fa fa-exclamation-circle'></i> There should be at least 1 vacancy for this position "
            },
            jobDescription:{
                required: "<i class='fa fa-exclamation-circle'></i> Job Description can't be empty",
                minlength: "<i class='fa fa-exclamation-circle'></i> There should be at least 150 characters for Job Description"
                   
            },
            salary1:{
                required: "<i class='fa fa-exclamation-circle'></i> This field is required"
            },
            salary2:{
                required: "<i class='fa fa-exclamation-circle'></i> This field is required"
            }
        },
        tooltip_options:{
            jobTitle:{
                trigger: 'focus',
                placement: 'right',
                html: true,

            },
            permanentAddress:{
                trigger: 'focus',
                placement: 'right',
                minlength: 5,
                html: true
            },
            jobCategory:{
                trigger: 'focus',
                placement: 'right',
                html: true,

            },
            jobVacancy:{
                trigger: 'focus',
                placement: 'left',
                html: true,
            },
            // jobExpiration:{
            //     trigger: 'focus',
            //     placement: 'right',
            //     html: true,
            // },
            jobDescription:{
                trigger: 'focus',
                placement: 'right',
                html: true,
            },
            salary1:{
                trigger: 'focus',
                placement: 'top',
                html: true,
            },
            salary2:{
                trigger: 'focus',
                placement: 'top',
                html: true,
            }  
        },
    
        submitHandler:function(form){
            var jobTitle = $("input[name=jobTitle]").val();
            var location =  $('input[name=permanentAddress]').data('region');
            var city = $('input[name=permanentAddress]').data('city');
            var jobCategory = $( "select[name=jobCategory] option:selected" ).val();
            var salary1 = $("input[name=salary1]").val();
            var salary2 = $("input[name=salary2]").val();
            var salaryStatus = ($("input[name=displaySalary]").is(":checked"))? 1 : 0;
            var jobVacancy = $("input[name=jobVacancy]").val();
            var jobDuration = $("select[name=jobDuration] option:selected" ).val();
            var educAttainment = $("select[name=educationalAttainment] option:selected" ).val();;
            var addRequirements = $("input[name=add_requirements]").val();
            var gender = $("select[name=gender] option:selected").val();
            var civilStatus = $("select[name=civilStatus] option:selected").val();
            //var jobDesc = tinyMCE.get('job-description').getContent();//html format
            // var jobDescTextFormat = tinyMCE.get('job-description').getContent({format:'text'}); tinymce get textarea content
            var jobDesc = CKEDITOR.instances.jobDescription.getData();
            

            if(jobDescStatus != false)
            {
                $("#submit").prop("disabled", true);
                $("#submit").append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Saving...</span>');
              
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data:
                    {
                        job_id: job_id,
                        jobTitle: jobTitle,
                        location: location,
                        city: city,
                        jobCategory: jobCategory,
                        salary1: salary1,
                        salary2: salary2,
                        salaryStatus: salaryStatus,
                        jobVacancy: jobVacancy,
                        jobDuration: jobDuration,
                        educAttainment: educAttainment,
                        addRequirements: addRequirements,
                        jobDesc: jobDesc,
                        gender: gender,
                        civilStatus: civilStatus
                    },
                    success: function (data) {
                
                        $.notify({
                            title: " ",
                            message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6> ",

                        },{
                            type: "success",
                            animate: {
                                enter: 'animated fadeIn',
                                exit: 'animated fadeOut'
                            },
                        });

                        $("#submit").prop("disabled", false);
                        $("#submit").html('Save Post');
                        
                        if(seg[4] == "create")
                        {
                            $("#create-job-post-form")[0].reset();
                            $("#job-role").html('');
                            CKEDITOR.instances.jobDescription.setData('');
                        }
                        console.log(data);
                    },
                    error: function(jqXHR, exception){
                        console.log(jqXHR);
                    }
                });
            }
            else{
                //ckeditor job description validation
                $("#cke_jobDescription").css("border","1px solid #d9534f");
                $("#cke_jobDescription").css("box-shadow","0px 0px 5px 1px rgba(217,83,79,1)");
                $("#cke_jobDescription").tooltip({
                    title: "<i class='fa fa-exclamation-circle'></i> There should be at least 150 characters for Job Description",
                    html: true,
                    placement: "left"
                });
                $("#cke_jobDescription").tooltip("show");
            }
        }    
    }); 
   

    /** 
        Additional Validation method
    */
    jQuery.validator.addMethod("dateValueIsValid", function(value, element){
        var currentDate = new Date().toISOString().slice(0, 10);
        var inputDate = new Date(value).toISOString().slice(0, 10);

        return  (inputDate > currentDate)? true: false;
        
        // console.log(inputDate +"||"+ currentDate);
    }, jQuery.validator.format("<i class='fa fa-exclamation-circle'></i> The date you specified has already passed."));

    jQuery.validator.addMethod("salaryIsValid", function(value, element){
        var salary2 = parseFloat(value);    
        var salary1 = parseFloat($('input[name=salary1]').val());
        // console.log(salary2 +"||"+ salary1);
        return  (salary2 > salary1)? true: false;
    }, jQuery.validator.format("<i class='fa fa-exclamation-circle'></i> Salary range is incorrect!"));

    /** 
            Other Initialization
    */

    $('.custom-checkbox').on("mouseenter",function(){
        $("#displaySalary").popover('show');
    });

    $('.custom-checkbox').on("mouseleave",function(){
        $("#displaySalary").popover('hide');
    });
    
   

    ///NOTES

    //save to localstorage
     //     var jobPost = {
            //         jobTitle: jobTitle,
            //         location: location,
            //         city: city,
            //         jobCategory: jobCategory,
            //         jobRole: jobRole,
            //         salary1: salary1,
            //         salary2: salary2,
            //         salaryStatus: salaryStatus,
            //         jobVacancy: jobVacancy,
            //         jobDuration: jobDuration,
            //         educAttainment: educAttainment,
            //         addRequirements: addRequirements,
            //         jobDesc: jobDesc
            //     }
            //     db.insert("jp",jobPost);
            //     db.commit();
     /**
        Initialize tinyMCE 
    */
    // tinymce.init({
    //     selector: '[name=jobDescription]',
    //     browser_spellcheck: true,
    //     height: 300,
    //     theme: 'modern',
    //     menubar: false,
    //     plugins: [
    //     'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    //     'searchreplace wordcount visualblocks visualchars code fullscreen',
    //     'insertdatetime media nonbreaking save table contextmenu directionality',
    //     'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
    //     ],
    //     toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
    //     toolbar2: 'browse preview | forecolor backcolor emoticons | codesample',
    //     image_advtab: true,
    //     content_css: [
    //     '//fonts.googleapis.com/css?family=Quicksand:300,300i,400,400i',
    //     '//www.tinymce.com/css/codepen.min.css'
    //     ],
    //     setup: function(editor) {
    //         editor.on('keyup', function(e) {
    //             var content = e.currentTarget.innerText;
    //             var count = content.length;
    //             console.log(count);
    //             $("#char-count").text(count);
    //             // console.log("count:"+count);
    //             if(content.length > 150)
    //             {   
    //                 jobDescStatus = true;
    //                 $("#mceu_23-body").tooltip("hide");
    //                 $("#mceu_23-body").css("border","0");
    //                 $("#char-label").css("color","#5cb85c");
    //                 $("#char-count").css("color","#5cb85c");
    //             }
    //             else if(content.length < 150){
    //                 $("#char-label").css("color","red");
    //                 $("#char-count").css("color","red");
    //             }
    //         });
    //     }
    // });

    /** ------------END OF INITIALIZATION---------------*/
    //  $("#test").on("click", function(){
    //    // CKEDITOR.instances.jobDescription.setData('');
    //    // $(this).prop('disabled',false);
    //    // $(this).append('<i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Loading...</span>');
    //    $("#permanentAddress" ).data( "test", "pizza");
    //    //console.log(rid +", "+cid)
    // });
 });	