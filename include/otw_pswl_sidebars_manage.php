<?php
/** Create/edit otw sidebar
  *
  */
	global $validate_messages;
	
	$otw_sidebar_values = array(
		'sbm_loaded'             =>  false,
		'sbm_title'              =>  '',
		'sbm_description'        =>  '',
		'sbm_replace'            =>  '',
		'sbm_status'             =>  'inactive',
		'sbm_widget_alignment'   =>  'vertical'
	);
	
	$otw_sidebar_id = '';
	
	$page_title = esc_html__( 'Create New Sidebar', 'otw_pswl' );
	
	if( otw_get( 'sidebar', false ) ){
		
		$otw_sidebar_id = otw_get( 'sidebar', '' );
		$otw_sidebars = get_option( 'otw_sidebars' );
		
		if( is_array( $otw_sidebars ) && isset( $otw_sidebars[ $otw_sidebar_id ] ) ){
			
			$otw_sidebar_values['sbm_loaded'] = true;
			$otw_sidebar_values['sbm_title'] = $otw_sidebars[ $otw_sidebar_id ]['title'];
			$otw_sidebar_values['sbm_description'] = $otw_sidebars[ $otw_sidebar_id ]['description'];
			$otw_sidebar_values['sbm_status'] = $otw_sidebars[ $otw_sidebar_id ]['status'];
			if( isset( $otw_sidebars[ $otw_sidebar_id ]['widget_alignment'] ) ){
				$otw_sidebar_values['sbm_widget_alignment'] = $otw_sidebars[ $otw_sidebar_id ]['widget_alignment'];
			}
			$page_title = esc_html__( 'Edit Sidebar', 'otw_pswl' );
		}
	}
	
	//apply post values
	if( otw_post('otw_action',false) ){
		foreach( $otw_sidebar_values as $otw_field_key => $otw_field_default_value ){
			if( otw_post( $otw_field_key, false ) ){
				$otw_sidebar_values[ $otw_field_key ] = otw_post( $otw_field_key, '' );
			}
		}
	}
?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br/></div>
	<h2>
		<?php echo $page_title; ?>
		<a class="preview button" href="admin.php?page=otw-pswl-sidebars-list"><?php esc_html_e('Back To Available Sidebars', 'otw_pswl')?></a>
	</h2>
	<?php include_once( 'otw_pswl_help.php' );?>
	<?php if( isset( $validate_messages ) && count( $validate_messages ) ){?>
		<div id="message" class="error">
			<?php foreach( $validate_messages as $v_message ){
				echo '<p>'.$v_message.'</p>';
			}?>
		</div>
	<?php }?>
	<div class="form-wrap" id="poststuff">
		<form method="post" action="" class="validate">
			<input type="hidden" name="otw_action" value="otw_pswl_sidebars_manage" />
			<?php wp_original_referer_field(true, 'previous'); wp_nonce_field('otw-pswl-sidebars-manage'); ?>
			<div id="post-body">
				<div id="post-body-content">
					<div id="col-left" style="width: 35%;">
						<div class="form-field form-required">
							<label for="sbm_title"><?php esc_html_e( 'Sidebar title', 'otw_pswl' );?></label>
							<input type="text" id="sbm_title" value="<?php echo esc_attr( $otw_sidebar_values['sbm_title'] )?>" tabindex="1" size="30" name="sbm_title"/>
							<p><?php esc_html_e( 'The name is how it appears on your site.', 'otw_pswl' );?></p>
						</div>
						<div class="form-field">
							<label for="sbm_status"><?php esc_html_e( 'Status', 'otw_pswl' );?></label>
							<select id="sbm_status" tabindex="2" style="width: 170px;" name="sbm_status">
								<option value=""<?php if( $otw_sidebar_values['sbm_status'] == '' ){ echo ' selected="selected" ';}?>>--/--</option>
								<option value="active"<?php if( $otw_sidebar_values['sbm_status'] == 'active' ){ echo ' selected="selected" ';}?>><?php esc_html_e( 'Active', 'otw_pswl' )?></option>
								<option value="inactive"<?php if( $otw_sidebar_values['sbm_status'] == 'inactive' ){ echo ' selected="selected" ';}?>><?php esc_html_e( 'Inactive', 'otw_pswl' )?></option>
							</select>
						</div>
						<div class="form-field" id="sbm_widget_alignment_cnt">
							<label for="sbm_widget_alignment"><?php esc_html_e( 'Widget Alignment', 'otw_pswl' );?></label>
							<select id="sbm_widget_alignment" tabindex="2" style="width: 170px;" name="sbm_widget_alignment">
								<option value="vertical"<?php if( in_array( $otw_sidebar_values['sbm_widget_alignment'], array( '', 'vertical' ) ) ){ echo ' selected="selected" ';}?>><?php esc_html_e( 'Vertical (WP default)', 'otw_pswl' )?></option>
								<option value="horizontal"<?php if( $otw_sidebar_values['sbm_widget_alignment'] == 'horizontal' ){ echo ' selected="selected" ';}?>><?php esc_html_e( 'Horizontal', 'otw_pswl' )?></option>
							</select>
						</div>
						<div class="form-field">
							<label for="sbm_description"><?php esc_html_e( 'Description', 'otw_pswl' )?></label>
							<textarea id="sbm_description" name="sbm_description" tabindex="4" rows="3" cols="10"><?php echo otw_esc_text( $otw_sidebar_values['sbm_description'], 'cont' )?></textarea>
							<p><?php esc_html_e( 'Short description for your reference at the admin panel.', 'otw_pswl')?></p>
						</div>
						<p class="submit">
							<input type="submit" value="<?php esc_html_e( 'Save Sidebar', 'otw_pswl') ?>" name="submit" class="button button-primary button-large"/>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
