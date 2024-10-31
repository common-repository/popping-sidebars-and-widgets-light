<?php
/** List with all available otw sitebars
  *
  *
  */
global $_wp_column_headers;

$_wp_column_headers['toplevel_page_otw-pswl'] = array(
	'title' => esc_html__( 'Title', 'otw_pswl' ),
	'type' =>  esc_html__( 'Type', 'otw_pswl' ),
	'status' => esc_html__( 'Status', 'otw_pswl' )
);

$otw_overlay_list = otw_get_overlays();

$message = '';
$massages = array();
$messages[1] = esc_html__( 'overlay saved.', 'otw_pswl' );
$messages[2] = esc_html__( 'overlay deleted.', 'otw_pswl' );
$messages[3] = esc_html__( 'overlay activated.', 'otw_pswl' );
$messages[4] = esc_html__( 'overlay deactivated.', 'otw_pswl' );


if( otw_get('message',false) && isset( $messages[ otw_get('message','') ] ) ){
	$message .= $messages[ otw_get('message','') ];
}


?>
<?php if ( $message ) : ?>
<div id="message" class="updated"><p><?php echo esc_html( $message ); ?></p></div>
<?php endif; ?>
<div class="wrap">
	<div id="icon-edit" class="icon32"><br/></div>
	<h2>
		<?php esc_html_e('Available Custom overlays', 'otw_pswl') ?>
		<a class="preview button" href="admin.php?page=otw-pswl-manage"><?php esc_html_e('Add New', 'otw_pswl') ?></a>
	</h2>
	<?php include_once( 'otw_pswl_help.php' );?>
	<form class="search-form" action="" method="get">
	</form>
	
	<br class="clear" />
	<?php if( is_array( $otw_overlay_list ) && count( $otw_overlay_list ) ){?>
	<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<?php foreach( $_wp_column_headers['toplevel_page_otw-pswl'] as $key => $name ){?>
					<th><?php echo esc_html( $name )?></th>
				<?php }?>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<?php foreach( $_wp_column_headers['toplevel_page_otw-pswl'] as $key => $name ){?>
					<th><?php echo esc_html( $name )?></th>
				<?php }?>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach( $otw_overlay_list as $overlay_item ){?>
				<tr>
					<?php foreach( $_wp_column_headers['toplevel_page_otw-pswl'] as $column_name => $column_title ){
						
						$edit_link = admin_url( 'admin.php?page=otw-pswl-manage&amp;action=edit&amp;overlay='.$overlay_item['id'] );
						$delete_link = admin_url( 'admin.php?page=otw-pswl-action&amp;overlay='.$overlay_item['id'].'&amp;action=delete' );
						$status_link = '';
						switch( $overlay_item['status'] ){
							case 'active':
									$status_link = admin_url( 'admin.php?page=otw-pswl-action&amp;overlay='.$overlay_item['id'].'&amp;action=deactivate' );
									$status_link_name = esc_html__( 'Deactivate', 'otw_pswl' );
								break;
							case 'inactive':
									$status_link = admin_url( 'admin.php?page=otw-pswl-action&amp;overlay='.$overlay_item['id'].'&amp;action=activate' );
									$status_link_name = esc_html__( 'Activate', 'otw_pswl' );
								break;
						}
						switch($column_name) {

							case 'cb':
									echo '<th scope="row" class="check-column"><input type="checkbox" name="itemcheck[]" value="'. esc_attr($overlay_item['id']) .'" /></th>';
								break;
							case 'title':
									echo '<td><strong><a href="'.esc_attr( $edit_link ).'" title="'.esc_attr(sprintf(__('Edit &#8220;%s&#8221;', 'otw_pswl'), $overlay_item['title'])).'">'.$overlay_item['title'].'</a></strong><br />';
									
									echo '<div class="row-actions">';
									echo '<a href="'.esc_attr( $edit_link ).'">' . esc_html__('Edit', 'otw_pswl') . '</a>';
									echo ' | <a href="'.esc_attr( $delete_link ).'">' . esc_html__('Delete', 'otw_pswl'). '</a>';
									if( $status_link ){
									echo ' | <a href="'.esc_attr( $status_link ).'">' . $status_link_name. '</a>';
									}
									echo '</div>';
									
									echo '</td>';
								break;
							case 'type':
									echo '<td>'.$overlay_item['type'].'</td>';
								break;
							case 'status':
									switch( $overlay_item['status'] ){
										case 'active':
												echo '<td class="overlay_active">'.esc_html__( 'Active', 'otw_pswl' ).'</td>';
											break;
										case 'inactive':
												echo '<td class="overlay_inactive">'.esc_html__( 'Inactive', 'otw_pswl' ).'</td>';
											break;
										default:
												echo '<td>'.esc_html__( 'Unknown', 'otw_pswl' ).'</td>';
											break;
									}
								break;
						}
					}?>
				</tr>
			<?php }?>
		</tbody>
	</table>
	<?php }else{ ?>
		<p><?php esc_html_e('No overlays found.', 'otw_pswl')?></p>
	<?php } ?>
</div>
