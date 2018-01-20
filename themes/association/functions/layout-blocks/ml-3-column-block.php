<?php

/** A simple text block **/

class ML_3_Column_Block extends ML_Block {

	

	/* PHP5 constructor */

	function __construct() {

		

		$block_options = array(

			'name' => esc_html__('Narrow Column','association'),

			'size' => 'span4',

		);

		

		//create the widget

		parent::__construct('ml_3_column_block', $block_options);

		

	}







	//form header

	function before_form($instance) {

		extract($instance);

		

		$title = $title ? '<span class="in-block-title"> : '.$title.'</span>' : '';

		$resizable = $resizable ? '' : 'not-resizable';

		

		echo '<li id="template-block-'.$number.'" class="block block-container block-'.$id_base.' '. $size .' '.$resizable.'">',

				'<dl class="block-bar">',

					'<dt class="block-handle">',

						'<div class="block-title">',

							$name , $title, 

						'</div>',

						'<span class="block-controls">',

							'<a class="block-edit" id="edit-'.$number.'" title="Edit Block" href="#block-settings-'.$number.'">Edit Block</a>',

						'</span>',

					'</dt>',

				'</dl>',

				'<div class="block-settings cf" id="block-settings-'.$number.'">';

	}



	function form($instance) {

		echo '<p class="empty-column">',

		__('Narrow Column - Drag block items into this column box','association'),

		'</p>';

		echo '<ul class="blocks column-blocks cf"></ul>';

	}

	

	function form_callback($instance = array()) {

		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;

		

		//insert the dynamic block_id & block_saving_id into the array

		$this->block_id = 'ml_block_' . $instance['number'];

		$instance['block_saving_id'] = 'ml_blocks[ml_block_'. $instance['number'] .']';



		extract($instance);

		

		$col_order = $order;

		

		//column block header

		if(isset($template_id)) {

			echo '<li id="template-block-'.$number.'" class="block block-container block-ml_column_block '.$size.'">',

					'<div class="block-settings-column cf" id="block-settings-'.$number.'">',

						'<p class="empty-column">',

							__('1/3 Column - Drag block items into this column box','association'),

						'</p>',

						'<ul class="blocks column-blocks cf">';

					

			//check if column has blocks inside it

			$blocks = ml_get_blocks($template_id);

			

			//outputs the blocks

			if($blocks) {

				foreach($blocks as $key => $child) {

					global $ml_registered_blocks;

					extract($child);

					

					//get the block object

					$block = $ml_registered_blocks[$id_base];

					

					if($parent == $col_order) {

						$block->form_callback($child);

					}

				}

			} 

			echo 		'</ul>';

			

		} else {

			$this->before_form($instance);

			$this->form($instance);

		}

				

		//form footer

		$this->after_form($instance);

	}

	

	//form footer

	function after_form($instance) {

		extract($instance);

		

		$block_saving_id = 'ml_blocks[ml_block_'.$number.']';

			

			echo '<div class="block-control-actions cf"><a href="#" class="delete">Delete</a></div>';

			echo '<input type="hidden" class="id_base" name="'.$this->get_field_name('id_base').'" value="'.$id_base.'" />';

			echo '<input type="hidden" class="name" name="'.$this->get_field_name('name').'" value="'.$name.'" />';

			echo '<input type="hidden" class="order" name="'.$this->get_field_name('order').'" value="'.$order.'" />';

			echo '<input type="hidden" class="size" name="'.$this->get_field_name('size').'" value="'.$size.'" />';

			echo '<input type="hidden" class="parent" name="'.$this->get_field_name('parent').'" value="'.$parent.'" />';

			echo '<input type="hidden" class="number" name="'.$this->get_field_name('number').'" value="'.$number.'" />';

		echo '</div>',

			'</li>';

	}

	

	function block_callback($instance) {

		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;

		

		extract($instance);

		

		$col_order = $order;

		$col_size = absint(preg_replace("/[^0-9]/", '', $size));

		

		//column block header

		if(isset($template_id)) {

			$this->before_block($instance);

			

			//define vars

			$overgrid = 0; $span = 0; $first = false;

			

			//check if column has blocks inside it

			$blocks = ml_get_blocks($template_id);

			

			//outputs the blocks

			if($blocks) {

				foreach($blocks as $key => $child) {

					global $ml_registered_blocks;

					extract($child);

					

					if(class_exists($id_base)) {

						//get the block object

						$block = $ml_registered_blocks[$id_base];

						

						//insert template_id into $child

						$child['template_id'] = $template_id;

						

						//display the block

						if($parent == $col_order) {

							

							$child_col_size = absint(preg_replace("/[^0-9]/", '', $size));

							

							$overgrid = $span + $child_col_size;

							

							if($overgrid > $col_size || $span == $col_size || $span == 0) {

								$span = 0;

								$first = true;

							}

							

							if($first == true) {

								$child['first'] = true;

							}

							

							$block->block_callback($child);

							

							$span = $span + $child_col_size;

							

							$overgrid = 0; //reset $overgrid

							$first = false; //reset $first

						}

					}

				}

			} 

			

			$this->after_block($instance);

			

		} else {

			//show nothing

		}

	}

	

}