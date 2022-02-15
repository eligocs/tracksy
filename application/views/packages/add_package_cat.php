<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Create Package Category
                    </div>
                    <a class="btn btn-success pull-right" href="<?php echo site_url("packages/viewCategory"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
			<div class="second_custom_card">
				<form id="addCat">
					<div class="portlet-body form">

						<div class="form-group">
							<label class="control-label">Package Category Name
								<span class="required"> * </span>
							</label>
							<input type="text" required class="form-control" name="package_cat_name" value=""
								placeholder="Category Name" />

						</div>
						<div class="margiv-top-10">
							<button type="submit" id="SubmitForm" class="btn green uppercase add_category">Add
								Category</button>
						</div>
						<div class="clearfix"></div>
					</div>
				</form>
			</div>
            <div id="res"></div>

            <!-- END CONTENT BODY -->
        </div>
        <!-- Modal -->
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    //submit form
    $("#addCat").validate({
        submitHandler: function() {
            var formData = $('#addCat').serializeArray();
            var resp = $("#res");
            var ajaxReq;
            if (ajaxReq) {
                ajaxReq.abort();
            }
            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('packages/ajax_add_cat'); ?>",
                data: formData,
                dataType: "json",
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
                        //console.log("done");
                        $('#addCat')[0].reset();
                        //console.log(res.msg);
                        window.location.href =
                            "<?php echo site_url('packages/viewCategory');?>";

                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        //console.log("error");
                    }
                },
                error: function(e) {
                    console.log(e);
                    resp.html(
                        '<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>'
                        );
                }
            });
        }
        //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
    });
});
</script>