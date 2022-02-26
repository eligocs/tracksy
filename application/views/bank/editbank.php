<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php if( $banks ){ 
			
		$banks = $banks[0];		?>

            <?php //echo validation_errors('<span class="help-block help-block-error">', '</span>'); ?>
            <?php $attributes = array('id' => 'editBank'); ?>
            <?php echo form_open('bank/editbank', $attributes); ?>

            <div class="portlet box blue">

                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>Edit Bank Details
                    </div>

                    <a class="btn btn-success" href="<?php echo site_url("bank");?>" title="Back">Back</a>
                </div>
            </div>

            <div class="portlet-body custom_card">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Bank Name*</label>
                            <input required type="text" placeholder="Bank Name" name="inp[bank_name]"
                                class="form-control"
                                value="<?php if(isset($banks->bank_name)){ echo $banks->bank_name; }else{ echo set_value('inp[bank_name]'); } ?>" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Payee Name</label>
                            <input required type="text" placeholder="Payee Name" name="inp[payee_name]"
                                class="form-control"
                                value="<?php if(isset($banks->payee_name)){ echo $banks->payee_name; }else{ echo set_value('inp[payee_name]'); } ?>" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Account Type*</label>
                            <select name="inp[account_type]" class="form-control" required>
                                <option value=""> Select Account Type</option>
                                <option value="Current Account"
                                    <?php if($banks->account_type == "Current Account"){echo "selected=selected";}?>>
                                    Current Account</option>
                                <option value="Saving Account"
                                    <?php if($banks->account_type == "Saving Account"){echo "selected=selected";}?>>
                                    Saving Account</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Account Number*</label>
                            <input required type="number" placeholder="Account Number" name="inp[account_number]"
                                class="form-control"
                                value="<?php if(isset($banks->account_number)){ echo $banks->account_number; }else{ echo set_value('inp[account_number]'); } ?>" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Branch Address*</label>
                            <input required type="text" placeholder="Branch Address" name="inp[branch_address]"
                                class="form-control"
                                value="<?php if(isset($banks->branch_address)){ echo $banks->branch_address; }else{ echo set_value('inp[branch_address]'); } ?>" />
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">IFSC Code*</label>
                            <input required placeholder="IFSC Code" type="text" class="form-control"
                                name="inp[ifsc_code]"
                                value="<?php if(isset($banks->ifsc_code)){ echo $banks->ifsc_code; }else{ echo set_value('inp[ifsc_code]'); } ?>"
                                maxlength="20">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Account Status*</label>
                            <select name="inp[status]" class="form-control">
                                <option value="active"
                                    <?php if($banks->status == "active"){echo "selected=selected";}?>>Active</option>
                                <option value="inactive"
                                    <?php if($banks->status == "inactive"){echo "selected=selected";}?>>Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                </div> <!-- row -->

                <div class="clearfix"></div>
                <div>
                    <input type="hidden" name="bank_id" value="<?php echo $banks->bank_id; ?>" />
                    <button type="submit" class="btn green uppercase edit_Customer margin_left_15">Update Banks Details</button>
                </div>
                </form>
            </div>
        </div>
        <div id="res"></div>
    </div>
    <?php }else{
			redirect("customers");
		} ?>
    <!-- END CONTENT BODY -->
</div>
<!-- Modal -->
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    var form = $("#editBank");
    form.validate();
});
</script>