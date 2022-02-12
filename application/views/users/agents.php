<div class="page-container">
   <div class="page-content-wrapper">
      <div class="page-content">
         <!-- BEGIN SAMPLE TABLE PORTLET-->
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption">
                  <i class="fa fa-cogs"></i>All Users
               </div>
               <a class="btn btn-success" href="<?php echo site_url("agents/addagent"); ?>" title="add agent">Add User</a>
            </div>
         </div>
         <div class="second_custom_card">
            <?php 
               $ustatus = "";
               if( isset( $_GET['ustatus'] ) && !empty( $_GET['ustatus'] ) ){
               	$ustatus = $_GET['ustatus'];
               } ?>
            <div class="filter_section text-center">
               <div id="filter"></div>
               <input type="hidden" id="ustatus" value="<?php echo $ustatus; ?>">
               <div class="col-md-offset-2 col-md-4">
                  <label><strong>Select User By Status:</strong></label>
                  <select class='form-control mfilter'>
                     <option value="">Select Status</option>
                     <option value="">All Users</option>
                     <option value="active">Active User</option>
                     <option value="inactive">Inactive User</option>
                     <option value="block">Block User</option>
                  </select>
               </div>
               <div class="col-md-4">
                  <label><strong>Select User By Role:</strong></label>
                  <select class='form-control mfilter'>
                     <option value="">Select Role</option>
                     <option value="">All Roles</option>
                     <?php if( get_all_users_role() ){
                        $roles = get_all_users_role();
                        foreach( $roles as $r ){
                        	if( $r->role_id == 99 ) continue;
                        	$role_name = ucfirst($r->role_name);
                        	echo "<option value='{$r->role_id}'>{$role_name}</option>";
                        }
                        } ?>
                  </select>
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
         <hr>
         <div class="portlet-body">
            <div class="table-responsive custom_card">
               <table class="table table-striped display" id="table" cellspacing="0" width="100%">
                  <thead>
                     <tr>
                        <th> # </th>
                        <th> Name </th>
                        <th> User Name </th>
                        <th> User Role </th>
                        <th> Email </th>
                        <th> Mobile </th>
                        <th> User Status </th>
                        <th> Action </th>
                        <th> Update Status </th>
                        <th> Last Login </th>
                     </tr>
                  </thead>
                  <tbody>
                     <!--Data table -->
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<script type="text/javascript">
   jQuery(document).ready(function($){
   $(document).on("click", ".ajax_delete_user",function(){
   	var user_id = $(this).attr("data-id");
   	//alert(user_id);
   	if (confirm("Are you sure?")) {
   		$.ajax({
   			url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_deleteUser?id=" + user_id,
   			type:"GET",
   			data:user_id,
   			dataType: "json",
   			cache: false,
   			success: function(r){
   				if(r.status = true){
   					location.reload();
   				  console.log("ok" + r.msg);
   				}else{
   					alert("Error! Please try again.");
   				}
   			}
   		});	
   	}   
   });
   }); 
</script>
<script type="text/javascript">
   var table;
   $(document).ready(function() {
   	//on change filter
   	$(document).on('change', ".mfilter", function () {
   		var val = $(this).find(":selected").val();		
   		console.log( val );
   		$("input[type='search']").val(val);
   		table.search( val ).draw();
   		//console.log(val);
   	});
   	
       //datatables
       table = $('#table').DataTable({ 
   		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
           "processing": true, //Feature control the processing indicator.
           "serverSide": true, //Feature control DataTables' server-side processing mode.
           "order": [], //Initial no order
   		language: {
   			search: "<strong>Search By User name/Email Id:</strong>",
   			searchPlaceholder: "Search..."
   		},
           // Load data for the table's content from an Ajax source
   		"ajax": {
               "url": "<?php echo site_url('agents/ajax_list')?>",
               "type": "POST"
           },
       
           //Set column definition initialisation properties.
           "columnDefs": [
   			{ 
   				"targets": [ 0 ], //first column / numbering column
   				"orderable": false, //set not orderable
   			},
           ],
   
       });
   	
   });
</script>
<script>
   jQuery(document).ready(function($){
   	$(document).on("click", '#inSlider', function() {
   		var ajaxReq;
   		//get review status
   		if ( !$(this).is(':checked') ) {
   			var chkVal = "inactive";
   		}else{
   			var chkVal = "active";
   		}
   		//get review id
   		var id = $(this).attr("data-id");
   		console.log( id );
   		console.log( chkVal );
   		if (ajaxReq) {
   			ajaxReq.abort();
   		}
   		//ajax request to update status	
   		ajaxReq = $.ajax({
   			url: "<?php echo base_url(); ?>" + "agents/ajax_user_updateStatus",
   			type:"POST",
   			data:{ "id":  id, "ustatus": chkVal },
   			dataType: 'json',
   			cache: false,
   			success: function(r){
   				if(r.status = true){
   					location.reload();
   				  console.log("ok" + r.msg);
   					//console.log(r.msg);
   				}else{
   					alert("Error! Please try again.");
   				}
   			}
   		});
   	});
   });	
</script>