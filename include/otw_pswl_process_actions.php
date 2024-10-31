<?php
/**
 * Process otw actions
 *
 */
if( otw_post('otw_action',false) ){

	switch( otw_post('otw_action','') ){
		
		case 'otw_pswl_overlay_activate':
				if( otw_post( 'cancel', false ) ){
					wp_redirect( 'admin.php?page=otw-pswl' );
				}else{
					$otw_overlays = otw_get_overlays();
					
					if( otw_get('overlay',false) && isset( $otw_overlays[ otw_get('overlay','') ] ) ){
						$otw_overlay_id = otw_get( 'overlay', '' );
						
						$otw_overlays[ $otw_overlay_id ]['status'] = 'active';
						
						otw_save_overlays( $otw_overlays );
						
						wp_redirect( 'admin.php?page=otw-pswl&message=3' );
					}else{
						wp_die( esc_html__( 'Invalid overlay', 'otw_pswl' ) );
					}
				}
			break;
		case 'otw_pswl_overlay_deactivate':
				if( otw_post( 'cancel', false ) ){
					wp_redirect( 'admin.php?page=otw-pswl' );
				}else{
					$otw_overlays = otw_get_overlays();
					
					if( otw_get('overlay',false) && isset( $otw_overlays[ otw_get('overlay','') ] ) ){
						$otw_overlay_id = otw_get( 'overlay', '' );
						
						$otw_overlays[ $otw_overlay_id ]['status'] = 'inactive';
						
						otw_save_overlays( $otw_overlays );
						
						wp_redirect( 'admin.php?page=otw-pswl&message=4' );
					}else{
						wp_die( esc_html__( 'Invalid overlay', 'otw_pswl' ) );
					}
				}
			break;
		case 'otw_pswl_overlay_delete':
				if( otw_post( 'cancel', false ) ){
					wp_redirect( 'admin.php?page=otw-pswl' );
				}else{
					
					$otw_overlays = otw_get_overlays();
					
					if( otw_get('overlay',false) && isset( $otw_overlays[ otw_get('overlay','') ] ) ){
						$otw_overlay_id = otw_get( 'overlay', '' );
						
						$new_overlays = array();
						
						//remove the overlay from otw_overlays
						foreach( $otw_overlays as $overlay_key => $overlay ){
						
							if( $overlay_key != $otw_overlay_id ){
							
								$new_overlays[ $overlay_key ] = $overlay;
							}
						}
						otw_save_overlays( $new_overlays );
						
						wp_redirect( admin_url( 'admin.php?page=otw-pswl&message=2' ) );
					}else{
						wp_die( esc_html__( 'Invalid overlay', 'otw_pswl' ) );
					}
				}
			break;
		case 'otw_pswl_sidebar_activate':
				if( otw_post( 'cancel', false ) ){
					wp_redirect( 'admin.php?page=otw-pswl-sidebars-list' );
				}else{
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( otw_get( 'sidebar', false ) && isset( $otw_sidebars[ otw_get( 'sidebar', '' ) ] ) ){
						$otw_sidebar_id = otw_get( 'sidebar', '' );
						
						$otw_sidebars[ $otw_sidebar_id ]['status'] = 'active';
						
						update_option( 'otw_sidebars', $otw_sidebars );
						
						wp_redirect( 'admin.php?page=otw-pswl-sidebars-list&message=3' );
					}else{
						wp_die( esc_html__( 'Invalid sidebar', 'otw_pswl' ) );
					}
				}
			break;
		case 'otw_pswl_sidebar_deactivate':
				if( otw_post( 'cancel', false ) ){
					wp_redirect( 'admin.php?page=otw-pswl-sidebars-list' );
				}else{
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( otw_get( 'sidebar', false ) && isset( $otw_sidebars[ otw_get( 'sidebar', '' ) ] ) ){
						$otw_sidebar_id = otw_get( 'sidebar', '' );
						
						$otw_sidebars[ $otw_sidebar_id ]['status'] = 'inactive';
						
						update_option( 'otw_sidebars', $otw_sidebars );
						
						wp_redirect( 'admin.php?page=otw-pswl-sidebars-list&message=4' );
					}else{
						wp_die( esc_html__( 'Invalid sidebar', 'otw_pswl' ) );
					}
				}
			break;
		case 'otw_pswl_sidebar_delete':
				if( otw_post( 'cancel', false ) ){
					wp_redirect( 'admin.php?page=otw-pswl-sidebars-list' );
				}else{
					
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( otw_get( 'sidebar', false ) && isset( $otw_sidebars[ otw_get( 'sidebar', '' ) ] ) ){
						$otw_sidebar_id = otw_get( 'sidebar', '' );
						
						$new_sidebars = array();
						
						//remove the sidebar from otw_sidebars
						foreach( $otw_sidebars as $sidebar_key => $sidebar ){
						
							if( $sidebar_key != $otw_sidebar_id ){
							
								$new_sidebars[ $sidebar_key ] = $sidebar;
							}
						}
						update_option( 'otw_sidebars', $new_sidebars );
						
						//remove sidebar from widget
						$widgets = get_option( 'sidebars_widgets' );
						
						if( isset( $widgets[ $otw_sidebar_id ] ) ){
							
							$new_widgets = array();
							foreach( $widgets as $sidebar_key => $widget ){
								if( $sidebar_key != $otw_sidebar_id ){
								
									$new_widgets[ $sidebar_key ] = $widget;
								}
							}
							update_option( 'sidebars_widgets', $new_widgets );
						}
						
						wp_redirect( admin_url( 'admin.php?page=otw-pswl-sidebars-list&message=2' ) );
					}else{
						wp_die( esc_html__( 'Invalid sidebar', 'otw_pswl' ) );
					}
				}
			break;
		case 'otw_pswl_sidebars_manage':
				global $validate_messages, $wpdb;
				
				$validate_messages = array();
				$valid_page = true;
				if( !otw_post( 'sbm_title', false ) || !strlen( trim( otw_post( 'sbm_title', '' ) ) ) ){
					$valid_page = false;
					$validate_messages[] = esc_html__( 'Please type valid sidebar title', 'otw_pswl' );
				}
				if( !otw_post( 'sbm_status', false ) || !strlen( trim( otw_post( 'sbm_status', '' ) ) ) ){
					$valid_page = false;
					$validate_messages[] = esc_html__( 'Please select status', 'otw_pswl' );
				}
				
				if( $valid_page ){
					$otw_sidebars = get_option( 'otw_sidebars' );
					
					if( !is_array( $otw_sidebars ) ){
						$otw_sidebars = array();
					}
					
					if( otw_get( 'sidebar', false ) && isset( $otw_sidebars[ otw_get( 'sidebar', '' ) ] ) ){
						$otw_sidebar_id = otw_get( 'sidebar', '' );
						$sidebar = $otw_sidebars[ otw_get( 'sidebar', '' ) ];
					}else{
						$sidebar = array();
						$otw_sidebar_id = false;
					}
					
					$sidebar['title'] = (string) otw_post( 'sbm_title', '' );
					$sidebar['description'] = (string) otw_post( 'sbm_description', '' );
					$sidebar['status'] = (string) otw_post( 'sbm_status', '' );
					$sidebar['widget_alignment'] = (string) otw_post( 'sbm_widget_alignment', '' );
					
					if( $otw_sidebar_id === false ){
						
						$otw_sidebar_id = 'otw-sidebar-'.( get_next_otw_pswl_sidebar_id() );
						$sidebar['id'] = $otw_sidebar_id;
						$sidebar['replace'] = '';
						$sidebar['validfor'] = array();
					}
					
					$otw_sidebars[ $otw_sidebar_id ] = $sidebar;
					
					if( !update_option( 'otw_sidebars', $otw_sidebars ) && $wpdb->last_error ){
						
						$valid_page = false;
						$validate_messages[] = esc_html__( 'DB Error: ', 'otw_pswl' ).$wpdb->last_error.'. Tring to save '.strlen( maybe_serialize( $otw_sidebars ) ).' bytes.';
					}else{
						wp_redirect( 'admin.php?page=otw-pswl-sidebars-list&message=1' );
					}
				}
			break;
		case 'manage_otw_pswl_overlay':
				
				global $validate_messages, $wpdb, $otw_pswl_overlay_object;
				
				$validate_messages = array();
				
				$valid_page = true;
				if( !otw_post( 'title', false ) || !strlen( trim( otw_post( 'title', '' ) ) ) ){
					$valid_page = false;
					$validate_messages[] = esc_html__( 'Please type valid overlay title', 'otw_pswl' );
				}
				if( !otw_post( 'status', false ) || !strlen( trim( otw_post( 'status', '' ) ) ) ){
					$valid_page = false;
					$validate_messages[] = esc_html__( 'Please select status', 'otw_pswl' );
				}
				if( !otw_post( 'type', false ) || !strlen( trim( otw_post( 'type', '' ) ) ) ){
					$valid_page = false;
					$validate_messages[] = esc_html__( 'Please select overlay type', 'otw_pswl' );
				}
				if( $valid_page ){
					$otw_overlays = otw_get_overlays();
					
					if( otw_get('overlay',false) && isset( $otw_overlays[ otw_get('overlay','') ] ) ){
						$otw_overlay_id = otw_get( 'overlay', '' );
						$overlay = $otw_overlays[ otw_get('overlay','') ];
					}else{
						$overlay = array();
						$otw_overlay_id = false;
					}
					
					$overlay['title'] = (string) otw_post( 'title', '' );
					$overlay['type'] = (string) otw_post( 'type', '' );
					$overlay['status'] = (string) otw_post( 'status', '' );
					$overlay['grid_content'] = otw_post( array( '_otw_grid_manager_content', 'code' ), '' );
					$overlay['options'] = array();
					
					//save options
					foreach( $otw_pswl_overlay_object->overlay_types as $overlay_type => $overlay_type_data ){
						
						foreach( $overlay_type_data['options'] as $o_type => $type_options ){
							
							if( in_array( $o_type, array( 'main', 'custom' ) ) ){
								
								foreach( $type_options['items'] as $option_name => $option_item ){
									
									if( otw_post( $overlay_type.'_'.$option_name, false ) ){
										
										$overlay['options'][ $overlay_type.'_'.$option_name ] = otw_post( $overlay_type.'_'.$option_name, '' );
										
									}elseif( isset( $overlay['options'][ $overlay_type.'_'.$option_name ] ) ){
										
										unset( $overlay['options'][ $overlay_type.'_'.$option_name ] );
									}
									
									if( isset( $option_item['subfields'] ) && is_array( $option_item['subfields'] ) && count( $option_item['subfields'] ) ){
									
										foreach( $option_item['subfields'] as $subfield => $subfield_data ){
										
											if( otw_post( $overlay_type.'_'.$option_name.'_'.$subfield, false ) ){
												
												$overlay['options'][ $overlay_type.'_'.$option_name.'_'.$subfield ] = otw_post( $overlay_type.'_'.$option_name.'_'.$subfield, '' );
												
											}elseif( isset( $overlay['options'][ $overlay_type.'_'.$option_name.'_'.$subfield  ] ) ){
												
												unset( $overlay['options'][ $overlay_type.'_'.$option_name.'_'.$subfield  ] );
											}
										}
									
									}
								}
								
							}else{
								foreach( $type_options['items'] as $option_name => $option_item ){
									
									$overlay['options'][ $overlay_type.'_'.$option_name ] = $option_item['default'];
								}
							}
						}
					}
					
					if( $otw_overlay_id === false ){
						
						$otw_overlay_id = 'otw-overlay-'.( otw_get_next_overlay_id() );
						$overlay['id'] = $otw_overlay_id;
					}
					
					$otw_overlays[ $otw_overlay_id ] = $overlay;
					
					if( !otw_save_overlays( $otw_overlays ) && $wpdb->last_error ){
						
						$valid_page = false;
						$validate_messages[] = esc_html__( 'DB Error: ', 'otw_pswl' ).$wpdb->last_error.'. Tring to save '.strlen( maybe_serialize( $otw_overlays ) ).' bytes.';
					}else{
						wp_redirect( 'admin.php?page=otw-pswl&message=1' );
					}
				}
			break;
		case 'otw_pswl_manage_options':
				if( otw_post( 'otw_psw_promotions', false ) && !empty( otw_post( 'otw_psw_promotions', '' ) ) ){
					
					global $otw_pswl_factory_object, $otw_pswl_plugin_id;
					
					update_option( $otw_pswl_plugin_id.'_dnms', otw_post( 'otw_psw_promotions', '' ) );
					
					if( is_object( $otw_pswl_factory_object ) ){
						$otw_pswl_factory_object->retrive_plungins_data( true );
					}
				}
				wp_redirect( admin_url( 'admin.php?page=otw-pswl-options&message=1' ) );
			break;
	}
}
