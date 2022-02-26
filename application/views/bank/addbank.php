<div class="page-container">

    <div class="page-content-wrapper">

        <div class="page-content">



            <?php echo validation_errors('<span class="help-block1 help-block-error">', '</span>'); ?>

            <?php $message = $this->session->flashdata('error'); 

		if($message){ echo '<span class="help-block1 help-block-error">'.$message.'</span>';}

		?>



            <?php echo form_open('bank/savebank',array('id'=> 'bank_form')); ?>





            <div class="portlet box blue">

                <div class="portlet-title">

                    <div class="caption">

                        <i class="icon-plus"></i>Add Bank Details

                    </div>

                    <a class="btn btn-success" href="<?php echo site_url("bank");?>" title="Back">Back</a>

                </div>

            </div>

            <div class="portlet-body custom_card">



                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label class="control-label">Bank Name*</label>

                            <input type="text" placeholder="Bank Name" name="inp[bank_name]" class="form-control"
                                value="<?php if(isset($bank_name)){ echo $bank_name; }else{ echo set_value('inp[bank_name]'); } ?>"
                                required="required" />

                        </div>

                    </div>



                    <div class="col-md-4">

                        <div class="form-group">

                            <label class="control-label">Payee Name*</label>

                            <input type="text" placeholder="Payee Name" name="inp[payee_name]" class="form-control"
                                value="<?php if(isset($payee_name)){ echo $payee_name; }else{ echo set_value('inp[payee_name]'); } ?>"
                                required="required" />

                        </div>

                    </div>



                    <div class="col-md-4">

                        <div class="form-group">

                            <label class="control-label">Account Type*</label>

                            <select name="inp[account_type]" class="form-control" required="required">

                                <option value="">Select Account Type</option>

                                <option value="Current Account">Current Account</option>

                                <option value="Saving Account">Saving Account</option>





                            </select>

                        </div>

                    </div>



                    <div class="col-md-4">

                        <div class="form-group">

                            <label class="control-label">Acount Number*</label>

                            <input type="number" placeholder="Account Number" name="inp[account_number]"
                                class="form-control"
                                value="<?php if(isset($account_number)){ echo $account_number; }else{ echo set_value('inp[account_number]'); } ?>"
                                required="required" />

                        </div>

                    </div>



                    <div class="col-md-4">

                        <div class="form-group">

                            <label class="control-label">Branch Address*</label>

                            <input type="text" placeholder="Branch Address" name="inp[branch_address]"
                                class="form-control"
                                value="<?php if(isset($branch_address)){ echo $branch_address; }else{ echo set_value('inp[branch_address]'); } ?>"
                                required="required" />

                        </div>

                    </div>





                    <div class="col-md-4">

                        <div class="form-group">

                            <label class="control-label">IFSC Code</label>

                            <input type="text" placeholder="IFSC Code" name="inp[ifsc_code]" class="form-control"
                                value="<?php if(isset($ifsc_code)){ echo $branch_address; }else{ echo set_value('inp[ifsc_code]'); } ?>"
                                required="required" maxlength="20" />

                        </div>

                    </div>

                </div> <!-- row close -->



                <div class="clearfix"></div>

                <div class="margiv-top-10">

                    <button type="submit" class="btn green uppercase add_Bank margin_left_15">Add Bank</button>

                </div>

                </form>



            </div><!-- portlet body -->

        </div> <!-- portlet -->

        <div class="clearfix"></div>

        <div id="res"></div>

    </div>

    <!-- END CONTENT BODY -->

</div>

<!-- Modal -->

</div>

<script>
jQuery('#bank_form').validate();
</script>