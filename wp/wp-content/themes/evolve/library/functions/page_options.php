<div class='pyre_metabox'>
<h2 style="margin-top:0;">Post options</h2>
<?php
$this->evolve_select(	'full_width',
				'Full Width',
				array('no' => 'No', 'yes' => 'Yes'),
				''
			);
?>  
<h2 style="margin-top:0;">Slider Options:</h2>
<?php   
$this->evolve_select(	'slider_type',
				'Slider Type',
				array('no' => 'No Slider', 'parallax' => 'Parallax Slider', 'posts' => 'Posts Slider'),
				''
			);
?>
</div>
