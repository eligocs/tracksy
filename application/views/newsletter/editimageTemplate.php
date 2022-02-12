<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/form-repeater.min.js" type="text/javascript"></script>


	<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
		
		$error = $this->session->flashdata('error'); 
		if($error){ echo '<span class="help-block help-block-error">'.$error.'</span>'; }
	?>
<?php if(isset($img) && !empty($img)){ ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Default Image Template </div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters"); ?>" title="Back">Back</a>
				</div>
			</div>
	
								<div class="portlet-body">
                                       		<form method="post"  id="defalutTextTemplate" action="<?php echo base_url('newsletters/edituploadImage/').$img[0]->id; ?>" enctype="multipart/form-data">
										<div class="row">
										<div class="col-md-6">
										<div class="col-mdd-10 form_vr"><img src="<?php echo base_url('site/images/imageTemplate/').$img[0]->img_name; ?>" alt="Smiley face" height="80" width="80">
										</div>
                                            <div class="form-group">
                                                <label class="control-label">Upload Image</label>
                                                <input type="file"  required id="file" name="file"  >
											</div>
										</div> 
									
										</div>		
										
											<div class="margin-top-10">
                                                <input type="submit" id="submit" value="Save Changes" class="btn green">
                                                <a href="javascript:;" class="btn default">Cancel </a>
                                            </div>
                                        </form>
																	<div id="res"></div>

                                    </div>
                                </div>
                            </div>
			
		</div>
		<!-- END CONTENT BODY -->
	</div>
	<!-- END CONTENT -->

<?php  }else{
	redirect('newsletters/imagetemplateList');
} ?>
