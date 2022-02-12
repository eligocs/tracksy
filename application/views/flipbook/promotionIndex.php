<div class="page-container">
   <div class="page-content-wrapper">
      <div class="page-content">
         <!-- BEGIN SAMPLE TABLE PORTLET-->
         <?php $message = $this->session->flashdata('success'); 
            if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
            ?>
         <!--error message-->
         <?php $err = $this->session->flashdata('error'); 
            if($err){ echo '<span class="help-block help-block-error2 red">'.$err.'</span>';}
            ?>
         <div class="portlet box blue" >
            <div class="portlet-title" >
               <div class="caption"><i class="fa fa-product-hunt" aria-hidden="true"></i> Promotion </div>
               <?php if( $user_role != 97 ){ ?>
               <a class="btn btn-success" href="<?php echo site_url("flipbook"); ?>" title="add Itineraries">Add Promotion </a>
               <?php } ?>	
            </div>
         </div>
         <div class="portlet-body">
            <div class="table-responsive second_custom_card">
               <table id="itinerary" class="table dataTable table-striped table-hover">
                  <thead>
                     <tr>
                        <th> # </th>
                        <th> Promotion ID </th>
                        <th> Promotion Name </th>
                        <th> State</th>
                        <th> City</th>
                        <th> No.Of Pages</th>
                        <th> Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $n=1; foreach($promo as $pro){ $pages=count_pages($pro->id);?> 
                     <tr>
                        <td><?php echo $n++; ?></td>
                        <td><?php echo $pro->id; ?></td>
                        <td><?php echo $pro->promotion_name; ?></td>
                        <td><?php echo get_state_name($pro->state); ?></td>
                        <td><?php echo get_city_name($pro->city); ?></td>
                        <td><?php if($pages){
                           echo $pages;
                           }
                            else{
                             echo 'NIL';
                            }?>
                        </td>
                        <td>
                           <div class="dropdown">
                              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                              <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php  echo base_url('flipbook/view/').$pro->id; ?>" class="nav-link "><i class="fa fa-eye" aria-hidden="true"></i> View Details</a></li>
                                 <li><a href="<?php  echo base_url('flipbook/add/').$pro->id; ?>" class="nav-link "><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></li>
                                 <li><a href="<?php  echo base_url('flipbook/addpages/').$pro->id; ?>" class="nav-link "><i class="fa fa-plus" aria-hidden="true"></i> Add Pages</a></li>
                                 <li class="<?php if(empty($pages)){ echo 'hide'; } ?>" ><a  target = '_blank'  href="<?php echo site_url("flipbook/viewpromotion/").$pro->id.'/'.$pro->tmp_key;?>" title="Back"><i class="fa fa-product-hunt" aria-hidden="true"></i> View Promotion </a></li>
                                 <li><a href="<?php  echo base_url('flipbook/deletePromo/').$pro->id; ?>" class="nav-link "><i class="fa fa-remove" aria-hidden="true"></i>Delete Promotion</a></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                     <?php } ?> 
                     <div class="loader"></div>
                     <div id="res"></div>
                     <!--DataTable Goes here-->
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END CONTENT BODY -->
</div>
<div class="modal-footer"></div>
</div>
</div>
</div>
<script>
   $(document).ready( function () {
   $('#itinerary').DataTable();
   
   } );
   $(document).on("click", ".optionToggleBtn", function(e){
   		e.preventDefault();
   		var _this = $(this);
   		_this.parent().find(".optionTogglePanel").slideToggle();
   	});
   	
</script>