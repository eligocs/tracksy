<div class="page-container">
    <link rel="stylesheet" href="<?php echo base_url(); ?>site/assets/css/croppie.css">
    <script src="<?php echo base_url(); ?>site/assets/js/croppie.js"></script>

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus"></i>Add New Slide
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("clientsection/sliders"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <div class="portlet-body second_custom_card">
                <form role="form" id="addSlide" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Name*</label>
                                <input type="text" id="name" required placeholder="eg: Shimla" name="name"
                                    class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Upload Image*</label>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div id="upload-demo" style="width:400px;"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
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
                                    <span class="label label-danger">NOTE! </span>&nbsp;&nbsp;&nbsp;
                                    <span class='red'> Image size not bigger then 2 MB and dimensions(650px X
                                        250px).</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="margiv-top-10">
                            <input type="hidden" id='id' name="agent_id" value="<?php echo $agent_id; ?>" />
                            <button class="btn btn-success upload-result">Upload Image</button>
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
<script type="text/javascript">
/* jQuery(document).ready(function($){
	var resp = $("#addresEd"),ajaxReq;
	$("#addSlide").validate();
	$(document).on("submit",'#addSlide', function(e){
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('clientsection/ajax_add_slide'); ?>" ,
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success:function(data){
					if( data == "success" ){
						resp.html('<div class="alert alert-success"><strong>Success: </strong> slide successfully uploaded!</div>');
						window.location.href = "<?php echo site_url("clientsection/sliders");?>"; 
					}else{
						resp.html(data);
					}
				},
				error: function(e){
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		
	});	
});  */
</script>

<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 650,
        height: 250,
        type: 'rectangle'
    },
    boundary: {
        width: 700,
        height: 300,
    }
});


$('#image_url').on('change', function() {
    var reader = new FileReader();
    reader.onload = function(e) {
        $uploadCrop.croppie('bind', {
            url: e.target.result
        }).then(function() {
            console.log('jQuery bind complete');
        });

    }
    reader.readAsDataURL(this.files[0]);
});


$('.upload-result').on('click', function(ev) {
    ev.preventDefault();
    var res = $("#addresEd"),
        ajaxReq;
    var name = $('#name').val();
    var id = $('#id').val();
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function(resp) {
        $.ajax({
            url: "<?php echo base_url('clientsection/do_upload'); ?>",
            type: "POST",
            data: {
                "image": resp,
                'name': name,
                'id': id
            },
            success: function(data) {
                if (data == "success") {
                    res.html(
                        '<div class="alert alert-success"><strong>Success: </strong> slide successfully uploaded!</div>'
                        );
                    window.location.href =
                    "<?php echo site_url("clientsection/sliders");?>";
                } else {
                    res.html(data);
                }
            },
            error: function(e) {
                //console.log(e);
                res.html(
                    '<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>'
                    );
            }
        });
    });
});
</script>