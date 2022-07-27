<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Post_Checkboxes extends Cuztom_Field
{
	var $_supports_bundle		= true;
	
	var $css_classes 			= array( 'cuztom-input' );

	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );

		$this->args = array_merge(
			array(
				'post_type'			=> 'post',
				'posts_per_page'	=> -1
			),
			$this->args
		);
		
		$this->default_value 	 = (array) $this->default_value;
		$this->posts 			 = get_posts( $this->args );
		$this->after			.= '[]';
	}
	
	function _output( $value )
	{		
		$output = '<div class="cuztom-checkboxes-wrap">';
			if( is_array( $this->posts ) )
			{
				foreach( $this->posts as $post )
				{
					$is_checked = false;

					if( is_array( $value ) ) {
						$is_checked = in_array( $post->ID, $value );
					} else {
						$is_checked = $value != '-1' && in_array( $post->ID, $this->default_value );
					}

					$output .= '<input type="checkbox" ' . $this->output_name() . ' ' . $this->output_id( $this->id . $this->after_id . '_' . Cuztom::uglify( $post->post_title ) ) . ' ' . $this->output_css_class() . ' value="' . $post->ID . '" ' . ( $is_checked ? 'checked="checked"' : '' ) . ' /> ';
					$output .= '<label for="' . $this->id . $this->after_id . '_' . Cuztom::uglify( $post->post_title ) . '">' . $post->post_title . '</label>';
					$output .= '<br />';
				}
			}
		$output .= '</div>';

		$output .= $this->output_explanation();

		return $output;
	}

	function save_value( $value )
	{
		return empty( $value ) ? '-1' : $value;
	}
}