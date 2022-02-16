<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php echo validation_errors('<span class="help-block help-block-error1">', '</span>'); ?>
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
            <!--error message-->
            <?php $err = $this->session->flashdata('error'); 
		if($err){ echo '<span class="help-block help-block-error2 red">'.$err.'</span>';}
		?>

            <!--redirect if user try to edit travel parter category-->
            <?php isset( $customer_type[0]->id ) && $customer_type[0]->id < 3 ? redirect("customers/customer_type") : ""; ?>

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-user"></i>Add/Edit Customer Type</div>
                    <a class="btn btn-success" href="<?php echo site_url("customers/customer_type"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <div class="portlet-body custom_card">
                <form role="form" id="addCat" method="post"
                    action="<?php echo site_url("customers/updatecustomertype/" ); ?>">
                    <div class="form-group col-md-4">
                        <label class="control-label">Customer Type*</label>
                        <input type="text" name="customer_type" placeholder="Customer Type. eg: Travel Partner"
                            class="form-control"
                            value="<?php echo isset( $customer_type[0]->name ) ? $customer_type[0]->name : set_value('customer_type'); ?>" />
                    </div>
                    <div class="clearfix margiv-top-10">
                        <input type="hidden" name="id"
                            value="<?php echo isset( $customer_type[0]->id ) ? $customer_type[0]->id : set_value('id'); ?>">
                        <button type="submit" class="btn green uppercase add_agent margin_left_15">Add Category</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div><!-- portlet body -->
        </div> <!-- portlet -->
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- Modal -->
</div>