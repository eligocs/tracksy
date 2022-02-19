<?php if( $hotel_booking[0] ){ ?>
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php $hotel_book = $hotel_booking[0];  ?>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-users"></i>Hotel Name:
                        <strong><?php echo get_hotel_name($hotel_book->hotel_id); ?></strong></div>

                    <a class="btn btn-success" href="<?php echo site_url("hotelbooking"); ?>" title="Back">Back</a>
                </div>
            </div>
			<div class="custom_card">

            <form class="form-horizontal2" role="form" id="addHotelRoomRate">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select State*</label>
                        <select required name="state_id" class="form-control state" id='state'>
                            <option value="">Select state</option>
                            <?php $state_list = get_indian_state_list(); 
					if( $state_list ){
						foreach($state_list as $state){
							$selected = isset($hotel_book->state_id) && $state->id == $hotel_book->state_id ? "selected=selected" : "";
							echo '<option value="'.$state->id.'" '. $selected .' >'.$state->name.'</option>';
						}
					} ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select City*</label>
                        <select required name="hotelcity" class="form-control city">
                            <option value="">Select City</option>
                            <?php $cities = get_city_list($hotel_book->state_id);
					if($cities){
						foreach( $cities as $city ){ ?>
                            <option value="<?php echo $city->id;?>" <?php if ($city->id == $hotel_book->city_id ) { ?>
                                selected="selected" <?php } ?>> <?php echo $city->name ; ?></option>
                            <?php }
					}
					?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select Hotel*</label>
                        <select required name="hotel" class="form-control" id="hotels_list">
                            <option value="">Select Hotel</option>
                            <?php $hotels = get_hotel_list( $hotel_book->city_id );
					if($hotels){
						foreach( $hotels as $hotel ){
							$h_id = $hotel->id ;
							$selected = isset($hotel_book->hotel_id) && $h_id == $hotel_book->hotel_id ? "selected=selected" : "";
							$h_name = $hotel->hotel_name;
							$city = get_city_name($hotel->city_id);
							$cat = get_hotel_cat_name($hotel->hotel_category);
							$printD = "{$h_name}  {$cat}  AT ( {$city} )";
							echo '<option value="'. $hotel->id . '" '. $selected .' >' . $printD .' </option>';
						}
					}else{
						echo '<option value="">No hotel found! Contact your admin.</option>';
					}
					?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Room Category*</label>
                        <select required name="room_type" class="form-control">
                            <option value="">Select Category</option>
                            <?php $roomcat = get_room_categories();
					if($roomcat){
						foreach( $roomcat as $rcat ){
							$c_id = $rcat->room_cat_id ;
							$selected = isset($hotel_book->room_type) && $c_id == $hotel_book->room_type ? "selected=selected" : "";
							echo '<option value="'. $rcat->room_cat_id . '" '. $selected .' >' . $rcat->room_cat_name . '</option>';
						}
					}else{
						echo '<option value="">No category found! Contact your admin.</option>';
					}
					?>
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="">Invoice Id*: </label>
                        <div class="clearfix"></div>
                        <input type="text" class="form-control" required name="invoice_id"
                            value="<?php echo isset($hotel_book->invoice_id) ? $hotel_book->invoice_id : ""; ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="">Total Guest*: </label>
                        <div class="clearfix"></div>
                        <input type="text" id="total_tral" class="form-control" required name="total_travellers"
                            value="<?php echo isset($hotel_book->total_travellers) ? $hotel_book->total_travellers : ""; ?>">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="">Booking Date*: </label>
                        <div class="clearfix"></div>
                        <div class="input-group input-daterange">
                            <input readonly required type="text" class="form-control" name="check_in"
                                value="<?php echo isset($hotel_book->check_in) ? $hotel_book->check_in : ""; ?>"
                                id="check_in">
                            <span class="input-group-addon hotel_addon"> to </span>
                            <input readonly required type="text" class="form-control" name="check_out"
                                value="<?php echo isset($hotel_book->check_out) ? $hotel_book->check_out : ""; ?>"
                                id="check_out">
                        </div>
                    </div>
                </div>
                <?php 
				$check_in 	=  $hotel_book->check_in; 
				$check_out 	=  $hotel_book->check_out;
				$date1 		=	 new DateTime($check_in);
				$t_date2 	=  new DateTime($check_out);
				$total_nights =  $t_date2->diff($date1)->format("%a"); 
			?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="">Total Nights:</label>
                        <input readonly type="text" id="total_nights" class="form-control"
                            value="<?php echo $total_nights; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="">Meal Plan *</label>
                        <?php $mealPlans = get_all_mealplans();
				if($mealPlans){ ?>
                        <select name="meal_plan" required class="form-control">
                            <option value="">Choose Meal Plan</option>
                            <?php foreach( $mealPlans as $mp ){
								$m_id = $mp->id ;
								$selected = isset($hotel_book->meal_plan) && $m_id == $hotel_book->meal_plan ? "selected=selected" : "";
								echo '<option value="'. $mp->id . '" '. $selected .' >' . $mp->name . '</option>';
							} ?>
                        </select>
                        <?php }else{ ?>
                        <input type="text" required readonly class="form-control"
                            placeholder="You need to add meal plan to proceed." value="">
                        <a href="<?php echo base_url("hotels/addmealplan"); ?>" title="Add Meal Plan"> Click here to add
                            Meal Plan</a>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Inclusion: </label>
                        <textarea type="text" name="inclusion" placeholder="Inclusion"
                            class="form-control"><?php echo isset($hotel_book->inclusion) ? $hotel_book->inclusion : ""; ?></textarea>
                    </div>
                </div>

                <?php 
						/* Calculate total cost */
						$total_rooms 	= $hotel_book->total_rooms;
						$room_rate 		= $hotel_book->room_cost;
						$total_room_cost_pernight = $total_rooms * $room_rate;
						$extra_bed 			= $hotel_book->extra_bed;
						$extra_bed_cost 	= !empty($hotel_book->extra_bed_cost) ? $hotel_book->extra_bed_cost : 0;
						$extra_bed_cost_per_night = $extra_bed * $extra_bed_cost;
					?>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=" ">Room Rate(Per/room)*: </label>
                        <input type="text" required placeholder="Room Rate" name="room_rates"
                            class="form-control room_rates clearfield price_input"
                            value="<?php echo isset($hotel_book->room_cost) ? $hotel_book->room_cost : ""; ?>" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Total Room Cost for 1 Night*: </label>
                        <div class="form-group2">
                            <input class="form-control total_room_rates clearfield" readonly required type="text"
                                name="total_room_rates" value="<?php echo $total_room_cost_pernight; ?>"
                                id="total_room_rates">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Total Rooms*: </label>
                        <select required name="total_rooms" class="form-control total_rooms clearfield">
                            <option value=''>Select Rooms</option>
                            <?php for( $i=1 ; $i<=15; $i++ ){
							$selected = isset($hotel_book->total_rooms) && $total_rooms == $i ? "selected=selected" : "";
							echo '<option value="' . $i . '" '. $selected .' > '. $i . '</option>';
						} ?>
                        </select>
                        <?php $extra_bed_check = !empty($hotel_book->extra_bed ) ? "checked=checked" : ""; ?>
                        <?php $without_extra_bed_check = !empty($hotel_book->without_extra_bed_cost ) ? "checked=checked" : ""; ?>
                        <label for="extra_bed_check"><input type="checkbox" <?php echo $extra_bed_check; ?>
                                id="extra_bed_check" name="extra_bed_check" value="Yes"> Click Here to Add extra
                            bed.</label>
                        <label for="without_extra_bed_check"><input type="checkbox"
                                <?php echo $without_extra_bed_check; ?> id="without_extra_bed_check" value="Yes"> Click
                            Here to Without extra bed.</label>
                    </div>
                </div>
                <div class="col-md-9">


                    <?php $display = !empty($hotel_book->extra_bed ) ? "block" : "none"; ?>
                    <div class="extra_bed_section" style="display: <?php echo $display; ?>">
                        <!--extra bed cost section-->
                        <div class="col-md-4">

                            <label class="">Extra Bed Rate (Per/bed)*: </label>
                            <input required type="text" id="extra_bed_rate" name="extra_bed_rate"
                                placeholder="Extra Bed Charges"
                                class="form-control extra_bed_rate clearfield price_input"
                                value="<?php echo isset($hotel_book->extra_bed_cost) ? $hotel_book->extra_bed_cost : 0; ?>" />

                        </div>

                        <div class="col-md-4">

                            <label class="">Extra Bed*: </label>
                            <select required name="extra_bed" class="form-control extra_bed clearfield">
                                <option value="">Select Extra Bed</option>
                                <?php $extra_bed = isset($hotel_book->extra_bed) ? $hotel_book->extra_bed : 0;
								for(  $eb = 1; $eb <= $total_rooms ; $eb++ ){
									$selected = isset($hotel_book->extra_bed) && $extra_bed == $eb ? "selected=selected" : "";
									echo '<option value="' . $eb . '" '. $selected .' > '. $eb . '</option>';
								}
							?>
                            </select>

                        </div>
                        <div class="col-md-4">
                            <label>Total Bed Cost for 1 Night*: </label>
                            <div class="form-group2">
                                <input class="form-control clearfield" type="text" name="total_ex_bed_rate"
                                    value="<?php echo $extra_bed_cost_per_night; ?>" id="total_ex_bed_rate" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <!--Without Extra bed cost section-->
                    <?php $display_w = !empty($hotel_book->without_extra_bed_cost ) ? "block" : "none"; ?>
                    <div class="without_extra_bed_section" style="display: <?php echo $display_w; ?>">


                        <?php 
						/* Calculate total cost */
						$without_extra_bed 				= $hotel_book->without_extra_bed;
						$without_extra_bed_cost 		= $hotel_book->without_extra_bed_cost;
						//Without extra bed default: 1 for old entries
						$w_extra_bed 		= !empty($hotel_book->without_extra_bed) ? $hotel_book->without_extra_bed : 1;
						$without_extra_bed_cost = !empty($hotel_book->without_extra_bed_cost) ? $hotel_book->without_extra_bed_cost * $w_extra_bed : 0;
						$without_bed_cost_per_night = $w_extra_bed * $without_extra_bed_cost;
					?>

                        <div class="col-md-4">
                            <label class=" ">Without Extra Bed Cost (Per/without extra bed)*: </label>
                            <input required type="number" id="without_extra_bed_rate" name="without_extra_bed_cost"
                                placeholder="Without Extra Bed Charges"
                                class="form-control without_extra_bed_rate clearfield price_input"
                                value="<?php echo !empty( $hotel_book->without_extra_bed_cost) ? $hotel_book->without_extra_bed_cost : 0; ?>" />
                        </div>

                        <div class="col-md-4">
                            <label class=" ">Without Extra Bed*: </label>
                            <select required name="without_extra_bed" class="form-control withour_extra_bed clearfield">
                                <option value="">Select</option>
                                <?php $without_extra_bed = isset($hotel_book->without_extra_bed ) ? $hotel_book->without_extra_bed : 0;
								for(  $eb = 1; $eb <= 20 ; $eb++ ){
									$selected = isset($hotel_book->without_extra_bed) && $without_extra_bed == $eb ? "selected=selected" : "";
									echo '<option value="' . $eb . '" '. $selected .' > '. $eb . '</option>';
								}
								?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Total Without Extra Bed Cost per/night*: </label>
                            <div class="form-group">
                                <input class="form-control clearfield" type="text" name="total_without_ex_bed_rate"
                                    value="<?php echo $without_bed_cost_per_night; ?>" id="total_without_ex_bed_rate"
                                    readonly />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!--End Without Extra bed cost section-->

                </div>


                <div class="clearfix"></div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class=" "><strong>Inclusion Charges:</strong></label>
                        <input class="form-control price_input" id="extra_charges" type="number" placeholder="eg: 100"
                            name="extra_charges"
                            value="<?php echo isset($hotel_book->inclusion_cost) ? $hotel_book->inclusion_cost : 0; ?>" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class=" "><strong>Hotel Tax:</strong></label>
                        <input class="form-control price_input" id="hotel_tax" type="number" placeholder="eg: 100"
                            name="hotel_tax"
                            value="<?php echo isset($hotel_book->hotel_tax) ? $hotel_book->hotel_tax : 0; ?>" />
                    </div>
                </div>

                <div class="col-md-3">
                    <label class=""><strong>Total Cost*:</strong></label>
                    <a href="javascript: void(0)" id="calculate_cost">Calculate</a>
                    <input readonly class="form-control clearfield price_input" id="total_cost" type="number"
                        name="total_cost"
                        value="<?php echo isset($hotel_book->total_cost) ? $hotel_book->total_cost : ""; ?>">
                </div>
                <div class="clearfix"></div>

                <hr>
                <input type="hidden" name="id" id="hotel_book_id" value="<?php echo $hotel_book->id; ?>">
                <input type="hidden" id="iti_id" value="<?php echo $hotel_book->iti_id; ?>">
                <div class="margiv-top-10 col-md-12">
                    <!--CHECK IF PENDING REQUEST APPROVED BY GM-->
                    <?php /* if( ( is_gm() || is_admin ) && $hotel_book->is_approved_by_gm == 1 ){ ?>
                    <input type="hidden" name='approve_pending' value="1">
                    <button type="submit" class="btn green uppercase add_hotel">Update And Approve Quotation</button>
                    <?php }else{ ?>
                    <button type="submit" class="btn green uppercase add_hotel">Update</button>
                    <?php } */ ?>
                    <button type="submit" class="btn green uppercase add_hotel">Update</button>
                </div>
                <div class="clearfix"></div>
                <div id="addresEd"></div>
            </form>
			</div>

            <?php }else{
	redirect(404);
} ?>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<script type="text/javascript">
/* Calculate Total Cost for Hotel Booking */
jQuery(document).ready(function($) {
    //Prevent Dot from number field
    $(".price_input").on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 46) {
            e.preventDefault();
            return false;
        }
    });

    function resetAllfields() {
        $('.clearfield').val('');
        $(".total_rooms").attr("disabled", "disabled");
        $("#extra_bed_check").attr("disabled", "disabled");
        $(".extra_bed").attr("disabled", "disabled");
        $("#check_in").val("");
        $("#check_out").val("");
    }

    //Get Total Nights on datepicker change
    var today = new Date(),
        chkin = $('#check_in').val(),
        chkout = $('#check_out').val();
    $('.input-daterange').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: chkin,
            endDate: chkout,
            minDate: today
        },
        function(start, end, label) {
            var starD = start.format('YYYY-MM-DD');
            var endD = end.format('YYYY-MM-DD');
            $('#check_in').val(starD);
            $('#check_out').val(endD);

            var nights = calculateNights(starD, endD);
            //console.log(nights);
            $("#total_nights").val(nights);
            $("#total_cost").val("");
            //alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });


    //calculate total nights
    function calculateNights(start_Date, End_Date) {
        if (jQuery.type(start_Date) === "undefined" && jQuery.type(End_Date) === "undefined") {
            return false;
        } else {
            var startDate = Date.parse(start_Date);
            var endDate = Date.parse(End_Date);
            var timeDiff = endDate - startDate;
            daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            return daysDiff;
        }
    }
    /*calculate total cost*/
    $(document).on("click", "#calculate_cost", function() {
        var _total = $("#total_cost"),
            tc = 0,
            tt = 0,
            total = 0,
            tn = $("#total_nights").val(),
            inc_charge = $("#extra_charges").val(),
            rc = $("#total_room_rates").val(),
            exbed = $("#total_ex_bed_rate").val();
        var total_nights = tn < 1 ? 1 : tn;
        var inclu_charges = inc_charge < 1 ? 0 : inc_charge;
        var total_room_cost = rc < 1 ? 0 : rc;
        var extra_bed_cost = exbed < 1 ? 0 : exbed;

        var total_nights = parseInt(total_nights),
            inclu_charges = parseFloat(inclu_charges),
            total_room_cost = parseFloat(total_room_cost),
            extra_bed_cost = parseFloat(extra_bed_cost),
            hotel_tax = parseFloat($("#hotel_tax").val()),
            without_extra_bed = parseFloat($("#total_without_ex_bed_rate").val());


        if (tn == 0 || tn == "") {
            alert("Please Select valid check_in and check_out dates");
            $("#check_in").focus();
            return false;
        }

        /*calculate total cost*/
        tc = total_room_cost + extra_bed_cost + without_extra_bed;
        tt = tc * total_nights;
        total = inclu_charges + tt + hotel_tax;
        _total.val(total.toFixed(0));
    });
    /* total rooms cost */
    $(document).on("change", ".total_rooms", function() {
        var roomRate = $(".room_rates").val();
        if (roomRate == "" || roomRate == 0) {
            alert("Please Add room rate first!");
            $(".room_rates").focus();
            $(this).val("");
            return false;
        }
        var room_rate = parseFloat($(".room_rates").val());
        var _this = $(this),
            total = _this.val() * room_rate;
        $("#total_room_rates").val(total.toFixed(0));
        $("#total_cost").val("");
    });

    //change room rate
    $(document).on("blur", ".room_rates", function() {
        //$(".total_rooms").val(""); 
        //var _this = $(this);
        var _this_val = parseFloat($(this).val());
        if (_this_val < 10 || $.isNumeric($(this).val()) == false) {
            alert("Please enter rate more than 10/- ");
            $(this).val("");
            $(this).attr('value', "");
        }

        var total_rooms = $(".total_rooms").val() != "" ? parseFloat($(".total_rooms").val()) : 0;
        total = _this_val * total_rooms;
        $("#total_room_rates").val(total.toFixed(0));
        $("#total_room_rates").attr("value", total.toFixed(0));
    });


    $(document).on("blur", "#extra_bed_rate", function() {
        //$(".extra_bed").val(""); 
        var _this_val = parseFloat($(this).val());
        var extra_bed = $(".extra_bed").val() != "" ? parseFloat($(".extra_bed").val()) : 0;
        var total = _this_val * extra_bed;
        $("#total_ex_bed_rate").val(total.toFixed(0));
        $("#total_ex_bed_rate").attr("value", total.toFixed(0));
    });

    $(document).on("blur", "#without_extra_bed_rate", function() {
        //$(".withour_extra_bed, #total_without_ex_bed_rate").val(""); 
        var _this_val = parseFloat($(this).val());
        var withour_extra_bed = $(".withour_extra_bed").val() != "" ? parseFloat($(".withour_extra_bed")
            .val()) : 0;
        var total = _this_val * withour_extra_bed;
        $("#total_without_ex_bed_rate").val(total.toFixed(0));
        $("#total_without_ex_bed_rate").attr("value", total.toFixed(0));
    });


    /* .extra_bed cost */
    $(document).on("change", ".extra_bed", function() {
        var _this = $(this),
            eRate = $("#extra_bed_rate").val(),
            extra_bed_rate = parseFloat(eRate);
        if (eRate == "" || eRate == 0) {
            alert("Please Add extra bed rate rate first!");
            $("#extra_bed_rate").focus();
            $(this).val("");
            return false;
        }
        var total = _this.val() * extra_bed_rate;
        $("#total_ex_bed_rate").val(total.toFixed(0));
        $("#total_ex_bed_rate").attr("value", total.toFixed(0));
        $("#total_cost").val("");
    });

    /* without extra_bed cost */
    $(document).on("change", ".withour_extra_bed", function() {
        var _this = $(this),
            eRate = $("#without_extra_bed_rate").val(),
            wextra_bed_rate = parseFloat(eRate);
        if (eRate == "" || eRate == 0) {
            alert("Please Add without extra bed rate rate first!");
            $("#without_extra_bed_rate").focus();
            $(this).val("");
            return false;
        }
        var wtotal = _this.val() * wextra_bed_rate;
        $("#total_without_ex_bed_rate").val(wtotal.toFixed(0));
        $("#total_without_ex_bed_rate").attr("value", wtotal.toFixed(0));
        $("#total_cost").val("");
    });

    /* Inclusion Charges */
    $(document).on("blur", ".price_input", function() {
        $("#total_cost").val("");
        var _this = $(this).val();
        var value = parseFloat($(this).val());
        if (value < 0 || $.isNumeric($(this).val()) == false) {
            alert("Please enter positive numeric value");
            $(this).val(0);
            $(this).attr('value', 0);
            $(this).attr('value', value);
        } else {
            if (_this != '') {
                $(this).attr('value', value);
            } else {
                $(this).val(0);
                $(this).attr('value', 0);
            }
        }
    });
});
</script>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $(document).on("change", ".total_rooms", function() {
        $("#total_ex_bed_rate").val("");
        var total_rooms = $(this).val();
        var ext_beds = $(".extra_bed");
        ext_beds.html("<option value=''>Select extra beds</option>");
        for (var i = 1; i <= total_rooms; i++) {
            ext_beds.append("<option value=" + i + ">" + i + "</option>");
        }
    });
    /* Check for extra bed */
    $(document).on('click', '#extra_bed_check', function(e) {
        $("#total_ex_bed_rate, #total_cost,.extra_bed, #extra_bed_rate ").val("");
        if ($('#extra_bed_check').is(':checked')) {
            $(".extra_bed_section").show();
            $(".extra_bed_rate").addClass("ex_rate");
        } else {
            $(".extra_bed_rate").removeClass("ex_rate");
            $(".extra_bed_section").hide();
        }
    });
    /* Check for without extra bed */
    $(document).on('click', '#without_extra_bed_check', function(e) {
        $("#total_cost").val("");
        if ($('#without_extra_bed_check').is(':checked')) {
            $(".without_extra_bed_section").show();
        } else {
            $("#without_extra_bed_rate,.withour_extra_bed,#total_without_ex_bed_rate").val(0);
            $(".without_extra_bed_section").hide();
        }
    });

    //Submit form
    var ajaxReq;
    $("#addHotelRoomRate").validate({
        rules: {
            total_cost: {
                required: true,
                number: true
            },
        },
        submitHandler: function(form) {
            var resp = $("#addresEd");
            var hotel_book_id = $("#hotel_book_id").val();
            var iti_id = $("#iti_id").val();
            console.log(hotel_book_id);
            var formData = $("#addHotelRoomRate").serializeArray();
            //console.log( formData );
            if (ajaxReq) {
                ajaxReq.abort();
            }
            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('hotelbooking/ajax_edit_book_hotel'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    $(".fullpage_loader").show();
                    resp.html(
                        '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                        );
                },
                success: function(res) {
                    $(".fullpage_loader").hide();
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success !</strong> ' +
                            res.msg + '</div>');
                        //console.log("done");
                        $("#addHotelRoomRate")[0].reset();
                        window.location.href =
                            "<?php echo site_url("hotelbooking/view/");?>" +
                            hotel_book_id + '/' + iti_id;
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        //console.log("error");
                    }
                },
                error: function(e) {
                    $(".fullpage_loader").hide();
                    //console.log(e);
                    resp.html(
                        '<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>'
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
    function resetAllValues() {
        $('.clearfield').val('');
        $(".total_rooms").attr("disabled", "disabled");
        $("#extra_bed_check").attr("disabled", "disabled");
        $(".extra_bed").attr("disabled", "disabled");
    }
    jQuery.validator.addMethod("multiemail", function(value, element) {
        if (this.optional(element)) {
            return true;
        }
        var emails = value.split(','),
            valid = true;
        for (var i = 0, limit = emails.length; i < limit; i++) {
            value = emails[i];
            valid = valid && jQuery.validator.methods.email.call(this, value, element);
        }
        return valid;
    }, "Please separate valid email addresses with a comma and do not use spaces.");
    /* get Hotels from City */
    $(document).on('change', 'select.hotel', function() {
        $(".roomcat").removeAttr("disabled");
        $(".roomcat").val("");
        resetAllValues();
    });

    /*get Hotels Rate By Hotel ID from City*/
    $(document).on('change', 'select.roomcat', function() {
        /* $("#total_cost").val("");
        $(".total_rooms").val(""); */
        resetAllValues();
        var room_cat = $(".roomcat option:selected").val();
        var hotel_id = $(".hotel").val();
        if (room_cat == "") {
            alert("Please Select Room Category!");
            $("input[name='room_rates']").val("");
            $("input[name='extra_bed_rate']").val("");
            $(".total_rooms").attr("disabled", "disabled");
            $("#extra_bed_check").attr("disabled", "disabled");
            $(".extra_bed").attr("disabled", "disabled");
        } else {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo base_url('AjaxRequest/get_rooms_rates'); ?>",
                data: {
                    room_cat: room_cat,
                    hotel_id: hotel_id
                },
                beforeSend: function() {

                },
                success: function(res) {
                    if (res.status = true) {
                        var rr = res.room_rate;
                        var ex = res.extra_bed;
                        if (typeof(rr) === "undefined" && typeof(ex) === "undefined") {
                            alert(
                                "Select other hotel/room category or Contact Administrator/Manager.Because Room Rate Not Found!.");
                            $(".total_rooms").attr("disabled", "disabled");
                            $("#extra_bed_check").attr("disabled", "disabled");
                            $(".extra_bed").attr("disabled", "disabled");
                            $("input[name='room_rates']").val("");
                            $("input[name='extra_bed_rate']").val("");
                        } else {
                            $(".total_rooms").removeAttr("disabled");
                            $("#extra_bed_check").removeAttr("disabled");
                            $(".extra_bed").removeAttr("disabled");
                            $("input[name='room_rates']").val(rr);
                            $("input[name='extra_bed_rate']").val(ex);
                        }
                        //console.log(rr);
                        //console.log(ex);
                    } else {
                        //console.log( "error" );
                        alert(
                            "Select other hotel/room category or Contact Administrator/Manager.");
                    }
                },
                error: function() {
                    //console.log( "error 1 " );
                    alert(
                        "Before you proceed please add room rate! or Contact Administrator/Manager.");
                }
            });
        }
    });

});
</script>

<script>
/*get cities from state*/
jQuery(document).ready(function($) {
    $(document).on('change', 'select.state', function() {
        var selectState = $(".state option:selected").val();
        var _this = $(this);
        $("#hotels_list").val("");
        _this.parent().append(
            '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelCityData'); ?>",
            data: {
                state: selectState
            }
        }).done(function(data) {
            $(".bef_send").hide();
            $(".city").html(data);
            $("#hotels_list").html("<option vlaue=''>select hotel</option>");
        }).error(function() {
            $("#city_list").html("Error! Please try again later!");
        });
    });
    /*get cities from state*/
    $(document).on('change', 'select.city', function() {
        var selectcity = $(".city option:selected").val();
        var _this = $(this);
        _this.parent().append(
            '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotellistByCityId'); ?>",
            data: {
                hotel: selectcity
            }
        }).done(function(data) {
            $(".bef_send").hide();
            $("#hotels_list").html(data);
        }).error(function() {
            $("#hotels_list").html("Error! Please try again later!");
        });
    });
});
</script>