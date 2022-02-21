<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php $cab_booking = $cab_booking[0];  ?>
            <?php if($cab_booking){ ?>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-bus"></i>Transporter Name:
                        <strong><?php echo get_transporter_name($cab_booking->transporter_id); ?></strong>
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("vehiclesbooking"); ?>" title="Back">Back</a>
                </div>
            </div>

            <div class="custom_card">
                <form class="form-horizontal" role="form" id="edit_cab_booking">
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class="">Select Vehicle*</label>
                            <select disabled required class="form-control vehicle col-md-4">
                                <option value="">Choose Vehicle</option>
                                <?php $cars = get_car_categories(); 
						if( $cars ){
							foreach($cars as $car){
								$selected = isset($cab_booking->cab_id) && $car->id == $cab_booking->cab_id ? "selected=selected" : "";
								echo '<option value = "'.$car->id .'" '.$selected.' >'.$car->car_name.'</option>';
							}
						}else{
							echo '<option value="">No vehicle available. </option>';
						}
					?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="transporter_list">
                            <label>Select Transporter*</label>
                            <?php //dump( get_all_transporter_by_vehicle_id($cab_booking->cab_id) ); echo $cab_booking->transporter_id; ?>
                            <select disabled required class="form-control transporter">
                                <option value="">Select Transporter</option>
                                <?php $transporter = get_all_transporter_by_vehicle_id($cab_booking->cab_id); 
						if( $transporter ){
							foreach($transporter as $tra){
								$selected = isset($cab_booking->transporter_id) && $tra->id == $cab_booking->transporter_id ? "selected=selected" : "";
								echo '<option value = "'.$tra->id .'" '.$selected.' >'.$tra->trans_name.'</option>';
							}
						}else{
							echo '<option value="">No Transporters available. </option>';
						}
					?>
                            </select>
                            <div class="rhRes"></div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class="">Total Travellers*: </label>
                            <input type="text" disabled required class="form-control"
                                value="<?php echo isset($cab_booking->total_travellers) ? $cab_booking->total_travellers : ""; ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class="">Booking Date*: </label>
                            <div class="clearfix"></div>
                            <div class="input-group input-daterange">
                                <input disabled required type="text" class="form-control"
                                    value="<?php echo isset($cab_booking->picking_date) ? $cab_booking->picking_date : ""; ?>"
                                    id="check_in">
                                <span class="input-group-addon hotel_addon"> to </span>
                                <input disabled required type="text" class="form-control"
                                    value="<?php echo isset($cab_booking->droping_date) ? $cab_booking->droping_date : ""; ?>"
                                    id="check_out">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Reporting/Departure Time*</label>
                            <div class="input-group input-large">
                                <span class="input-group-addon"> Rep. </span>
                                <input disabled type="text" class="form-control timepicker timepicker-no-seconds"
                                    value="<?php echo isset($cab_booking->reporting_time) ? $cab_booking->reporting_time : ""; ?>" />
                                <span class="input-group-addon"> Dep.</span>
                                <input disabled type="text" class="form-control timepicker timepicker-no-seconds"
                                    value="<?php echo isset($cab_booking->departure_time) ? $cab_booking->departure_time : ""; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class="">Booking Duration*: </label>
                            <input type="text" readonly required id="booking_duration" class="form-control"
                                value="<?php echo isset($cab_booking->booking_duration) ? $cab_booking->booking_duration : ""; ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class="">Picking Location*</label>
                            <input type="text" disabled required id="pic_location" placeholder="Picking Location"
                                class="form-control"
                                value="<?php echo isset($cab_booking->pic_location) ? $cab_booking->pic_location : ""; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group2">
                            <label>Dropping Location*: </label>
                            <input type="text" required disabled id="drop_location" placeholder="Droping Location"
                                class="form-control"
                                value="<?php echo isset($cab_booking->drop_location) ? $cab_booking->drop_location : "";?>">
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class=" ">Cab Rate (Per/day)*: </label>
                            <input required disabled type="text" placeholder="Cab Rate"
                                class="form-control cab_rate clearfield"
                                value="<?php echo isset($cab_booking->cab_rate) ? $cab_booking->cab_rate : 0; ?>" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group2">
                            <label>Total Cabs*: </label>
                            <select required disabled class="form-control total_cabs clearfield">
                                <option value=''>Select Cabs</option>
                                <?php for( $i=1 ; $i<=10; $i++ ){
							$selected = isset($cab_booking->total_cabs) && $i == $cab_booking->total_cabs ? "selected=selected" : "";
							echo "<option value=" . $i . " $selected > ". $i . "</option>";
						} ?>
                            </select>
                        </div>
                    </div>
                    <?php $total_cost = $cab_booking->cab_rate * $cab_booking->total_cabs; ?>
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label>Total Cabs Cost (per/day)*: </label>
                            <input readonly required type="text" placeholder="Cab Total Cost per/day"
                                id="cab_total_cost" class="form-control cab_total_cost clearfield"
                                value="<?php echo !empty($total_cost) ? $total_cost : 0; ?>" />
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class=" "><strong>Inclusion Charges:</strong></label>
                            <input class="form-control" disabled id="extra_charges" type="text" placeholder="eg. 100"
                                value="<?php echo isset($cab_booking->extra_charges) ? $cab_booking->extra_charges : 0; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class=""><strong>Total Days*:</strong></label>
                        <input readonly type="text" required id="total_days" class="form-control"
                            value="<?php echo isset($cab_booking->booking_duration) ? $cab_booking->booking_duration : 0; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class=""><strong>Total Cost*:</strong></label>
                        <input readonly class="form-control clearfield" required id="total_cost" type="number"
                            value="<?php echo isset($cab_booking->total_cost) ? $cab_booking->total_cost : 0; ?>">
                    </div>
                    <div class="clearfix"></div>
                    <?php 
					$t_cabs = $cab_booking->total_cabs;
					if( $t_cabs > 0 ){
						echo '<h3 class="text-center uppercase">Update Cab Details</h3>';
						for( $i=0; $i < $t_cabs; $i++ ){ 
						$cab_meta = unserialize( $cab_booking->cab_meta ); 
						$count_cab_meta = count( $cab_meta ); ?>
                    <hr>
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class="">Enter Cab Number ( Cab <?php echo $i+1; ?> ) : </label>
                            <input type='text' required name='cab_meta[<?php echo $i; ?>][taxi_number]'
                                class="form-control" placeholder='Enter Cab Number'
                                value="<?php echo isset($cab_meta[$i]['taxi_number']) ? $cab_meta[$i]['taxi_number'] : ""; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class="">Enter Driver Name ( Cab <?php echo $i+1; ?> ): </label>
                            <input required type='text' name='cab_meta[<?php echo $i; ?>][driver_name]'
                                class="form-control" placeholder='Enter Driver Name'
                                value="<?php if(isset($cab_meta[$i]['driver_name']) ){ echo $cab_meta[$i]['driver_name']; } ?>">
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group2">
                            <label class="">Enter Driver Contact ( Cab <?php echo $i+1; ?> ): </label>
                            <input required type='text' name='cab_meta[<?php echo $i; ?>][driver_contact]'
                                class="form-control" placeholder='Enter Driver Contact'
                                value="<?php if(isset($cab_meta[$i]['driver_contact']) ){ echo $cab_meta[$i]['driver_contact']; } ?>">
                        </div>
                    </div>
                    <hr>
                    <?php }	
					}
					?>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="margiv-top-10 margin-bottom-20 col-md-12">
                        <button type="submit" class="btn green uppercase add_hotel">Update Cab Detail</button>
                    </div>
                    <input type="hidden" name="id" id="booking_id" value="<?php echo $cab_booking->id; ?>">
                </form>
                <div class="clearfix"></div>
                <div id="addresEd"></div>
            </div>
            <?php }else{
				redirect(404);
			} ?>

        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($) {
    //submit form
    var ajaxReq;
    var BOOKING_ID = $("#booking_id").val();
    $("#edit_cab_booking").validate({
        submitHandler: function(form) {
            var resp = $("#addresEd");
            var formData = $("#edit_cab_booking").serializeArray();
            if (ajaxReq) {
                ajaxReq.abort();
            }
            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('vehiclesbooking/ajax_update_cab_details'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    LOADER.show();
                    resp.html(
                        '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                    );
                },
                success: function(res) {
                    LOADER.hide();
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        //console.log("done");
                        $("#edit_cab_booking")[0].reset();
                        window.location.href =
                            "<?php echo site_url("vehiclesbooking");?>";
                        window.location.href =
                            "<?php echo site_url("vehiclesbooking/viewbooking/");?>" +
                            BOOKING_ID;
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        //console.log("error");
                    }
                },
                error: function(e) {
                    LOADER.hide();
                    //console.log(e);
                    resp.html(
                        '<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>'
                    );
                }
            });
            return false;
        }
    });
});
</script>