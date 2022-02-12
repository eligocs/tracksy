<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-users"></i>All Child Itineraries of ( Itinerary ID : <strong class="red"><?php echo $currentIti; ?></strong> )
						 Package Type: <strong class="red"> <?php echo check_iti_type( $currentIti ); ?></strong>
					</div>
						<a class="btn btn-success" href="<?php echo site_url("Itineraries"); ?>" title="add hotel">Back</a>
				</div>
			</div>	
			<!--pre>
			</pre-->
			<div class="portlet-body">
				
						<div id="res"></div>
								<?php if( !empty( $childIti ) ){
									//Count All Child Itineraries
									$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $currentIti, "del_status" => 0) );
									//get last followup
									$last_followUp_iti = isset( $lastFollow ) && !empty( $lastFollow ) ? trim($lastFollow) : 0;
									$i=1;
									foreach( $childIti as $c_iti ){
										//get iti_status
										$btncmt = "";
										$iti_status = $c_iti->iti_status;
										$parent_iti = $c_iti->parent_iti_id;
										$iti_id = $c_iti->iti_id;
										$key = $c_iti->temp_key;
										$pub_status = $c_iti->publish_status;
										//current followup iti id
										$curFollow = $last_followUp_iti == $iti_id ? "last_follow" : "";
										
										//get discount rate request
										$discount_request = $c_iti->discount_rate_request;
										$discReq = $discount_request == 1 ? "<strong class='red'> (Price Discount Request) </stron>" : " ";
										//Get Pulish status
										if( $pub_status == "publish" ){
											$p_status = "<div class='btn btn-success green'>" . ucfirst($pub_status) . "</div>";
											$p_status .= $discReq;
										}elseif( $pub_status == "price pending" ){
											$p_status = "<div class='btn btn-danger blue'>" . ucfirst($pub_status) . "</div>";
											$p_status .= $discReq;
										}else{
											$p_status = "<div class='btn btn-danger red'>" . ucfirst($pub_status) . "</div>";
										}
										
										//Get if Itinerary is parent or childIt
										$p_iti = empty( $parent_iti ) ? "Parent" : "Child";
										
										//clone button
										$dupBtn ="";
										$dupChildBtn ="";
										if( empty( $parent_iti ) &&  $countChildIti < 6  && $c_iti->iti_status == 0 && $c_iti->email_count > 0 && $pub_status == "publish" ){
											if( $c_iti->iti_type == 1 ){
											$dupBtn = "<a title='Duplicate Itinerary' href=" . site_url("itineraries/duplicate/{$iti_id}") . " class='btn btn-success duplicateItiBtn' ><i class='fa fa-files-o' aria-hidden='true'></i></a>"; ?>
											<!-- Modal Duplicate Itinerary-->
											<div id="duplicatePakcageModal" class="modal" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">Close</button>
															<h4 class="modal-title">Select Package</h4>
														</div>
														<div class="modal-body"> 
															<form id="createIti">
																<div class="">
																	<?php $prePackages = get_all_packages(); ?>
																	<?php $getPackCat = get_package_categories(); ?>
																	<?php $state_list = get_indian_state_list(); ?>
																	<div class="form-group">
																	<label>Select Package Category</label>
																	<select required name="package_cat_id" class="form-control" id="pkg_cat_id">
																		<option value="">Choose Package</option>
																		<?php if( $getPackCat ){ ?>
																			<?php foreach($getPackCat as $pCat){ ?>
																				<option value = "<?php echo $pCat->p_cat_id ?>" ><?php echo $pCat->package_cat_name; ?></option>
																			<?php } ?>
																		<?php }	?>
																	</select>
																	</div>
																	<div class="form-group">
																		<label>Select State*</label>
																		<select required disabled name="satate_id" class="form-control" id="state_id">
																			<option value="">Select State</option>
																			<?php if( $state_list ){ 
																				foreach($state_list as $state){
																					echo '<option value="'.$state->id.'">'.$state->name.'</option>';
																				}
																			} ?>	
																		</select>
																	</div>
																	
																	<div class="form-group">
																	<label>Select Package</label>
																	<select required disabled name="packages" class="form-control" id="pkg_id">
																		<option value="">Choose Package</option>
																	</select>
																	</div>
																	
																	<div class="form-actions">
																		<input type="hidden" id="cust_id" value="<?php echo $c_iti->customer_id; ?>">
																		<input type="hidden" id="iti_id" value="<?php echo $c_iti->iti_id; ?>">
																		<input type="submit" class='btn btn-green disabledBtn' id="continue_package" value="Continue" >
																	</div>
																</div>	
																<div id="pack_response"></div>	
															</form>	
															<hr>
															<h2><strong>OR</strong></h2>
															<div class="form-group">
																<a href="<?php echo site_url("itineraries/duplicate/{$c_iti->iti_id}"); ?>" class='btn btn-green disabledBtn' id="clone_current_iti" title='Clone Itinerary'><i class='fa fa-plus'></i> Clone Current Itinerary</a>
															</div>
														</div>
														<div class="modal-footer"></div>
													</div>
												</div>
											</div>
										<?php
											}else{
												$dupBtn = "<a data-customer_id='{$c_iti->customer_id}' data-iti_id='{$c_iti->iti_id}' title='Duplicate Accommodation' href=" . site_url("itineraries/duplicate/{$c_iti->iti_id}") . " class='btn btn-success child_clone' ><i class='fa fa-files-o' aria-hidden='true'></i></a>";
											}

										}

										//Show duplicate button for child itinerary
										if( !empty( $parent_iti ) && $countChildIti < 6 ){
											$dupChildBtn = "<a title='Duplicate Current Itinerary' href=" . site_url("itineraries/duplicate_child_iti/?iti_id={$iti_id}&parent_iti_id={$parent_iti}" ) ." class='btn btn-success child_clone'><i class='fa fa-files-o' aria-hidden='true'></i></a>";
										}											
										
										/* count iti sent status */
										$iti_sent = $c_iti->email_count;
										$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent";
										
										//buttons
										//if price is updated remove edit for agent
										if( $c_iti->pending_price == 2 && $role == 96 ){
											$btn_edit = "<a title='Edit' href='javascript: void(0)' class='btn btn-success editPop' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
										}else{
											$btn_edit = "<a title='Edit' href=" . site_url("itineraries/edit/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
										}
				
										$btn_view = "<a target='_blank' title='View' href=" . site_url("itineraries/view_iti/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
										
										if( $c_iti->iti_type == 1 ){
											$btn_view .= "<a target='_blank' title='View' href=" . site_url("promotion/package/{$iti_id}/{$key}") . " class='btn btn-success' >Client view</a>";
										}
										
										$btn_view .= "<a target='_blank' title='View' href=" . site_url("promotion/itinerary/{$iti_id}/{$key}") . " class='btn btn-success' >Client view New</a>";

										if( !empty( $c_iti->client_comment_status ) && $c_iti->client_comment_status == 1 ){
											$btncmt = "<a data-id={$iti_id} data-key={$key} title='Client Comment' href='javascript:void(0)' class='btn btn-success ajax_iti_status red'><span class='blink'><i class='fa fa fa-comment-o' aria-hidden='true'></i>  New Comment</span></a>";
										}
										
										//if itinerary status is publish
										if( $pub_status == "publish" || $pub_status == "price pending" ){
											//delete itinerary button only for admin
											$row_delete = "";
											if( ( is_admin() || is_manager() ) && !empty( $parent_iti ) && ( $last_followUp_iti != $iti_id ) ){ 
												$row_delete = "<a data-id={$iti_id} title='Delete Itinerary' href='javascript:void(0)' class='btn btn-danger delete_iti_permanent'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
											}
											//echo "<td>{$btn_edit} {$btn_view} {$row_delete} {$it_status}{$dupBtn}</td>";
										}
										//echo "</tr>";
										echo "<div class='col-md-4'>
											<div class='itinerary-blocks {$curFollow}'>
											<div class='package_name'><div>{$btncmt}</div>{$c_iti->package_name}<div style='font-size:13px;'><span class='red'>{$p_iti}</span> {$c_iti->added}<div>Iti Id:<span class='red'>{$iti_id}</span></div></div></div>
											<div class='hover_section'>
												{$btn_edit}
												{$btn_view}
												{$p_status}
												{$row_delete}
												{$dupBtn}
												{$dupChildBtn}
											</div>
											</div>
										</div>";
										
										$i++;
									}
								} ?>
							
						<!--/tbody>
					</table>
				</div-->
			</div>
		</div>
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<div class="loader"></div>
<style>#editModal{top: 20%; }</style>
<!-- Modal -->
<div id="editModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close editPopClose" data-dismiss="modal">Close</button>
				<h4 class="modal-title">Permission denied</h4>
			</div>
			<div class="modal-body"> 
				Please contact to Manager or Administrator to edit Itinerary. Or Duplicate the Itinerary for revised quotation.
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){
	$(document).on("click",".ajax_iti_status", function(){
		var iti_id = $(this).attr("data-id");
		$.ajax({
			url: "<?php echo base_url(); ?>" + "itineraries/client_comment_popup",
			type:"POST",
			data:{ iti_id: iti_id },
			dataType: "json",
			cache: false,
			beforeSend: function(){
				$( "#myModal" ).html('<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">Close</button><h4 class="modal-title"> Please wait </h4></div><div class="modal-body"> <p><div class="alert alert-info"><strong>Please wait: </strong> Loading...............</div></p></div><div class="modal-footer"></div></div></div>').fadeIn();
				/*console.log("Please wait.......");*/
			},
			success: function(r){
				if(r.status = true){
					$( "#myModal" ).html('<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">Close</button><h4 class="modal-title"> Client Comment </h4></div><div class="modal-body"> <p>' + r.data + '</p></div><div class="modal-footer"></div></div></div>').fadeIn();
					//console.log("ok" + r.data);
				}else{
					console.log("Error.......");
					$( "#myModal" ).hide();
				}
			},
			error: function(){
				console.log("error");
				$( "#myModal" ).hide();
			}
		});
	});
	jQuery(document).on("click", ".close",function(){
		jQuery("#myModal").fadeOut();
	});
});
//update iti del status
jQuery(document).ready(function($){
	$(document).on("click", ".ajax_delete_iti", function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_delete_iti?id=" + id,
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
	$(document).on("click", ".delete_iti_permanent", function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "itineraries/delete_iti_permanently?id=" + id,
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
jQuery(document).ready(function($){
	$(document).on("click",".ajax_iti_status", function(){
		var iti_id = $(this).attr("data-id");
		var temp_key = $(this).attr("data-key");
		$.ajax({
			url: "<?php echo base_url(); ?>" + "itineraries/update_comment_status",
			type:"POST",
			data:{ iti_id: iti_id },
			dataType: "json",
			cache: false,
			beforeSend: function(){
				$(".loader").show();
				/* console.log("Please wait......."); */
			},
			success: function(r){
				$(".loader").hide();
				if(r.status = true){
					window.location.href = "<?php echo site_url('itineraries/view/');?>" + iti_id + "/" + temp_key + "#comments"; 
				}else{
					$(".loader").hide();
					alert("error");
					console.log("Error.......");
					
				}
			},
			error: function(){
				$(".loader").hide();
				alert("error");
				console.log("error");
			}
		});
	});
	
		//Show Modal if itinerary price updated for agent
	$(document).on("click",".editPop",function(){
		$("#editModal").show();
	});
	$(document).on("click",".editPopClose",function(){
		$("#editModal").hide();
	});
});	
</script>	
<script type="text/javascript">
jQuery(document).ready(function($){
	//open modal on duplicate iti btn click
	$(document).on("click", ".duplicateItiBtn", function(e){
		e.preventDefault();
		var _this = $(this);
		$("#duplicatePakcageModal").show();
		$("#continue_package, #clone_current_iti").removeClass("disabledBtn");
		//console.log(iti_id + " " + customer_id);
	});
	
	$(document).on('change', 'select#pkg_cat_id', function() {
		$("#state_id, #pkg_id").val("");
		$("#state_id").removeAttr("disabled");
	});
	/*get Packages by Package Category*/
	$(document).on('change', 'select#state_id', function() {
		var p_id = $("#pkg_cat_id option:selected").val();
		var state_id = $("#state_id option:selected").val();
		
		var _this = $(this);
		$("#pkg_id").val("");
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('packages/packagesByCatId'); ?>",
			data: { pid: p_id, state_id: state_id } 
		}).done(function(data){
			$(".bef_send").hide();
			$("#pkg_id").html(data);
			$("#pkg_id").removeAttr("disabled");
		}).error(function(){
			$(".bef_send").html("Error! Please try again later!");
		});
	});
	
	//ajax request if predefined package choose
	var ajaxReq;
	$("#createIti").validate({
		submitHandler: function(){
			if (ajaxReq) {
				ajaxReq.abort();
			}
			$("#continue_package, #clone_current_iti").addClass("disabledBtn");
			var resp = $("#pack_response");
			var package_id = $("#pkg_id").val();
			var customer_id = $("#cust_id").val();
			var iti_id		 = $("#iti_id").val();
			
			if( package_id == '' || customer_id == '' || iti_id == '' ){
				resp.html( "Please Choose Package First" );
				resp.html('<div class="alert alert-danger"><strong>Error! </strong>Please Choose Package First OR Reload page and try again.</div>');
				return false;
			}	
			//resp.html( "Iti Id: " + iti_id + "Package Id: " + package_id + "Customer Id: " + customer_id );
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/cloneItineraryFromPackageId'); ?>",
				data: {package_id: package_id, customer_id: customer_id, parent_iti_id: iti_id},
				dataType: "json",
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						window.location.href = "<?php echo site_url('itineraries/edit/');?>" + res.iti_id + "/" + res.temp_key;
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e,r){
					console.log(r);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			}); 
		}	
	});	
	$(document).on("click",".close",function(){
		$(".modal").hide();
		$("#continue_package, #clone_current_iti").addClass("disabledBtn");
	});
	
});
</script>

<script type="text/javascript">
	$('.child_clone').on('click', function () {
		return confirm('Are you sure to create duplicate itinerary ?');
	});
</script>