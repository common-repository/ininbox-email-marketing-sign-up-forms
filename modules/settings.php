<?php 
	
add_action('admin_menu', 'wif_item_menu');

function wif_item_menu() {
	add_options_page(  __('INinbox Settings', 'sc'), __('INinbox Settings', 'sc'), 'edit_published_posts', 'wif_config', 'wif_config');
}

function wif_config(){

?>
<div class="wrap tw-bs">
 <?php if(  wp_verify_nonce($_POST['_wpnonce']) ): ?>
  
  
  <?php 
  set_time_limit ( 300 );
  
  
  
  	foreach( $_POST as $key=>$value ){
		$wif_options[$key] = $value;
	}

	update_option('wif_options', $wif_options );
  
  
	$responce = wif_api_call(1);

	$json_out = json_decode( $responce );
	if( $json_out->Results	 ){
		$out_msg = '<div id="message" class="updated" >Settings saved successfully</div>';
		
		$responce = wif_api_call( 1000 );
		$json_out = json_decode( $responce );
		$num_of_ent = ($json_out->TotalNumberOfRecords / 10) ;
		$num_of_ent = (int)$num_of_ent + 1;
		for($i=1; $i<=$num_of_ent; $i++){
			$responce = wif_api_call( $i );
			$json_out = json_decode( $responce );
			foreach( $json_out->Results as $single_line ){
				$out[] = $single_line;
			}
			
		}
		//var_dump( $out );
		//adding prams
		update_option('_ininboxjson', $out );
		update_option('_ininboxjson_time', time() );
		
		//update form codes
		
		foreach( $out as $single_item ){
		
		$resp =wif_get_form( $single_item->WebformID );
		$resp = json_decode( $resp );
		update_option( '_form_data_'.$single_item->WebformID, $resp->WebformCode );
		
		}
		
		
		
	}else{
		$out_msg = '<div id="message" class="error" >Code: '.$json_out->Code.' Messgae: '.$json_out->Message.'</div>'; 
		delete_option('_ininboxjson' );
		delete_option('_ininboxjson_time' );
	}
	

	echo $out_msg;
  ?>
  
  
  <?php else:  ?>
  
  <?php //exit; ?>
  
  <?php endif; ?> 
  <a href="https://www.ininbox.com/free-sign-up.html" target="_blank"><img src="<?php echo plugins_url('/images/header.jpg', __FILE__ ); ?>" /></a>
<form class="form-horizontal" method="post" action="">
<?php wp_nonce_field();  
$config = get_option('wif_options'); 
?>  

    <fieldset>  
		<br/>
		<h3>Account Details</h3>  
		
		  <div class="control-group">  
            <label class="control-label" for="input01">INinbox API Key</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" id="api_key" name="api_key" value="<?php echo $config['api_key']; ?>"> 
				<p><a href="http://www.ininbox.com/api" target="_blank">Where can I find my API key?</a></p>			  
            </div>  
          </div> 
		  
		  <div class="control-group hide">  
            <label class="control-label" for="input01">API Password</label>  
            <div class="controls">  
              <input type="text" class="input-xlarge" id="api_pass" name="api_pass" value="IN">   
			  
            </div>  
          </div>

		  <div class="control-group">  
            <label class="control-label" for="optionsCheckbox">&nbsp;</label>  
            <div class="controls">  
              <label class="checkbox">  
                <input type="checkbox" name="powered" value="on" <?php if( $config['powered'] == 'on' ) echo ' checked '; ?> >  
                Display "Powered by INinbox" ?  
              </label>  
            </div>  
          </div> 

		 
          <div class="form-actions">  
            <button type="submit" class="btn btn-primary">Save Settings</button>  
          </div>  
        </fieldset> 

		<?php 
		
		//$forms = json_decode( wif_get_forms_call() );
		
		?>
		<br/>
		 <div class="control-group"> 
			<h3>Available Forms</h3>
		</div>
		<table class="table table_in">  
        <thead>  
          <tr>  
            <th>Form Name</th>   
            <th>List ID</th>  
            <th>Shortcode & Tag Direct Link</th>  
			<th>Shortcode & Tag IFrame Form</th>  
			<th>Shortcode & Tag HTML Form</th>  
			<th>Editor</th>
			<th>Preview</th>
			
          </tr>  
        </thead>  
        <tbody>  
          <?php 
	//var_dump( get_option('_ininboxjson' ) );
		  if( get_option('_ininboxjson' ) ):		  
		  $form_list =  get_option('_ininboxjson' );		  
		  foreach( $form_list as $single_form ): 
		  ?> 
          <tr>  
            <td><?php echo $single_form->FormName; ?></td>  
            <td><?php echo $single_form->WebformID; ?></td>  
            <td>[ininbox id="<?php echo $single_form->WebformID; ?>" type="direct" anchor="Subscribe!"]
			<br/>
			&lt;?php	 ininbox_form( '<?php echo $single_form->WebformID; ?>', 'direct', 'Subscribe!' ); ?&gt;
			</td>  
            <td>[ininbox id="<?php echo $single_form->WebformID; ?>" type="iframe"]<br/>
			&lt;?php	 ininbox_form( '<?php echo $single_form->WebformID; ?>', 'iframe' ); ?&gt;</td>  
			<td>[ininbox id="<?php echo $single_form->WebformID; ?>" type="html"]<br/>
			&lt;?php	 ininbox_form( '<?php echo $single_form->WebformID; ?>', 'html' ); ?&gt;</td>  
			<td><a href="http://www.ininbox.com/?page=m-webform_add&step=1&mode=Update&iMWebformId=<?php echo $single_form->WebformID; ?>" target="_blank">Edit</a>
			
			
			</td>
			<td>
			<a  href="<?php echo $single_form->WebformURL; ?>" target="_blank">Preview</a></td>
          </tr>  
		  <?php  
		  endforeach; 
		  endif;
		  ?>
        </tbody> 	
      </table>  
		<fieldset>
		<div class="">  
			
			<div class="pull-left mar_r" >
				Is your form not showing?
			</div>
			<div class="pull-left mar_r">
            <button type="submit" class="btn btn-success">Refresh Lists</button>
			
			
			</div>
			<div class="pull-left mar_r">
				or Create new one <a href="http://www.ininbox.com/?page=m-webform_add" target="_blank">here</a>.
			</div>
			
			<div class="clearfix"></div>
			<div class="l_upd">
			<?php if( get_option('_ininboxjson_time' ) ): ?>
			<div>Last Update: <?php  echo date( 'm/d/Y H:i:s', get_option('_ininboxjson_time' ) ); ?></div>
			<?php endif; ?>	
			</div>
          </div>  
		</fieldset>
		
		<br/>
	 <div class="control-group"> 
		<h3>INspired Support</h3>	
		<div>Not sure about one of the great features of this plugin? Get free support <a href="http://www.ininbox.com/support" target="_blank" >here</a>.</div>
	</div>
</form>
  
</div>


<?php 
}
?>