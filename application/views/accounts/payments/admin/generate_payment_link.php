<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js' type='text/javascript'></script>
<!-- CSS -->
<link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url(); ?>site/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>/site/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"
    type="text/javascript"></script>
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
                        <i class="icon-plus"></i>Create Payement Link For Customer
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("accounts/all_online_transactions");?>"
                        title="Back">Back</a>
                </div>
            </div>
            <?php 
				$customer_name = $customer_email = $customer_email = $customer_contact = '';
			
			if( isset($payment_link[0]->customer_id) ){
				$customer_id 			= $payment_link[0]->customer_id;
				$customer_account 		= get_customer_account( $customer_id );
				if( $customer_account && !empty( $customer_account[0]->customer_name ) ){
					$customer_name 		= $customer_account[0]->customer_name;
					$customer_email 	= $customer_account[0]->customer_email;
					$customer_contact 	= $customer_account[0]->customer_contact;
					$customer_address 	= $customer_account[0]->address;
					$country		 	= get_country_name($customer_account[0]->country_id);
					$state 				= get_state_name($customer_account[0]->state_id);
					$state_id 			= $customer_account[0]->state_id;
				}else{
					$customer = get_customer( $payment_link[0]->customer_id );
					$customer_name 		= $customer[0]->customer_name;
					$customer_email 	= $customer[0]->customer_email;
					$customer_contact 	= $customer[0]->customer_contact;
					$customer_address 	= $customer[0]->customer_address;
					$country		 	= get_country_name($customer[0]->country_id);
					$state 				= get_state_name($customer[0]->state_id);
					$state_id			= $customer[0]->state_id;
				}
			}
			?>

            <div class="portlet-body custom_card">
                <?php if( $get_all_booked_iti ){ ?>
                <div class="row">
                    <form id="addAcc_frm">
                        <!--IF NEW CUSTOMER ACCOUNT BOOKED ITI ID -->
                        <div class="col-md-offset-4 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Select Booked Lead ID*</label>
                                <select name="customer_id" class="form-control" required id="select_iti_id">
                                    <option value="">Select</option>
                                    <?php 
										foreach( $get_all_booked_iti as $iti ){
											$selected = isset( $payment_link[0]->customer_id ) && $payment_link[0]->customer_id == $iti->customer_id ? 'selected' : '';
											echo "<option {$selected} data-customer_id ='{$iti->customer_id}' data-total_package_cost ='{$iti->total_package_cost}' data-customer_name ='{$iti->customer_name}'  data-customer_email ='{$iti->customer_email}' data-customer_contact ='{$iti->customer_contact}' value='{$iti->customer_id}'>{$iti->customer_id} ( {$iti->customer_name} ) ( {$iti->customer_contact} )</option>";
										}	
									?>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Customer Name*</label>
                                <input type="text" placeholder="Customer Name" name="customer_name" class="form-control"
                                    value="<?php echo $customer_name; ?>" required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Customer Email*</label>
                                <input type="email" placeholder="Customer Email" name="customer_email"
                                    class="form-control" value="<?php echo $customer_email; ?>" required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Customer Contact*</label>
                                <input type="text" placeholder="Customer Contact" name="customer_contact"
                                    class="form-control" value="<?php echo $customer_contact; ?>" required="required" />
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">TOTAL PACKAGE COST</label>
                                <input type="text" disabled placeholder="Total Package cost" name="total_package_cost"
                                    class="form-control"
                                    value="<?php echo isset( $payment_link[0]->iti_id ) ? iti_final_cost($payment_link[0]->iti_id) : "" ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Enter Amount*</label>
                                <input type="number" id='amount' placeholder="Enter Amount" name="amount" min="10"
                                    class="form-control"
                                    value="<?php echo isset($payment_link[0]->trans_amount) ? $payment_link[0]->trans_amount : 0;?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Link Expire Date*</label>
                                <input type="text" id='expire_date' placeholder="Enter Link Expire Date"
                                    autocomplete="off" name="link_expire_date" class="form-control"
                                    value="<?php echo isset($payment_link[0]->link_expire_date) ? $payment_link[0]->link_expire_date : "";?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        
                        <div class="margiv-top-10">
                            <button type="submit" class="btn green uppercase add_Bank margin-top-20 margin_left_15">Generate Payement Link</button>
                            <input type='hidden' name='id'
                                value='<?php echo isset( $payment_link[0]->id ) ? $payment_link[0]->id : ""?>'>
                        </div>
                        <div class="clearfix"></div>
                        <div id="res"></div>
                    </form>
                </div>

                <?php }else{ ?>
                <!--if no booked itineray found-->
                <div class='alert alert-danger'>NO BOOKED ITNERARY FOUND</div>
                <?php } ?>

            </div> <!-- row close -->
        </div><!-- portlet body -->
    </div> <!-- portlet -->
</div>

<!-- END CONTENT BODY -->

</div>

<!-- Modal -->

</div>

<script>
jQuery(document).ready(function($) {
    //payment expire link
    var date = new Date();
    date.setDate(date.getDate());
    $("#expire_date").datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss",
        startDate: date,
    });
    //add 15 day to expire link
    var nextDayMin = moment(date).add(15, 'day').toDate();
    $("#expire_date").datetimepicker('setEndDate', nextDayMin);

    $("#select_iti_id").select2();
    //select iti change function
    $("#select_iti_id").change(function() {
        $("#amount").val('');
        var selected = $(this).val();
        if (selected) {
            var _this_opt = $('option:selected', this);
            var customer_id = _this_opt.attr("data-customer_id");
            var customer_name = _this_opt.attr("data-customer_name");
            var customer_email = _this_opt.attr("data-customer_email");
            var customer_contact = _this_opt.attr("data-customer_contact");
            var total_package_cost = _this_opt.attr("data-total_package_cost");

            $("input[name='customer_name']").val(customer_name);
            $("input[name='customer_email']").val(customer_email);
            $("input[name='customer_contact']").val(customer_contact);
            $("input[name='total_package_cost']").val(total_package_cost);

            $("#amount").attr('max', total_package_cost);
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
                url: "<?php echo base_url('accounts/ajax_generate_payment_link'); ?>",
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
                            "<?php echo site_url("accounts/view_payment_link/"); ?>" +
                            res.id;
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