$(document).ready(function() {

	var path = window.location.pathname;
 	var seg = path.split('/');
 	var pathUrl = window.location.protocol + "//" + window.location.host + "/" + seg[1];
    var current_url = window.location.href; 

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

    function postData(url, method, data, callback)
    {

        $.ajax({
            type: method,
            url : url,
            dataType: "JSON",
            data:data,
            success: callback,
            error:function(){
                alert("error");
            }
        });
    }

    var admin_category_table = $('#admin-category-table').DataTable({ 
            
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            "autoWidth": false,
            
            "ajax": {
                "url": pathUrl + "/admin/categories",
                "type": "POST",
                
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

    var admin_role_table = $('#admin-role-table').DataTable({ 
            
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            "autoWidth": false,
            
            "ajax": {
                "url": pathUrl + "/admin/get_job_roles",
                "type": "POST",
                
            },

            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

    var admin_religion_table = $('#admin-religion-table').DataTable({ 
            
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            "autoWidth": false,
            
            "ajax": {
                "url": pathUrl + "/admin/get_religions",
                "type": "POST",
              
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

    var admin_industry_table = $('#admin-industry-table').DataTable({ 
            
            "processing": true, 
            "serverSide": true, 
            "responsive": true,
            "autoWidth": false,
            
            "ajax": {
                "url": pathUrl + "/admin/get_industries",
                "type": "POST",
               
            },
            "language": {
                "processing": "<img src='"+pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });

    //Add Functions
    var gscope = '';
    var gid;

    $(document).on("click", "#btn-admin-add-category, #btn-admin-add-role, #btn-admin-add-religion, #btn-admin-add-industry, #btn-edit, #btn-disable", function(){

        gscope = $(this).data('scope');
        
        if($(this).attr('id') == "btn-edit")
        {
            //console.log($(this).data('id'))
            gid = $(this).data('id');
        } 

        if($(this).attr('id') == "btn-disable")
        {
            var resource;
            var id = $(this).data('id');
            switch (gscope){
                case "category": resource = "jobs/categories"; break;
                case "position": resource = "jobs/positions"; break;
                case "industry": resource = "companies/industries"; break;
                case "religion": resource = "religions"; break;
            }
            //console.log(resource)
            $.confirm({
                icon: 'fa fa-exclamation-circle',
                alignMiddle: true,
                columnClass: 'col-md-4',   
                title: 'JobFair Online says:',
                content: 'Are you sure to disable this '+gscope+ '?',
                buttons: {
                    confirm: {
                        btnClass: 'btn-success btn-materialize btn-materialize-sm',
                        action: function () {

                            $.ajax({
                                type: 'PATCH',
                                url: pathUrl + "/api/"+resource,
                                dataType: 'JSON',
                                data:{
                                    id : id,
                                    action: "disable"
                                },
                                success: function(data){
                                    if(gscope == "category"){
                                        admin_category_table.ajax.reload(null, false);
                                    }
                                    if(gscope == "position"){
                                        admin_role_table.ajax.reload(null, false);   
                                    }
                                    if(gscope == "religion"){
                                        admin_religion_table.ajax.reload(null, false);
                                    }
                                    if(gscope == "industry"){
                                        admin_industry_table.ajax.reload(null, false);
                                    }

                                    $.notify({
                                        title: " ",
                                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+data.message+"</small></h6>",

                                    },{
                                        type: "success",
                                        delay: 1200,
                                        animate: {
                                            enter: 'animated fadeIn',
                                            exit: 'animated fadeOut'
                                        }
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
    });

    $(document).on('show.bs.modal', '#dynamicModal', function (evt) {
        $('.modal .modal-dialog').attr('class', 'modal-dialog  zoomIn  animated');
    });

    $(document).on('shown.bs.modal', '#dynamicModal', function (evt) {
        var html = '';

        $(this).find('#ref').removeClass('modal-sm');
        $(this).find('.modal-body').html("");        

        if(gscope == "add-category")
        {
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> New Category</small></label>';
            html += '<input type="text" id="new-category" name="new-category" class="form-control" placeholder="" tabindex="" required>';
            html += '</div>';

            $(this).find('.modal-title').text("Add Category");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'save-category');
        }

        if(gscope == "add-role")
        {
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> Select Category for this Job Role</small></label>';
            html += '<select class="form-control" tabindex="16" id="category-id" name="jobCategory">';
            html += '<option>  </option>';
            html += '</select>';
            html += '</div>';
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> New Job Role</small></label>';
            html += '<input type="text" id="new-role" name="new-role" class="form-control" placeholder="" tabindex="" required>';
            html += '</div>';

            $(this).find('.modal-title').text("Add Job Role");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'save-role');

            var categories = getJSONDoc(pathUrl + "/api/jobs/categories");
            $.each(categories, function(index, item){
                $('select[name=jobCategory]').append('<option value="'+item.id+'">'+item.category_name+' </option>');
            });
        }

        if(gscope == "add-religion")
        {
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> New Religion</small></label>';
            html += '<input type="text" id="new-religion" name="new-religion" class="form-control" placeholder="" tabindex="" required>';
            html += '</div>';

            $(this).find('.modal-title').text("Add Religion");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'save-religion');
        }

        if(gscope == "add-industry")
        {
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> New Industry</small></label>';
            html += '<input type="text" id="new-industry" name="new-industry" class="form-control" placeholder="" tabindex="" required>';
            html += '</div>';

            $(this).find('.modal-title').text("Add Industry");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'save-industry');
        }

        if(gscope == "edit-category")
        {
            var prev_category = getJSONDoc(pathUrl + '/api/jobs/categories/id/'+ gid);
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> Category Name</small></label>';
            html += '<input type="text" id="new-category" name="new-category" class="form-control" value="'+prev_category.category_name+'" tabindex="" required>';
            html += '</div>';

            $(this).find('.modal-title').text("Edit Category");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'update-category');
        }

        if(gscope == "edit-position")
        {
            var prev_position = getJSONDoc(pathUrl + '/api/jobs/positions/id/'+ gid);
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> Select Category for this Job Role</small></label>';
            html += '<select class="form-control" tabindex="16" id="category-id" name="jobCategory">';
            html += '<option>  </option>';
            html += '</select>';
            html += '</div>';
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> Job Role</small></label>';
            html += '<input type="text" id="new-role" name="new-role" class="form-control" value="'+prev_position.name+'" tabindex="" required>';
            html += '</div>';

            $(this).find('.modal-title').text("Edit Job Role");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'update-position');

            var categories = getJSONDoc(pathUrl + "/api/jobs/categories");
            $.each(categories, function(index, item){
                
                var selected = (item.id == prev_position.category_id)? "selected" :"";

                $('select[name=jobCategory]').append('<option value="'+item.id+'" '+selected+'>'+item.category_name+' </option>');
            });
        }

        if(gscope == "edit-industry")
        {
            var prev_industry = getJSONDoc(pathUrl + '/api/companies/industries/id/'+ gid);
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> Industry Name</small></label>';
            html += '<input type="text" id="new-industry" name="new-industry" class="form-control" value="'+prev_industry.industry_name+'" tabindex="" required>';
            html += '</div>';

            $(this).find('.modal-title').text("Edit Industry");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'update-industry');
        }

        if(gscope == "edit-religion")
        {
            var prev_religion = getJSONDoc(pathUrl + '/api/religions/index/id/'+ gid);
            html += '<div class="form-group" style="margin-bottom:0.5rem;">';
            html += '<label class"control-label required" for="email"><small> Religion name</small></label>';
            html += '<input type="text" id="new-religion" name="new-religion" class="form-control" value="'+prev_religion.religion_name+'" tabindex="" required>';
            html += '</div>';

            $(this).find('.modal-title').text("Edit Religion");
            $(this).find('.modal-body').append(html);
            $(this).find('.btn-primary').attr('id', 'update-religion');
        }

    });

    $(document).on("click", "#save-category, #save-role, #save-religion, #save-industry, #update-industry, #update-religion, #update-category, #update-position", function(){
                
        var id = $(this).attr('id');
        var data;
        var inputSelector;
        var url = '';
        var method = '';
        var scope = '';
        var boolean = false;

        if(id == "save-category" || id == "update-category"){
            url = pathUrl + "/api/jobs/categories";
            method = method = (id == "save-category")? "POST" :(id == "update-category")? "PATCH": "";
            scope = 'category';
            inputSelector = $("#new-category");
            
            if(id == "update-category"){
                data = {
                    id : gid,
                    category: $.trim($("#new-category").val()),
                } 
            }
            else{
                data = {

                    category: $.trim($("#new-category").val()),
                }
            }
            
            if(data.category == "" || data.category.length == 0){
                $("#new-category").tooltip({
                    title: "<i class='fa fa-exclamation-circle'></i> New Category is required",
                    html: true,
                    placement: "top"
                });

                $("#new-category").tooltip("show");
                $("#new-category").closest('.form-group').addClass('has-danger');
            }
            else{
                boolean = true;
            }
        }

        if(id == "save-role" || id == "update-position"){
            url = pathUrl + "/api/jobs/positions";
            method = (id == "save-role")? "POST" :(id == "update-position")? "PATCH": "";;
            scope = 'position';
            inputSelector = $("#new-role");
            
                if(id == "update-position"){
                    data = {
                        id : gid,
                        position : $.trim($("#new-role").val()),
                        category_id  : $("#category-id").val()
                    } 
                }
                else{
                    data = {
                        position : $.trim($("#new-role").val()),
                        category_id  : $("#category-id").val()
                    }
                }

            if(data.category_id == ""){
                $("#category-id").tooltip({
                    title: "<i class='fa fa-exclamation-circle'></i> Please select category for this role",
                    html: true,
                    placement: "top"
                });

               $("#category-id").tooltip("show");
               $("#category-id").closest('.form-group').addClass('has-danger');
            }
            if(data.position == "" || data.position.length == 0){
                $("#new-role").tooltip({
                    title: "<i class='fa fa-exclamation-circle'></i> New Role is required",
                    html: true,
                    placement: "top"
                });

               $("#new-role").tooltip("show");
               $("#new-role").closest('.form-group').addClass('has-danger');
            }
            else{
                boolean = true;
            }
        }

        if(id == "save-religion" || id == "update-religion"){
            url = pathUrl + "/api/religions";
            method = (id == "save-religion")? "POST" :(id == "update-religion")? "PATCH": "";
            scope = 'religion';
            inputSelector = $("#new-religion");

            if(id == "update-religion"){
                data = {
                    id : gid,
                    religion: $.trim($("#new-religion").val()),
                } 
            }
            else{
                data = {

                    religion: $.trim($("#new-religion").val()),
                }
            }

            if(data.religion == "" || data.religion.length == 0){
                
                 $("#new-religion").tooltip({
                    title: "<i class='fa fa-exclamation-circle'></i> Religion name is required",
                    html: true,
                    placement: "top"
                });

                $("#new-religion").tooltip("show");
                $("#new-religion").closest('.form-group').addClass('has-danger');
            }
            else{
                boolean = true;
            }
        }

        if(id == "save-industry" || id == "update-industry")
        {
            url = pathUrl + "/api/companies/industries";
            method = (id == "save-industry")? "POST" :(id == "update-industry")? "PATCH": "";
            scope = "industry";
            inputSelector = $("#new-industry");
            
            if(id == "update-industry"){
                data = {
                    id : gid,
                    industry: $.trim($("#new-industry").val()),
                } 
            }
            else{
                data = {

                    industry: $.trim($("#new-industry").val()),
                } 
            }
            

            if(data.industry == "" || data.industry.length == 0){
                $("#new-industry").tooltip({
                    title: "<i class='fa fa-exclamation-circle'></i> Industry name is required",
                    html: true,
                    placement: "top"
                });

                $("#new-industry").tooltip("show");
                $("#new-industry").closest('.form-group').addClass('has-danger');
            }  
            else{
                boolean = true;
            }          
        }


        /** for removing has-danger on text fields */
        $("#category-id").on("change", function(){
            $(this).closest('.form-group').removeClass('has-danger');
            $(this).tooltip("dispose");
        });

        inputSelector.on("keyup", function(){
            var value = $.trim($(this).val());

            if(value.length != 0)
            {
                $(this).closest('.form-group').removeClass('has-danger');
                $(this).tooltip("dispose");
                boolean = true;
            }
        });
        
        if(boolean == true){
            console.log(method)
            postData(url, method, data, function(callback){

                if(callback.status === true)
                {
                    $("#dynamicModal").modal('hide');

                    if(scope == "category"){
                        admin_category_table.ajax.reload(null, false);
                    }
                    if(scope == "position"){
                        admin_role_table.ajax.reload(null, false);   
                    }
                    if(scope == "religion"){
                        admin_religion_table.ajax.reload(null, false);
                    }
                    if(scope == "industry"){
                        admin_industry_table.ajax.reload(null, false);
                    }

                    $.notify({
                        title: " ",
                        message: "<h6><i class='fa fa-exclamation-triangle'></i>&nbsp<small>"+callback.message+"</small></h6>",

                    },{
                        type: "success",
                        delay: 1200,
                        animate: {
                            enter: 'animated fadeIn',
                            exit: 'animated fadeOut'
                        }
                    });
                }
            });
        }

    });

    $(document).on('hide.bs.modal', '#dynamicModal',function (evt) {
        $('.modal .modal-dialog').attr('class', 'modal-dialog  zoomOutDown  animated');
        $('div').tooltip('dispose');
        
    });

    $(document).on('hidden.bs.modal', '#dynamicModal',function (evt) {

        var img = '';
        img += '<center>';
        img += '<img src="'+pathUrl+'/assets/images/app/ring.gif" style="">';
        img += '</center>';

        $(this).find('.modal-title').text("");
        $(this).find('.modal-body').html("").append(img);
        $(evt.target).removeData('bs.modal');
    });

});    