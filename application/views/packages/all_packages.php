<div class="page-container">
   <div class="page-content-wrapper">
      <div class="page-content">
         <!-- BEGIN SAMPLE TABLE PORTLET-->
         <?php $message = $this->session->flashdata('success'); 
            if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
            ?>
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption">
                  <i class="fa fa-users"></i>All Packages
               </div>
               <a class="btn btn-success" href="<?php echo site_url("packages/add"); ?>" title="add hotel">Add Package</a>
            </div>
         </div>
         <!--Filter-->
         <div class="cat_wise_filter second_custom_card">
            <form role="form" id="filter_frm" method="post">
               <div class="col-md-4">
                  <label class="control-label">State</label>
                  <div class="form-group">
                     <select name='state' class='form-control' id='stateID'>
                        <option value="">All States</option>
                        <?php $state_list = get_indian_state_list(); 
                           if( $state_list ){
                           	foreach($state_list as $state){
                           		echo '<option value="'.$state->id.'">'.$state->name.'</option>';
                           	}
                           } ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <label class="control-label">Package Category </label>
                  <div class="form-group">
                     <select name="p_cat_id" id="cat_id" class="form-control">
                        <option value="">All Package Category</option>
                        <?php 
                           $cats = get_package_categories();
                           if( $cats ){
                           foreach($cats as $cat){
                           	echo '<option value = "'.$cat->p_cat_id .'" >'.$cat->package_cat_name.'</option>';
                           	}
                           }
                           ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-4 margin-top-15">
                  <div class="margin-top-10">
                     <button type="submit" class="btn green uppercase add_user">Filter</button>
                     <a href="javascript:void(0);" class="btn green uppercase reset_filter"><i class="fa fa-refresh"></i> Reset</a>
                  </div>
               </div>
            </form>
            <div class="clearfix"></div>
            <div class="res"></div>
         </div>
         <hr>
         <div class="portlet-body">
            <div class="table-responsive custom_card">
               <table id="packages" class="table table-striped display">
                  <thead>
                     <tr>
                        <th> # </th>
                        <th> Package ID </th>
                        <th> Package Name </th>
                        <th> State </th>
                        <th> Category </th>
                        <th> Publish Status</th>
                        <th> Package Created</th>
                        <th> Action </th>
                     </tr>
                  </thead>
                  <tbody>
                     <div class="loader"></div>
                     <div id="res"></div>
                     <!--DataTable Goes here-->
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END CONTENT BODY -->
</div>
<div id="myModal" class="modal" role="dialog"></div>
<!-- Modal -->
<script type="text/javascript">
   //update package del status
   jQuery(document).ready(function($){
   	$(document).on("click", ".ajax_delete_package", function(){
   		var id = $(this).attr("data-id");
   		if (confirm("Are you sure?")) {
   			$.ajax({
   				url: "<?php echo base_url(); ?>" + "packages/update_del_status_package?id=" + id,
   				type:"GET",
   				data:id,
   				dataType: 'json',
   				cache: false,
   				success: function(r){
   					if(r.status = true){
   						location.reload();
   					  //console.log("ok" + r.msg);
   						//console.log(r.msg);
   					}else{
   						alert("Error! Please try again.");
   					}
   				}
   			});	
   		}   
   	});
   	//delete permanently Draft Itineraries
   	$(document).on("click", ".delete_package_permanent", function(){
   		var id = $(this).attr("data-id");
   		if (confirm("Are you sure?")) {
   			$.ajax({
   				url: "<?php echo base_url(); ?>" + "packages/delete_package_permanently?id=" + id,
   				type:"GET",
   				data:id,
   				dataType: 'json',
   				cache: false,
   				success: function(r){
   					if(r.status = true){
   						location.reload();
   					  //console.log("ok" + r.msg);
   						//console.log(r.msg);
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
   	var table;
   	var tableFilter;
   	
   	//Reset filter
   	$(document).on("click", ".reset_filter" ,function(e){
   		e.preventDefault();
   		$("form#filter_frm").find("input,select").val("");
   		table.ajax.reload(null,true);
   	});
   	
   	
   	$("#filter_frm").submit(function(e){
   		e.preventDefault();
   		table.ajax.reload(null,true);
   	});
   	
   	//datatables
   	table = $('#packages').DataTable({ 
   		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
   		"processing": true, //Feature control the processing indicator.
   		"serverSide": true, //Feature control DataTables' server-side processing mode.
   		"order": [], //Initial no order.
   		language: {
   			search: "<strong>Search By Package Id/Package Name:</strong>",
   			searchPlaceholder: "Search..."
   		},
   		// Load data for the table's content from an Ajax source
   		"ajax": {
   			"url": "<?php echo site_url('packages/ajax_packages_list')?>",
   			"type": "POST",
   			"data": function ( data ) {
   				//console.log($("#cat_id").val());
   				data.state_id = $("#stateID").val();
   				data.cat_id = $("#cat_id").val();
   			},
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