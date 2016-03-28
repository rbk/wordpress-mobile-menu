<?php  
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Rbk_Mobile_Menu {

	public function __construct() {
		
		// Setup class based variables
		$this->option_group = 'rbk_mobile_menu_settings';
		$this->options_slug = 'options-general.php';
		$this->prefix = 'rbk_';
		$this->settings_page = 'settings_page_rbk_mobile_menu';

		add_action('admin_menu', array($this, 'rbk_add_menu_item') );
		add_action( 'admin_init', array($this, 'rbk_menu_register_settings') );
		add_action('admin_enqueue_scripts', array( $this, 'rbk_enqueue_admin_js' ) );

	}

	public function rbk_add_menu_item( ){
		add_submenu_page( 
			$this->options_slug, 
			'Mobile Menu Settings', 
			'Mobile Menu Settings', 
			'administrator', 
			'rbk_mobile_menu', 
			array($this, 'rbk_mobile_menu_options_page') 
		);
	}
	public function rbk_menu_register_settings( ){

		register_setting( $this->option_group, $this->prefix . 'breakpoint' );
		register_setting( $this->option_group, $this->prefix . 'phone_number' );
		register_setting( $this->option_group, $this->prefix . 'email_address' );
		register_setting( $this->option_group, $this->prefix . 'mobile_logo' );
		register_setting( $this->option_group, $this->prefix . 'mobile_logo_height' );
		register_setting( $this->option_group, $this->prefix . 'mobile_logo_width' );
		register_setting( $this->option_group, $this->prefix . 'header_element_to_remove' );
		register_setting( $this->option_group, $this->prefix . 'menu_bar_color' );
		register_setting( $this->option_group, $this->prefix . 'menu_bar_icon_color' );
	}
	public function rbk_enqueue_admin_js($hook) {
		if ( $this->settings_page != $hook ) {
			return;
		}
		wp_enqueue_script( 'rbk_color_picker', plugins_url( 'js/rbk_mobile_menu.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), '', true  );
		wp_enqueue_style('rbk-menu-style', plugins_url('css/main.css',__FILE__) );
		wp_enqueue_style('rbk-icon-font-style', plugins_url('rbk_menu_icons/rbk-font-style.css',__FILE__) );
	}

	public function rbk_mobile_menu_options_page( ){
		wp_enqueue_media(); 
		wp_enqueue_style( 'wp-color-picker' );

		?>
	

		<div class="rbk wrap">

			<h2>Mobile Menu Settings</h2>

			<style>
				#rbk_mobile_logo_preview {
					background-color: #fff;
					height: 60px;
					padding-left: 8px;
					position: relative;
				}
				#rbk_mobile_logo_preview img {
					display: block;
					padding-top: 7px;
				}
				#rbk-preview-table {
				    min-width: 320px;
				    height: 60px;
				}
			</style>
			
			<form method="post" action="options.php">

				<?php settings_fields( $this->option_group ); ?>
				<?php do_settings_sections( $this->option_group ); ?>
				
				<table class="form-table">
					<tr>
						<th scope="row">
							<label>Mobile Logo</label><br>
							<small>Enter the URL to your mobile logo or upload the logo.</small>
						</th>
						<?php $mobile_logo_url = get_option('rbk_mobile_logo'); ?>
								<td>
									<input type="text" name="rbk_mobile_logo" id="rbk_mobile_logo" class="regular-text" value="<?php echo $mobile_logo_url; ?>" />
									<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Select Image" />
								</td>
								
							<?php if( $mobile_logo_url ) : ?>

							
								<td id="rbk-preview-table">
									<small>Preview:</small>
									<?php //echo rbk_append_menu() ?>
									<div id="rbk_mobile_logo_preview" style="background-color:<?php echo get_option('rbk_menu_bar_color');?>;">
										<img style="display:none;" src="<?php echo $mobile_logo_url; ?>" />
									</div>
								</td>

							<?php else : ?>


								<td id="rbk-preview-table">
									<small>Preview:</small>
									<div id="rbk_mobile_logo_preview" style="background-color:<?php echo get_option('rbk_menu_bar_color');?>;">
									</div>
								</td>

							<?php endif; ?>
					</tr>
					<tr>
						<th scope="row">Menu Bar Color</th>
						<td>
							<input type="text" name="rbk_menu_bar_color" value="<?php echo get_option('rbk_menu_bar_color'); ?>" id="mbcolor">
						</td>
					</tr>
					<tr>
						<th scope="row">Menu Bar Icon Color</th>
						<td>
							<input type="text" name="rbk_menu_bar_icon_color" value="<?php echo get_option('rbk_menu_bar_icon_color'); ?>" id="mbicolor">
						</td>
					</tr>
					<tr>
						<th scope="row"><label>Breakpoint</label><br>
							<small>
								(width at which the mobile menu should be activated)<br>
								Use a pixel value. Example: "768px"
							</small>
						</th>
						<td><input type="text" name="rbk_breakpoint" value="<?php echo ( get_option('rbk_breakpoint') ) ? get_option('rbk_breakpoint') : '767px' ?>" class="regular-text" /></td>
					</tr>
					<tr>
						<th scope="row">
							<label>ID or class of HTML element containing the header</label><br>
							<small>
								This is usually #header.
							</small>
						</th>
						<td><input type="text" name="rbk_header_element_to_remove" value="<?php echo get_option('rbk_header_element_to_remove'); ?>" class="regular-text" /></td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div><!-- end wrap -->
		<?php
	} // end page
}

// Intialize class
if( is_admin() ){
	$rbk_menu = new Rbk_Mobile_Menu();
}

?>