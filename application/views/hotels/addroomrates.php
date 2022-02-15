<div class="page-container customer_content">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-users"></i>Add Room Rate</div>
                    <a class="btn btn-success" href="<?php echo site_url("hotels/viewroomrates"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <div class="second_custom_card">
                <form role="form" id="addHotelRoomRate" action="<?php echo base_url( "hotels/add_room_rates" ); ?>"
                    method="post">
                    <?php //echo get_country_name(101);	?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Select Country*</label>
                            <select name="country" class="form-control country">
                                <option value="">Choose Country</option>
                                <?php $country = get_country_list();
							if($country){
								foreach( $country as $c ){
									echo '<option value="'. $c->id . '">' . $c->name . '</option>';
								}
							}
							?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div id="state_list">
                            <div class='form-group'><label>State*:</label><select disabled name='state'
                                    class='form-control state'>
                                    <option value="">Select state</option>
                                </select></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div id="city_list">
                            <div class='form-group'><label>City*:</label><select disabled name='city'
                                    class='form-control city'>
                                    <option value="">Select City</option>
                                </select></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div id="hotel_list">
                            <div class='form-group'><label>Hotel*:</label><select disabled name='hotel'
                                    class='form-control hotel'>
                                    <option value="">Select Hotel</option>
                                </select></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <style>
                    .single_rate_section {
                        margin-top: 10px;
                    }
                    </style>


                    <!--Start field Reaper -->
                    <div class="mt-repeater-rates">
                        <div data-repeater-list="hotel_rates_meta">
                            <div data-repeater-item class="mt-repeater-rates-item">
                                <div class="row single_rate_section">
                                    <div class="col-md-3 mt-repeater-rates-input">
                                        <div class="form-group">
                                            <label class="control-label">Room Category*</label>
                                            <select name="room_cat_id" required class="form-control roomcat">
                                                <option value="">Choose Room Category</option>
                                                <?php $roomcat = get_room_categories();
										if($roomcat){
											foreach( $roomcat as $rcat ){
												echo '<option value="'. $rcat->room_cat_id . '">' . $rcat->room_cat_name . '</option>';
											}
										}
										?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-innerrepeater-hotel inner_hotel_repeater col-md-9">
                                        <div data-repeater-list="rates_inner_meta" class="clearfix hotel_inner">
                                            <div data-repeater-item class="mt-innerrepeater-hotel-item">
                                                <div class="col-md-3 mt-innerrepeater-hotel-input">
                                                    <div class="form-group">
                                                        <label class="control-label">Season Type*</label>
                                                        <?php $seasons = get_all_seasons();
												if($seasons){ ?>
                                                        <select name="season_id" required class="form-control">
                                                            <option value="">Choose Season Type</option>
                                                            <?php foreach( $seasons as $season ){
																echo '<option value="'. $season->id . '">' . $season->season_name . '</option>';
															} ?>
                                                        </select>
                                                        <?php }else{ ?>
                                                        <input type="text" required readonly class="form-control"
                                                            placeholder="You need to add season to proceed." value="">
                                                        <a href="<?php echo base_url("hotels/addseason"); ?>"
                                                            title="Add Season">Click here to add season</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-innerrepeater-hotel-input">
                                                    <div class="form-group">
                                                        <label class="control-label">Meal Plan*</label>
                                                        <?php $mealPlans = get_all_mealplans();
												if($mealPlans){ ?>
                                                        <select name="meal_plan_id" required class="form-control">
                                                            <option value="">Choose Meal Plan</option>
                                                            <?php foreach( $mealPlans as $mp ){
																echo '<option value="'. $mp->id . '">' . $mp->name . '</option>';
															} ?>
                                                        </select>
                                                        <?php }else{ ?>
                                                        <input type="text" required readonly class="form-control"
                                                            placeholder="You need to add meal plan to proceed."
                                                            value="">
                                                        <a href="<?php echo base_url("hotels/addmealplan"); ?>"
                                                            title="Add Meal Plan">Click here to add Meal Plan</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-innerrepeater-hotel-input">
                                                    <div class="form-group">
                                                        <label class="control-label">Room Rate*</label>
                                                        <input type="number" required placeholder="Room Rate"
                                                            maxlength="10" minlength="2" name="room_rates"
                                                            class="form-control price_input" value="" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-innerrepeater-hotel-input">
                                                    <div class="form-group">
                                                        <label class="control-label">Extra Bed Rates*</label>
                                                        <input type="number" required name="extra_bed_rate"
                                                            maxlength="10" minlength="2" placeholder="Extra Bed Charges"
                                                            class="form-control price_input" value="" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mt-innerrepeater-hotel-input">
                                                    <div class="form-group">
                                                        <label class="control-label">Extra Bed Rates (For
                                                            Children)</label>
                                                        <input type="number" required name="extra_bed_rate_child"
                                                            maxlength="10" minlength="2"
                                                            placeholder="Extra Bed Charges for children"
                                                            class="form-control price_input" value="" />
                                                    </div>
                                                </div>



                                                <div class="mt-innerrepeater-hotel-input col-md-3">
                                                    <label class="center-block"><strong>&nbsp;</strong></label>
                                                    <a href="javascript:;" data-repeater-delete
                                                        class="btn btn-danger mt-innerrepeater-delete">
                                                        <i class="fa fa-close"></i> Delete</a>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-12">
                                            <a href="javascript:;" data-repeater-create
                                                class="clearfix btn btn-success">
                                                <i class="fa fa-plus"></i> Add New Season</a>
                                        </div>
                                    </div>
                                    <!--End inner repeater-->

                                    <div class="col-md-1">
                                        <a href="javascript:;" data-repeater-delete
                                            class="btn btn-danger mt-repeater-rates-delete mt-repeater-del-left mt-repeater-btn-inline">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add margin_left_15">
                            <i class="fa fa-plus"></i> Add new</a>
                    </div>
                    <!--End field Reaper -->


                    <div class="col-md-12 text-left">
                        <hr>
                        <div class="margiv-top-10">
                            <button type="submit" class="btn green uppercase add_hotel">Add Hotel Room Rates</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div id="addresEd"></div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- Modal -->
</div>

<script type="text/javascript">
/* Hotel Exclusion repeater */
jQuery(document).ready(function($) {
    FormRepeater.init();
});
var FormRepeater = function() {
    return {
        init: function() {
            jQuery('.mt-repeater-rates').each(function() {
                $(this).find(".mt-repeater-rates-delete:eq( 0 )").hide();
                $(this).repeater({
                    show: function() {
                        $(this).find(".mt-repeater-rates-delete:eq( 0 )").show();
                        $(this).show();
                    },
                    hide: function(deleteElement) {
                        if (confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    },
                    ready: function(setIndexes) {

                    },
                    repeaters: [{
                        // (Required)
                        // Specify the jQuery selector for this nested repeater
                        selector: '.inner_hotel_repeater',
                        show: function() {
                            /* Check if pakage category already selected */
                            /* $("select.hotel_rate_cat").find('option').prop('disabled', false);
                            $("select.hotel_rate_cat").each(function() {
                            	$("select.hotel_rate_cat").not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 
                            	$("select.hotel_rate_cat:selected").attr('disabled','disabled');
                            }); */
                            /* Check if pakage category already selected */
                            $(this).show();
                        },
                        ready: function(setIndexes) {
                            $(".inner_hotel_repeater").find(
                                ".mt-innerrepeater-delete:eq( 0 )").hide();
                        },
                        /* $(".hotel_inner").each(function(){
                        	$(this).find(".mt-innerrepeater-delete:eq( 0 )").hide();
                        	
                        }); */

                    }]

                });
            });
        }
    };
}();
</script>

<script type="text/javascript">
jQuery(document).ready(function($) {
    //Prevent Dot from number field
    $(".price_input").on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 46) {
            e.preventDefault();
            return false;
        }
    });
    /*get states from country*/
    $("select.country").change(function() {
        var selectCountry = $(".country option:selected").val();
        var _this = $(this);
        _this.parent().append(
            '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelStateData'); ?>",
            data: {
                country: selectCountry
            }
        }).done(function(data) {
            $(".bef_send").hide();
            $(".state").removeAttr("disabled");
            $(".state").html(data);
            $(".city").html("<option value=''>Select City</option>");
            $(".hotel").html("<option value=''>Select hotel</option>");
        }).error(function() {
            $(".bef_send").hide();
            $("#state_list").html("Error! Please try again later!");
        });
    });
    /*get cities from state*/
    $(document).on('change', 'select.state', function() {
        var selectState = $(".state option:selected").val();
        var _this = $(this);
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
            $(".city").removeAttr("disabled");
            $(".city").html(data);
            $(".hotel").html("<option value=''>Select hotel</option>");
        }).error(function() {
            $(".bef_send").hide();
            $("#city_list").html("Error! Please try again later!");
        });
    });

    /*get Hotels from City*/
    $(document).on('change', 'select.city', function() {
        var selectCity = $(".city option:selected").val();
        var _this = $(this);
        _this.parent().append(
            '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotellistByCityId'); ?>",
            data: {
                hotel: selectCity
            }
        }).done(function(data) {
            $(".bef_send").hide();
            $(".hotel").removeAttr("disabled");
            $(".hotel").html(data);
        }).error(function() {
            $(".bef_send").hide();
            $(".hotel").html("Error! Please try again later!");
        });
    });

    //Submit Form
    var form = $("#addHotelRoomRate");
    var resp = $("#addresEd");
    form.validate({
        rules: {
            country: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            },
            hotel: {
                required: true
            },
            room_cat_id: {
                required: true
            },
            room_rates: {
                required: true
            },
            extra_bed_rate: {
                required: true
            },

        },
        /* submitHandler: function(form) {
        	var formData = $("#addHotelRoomRate").serializeArray();
        	//console.log(formData);
        	$.ajax({
        		type: "POST",
        		url: "<?php echo base_url('AjaxRequest/addHotelRoomRates'); ?>" ,
        		dataType: 'json',
        		data: formData,
        		beforeSend: function(){
        			resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
        		},
        		success: function(res) {
        			if (res.status == true){
        				resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
        				//console.log("done");
        				$("#addHotelRoomRate")[0].reset();
        				window.location.href = "<?php echo site_url("hotels/viewroomrates");?>"; 
        			}else{
        				resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
        				//console.log("error");
        			}
        		},
        		error: function(e){
        				//console.log(e);
        			resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
        		}
        	});
        	return false;
        } */
    });
});
</script>