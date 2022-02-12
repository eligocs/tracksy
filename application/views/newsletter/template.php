<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="portlet box blue">
         <div class="portlet-title">
            <div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Default Template For Newsletter</div>
            <a class="btn btn-success pull-right" href="<?php echo site_url("newsletters"); ?>" title="Back">Back</a>
         </div>
      </div>
      <div class="profile-content">
         <div class="row second_custom_card">
            <div class="col-md-12">
               <!--h2 class="text-center"><strong>Newsletter Default Template </strong></h2-->
               <!--iframe class="newsletter-view" src="http://localhost/yatra/newsletters/create"></iframe-->
               <div class="portlet light ">
                  <form role="form" class="form-horizontal form-bordered" id="defalutTemplate">
                     <div class="form-group">
                        <textarea name="template" id="template"><?php if($templates!= NULL){ echo htmlspecialchars_decode($templates[0]->template); }?></textarea>
                        <div class="form-actions">
                           <div class="row">
                              <div class="col-md-10">
                                 <input type="hidden" name="id" value="<?php if($templates!= NULL){ echo $templates[0]->id; }?>"/>	
                                 <input type="hidden" name="type" value="<?php if($templates!= NULL){ echo "Edit"; } else { echo "Add";}?>"/>
                                 <button type="submit" class="btn green">
                                 <i class="fa fa-check"></i> Submit</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
                  <div id="res"></div>
               </div>
            </div>
         </div>
      </div>
      <!-- END PROFILE CONTENT -->
   </div>
   <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<script type="text/javascript">
   // Ajax a Account 
   jQuery(document).ready(function($) {
   	var ajaxRstr;
   	$("#defalutTemplate").submit(function(e){
   		e.preventDefault();
   		var response = $("#res");
   		var formData = $("#defalutTemplate").serializeArray();
   		if (confirm("Are you sure to save changes ?")) {
   			if (ajaxRstr) {
   				ajaxRstr.abort();
   			}
   			ajaxRstr =	jQuery.ajax({
   				type: "POST",
   				url: "<?php echo base_url(); ?>" + "newsletters/ajax_update_template",
   				dataType: 'json',
   				data: formData,
   				beforeSend: function(){
   					response.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
   				},
   				success: function(res) {
   					if (res.status == true){
   						response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
   						//console.log("done");
   						location.reload();
   					}else{
   						response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
   						//console.log("error");
   					}
   				},
   				error: function(){
   					response.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
   				}
   			});
   		}	
   		
   	});	
   });	
</script>