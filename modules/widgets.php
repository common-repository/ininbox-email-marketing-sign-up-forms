<?php 

class ininbox_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'ininbox_widget', // Base ID
			'INinbox Form', // Name
			array( 'description' => __( 'This INinbox widget allows you to add forms in any widget area you want.', 'text_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		$config = get_option('wif_options'); 
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$form = apply_filters( 'widget_title', $instance['form'] );
		$type = apply_filters( 'widget_title', $instance['type'] );
		$descr = apply_filters( 'widget_title', $instance['descr'] );
		$anchor = apply_filters( 'widget_title', $instance['anchor'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		if( $descr ){
			echo '<div>'.$descr.'</div>';	
		}
			
		echo do_shortcode( '[ininbox id="'.$form.'" type="'.$type.'" anchor="'.$anchor.'"]' );
		if( $config['powered'] == 'on' ){ 
			echo '<div> Powered by <a href="http://www.ininbox.com/" target="_blank" >INinbox</a> </div>';
		}
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['form'] = strip_tags( $new_instance['form'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['descr'] = strip_tags( $new_instance['descr'] );
		$instance['anchor'] = strip_tags( $new_instance['anchor'] );
		
		
		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		$form = $instance[ 'form' ];
		$type = $instance[ 'type' ];
		$descr = $instance[ 'descr' ];
		$anchor = $instance[ 'anchor' ];
		
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'descr' ); ?>"><?php _e( 'Description:' ); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'descr' ); ?>" name="<?php echo $this->get_field_name( 'descr' ); ?>" ><?php echo esc_attr( $descr ); ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'form' ); ?>"><?php _e( 'Form:' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id( 'form' ); ?>" name="<?php echo $this->get_field_name( 'form' ); ?>"  >
			<option value="" >Select Form
			<?php 
			 $form_list =  get_option('_ininboxjson' );		  
			  foreach( $form_list as $single_form ){
				echo '<option value="'.$single_form->WebformID.'" '.( esc_attr( $form ) == $single_form->WebformID ? ' selected ' : '' ).' >'.$single_form->FormName;
			  }
			
			?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type:' ); ?></label> 
			<select class="widefat type" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>"  >
			<option value="direct" <?php if( $type == 'direct' ) echo ' selected '; ?> >Direct Link
			<option value="iframe" <?php if( $type == 'iframe' ) echo ' selected '; ?> >IFrame
			<option value="html" <?php if( $type == 'html' ) echo ' selected '; ?> >HTML
			
			</select>
			<script>
			jQuery(document).ready(function($){
				jQuery('.type').change(function(){

					if( jQuery(this).val() == 'direct' ){
						var point = jQuery(this).parents('.widget-content');
						jQuery('.anchor', point).slideDown();
					
					}else{
						var point = jQuery(this).parents('.widget-content');
						jQuery('.anchor', point).slideUp();
					}
				})
				jQuery('.type').change();
			});
			
			</script>
		</p>
		<p class="anchor">
		<label for="<?php echo $this->get_field_id( 'anchor' ); ?>"><?php _e( 'Anchor:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'anchor' ); ?>" name="<?php echo $this->get_field_name( 'anchor' ); ?>" type="text" value="<?php echo esc_attr( $anchor ); ?>" />
		</p>
		<?php 
	}

} // class Foo_Widget
// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "ininbox_widget" );' ) );

?>