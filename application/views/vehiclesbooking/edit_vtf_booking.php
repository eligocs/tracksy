<?php if( $travel_booking ){
   $tra_book = $travel_booking[0];	
   $booking_type = $tra_book->booking_type;
   ?>
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus"></i>Add <?php echo $booking_type; ?> Booking Details Flight/Train/Volvo
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("vehiclesbooking/allvehiclesbookings"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <style>
            #arr_location-error {
                bottom: -35px;
            }

            #drop-error {
                top: 35px;
            }
            </style>
            <!--End if existing booking-->
            <div class="custom_card">
                <div class="tour_info text-left">
                    <h2 class="text-center">
                         <strong class='green'><?php echo  ucfirst($booking_type) . "</strong> Booking Details"?>
                </div>
                <div class="row">
                    <form class="form-horizontal" role="form" id="bookTrasVTF">
                        <?php if( $booking_type == 'volvo' ){
					$type = "Vovlo";
					// Change form Field Name / Placeholder
					$t_name = "Bus Name";
					$t_name_placeholder = "Bus Name eg. Himsuta Vovlo Bus";
					$t_number = "Bus Number";
					$t_number_placeholder = "Bus number for multi buses use comma to seprate.eg: HP63-5656, HP64-5657";
					}elseif( $booking_type == 'train'  ){
					$type = "Train";
					// Change form Field Name / Placeholder
					$t_name = "Train Name";
					$t_name_placeholder = "Train Name eg. SHATABDI EXPRESS";
					$t_number = "Train Number";
					$t_number_placeholder = "Train number. eg: 01202, 01203";
					}elseif( $booking_type == 'flight' ){
					$type = "Flight";
					// Change form Field Name / Placeholder
					$t_name = "Flight Name";
					$t_name_placeholder = "Flight Name eg. Spicejet Flight";
					$t_number = "Flight Number";
					$t_number_placeholder = "Flight number .eg: AI 0946";
					}else{
					$type = "Invalid Type";
					echo "Invalid Request";
					die;
					} ?>
                        <div class="col-md-offset-4 col-md-4">
                            <div class="form-group2">
                                <label class="">Booking Type: </label>
                                <select disabled name="inp[booking_type]" class="form-control book_type">
                                    <option <?php echo $booking_type == 'volvo' ? 'selected="selected"' : ''; ?>
                                        value='volvo'>Volvo</option>
                                    <option <?php echo $booking_type == 'train' ? 'selected="selected"' : ''; ?>
                                        value='train'>Train</option>
                                    <option <?php echo $booking_type == 'flight' ? 'selected="selected"' : ''; ?>
                                        value='flight'>Flight</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class="">Itinerary Id*: </label>
                                <input readonly type="text" name="inp[iti_id]" id="iti_id" class="form-control"
                                    id="iti_id"
                                    value="<?php if( isset($tra_book->iti_id) ){ echo $tra_book->iti_id; } ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class="">Customer Name*: </label>
                                <input readonly type="text" id="customer_id" class="form-control"
                                    value="<?php if( isset($tra_book->customer_id) ){ echo get_customer_name($tra_book->customer_id); } ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class=" ">Number of Passengers:*</label>
                                <input type="text" placeholder="Number of Passengers" name="inp[total_travellers]"
                                    class="form-control cab_rate "
                                    value="<?php if( isset($tra_book->total_travellers) ){ echo $tra_book->total_travellers; } ?>" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class=""><?php echo $t_name; ?>*: </label> <!-- eg. Bus Name-->
                                <input type="text" data-toggle="tooltip" placeholder="<?php echo $t_name; ?>"
                                    title="<?php echo $t_name_placeholder;?>" name="inp[t_name]" class="form-control"
                                    value="<?php if( isset($tra_book->t_name) ){ echo $tra_book->t_name; } ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class=" "><?php echo $t_number;?> *:</label>
                                <input type="text" data-toggle="tooltip" placeholder="<?php $t_number; ?>"
                                    title="<?php echo $t_number_placeholder; ?>" name="inp[t_number]"
                                    class="form-control"
                                    value="<?php if( isset($tra_book->t_number) ){ echo $tra_book->t_number; } ?>" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class="">Class Type*: </label>
                                <?php $c_type = isset($tra_book->class_type) ? $tra_book->class_type : ""; ?>
                                <select required name="inp[class_type]" class="form-control class_type ">
                                    <option value=''>Select Type</option>
                                    <?php if( $booking_type == 'volvo'){ ?>
                                    <option <?php echo $c_type == "AC" ? "selected=selected" : "";?>value='AC'>AC
                                    </option>
                                    <option <?php echo $c_type== "NON/AC" ? "selected=selected" : "" ?>value='NON/AC'>
                                        NON/AC
                                    </option>
                                    <option
                                        <?php echo $c_type== "Ordinary" ? "selected=selected" : "" ?>value='ordinary'>
                                        Ordinary
                                    </option>
                                    <option <?php echo $c_type== "other" ? "selected=selected" : "" ?>value='other'>
                                        other
                                    </option>
                                    <?php }elseif( $booking_type == 'train' ){  ?>
                                    <option <?php echo $c_type == "First Class" ? "selected=selected" : "";?>
                                        value='First Class'>First Class</option>
                                    <option <?php echo $c_type == "AC First Class" ? "selected=selected" : "";?>
                                        value='AC First Class'>AC First Class</option>
                                    <option <?php echo $c_type == "AC 2-Tier" ? "selected=selected" : "";?>
                                        value='AC 2-Tier'>AC 2-Tier</option>
                                    <option <?php echo $c_type == "AC 3-Tier" ? "selected=selected" : "";?>
                                        value='AC 3-Tier'>AC 3-Tier</option>
                                    <option <?php echo $c_type == "AC Chair Car" ? "selected=selected" : "";?>
                                        value='AC Chair Car'>AC Chair Car</option>
                                    <option <?php echo $c_type == "Second Sitting" ? "selected=selected" : "";?>
                                        value='Second Sitting'>Second Sitting</option>
                                    <option <?php echo $c_type == "Sleeper" ? "selected=selected" : "";?>
                                        value='Sleeper'>
                                        Sleeper
                                    </option>
                                    <option <?php echo $c_type == "other" ? "selected=selected" : "";?> value='other'>
                                        other
                                    </option>
                                    <?php }elseif( $booking_type == 'flight' ){ ?>
                                    <option <?php echo $c_type == "Economy Class" ? "selected=selected" : "";?>
                                        value='Economy Class'>Economy Class</option>
                                    <option <?php echo $c_type == "Business Class" ? "selected=selected" : "";?>
                                        value='Business Class'>Business Class</option>
                                    <option <?php echo $c_type == "First Class" ? "selected=selected" : "";?>
                                        value='First Class'>First Class</option>
                                    <option <?php echo $c_type == "Other" ? "selected=selected" : "";?> value='Other'>
                                        Other
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class="">Departure / Arrival Date*: </label>
                                <div class="clearfix"></div>
                                <div class="input-group date-picker input-daterange  " data-date=""
                                    data-date-format="yyyy-mm-dd">
                                    <span class="input-group-addon"> Dep. </span>
                                    <input required readonly type="text" class="form-control" name="inp[dep_date]"
                                        value="<?php if( isset($tra_book->dep_date) ){ echo $tra_book->dep_date; } ?>"
                                        id="check_in">
                                    <span class="input-group-addon"> Arr. </span>
                                    <input required readonly type="text" class="form-control" name="inp[arr_date]"
                                        value="<?php if( isset($tra_book->arr_date) ){ echo $tra_book->arr_date; } ?>"
                                        id="check_out">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class="control-label">Departure/Arrival Time*</label>
                                <div class="input-group">
                                    <span class="input-group-addon"> Dep. </span>
                                    <input required name="inp[dep_time]" type="text"
                                        class="form-control timepicker timepicker-no-seconds"
                                        value="<?php if( isset($tra_book->dep_time) ){ echo $tra_book->dep_time; } ?>" />
                                    <span class="input-group-addon"> Arr. </span>
                                    <input required name="inp[arr_time]" type="text"
                                        class="form-control timepicker timepicker-no-seconds"
                                        value="<?php if( isset($tra_book->arr_time) ){ echo $tra_book->arr_time; } ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class=" ">Seat Numbers:</label>
                                <textarea data-toggle="tooltip" placeholder="Seat number"
                                    title="Seat Number Seprated by Comma eg. 23,32,2. For Multi transporter use vehicle number eg: HP-63 6564(2,3,4,5), HP-63 6565(2,3,5)"
                                    name="inp[seat_numbers]"
                                    class="form-control"><?php if( isset($tra_book->seat_numbers) ){ echo $tra_book->seat_numbers; } ?></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group2">
                                <label class="control-label">Departure/Arrival Location*</label>
                                <div class="input-group">
                                    <span class="input-group-addon"> Dep. Location </span>
                                    <input type="text" required name="inp[dep_loc]" id="arr_location"
                                        placeholder="Departure Location" class="form-control"
                                        value="<?php if( isset($tra_book->dep_loc) ){ echo $tra_book->dep_loc; } ?>">
                                    <span class="input-group-addon"> Arr. Location</span>
                                    <input type="text" required name="inp[arr_loc]" id="drop"
                                        placeholder="Arrival Location" class="form-control"
                                        value="<?php if( isset($tra_book->arr_loc) ){ echo $tra_book->arr_loc; } ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group2">
                                <label>Number of Seats: </label>
                                <select required name="inp[total_seats]" class="form-control total_seats ">
                                    <option value=''>Select Seats</option>
                                    <?php
							$total_seats = isset($tra_book->total_seats) ? $tra_book->total_seats : "";	
							for( $i=1 ; $i<=50; $i++ ){
								$select = $total_seats == $i ? "selected=selected" : "";
								echo "<option value='{$i}' {$select} > {$i} </option>";
							} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group2">
                                <label class="red"><strong>Cost per/seat:</strong></label>
                                <input type='number' required data-toggle="tooltip" placeholder="Cost Per/seat"
                                    title="Cost Per Seat" name="inp[cost_per_seat]" class="form-control cost_per_seat"
                                    value="<?php if( isset($tra_book->cost_per_seat) ){ echo $tra_book->cost_per_seat; } ?>">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-3">
                            <div class="form-group2">
                                <label class=" ">Ticket Numbers:</label>
                                <textarea type="text" data-toggle="tooltip" placeholder="Ticket number"
                                    title="For Multi transporter use vehicle number eg: HP-63 6564(tick285,tick286,tick286), HP-63 6565(3332,3433,235)"
                                    name="inp[ticket_numbers]"
                                    class="form-control"><?php if( isset($tra_book->ticket_numbers) ){ echo $tra_book->ticket_numbers; } ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group2">
                                <label class=" ">Other Info:</label>
                                <textarea placeholder="Booking other info" name="inp[other_info]"
                                    class="form-control"><?php if( isset($tra_book->other_info) ){ echo $tra_book->other_info; } ?></textarea>
                            </div>
                        </div>
                        <?php $return_ticket = !empty($tra_book->return_t_name ) && !empty( $tra_book->return_class_type ) ? "checked=checked" : "";?>
                        <div class="col-md-2">
                            <div class="form-group2">
                                <label for="return_ticket">Return ticket:
                                    <input type="checkbox" id="return_ticket" <?php echo $return_ticket; ?> value="yes"
                                        class="form-control return_ticket">
                                </label>
                            </div>
                        </div>
                        <!--Return Ticket Process-->
                        <?php $display = !empty($return_ticket) ? "block" : "none"; ?>
                        <div id="return" style="display: <?php echo $display; ?>">
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group2">
                                    <label class=""><?php echo $t_name; ?> (Return Trip): </label>
                                    <input required type="text" data-toggle="tooltip"
                                        placeholder="<?php echo $t_name; ?>" title="<?php echo $t_name_placeholder; ?>"
                                        name="inp[return_t_name]" class="form-control clearfield"
                                        value="<?php if( isset($tra_book->return_t_name) ){ echo $tra_book->return_t_name; } ?>" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group2">
                                    <label class=" "><?php echo $t_number; ?> (Return Trip):</label>
                                    <input type="text" data-toggle="tooltip" placeholder="<?php echo $t_number; ?> "
                                        title="<?php echo $t_number_placeholder; ?>" name="inp[return_t_number]"
                                        class="form-control clearfield"
                                        value="<?php if( isset($tra_book->return_t_number) ){ echo $tra_book->return_t_number; } ?>" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group2">
                                    <label class="">Class Type (Return Trip): </label>
                                    <?php $c_rtype = isset($tra_book->return_class_type) ? $tra_book->return_class_type : ""; ?>
                                    <select required name="inp[return_class_type]"
                                        class="form-control clearfield return_booking_type ">
                                        <option value=''>Select Type</option>
                                        <?php if( $booking_type == 'volvo'){ ?>
                                        <option <?php echo $c_rtype == "AC" ? "selected=selected" : "";?>value='AC'>AC
                                        </option>
                                        <option
                                            <?php echo $c_rtype== "NON/AC" ? "selected=selected" : "" ?>value='NON/AC'>
                                            NON/AC
                                        </option>
                                        <option
                                            <?php echo $c_rtype== "Ordinary" ? "selected=selected" : "" ?>value='ordinary'>
                                            Ordinary
                                        </option>
                                        <option
                                            <?php echo $c_rtype== "other" ? "selected=selected" : "" ?>value='other'>
                                            other
                                        </option>
                                        <?php }elseif( $booking_type == 'train' ){  ?>
                                        <option <?php echo $c_rtype == "First Class" ? "selected=selected" : "";?>
                                            value='First Class'>First Class</option>
                                        <option <?php echo $c_rtype == "AC First Class" ? "selected=selected" : "";?>
                                            value='AC First Class'>AC First Class</option>
                                        <option <?php echo $c_rtype == "AC 2-Tier" ? "selected=selected" : "";?>
                                            value='AC 2-Tier'>AC 2-Tier</option>
                                        <option <?php echo $c_rtype == "AC 3-Tier" ? "selected=selected" : "";?>
                                            value='AC 3-Tier'>AC 3-Tier</option>
                                        <option <?php echo $c_rtype == "AC Chair Car" ? "selected=selected" : "";?>
                                            value='AC Chair Car'>AC Chair Car</option>
                                        <option <?php echo $c_rtype == "Second Sitting" ? "selected=selected" : "";?>
                                            value='Second Sitting'>Second Sitting</option>
                                        <option <?php echo $c_rtype == "Sleeper" ? "selected=selected" : "";?>
                                            value='Sleeper'>Sleeper</option>
                                        <option <?php echo $c_rtype == "other" ? "selected=selected" : "";?>
                                            value='other'>
                                            other
                                        </option>
                                        <?php }elseif( $booking_type == 'flight' ){ ?>
                                        <option <?php echo $c_rtype == "Economy Class" ? "selected=selected" : "";?>
                                            value='Economy Class'>Economy Class</option>
                                        <option <?php echo $c_rtype == "Business Class" ? "selected=selected" : "";?>
                                            value='Business Class'>Business Class</option>
                                        <option <?php echo $c_rtype == "First Class" ? "selected=selected" : "";?>
                                            value='First Class'>First Class</option>
                                        <option <?php echo $c_rtype == "Other" ? "selected=selected" : "";?>
                                            value='Other'>
                                            Other
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3">
                                <div class="form-group2">
                                    <label class="">Departure Date* (Return trip): </label>
                                    <div class="clearfix"></div>
                                    <input type="text" readonly class="form-control datepicker clearfield"
                                        name="inp[return_dep_date]"
                                        value="<?php if( isset($tra_book->return_dep_date) ){ echo $tra_book->return_dep_date; } ?>"
                                        id="check_out">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Departure Time (Return trip): </label>
                                    <input name="inp[return_dep_time]" type="text"
                                        class="form-control timepicker timepicker-no-seconds clearfield"
                                        value="<?php if( isset($tra_book->return_dep_time) ){ echo $tra_book->return_dep_time; } ?>" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group2">
                                    <label>Departure Location (Return trip): </label>
                                    <input type="text" data-toggle="tooltip" name="inp[return_dep_loc]"
                                        id="return_dep_loc" title="Departure Location eg. (Manali-Shimla)"
                                        Placeholder="Departure Location" class="form-control clearfield"
                                        value="<?php if( isset($tra_book->return_dep_loc) ){ echo $tra_book->return_dep_loc; } ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group2">
                                    <label class=" ">Ticket Numbers (Return trip):</label>
                                    <textarea type="text" data-toggle="tooltip" placeholder="Ticket number"
                                        title="(Return Trip) For Multi transporter use vehicle number eg: HP-63 6564(tick285,tick286,tick286), HP-63 6565(3332,3433,235)"
                                        name="inp[return_ticket_numbers]"
                                        class="form-control clearfield"><?php if( isset($tra_book->return_ticket_numbers) ){ echo $tra_book->return_ticket_numbers; } ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4">
                                <div class="form-group2">
                                    <label>Number of Seats (Return trip): </label>
                                    <select required name="inp[return_total_seats]"
                                        class="form-control return_total_seats clearfield">
                                        <option value=''>Select Seats</option>
                                        <?php 
								$total_rseats = isset($tra_book->return_total_seats) ? $tra_book->return_total_seats : "";	
								for( $i=1 ; $i<=50; $i++ ){
									$rselect = $total_rseats == $i ? "selected=selected" : "";
									echo "<option value='{$i}' {$rselect} > {$i} </option>";
								} ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group2">
                                    <label class="red">Cost per/seat (Return Trip):</label>
                                    <input required type='number' data-toggle="tooltip"
                                        placeholder="Cost Per/seat (Return trip)" title="Cost Per Seat"
                                        name="inp[cost_per_seat_return_trip]"
                                        class="form-control cost_per_seat_return_trip clearfield"
                                        value="<?php if( isset($tra_book->cost_per_seat_return_trip) ){ echo $tra_book->cost_per_seat_return_trip; } ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group2">
                                    <label class=" ">Seat Numbers (Return Trip):</label>
                                    <textarea type="text" data-toggle="tooltip" placeholder="Seat number"
                                        title="(Return Trip) Seat Number Seprated by Comma eg. 23,32,2. For Multi transporter use vehicle number eg: HP-63 6564(2,3,4,5), HP-63 6565(2,3,5)."
                                        name="inp[return_seat_numbers]"
                                        class="form-control clearfield"><?php if( isset($tra_book->return_seat_numbers) ){ echo $tra_book->return_seat_numbers; } ?></textarea>
                                </div>
                            </div>
                        </div>
                        <!--End Return Ticket Process-->
                        <div class="clearfix"></div>
                        <div class="col-md-12 margin-top-20">
                            <?php /* if( ( is_gm() || is_admin() ) && $tra_book->is_approved_by_gm == 1 ){ ?>
                            <input type="hidden" name='approve_pending' value="1">
                            <button type="submit" class="btn green uppercase add_hotel"
                                onclick="return confirm('Are you sure to approve Quotation? ')">Update And Approve
                                Quotation</button>
                            <?php }else{ ?>
                            <button type="submit" class="btn green uppercase add_hotel">Update Changes</button>
                            <?php } */ ?>
                            <button type="submit" class="btn green uppercase add_hotel">Update Changes</button>
                        </div>
                </div>
                <div class="clearfix"></div>
                <div id="addresEd"></div>
                <input type="hidden" id="id" name="inp[id]" value="<?php echo $tra_book->id; ?>" />
                <input type="hidden" id="iti_id" value="<?php echo $tra_book->iti_id; ?>" />
                </form>
            </div>

        </div>
    </div>
    <?php }else{
      redirect(404);
      } ?>
    <!-- Modal -->
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    //submit form
    var ID = $("#id").val();
    var ITI_ID = $("#iti_id").val();
    $("#bookTrasVTF").validate({
        submitHandler: function(form) {
            var resp = $("#addresEd");
            var formData = $("#bookTrasVTF").serializeArray();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('vehiclesbooking/ajax_edit_vtf'); ?>",
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
                        $("#bookTrasVTF")[0].reset();
                        window.location.href =
                            "<?php echo site_url("vehiclesbooking/viewvehiclebooking/"); ?>" +
                            ID + "/" + ITI_ID;
                        //location.reload();
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
<script type="text/javascript">
jQuery(document).ready(function($) {
    var ch_inDate = $("#tra_date").val();
    var ch_outDate = $("#tra_end_date").val();

    $('.input-daterange').datepicker({
        startDate: "1d"
    }).on('changeDate', function(ev) {
        $('input.datepicker').val("");
        var _thisDate = ev.date;
        var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
        $('input.datepicker').datepicker('setStartDate', nextDayMin);
    });
    $('.datepicker').datepicker({
        startDate: "1d",
        format: "yyyy-mm-dd"
    });
    /* Check for Return Ticket */
    $(document).on('click', '.return_ticket', function(e) {
        if ($('.return_ticket').is(':checked')) {
            $("#return").show();
        } else {
            $("#return").hide();
            clearfield();
        }
    });

    function clearfield() {
        return $(".clearfield").val("");
    }
});


jQuery(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        placement: 'top'
    });
});
</script>