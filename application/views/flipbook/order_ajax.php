<?php
echo get_ol($pages);
function get_ol ($array, $child = FALSE)
{
	$str = '';
	
	if (count($array)) {
		$str .= $child == FALSE ? '<ol class="sortable">' : '<ol>';
		
		foreach ($array as $item) {
			$content =$item['content'];
			$pid =get_promo_name($item['promotion_id']);
			$str .= '<li  id="list_' . $item['id'] .'">';
			if($item['page_type'] == 0){
			$str .= "<div><img title=".$content." src=".base_url('site/images/promotions/').$content. '></div>';
			}
			else{
			//$text = strlen($content) > 150 ? substr($content, 0, 50).'&hellip;' : $content;

			$str .= "<div class='summery'><h4>". $item['page_title'].'</h4><p>'.$content.'<p></div>';
			}
			// Do we have any children?
			if (isset($item['children']) && count($item['children'])) {
				$str .= get_ol($item['children'], TRUE);
			}
			
			$str .= '</li>' . PHP_EOL;
		}
		
		$str .= '</ol>' . PHP_EOL;
	}
	
	return $str;
}
?>

<script>
$(document).ready(function(){

 $( function() {
    $( ".sortable" ).sortable();
    $( ".sortable" ).disableSelection();
  } );       

});
</script>