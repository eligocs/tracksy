<?php $customer = $customer[0];  ?>
<?php  if($customer){ ?>
<div class="page-container customer_content">
   <div class="page-content-wrapper">
      <div class="page-content">
         <!-- BEGIN SAMPLE TABLE PORTLET-->
         <?php $message = $this->session->flashdata('success'); 
            if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
            ?>
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption"><i class="fa fa-users"></i><span>Customer Detail </span>
                  <a class="btn btn-danger" style="display:inline;" href="<?php echo site_url("purchaseleads/editlead/{$customer->id}"); ?>" title="Edit Customer Info">Edit Customer</a>
               </div>
               <div class="actions">
                  <a class="btn btn-success" href="<?php echo site_url("purchaseleads"); ?>" title="add customer">Back To All Leads</a>
               </div>
            </div>
         </div>
         <div class="portlet-body">
            <h3>Details</h3>
            <table class="table table-condensed table-hover">
               <tr>
                  <td width="20%">
                     <div class="col-mdd-2 form_vl"><strong>Id: </strong></div>
                  </td>
                  <td>
                     <div class="col-mdd-10 form_vr"><?php  echo $customer->id; ?></div>
                  </td>
               </tr>
               <tr>
                  <td width="20%">
                     <div class="col-mdd-2 form_vl"><strong> Name: </strong></div>
                  </td>
                  <td>
                     <div class="col-mdd-10 form_vr"><?php  echo $customer->c_name; ?></div>
                  </td>
               </tr>
               <tr>
                  <td width="20%">
                     <div class="col-mdd-2 form_vl"><strong>Email: </strong></div>
                  </td>
                  <td>
                     <div class="col-mdd-10 form_vr"><?php echo $customer->c_email; ?></div>
                  </td>
               </tr>
            </table>
         </div>
      </div>
   </div>
</div>
<?php }?>