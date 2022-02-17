<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js' type='text/javascript'></script>
<!-- CSS -->
<link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' rel='stylesheet' type='text/css'>

<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php echo validation_errors('<span class="help-block1 help-block-error">', '</span>'); ?>

            <?php 
		$message = $this->session->flashdata('error'); 
		if($message){ echo '<span class="help-block1 help-block-error">' . $message . '</span>';}
		?>
            <style>
            .dis_block {
                display: block;
            }

            .hide_div,
            .shownewbooking {
                display: none;
            }

            #new_iti_id+span.select2 {
                width: 100% !important;
            }
            </style>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus"></i>Add Customer Account Details
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("accounts/customeraccounts");?>"
                        title="Back">Back</a>
                </div>

            </div>
            <div class="portlet-body custom_card">
                <div class="row">
                    <form id="addAcc_frm">

                        <!--IF NEW CUSTOMER ACCOUNT DROPDOWN BOOKED ITI ID -->
                        <?php if( !isset( $account_listing[0]->id ) ){ ?>
                        <div class="col-md-offset-4 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Select Booked Lead ID*</label>
                                <select name="iti_id" class="form-control" required id="select_iti_id">
                                    <option value="">Select</option>
                                    <?php if( isset( $pending_accounts ) && !empty( $pending_accounts ) ){ 
										foreach( $pending_accounts as $account ){
											echo "<option data-customer_id ='{$account->customer_id}' data-customer_name ='{$account->customer_name}'  data-customer_email ='{$account->customer_email}' data-customer_contact ='{$account->customer_contact}' value='{$account->iti_id}'>{$account->customer_id} ( {$account->customer_name} ) ( {$account->customer_contact} )</option>";
										}	
									}else{
										echo "<option value=''>No Pending Customer Found(You can't create account)</option>";
									} ?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php } ?>

                        <?php if( isset( $booking_listing[0]->cus_account_id) && !empty( $booking_listing[0]->cus_account_id ) ){ ?>
                        <h5 class="text-center">Booking Ids: </h5>
                        <?php 
							$co = 1;
						foreach( $booking_listing as $booking_id ){
							//chek if invoice generated
							$del_b = "";
							$check_invoice = is_invoice_generated( $booking_id->lead_id );
							if( empty($check_invoice) && $co > 1 ){
								$del_b = "<a href='javascript:void(0)' data-lead_id= '{$booking_id->lead_id}' class='del_booking_id' title='Delete Booking Id'><i class='fa fa-trash-o'></i> </a>";
							}
							
							$iti_link = iti_view_single_link($booking_id->iti_id);
							echo "<div class='text-center'>
							Lead ID: <strong><a href='{$iti_link}' target='_blank' title='click to view'>{$booking_id->lead_id}</a></strong> &nbsp;&nbsp; {$del_b}
							</div>";
							$co++;
						}
						echo "<hr>";
					} ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Customer Name*</label>
                                <input type="text" placeholder="Customer Name" name="customer_name" class="form-control"
                                    value="<?php echo isset( $account_listing[0]->customer_name ) ? $account_listing[0]->customer_name : ""; ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Customer Email*</label>
                                <input type="email" placeholder="Customer Email" name="customer_email"
                                    class="form-control"
                                    value="<?php echo isset( $account_listing[0]->customer_email ) ? $account_listing[0]->customer_email : ""; ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Customer Contact*</label>
                                <input type="text" placeholder="Customer Contact" name="customer_contact"
                                    class="form-control"
                                    value="<?php echo isset( $account_listing[0]->customer_contact ) ? $account_listing[0]->customer_contact : ""; ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Customer Alternate Contact</label>
                                <input type="text" placeholder="Customer Alternate Contact"
                                    name="alternate_contact_number" class="form-control"
                                    value="<?php echo isset( $account_listing[0]->alternate_contact_number ) ? $account_listing[0]->alternate_contact_number : ""; ?>" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Select Country*</label>
                                <select required name="country_id" class="form-control country">
                                    <option value="">Choose Country</option>
                                    <?php $country = get_country_list();
								if($country){
									foreach( $country as $c ){
										$selectedc = isset( $account_listing[0]->country_id ) && $account_listing[0]->country_id ==  $c->id ? "selected" : ""; 
										echo "<option {$selectedc} value={$c->id}>{$c->name}</option>";
									}
								}
								?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Select State*</label>
                                <select required name="state_id" class="form-control state">
                                    <option value="">Choose State</option>
                                    <?php 
								if( isset( $account_listing[0]->country_id ) ){
									$states = get_state_list( $account_listing[0]->country_id );
									foreach( $states as $state ){
										$selected = isset( $account_listing[0]->state_id ) && $account_listing[0]->state_id == $state->id ? "selected" : "";
										echo "<option {$selected} value={$state->id}>{$state->name}</option>";
									}
								}
								?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Place of Supply*</label>
                                <select required name="place_of_supply_state_id" class="form-control">
                                    <option value="">Choose State</option>
                                    <?php 
								$states = get_state_list( 101 );
								if( $states ){
									foreach( $states as $state ){
										$selected = isset( $account_listing[0]->place_of_supply_state_id ) && $account_listing[0]->place_of_supply_state_id == $state->id ? "selected" : "";
										echo "<option {$selected} value={$state->id}>{$state->name}</option>";
									}
								}
								?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Client GST</label>
                                <input type="text" placeholder="Client GST NO" maxlength="16" name="client_gst"
                                    class="form-control"
                                    value="<?php echo isset( $account_listing[0]->client_gst ) ? $account_listing[0]->client_gst : ""; ?>"
                                    required="required" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Address*</label>
                                <textarea placeholder="Address" name="address" class="form-control"
                                    required="required"><?php echo isset( $account_listing[0]->address ) ? $account_listing[0]->address : ""; ?></textarea>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Remarks*</label>
                                <textarea placeholder="Remarks" name="remarks" class="form-control"
                                    required="required"><?php echo isset( $account_listing[0]->remarks ) ? $account_listing[0]->remarks : ""; ?></textarea>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <?php if(isset( $account_listing[0]->id ) ) {
						$check_status = $account_listing[0]->status == 1 ? "checked" : "";
						?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Black Listed ?</label>
                                <input type="checkbox" name="status" <?php echo $check_status; ?> class="form-control">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="control-label">Add New Booking ?</label>
                                    <input type="checkbox" name="addn" class="form-control cheknewbtn">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 shownewbooking">
                            <div class="form-group">
                                <label class="control-label">Select New Booked Lead ID*</label>
                                <select name="new_iti_id" class="form-control new_iti_id" required id="new_iti_id">
                                    <option value="">Select</option>
                                    <?php if( isset( $pending_accounts ) && !empty( $pending_accounts ) ){ 
										foreach( $pending_accounts as $account ){
											echo "<option data-customer_id ='{$account->customer_id}' data-customer_name ='{$account->customer_name}'  data-customer_email ='{$account->customer_email}' data-customer_contact ='{$account->customer_contact}' value='{$account->iti_id}'>{$account->customer_id} ( {$account->customer_name} )( {$account->customer_contact} )</option>";
										}	
									}else{
										echo "<option value=''>No Pending Customer Found(You can't create account)</option>";
									} ?>
                                </select>
                            </div>
                        </div>

                        <?php } ?>

                </div>
				<div class="margiv-top-10">
                <input type="hidden" name="id"
                    value="<?php echo isset( $account_listing[0]->id ) ? $account_listing[0]->id : ""; ?>">
                <input type="hidden" name="customer_id" value="">
                <input type="hidden" name="new_cus_id" value="" class="new_cus_id">
                <button type="submit" class="btn green uppercase add_Bank">Update Account</button>
            </div>
            </div> <!-- row close -->
            <div class="clearfix"></div>
            <!-- <div class="margiv-top-10">
                <input type="hidden" name="id"
                    value="<?php //echo isset( $account_listing[0]->id ) ? $account_listing[0]->id : ""; ?>">
                <input type="hidden" name="customer_id" value="">
                <input type="hidden" name="new_cus_id" value="" class="new_cus_id">
                <button type="submit" class="btn green uppercase add_Bank">Update Account</button>
            </div> -->
            <div class="clearfix"></div>
            <div id="res"></div>
            </form>
        </div><!-- portlet body -->
    </div> <!-- portlet -->
</div>

<!-- END CONTENT BODY -->

</div>

<!-- Modal -->

</div>

<script>
jQuery(document).ready(function($) {

    //get states
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
            $(".state").html(data);
        }).error(function() {
            alert("Error! Please try again later!");
        });
    });


    $(document).on("click", ".del_booking_id", function() {
        var res = $("#res");
        var id = $(this).attr("data-lead_id");
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "accounts/delete_booking_account_lead?id=" +
                    id,
                type: "GET",
                data: id,
                dataType: "json",
                cache: false,
                success: function(r) {
                    if (r.status = true) {
                        alert(r.msg);
                        location.reload();
                    } else {
                        alert("Error! Please try again.");
                    }
                }
            });
        }
    });

    $(".cheknewbtn").click(function() {
        if ($(this).is(':checked')) {
            $(".shownewbooking").show();
        } else {
            $(".new_iti_id").val("");
            $(".new_cus_id").val("");
            $(".shownewbooking").hide();
        }
    });

    $(".new_iti_id").select2();
    //select iti change function
    $(".new_iti_id").change(function() {
        var selected = $(this).val();
        if (selected) {
            var _this_opt = $('option:selected', this);
            var customer_id = _this_opt.attr("data-customer_id");
            $("input[name='new_cus_id']").val(customer_id);
            //alert( customer_name );
        } else {
            $("input[name='new_cus_id']").val("");
        }
    });

    $("#select_iti_id").select2();

    //select iti change function
    $("#select_iti_id").change(function() {
        var selected = $(this).val();
        if (selected) {
            var _this_opt = $('option:selected', this);
            var customer_id = _this_opt.attr("data-customer_id");
            var customer_name = _this_opt.attr("data-customer_name");
            var customer_email = _this_opt.attr("data-customer_email");
            var customer_contact = _this_opt.attr("data-customer_contact");

            $("input[name='customer_name']").val(customer_name);
            $("input[name='customer_email']").val(customer_email);
            $("input[name='customer_contact']").val(customer_contact);
            $("input[name='customer_id']").val(customer_id);

            //alert( customer_name );
        } else {
            $("input[name='customer_id']").val("");
        }

    });

    //submit form
    $('#addAcc_frm').validate({
        submitHandler: function(form) {

            var resp = $("#res");
            var ajaxReq;
            var formData = $("#addAcc_frm").serializeArray();

            //console.log(formData);
            if (ajaxReq) {
                ajaxReq.abort();
            }

            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('accounts/ajax_add_customer_account_details'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    resp.html(
                        '<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                        );
                },
                success: function(res) {
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        console.log("done");
                        $("#addAcc_frm")[0].reset();
                        window.location.href =
                            "<?php echo site_url("accounts/view_customer/"); ?>" + res
                            .id;
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        console.log("error");
                    }
                },
                error: function(e) {
                    console.log(e);
                    //response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
                }
            });
            return false;
        }
    });
});
</script>