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
                        <i class="icon-plus"></i>Add Vednder Account Details
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("ledger");?>" title="Back">Back</a>
                </div>

            </div>
            <div class="portlet-body custom_card">
                <div class="row">
                    <form id="addAcc_frm">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Name*</label>
                                <input type="text" placeholder="Vendor Name" name="name" class="form-control"
                                    value="<?php echo isset( $account_listing[0]->name ) ? $account_listing[0]->name : ""; ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Email*</label>
                                <input type="email" placeholder="Email" name="email" class="form-control"
                                    value="<?php echo isset( $account_listing[0]->email ) ? $account_listing[0]->email : ""; ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Contact*</label>
                                <input type="text" placeholder="Contact" name="contact" class="form-control"
                                    value="<?php echo isset( $account_listing[0]->contact ) ? $account_listing[0]->contact : ""; ?>"
                                    required="required" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Alternate Contact</label>
                                <input type="text" placeholder="Alternate Contact" name="alternate_contact_number"
                                    class="form-control"
                                    value="<?php echo isset( $account_listing[0]->alternate_contact_number ) ? $account_listing[0]->alternate_contact_number : ""; ?>" />
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

                        <div class="col-md-3">
                            <input type="hidden" name="id"
                                value="<?php echo isset( $account_listing[0]->id ) ? $account_listing[0]->id : ""; ?>">
                            <button type="submit" class="btn green uppercase add_Bank">Update Account</button>
                        </div>
                </div>
            </div> <!-- row close -->
            <div class="clearfix"></div>
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
                url: "<?php echo base_url('ledger/ajax_add_vendor_account_details'); ?>",
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
                            "<?php echo site_url("ledger/view_vendor/"); ?>" + res
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
                }
            });
            return false;
        }
    });
});
</script>