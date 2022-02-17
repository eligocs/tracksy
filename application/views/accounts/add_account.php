<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php echo validation_errors('<span class="help-block1 help-block-error">', '</span>'); ?>
            <?php $message = $this->session->flashdata('error'); 
		if($message){ echo '<span class="help-block1 help-block-error">'.$message.'</span>';}
		?>
            <style>
            .dis_block {
                display: block;
            }

            .hide_div {
                display: none;
            }
            </style>
            <div class="portlet box blue">

                <div class="portlet-title">

                    <div class="caption">

                        <i class="icon-plus"></i>Add Account Details

                    </div>

                    <a class="btn btn-success" href="<?php echo site_url("accounts");?>" title="Back">Back</a>

                </div>

            </div>

            <?php $show_bank =  isset( $account_listing[0]->account_type ) && $account_listing[0]->account_type == "bank" ? "dis_block" : "hide_div"; ?>
            <div class="portlet-body custom_card">
                <div class="row">
                    <form id="addAcc_frm">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Account Name*</label>
                                <input type="text" placeholder="Account Name" name="account_name" class="form-control"
                                    value="<?php echo isset( $account_listing[0]->account_name ) ? $account_listing[0]->account_name : ""; ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Account Type*</label>
                                <select name="account_type" class="form-control account_type" required="required">
                                    <option value="">Select Account Type</option>
                                    <option
                                        <?php echo isset( $account_listing[0]->account_type ) && $account_listing[0]->account_type == "bank" ? "selected" : ""; ?>
                                        value="bank">Bank</option>
                                    <option
                                        <?php echo isset( $account_listing[0]->account_type ) && $account_listing[0]->account_type == "cash" ? "selected" : ""; ?>
                                        value="cash">Cash</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 showon_bank <?php echo $show_bank; ?>">
                            <div class="form-group">
                                <label class="control-label">Acount Number*</label>
                                <input type="number" placeholder="Account Number" name="account_number"
                                    class="form-control"
                                    value="<?php echo isset( $account_listing[0]->account_number ) ? $account_listing[0]->account_number : ""; ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4 showon_bank <?php echo $show_bank; ?>">
                            <div class="form-group">
                                <label class="control-label">IFSC Code*</label>
                                <input type="text" placeholder="IFSC Code" name="ifsc_code" class="form-control"
                                    value="<?php echo isset( $account_listing[0]->ifsc_code ) ? $account_listing[0]->ifsc_code : ""; ?>"
                                    required="required" maxlength="20" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Address*</label>
                                <textarea placeholder="Address" name="address" class="form-control"
                                    required="required"><?php echo isset( $account_listing[0]->address ) ? $account_listing[0]->address : ""; ?></textarea>

                            </div>

                        </div>
                        <?php if(isset( $account_listing[0]->id ) ) {
						$check_status = $account_listing[0]->acc_status == 1 ? "checked" : "";
						?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Black Listed ?</label>
                                <input type="checkbox" name="acc_status" <?php echo $check_status; ?>
                                    class="form-control">
                            </div>
                        </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Remarks</label>
                                <textarea placeholder="Remarks" name="remarks" class="form-control"
                                    required="required"><?php echo isset( $account_listing[0]->remarks ) ? $account_listing[0]->remarks : ""; ?></textarea>

                            </div>

                        </div>

                </div> <!-- row close -->
                <div class="clearfix"></div>
                <div class="margiv-top-10">
                    <input type="hidden" name="id"
                        value="<?php echo isset( $account_listing[0]->id ) ? $account_listing[0]->id : ""; ?>">
                    <button type="submit" class="btn green uppercase add_Bank margin_left_15">Add Account</button>

                </div>
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
    //account type on change
    $(".account_type").change(function() {
        console.log();
        if ($(this).val() == "bank") {
            $(".showon_bank").show();
        } else {
            $(".showon_bank").hide();
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
                url: "<?php echo base_url('accounts/ajax_add_account_details'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    resp.html(
                        '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                        );
                },
                success: function(res) {
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        console.log("done");
                        $("#addAcc_frm")[0].reset();
                        window.location.href = "<?php echo site_url("accounts");?>";
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
})
</script>