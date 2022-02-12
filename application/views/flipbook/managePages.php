<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>Promotion Name: <strong><?php echo $promotion[0]->promotion_name; ?></strong>
					</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("flipbook/view/").$promotion[0]->id; ?>" title="Back">Back</a>
				</div>
			</div>
			<a class="btn btn-success"  href="<?php echo site_url("flipbook/viewpromotion/").$promotion[0]->id.'/'.$promotion[0]->tmp_key;?>" title="Back">View Promotion </a>
			<a title='Edit User' class="btn btn-success pull-right" href="<?php echo site_url("flipbook/addpages/{$promotion[0]->id}"); ?>" class="" ><i class="fa fa-pencil"></i>Add Pages</a>
		<?php if(isset($pages) && !empty($pages) ){ ?>
			<table class="table dataTable table-striped table-hover">
				<thead>
					<tr>
						<th> # </th>
						<th> Page ID </th>
						<th> Page Title</th>
						<th> Page Type</th>
						<th> Order</th>
						<th> Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 	$i=1;
					$count = count($pages);
					foreach($pages as $page){ ?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo $page->id; ?> </td>
						<td><?php echo $page->page_title; ?></td>
						<td><?php $type = $page->page_type; 
								if($type == 1){
									echo 'Text';
								}
								else{
								echo 'Image';
								}
						?></td>
						<td><?php echo $page->p_order; ?></td>
						<td><a href="<?php  echo base_url('flipbook/viewPage/').$page->id.'/'.$type; ?>" class="nav-link "><i class="fa fa-eye" aria-hidden="true"></i></a>
							<a href="<?php  echo base_url('flipbook/editPage/').$page->id.'/'.$type; ?>" class="nav-link ">
								<i class="fa fa-edit" aria-hidden="true"></i></a>
							<a href="<?php  echo base_url('flipbook/deletePage/').$page->id; ?>" class="nav-link"><i class="fa fa-remove" aria-hidden="true"></i></a>
						<?php }?>
				</tbody>
			</table>
		<?php  }else{echo 'No Pages Available';}?>
		</div>	
	</div>	
</div>	