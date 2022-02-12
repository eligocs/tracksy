<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>

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
  <div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">Promotion Page</div> <a class="btn btn-success" href="<?php echo site_url("flipbook/view/").$id; ?>" title="Back">Back</a>
			</div>	
		</div>	
 

	<div class="panel-body"> 
	<div>
	<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Select Page Type :</label>
							<select id="typ" class="form-control">
							<option >Select Type
							</option>	
							<option value='0'>Image
							</option>
							<option value="1">Text
							</option>
							</select>
					</div>
		</div>
	</div>
	</div>
	
	
	
	<div id="img" class="hide">
	<div class="portlet box blue">
		<div class="portlet-title">
		<div class="caption"><i class="fa fa-gift"></i><?php echo 'Add promotion page Image'; ?></div>
		</div>
	<div class="portlet-body">

	<form method="post" action="<?Php echo base_url('flipbook/addImage'); ?>" enctype="multipart/form-data">
	  <div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label">Image Title *</label>
						<input type="text" class="form-control" required id="title" name="title" value="" placeholder="Image Title">
					</div>
				</div>
			</div>

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
					

					<input type="hidden" id="pId" name='promotion_id' value="<?php echo $id; ?>">
					<input type="hidden" name='page_type' value="0">

					<div class="row">
						<div class="col-md-12 text-center">
							<div id="upload-demo" style="width:400px;"></div>
						</div>
	  			  	</div>
						<div id="addresEd"></div>		
				<button class="btn btn-success upload-result">Upload Image</button>

				</div>
			</div>
				<?//php echo form_submit('submit','Save','class="btn btn-primary"'); ?>
				</form>


	</div>
	</div>
	</div> <!-- #img close-->
	
	
	
<div id='text' class="hide" >

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption"> <i class="fa fa-gift"></i><?php echo 'Add promotion page text'; ?> </div>
		</div>
		<div class="portlet-body">
   <form method="post" action="<?Php echo base_url('flipbook/addText'); ?>" enctype="multipart/form-data">
		<?php echo validation_errors(); ?>
				<?php echo validation_errors(); ?>
		
		<table class ="table">
		
												 
			<tr>
				<td>Title</td>
				<td>
					<div class=""form-group>
				<input type="text"  required name="page_title" class="form-control" /></td>
				</tr>
				<input type="hidden" name='promotion_id' value="<?php echo $id; ?>">
						<input type="hidden" name='page_type' value="1">

			<tr>
				<td>Body</td>
				<td><textarea   id="summernote_1" onkeyup="countChar(this)"  required name="content"></textarea>
							<label class="control-label " id="Num" ></label>
							<label class="control-label " id="charNum" style="float: right;" ></label>
							</td>
			</tr>
		<tr>
				<td></td>
				<td><?php echo form_submit('submit','Save','class="btn btn-primary"'); ?></td>
			</tr>
		</table>
	</div>
	</form>
			 
			
		</div>
	</div>
	</div>
<script>
jQuery(document).ready(function($){
	 $('#typ').on('change',function(){
		 var type = $(this).val();
		if(type ==0){
			$('#img').removeClass('hide');
			$('#text').addClass('hide');

		}
		else{
			$('#text').removeClass('hide');
			$('#img').addClass('hide');


		}		
	 });
});
	function countChar(val) {
        var len = val.value.length;
		 $('#charNum').text(len);

		
					}

</script>
<script type="text/javascript">
	$uploadCrop = $('#upload-demo').croppie({
		enableExif: true,
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
		var pid = $('#pId').val();
		$uploadCrop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (resp) {
			$.ajax({
				url: "<?php echo base_url('flipbook/do_upload'); ?>",
				type: "POST",
				data: { "image":resp,'title': title,'pid': pid },
				beforSend: function(){
					res.html('<div class="alert alert-info">Please wait....</div>');
				},
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

</div>
</div>
</div>