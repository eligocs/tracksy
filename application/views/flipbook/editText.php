<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>
<div class="page-container">

	<div class="page-content-wrapper">
		
		<div class="page-content">
					<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
		?>
		<!--error message-->
		<?php $err = $this->session->flashdata('error'); 
		if($err){ echo '<span class="help-block help-block-error2 red">'.$err.'</span>';}
		?>
		<h3><?php echo 'Edit promotion page text'; ?></h3>
		<?php echo validation_errors(); ?>
		
		<form method="post" action="<?Php echo base_url('flipbook/editText'); ?>" enctype="multipart/form-data">
		<table class ="table">
		
			<tr>
				<td>Title</td>
				<td><input type="text" name="page_title" value="<?php if(isset($page[0]->page_title)){echo $page[0]->page_title;} ?>" /></td>
				</tr>
				<input type="hidden" name='pageId' value="<?php echo $page[0]->id; ?>">
				<input type="hidden" name='page_type' value="1">

			<tr>
				<td>Body</td>
				<td><textarea name="content" id="summernote_2" ><?php  if(isset($page[0]->content)){ echo $page[0]->content; }?></textarea></td>
			</tr>
		<tr>
				<td></td>
				<td><?php echo form_submit('submit','Save','class="btn btn-primary"'); ?></td>
			</tr>
		</table>
		<?php echo form_close();?>
		</div>
		</div>
		</div>