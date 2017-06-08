$(document).ready(function(){
	var admin_logs_table = $('#admin-logs-table').DataTable({ 
            
            "processing": true, 
            "serverSide": true,    
            "ajax": {
                "url": App.pathUrl + "/admin/get_activity_logs",
                "type": "POST",
                
            },
            "language": {
                "processing": "<img src='"+App.pathUrl+'/assets/images/app/ajax-loader.gif'+"'>",
            },
          
            "columnDefs": [
                { 
                  "targets": ['class','no-sort'], 
                  "orderable": false, 
                },
            ],
        });
});