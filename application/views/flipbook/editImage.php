<div class="page-container">
	<div class="page-content-wrapper">
		
	<link rel="stylesheet" href="<?php echo base_url(); ?>site/assets/css/croppie.css">
	<script src="<?php echo base_url(); ?>site/assets/js/croppie.js"></script>
	
		<div class="page-content">
					<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
		?>
		<!--error message-->
		<?php $err = $this->session->flashdata('error'); 
		if($err){ echo '<span class="help-block help-block-error2 red">'.$err.'</span>';}
		?>
			<?php 
				$pid =get_promo_name($page[0]->promotion_id);
				$content = $page[0]->content;  ?>
		
  <div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">Edit promotion page Image</div> <a class="btn btn-success" href="<?php echo site_url("flipbook/view/").$page[0]->promotion_id; ?>" title="Back">Back</a>
			</div>	
		</div>	
 
		<?php echo validation_errors(); ?>
		<form method="post" action="<?Php echo base_url('flipbook/editImage'); ?>" enctype="multipart/form-data">
		<table class ="table">
		
			<tr>
				<td>Title</td>
				<td><input type="text" id="title" name="title" value="<?php if(isset($page[0]->page_title)){echo $page[0]->page_title;} ?>" /></td>
				</tr>
				<input type="hidden" id='pgId' name='pageId' value="<?php echo $page[0]->id; ?>">
				<input type="hidden" id='proId' value="<?php echo $page[0]->promotion_id; ?>">
			</tr>
		</table>
			
			
			<div class="row">
				<div class="col-md-6">

					<div class="form-group">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div>
								<span class="btn default btn-file">
									<span class="fileinput-newa"> Click here to upload image </span>
									<span class="fileinput-existss"> </span>
									<input required id="image_url" type="file" name="image"> </span>
								<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
							</div>
						<div class="clearfix margin-top-10">
							<span class="label label-danger">NOTE! </span>&nbsp;&nbsp;&nbsp;
							<span class='red'> Image size not bigger then 2 MB and dimensions(550px X 700px).</span>
						</div>
					</div>
					


					<div class="row">
						<?php $slide_img_path = base_url('site/images/promotions/').$content ; ?>

						<div class="col-md-12 text-center">
							<div id="upload-demo" style="width:400px;"></div>
						</div>
	  			  	</div>
						<div id="addresEd"></div>		
				<button class="btn btn-success upload-result">Upload Image</button>

				</div>
			</div>
			
		<?php echo form_close();?>
		</div>
		</div>
		</div>
		<script type="text/javascript">
	$uploadCrop = $('#upload-demo').croppie({
		enableExif: true,
			    url: '<?php echo $slide_img_path; ?>',

		viewport: {
			width: 550,
			height: 700,
			type: 'rectangle'
		},
		boundary: {
			width:650,
			height:800,
		}
	});


	$('#image_url').on('change', function () { 
		var reader = new FileReader();
		reader.onload = function (e) {
			$uploadCrop.croppie('bind', {
				url: e.target.result
			}).then(function(){
				console.log('jQuery bind complete');
			});
			
		}
		reader.readAsDataURL(this.files[0]);
	});


	$('.upload-result').on('click', function (ev) {
		ev.preventDefault();
		var res = $("#addresEd"),ajaxReq;
		var title = $('#title').val();
		var pgId = $('#pgId').val();
		var proId = $('#proId').val();
		$uploadCrop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (resp) {
			$.ajax({
				url: "<?php echo base_url('flipbook/do_upload_edit'); ?>",
				type: "POST",
				data: { "image":resp,'title': title,'pgId': pgId ,'proId':proId },
				success: function (data) {
					if( data == "success" ){
						res.html('<div class="alert alert-success"><strong>Success: </strong> Image successfully uploaded!</div>');
						window.location.href = ""; 
					}else{
						res.html(data);
					}
				},
				error: function(e){
						//console.log(e);
					res.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
		});
	});

</script>