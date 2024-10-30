<?php 

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { 
global $current_user;
?>

	
<h3><?php echo __( 'Skills' ,'sc' ); ?></h3>
	<table class="form-table">		
		<tr>
			<th><?php echo __( 'Phone' ,'sc' ); ?></th>
			<td>
				<input type="text" name="user_phone"  value="<?php echo esc_attr( get_user_meta(  $user->ID, 'user_phone', true ) ); ?>" />
			</td>
		</tr>		

		
</table>

	 
<?php }
add_action( 'personal_options_update', 'my_satg_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_satg_extra_profile_fields' );

function my_satg_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	update_usermeta( $user_id, 'user_phone', $_POST['user_phone'] );	

}
?>