<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus"></i>Add New Video
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("clientsection/youtube"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <div class="portlet-body second_custom_card">
                <form role="form" id="addSlide" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Name*</label>
                                <input type="text" required placeholder="eg: Shimla View" name="name"
                                    class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Youtube Poster Image*</label>
                            <div class="form-group">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img alt="" class="img-responsive" src="" />
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                        style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-newa"> Click here to upload image </span>
                                            <span class="fileinput-existss"> </span>
                                            <input required id="image_url" type="file" name="image_url"> </span>
                                        <a href="javascript:;" class="btn default fileinput-exists"
                                            data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-danger">NOTE! </span>&nbsp;
                                    <span class='red'> Image size not bigger then 1 MB and dimensions(250px X
                                        250px).</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Youtube Video Link*</label>
                                <input type="url" required placeholder="eg: https://www.youtube.com/watch?v=YE7VzlLtp-4"
                                    name="youtube_vid_link" class="form-control" value="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="margiv-top-10">
                            <input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>" />
                            <button type="submit" class="btn green uppercase">Add video</button>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
                <div id="addresEd"></div>
            </div><!-- portlet body -->
        </div> <!-- portlet -->
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- Modal -->
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    var resp = $("#addresEd"),
        ajaxReq;
    $("#addSlide").validate();
    $(document).on("submit", '#addSlide', function(e) {
        //console.log(formData);
        if (ajaxReq) {
            ajaxReq.abort();
        }
        ajaxReq = $.ajax({
            type: "POST",
            url: "<?php echo base_url('clientsection/ajax_add_youtube_vid'); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
            },
            success: function(data) {
                if (data == "success") {
                    resp.html(
                        '<div class="alert alert-success"><strong>Success: </strong> Video successfully uploaded!</div>'
                        );
                    window.location.href =
                    "<?php echo site_url("clientsection/youtube");?>";
                } else {
                    resp.html(data);
                }
            },
            error: function(e) {
                //console.log(e);
                resp.html(
                    '<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>'
                    );
            }
        });
        return false;

    });
});
</script>