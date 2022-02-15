<div class="page-container customer_content">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php $mealplan = $mealplans[0]; 
				if( !empty( $mealplan ) ){	?>
            <?php $message = $this->session->flashdata('error'); 
				if($message){ echo '<span class="help-block help-block-error1 red">'.$message.'</span>';} ?>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus"></i>Edit Mealplan
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("hotels/mealplan"); ?>" title="Back">Back</a>
                </div>
            </div>
            <div class="second_custom_card">
                <form role="form" id="editMeal" method="post" action="<?php echo site_url("hotels/updatemealplan"); ?>">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Mealplan Name*</label>
                                    <input type="text" required placeholder="Meal Plan Name. eg: Breakfast,dinner etc."
                                        name="inp[name]" class="form-control" value="<?php echo $mealplan->name; ?>" />
                                </div>
                            </div>
                            <input type="hidden" name="inp[id]" class="form-control"
                                value="<?php echo $mealplan->id; ?>" />
                        </div> <!-- row -->
                        <div class="clearfix"></div>
                        <div class="margiv-top-10">
                            <button type="submit" class="btn green uppercase add_roomcategory margin_left_15">Update</button>
                        </div>
                </form>
            </div>
        </div><!-- portlet body -->
    </div> <!-- portlet -->
    <?php }else{
				redirect("hotels/mealplan");
			}	?>
</div>
<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
</div>


<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#editMeal").validate();
});
</script>