<div class="page-container">
   <div class="page-content-wrapper">
      <div class="page-content">
         <!-- BEGIN SAMPLE TABLE PORTLET-->
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption">
                  <i class="fa fa-cogs"></i>All Reference Customers
               </div>
               <a class="btn btn-success" href="<?php echo site_url("Reference_customers/add"); ?>" title="add user">Add Reference Customer</a>
            </div>
         </div>
         <!--Show success message if hotel edit/add -->
         <?php $message = $this->session->flashdata('success'); 
            if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
            ?>
         <?php $eerr = $this->session->flashdata('error'); 
            if($eerr){ echo '<span class="help-block help-block-success"><span class="red">'.$eerr.'</span></span>'; }
            ?>
         <!--Filter-->
         <div class="cat_wise_filter second_custom_card">
            <form role="form" id="filter_frm" method="post">
               <div class="col-md-4">
                  <label class="control-label">State * </label>
                  <div class="form-group">
                     <select name='state' required class='form-control' id='state'>
                        <option value="">Select State</option>
                        <?php $state_list = get_indian_state_list(); 
                           if( $state_list ){
                           	foreach($state_list as $state){
                           		echo '<option value="'.$state->id.'">'.$state->name.'</option>';
                           	}
                           } ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-4 margin-top-15">
                  <div class="margin-top-10">
                     <button type="submit" class="btn green uppercase add_user">Filter</button>
                     <a href="javascript:void(0);" class="btn green uppercase reset_filter"><i class="fa fa-refresh"></i> Reset</a>
                  </div>
               </div>
               <input type="hidden" id="stateID" value="" />
               <input type="hidden" id="cityID" value="" />
            </form>
            <div class="clearfix"></div>
            <div class="res"></div>
         </div>
         <!--End Filter-->
         <div class="filter_city_list"></div>
         <!--city filter-->
         <hr class="clearfix" />
         <div class="loader"></div>
         <div class="custom_card">
            <div class="upload_user_section">
               <form class="" action="<?php echo base_url(); ?>reference_customers/import_ref_customers" method="post" name="upload_excel" enctype="multipart/form-data">
                  <!-- File Button -->
                  <div class="col-md-4">
                     <div class="form-group">
                        <label class="control-label" for="filebutton">Select Csv File</label>
                        <div class="d_inline_block">
                           <input required type="file" name="file" id="file" class="input-large">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <!-- Button -->
                     <div class="form-group">
                        <label class="control-label" for="singlebutton">Import Customers</label>
                        <div class="d_inline_block">
                           <button type="submit" id="submit" name="Import" class="btn green uppercase button-loading" data-loading-text="Loading...">Import</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="clearfix"></div>
            <div class="portlet-body">
               <div class="table-responsive">
                  <table class="table table-striped display" id="table" cellspacing="0" width="100%">
                     <thead>
                        <tr>
                           <th> # </th>
                           <th> Name </th>
                           <th> Email </th>
                           <th> Contact </th>
                           <th> State</th>
                           <th> City</th>
                           <th> Action </th>
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
</div>
<!-- END CONTENT BODY -->
</div>
<style>
   .city_filter .btn:hover {
   background-color: #32c5d2 !important;
   }
   .city_filter .btn.active {
   background-color: #32c5d2 !important;
   }
</style>
<script type="text/javascript">
   jQuery(document).ready(function($){
   $(document).on("click", ".ajax_delete_user",function(){
   	var cus_id = $(this).attr("data-id");
   	//alert(user_id);
   	if (confirm("Are you sure?")) {
   		$.ajax({
   			url: "<?php echo base_url(); ?>" + "reference_customers/ajax_ref_customer?id=" + cus_id,
   			type:"GET",
   			data:cus_id,
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
   $(document).ready(function() {
   	var ajaxReq, table;
   	$("#filter_frm").validate({
   		submitHandler: function(form) {
   			var resp = $(".res");
   			var city_d = $(".filter_city_list");
   			var formData = $("#filter_frm").serializeArray();
   			
   			//Reload data table
   			$("input#stateID").val($("#state").val());
   			$("input#cityID").val("all");
   			table.ajax.reload(null,true);
   		
   			//console.log(formData);
   			if (ajaxReq) {
   					ajaxReq.abort();
   				}
   				ajaxReq = $.ajax({
   				type: "POST",
   				url: "<?php echo base_url('reference_customers/ajax_get_ref_customer_city_list'); ?>" ,
   				dataType: 'json',
   				data: formData,
   				beforeSend: function(){
   					resp.html('<p class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
   				},
   				success: function(res) {
   					if (res.status == true){
   						resp.html("");
   						city_d.html('<div class="city_filter">'+res.city_data+'</div>');
   						//console.log("done");
   					}else{
   						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
   						city_d.html("");
   						console.log("error");
   					}
   				},
   				error: function(e){
   					console.log(e);
   					//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
   				}
   			});
   			return false;
   		}
   	});	
   	
   	//Add active class to city list filter
   	$(document).on("click", ".city_btn", function(e){
   		var _this = $(this);
   		e.preventDefault();
   		$(".city_btn").removeClass("active");
   		_this.addClass("active");
   		
   		//Get city id and category id
   		var city_id = _this.attr("data-city_id");
   		var state_id = _this.attr("data-state_id");
   		
   		//add city to export button
   		$("#btn_export_data").attr("data-city_id", city_id);
   		
   		$("input#stateID").val(state_id);
   		$("input#cityID").val(city_id);
   		//reload data table
   		table.ajax.reload(null,true);
   	});
   	
   	//Export data btn click
   	$(document).on("click", "#btn_export_data", function(e){
   		//$(".loader").show();
   		var state 	= $(this).attr("data-state_id");
   		var city	 = $(this).attr("data-city_id");
   		var ex_url = "<?php echo base_url( "export/export_ref_customers_data?state=" );?>" + state + "&city=" + city;
   		//console.log( ex_url );
   		window.location.href = ex_url;
   	});	
   	
   	//Reset filter
   	$(document).on("click", ".reset_filter" ,function(e){
   		e.preventDefault();
   		$("form#filter_frm").find("input,select").val("");
   		$(".filter_city_list, .res").html("");
   		table.ajax.reload(null,true);
   	});
   	
       //data tables
       table = $('#table').DataTable({ 
   		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
           "processing": true, //Feature control the processing indicator.
           "serverSide": true, //Feature control DataTables' server-side processing mode.
           "order": [], //Initial no order.
   		language: {
   			search: "<strong>Search By User name/Email Id:</strong>",
   			searchPlaceholder: "Search..."
   		},
           // Load data for the table's content from an Ajax source
   		"ajax": {
               "url": "<?php echo site_url('reference_customers/ajax_reference_customer_list')?>",
               "type": "POST",
   			"data": function ( data ) {
   					data.state_id = $("#stateID").val();
   					data.city_id = $("#cityID").val();
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