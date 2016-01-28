<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Output the menu
function rbk_append_menu( ){

	$header_element = get_option('rbk_header_element_to_remove');
	$header_to_replace = ( $header_element  ) ? $header_element : '#header';
	$width = 0;
	$max_height = 46;
	$breakpoint = get_option('rbk_breakpoint');
	$phone = get_option('rbk_phone_number');
	$email = get_option('rbk_email_address');
	$logo = get_option('rbk_mobile_logo');
	$home_url = home_url('/');

	// Colors/Style
	$mbcolor = get_option( 'rbk_menu_bar_color' );
	$mbcolor = ( !empty($mbcolor) ) ? $mbcolor : '#fff';

	$mbicolor = get_option( 'rbk_menu_bar_icon_color' );
	$mbicolor = ( !empty($mbicolor) ) ? $mbicolor : 'gray';
	
	function rbk_calculate_image_width_based_on_max_height( $filename, $max_height ) {
			if( !empty($filename) ){

				$attributes = getimagesize( $filename );
				$image_width = $attributes[0];
				$image_height = $attributes[1];	

				if( $image_width > $image_height ){
					return $image_width / $image_height * $max_height; 
				} else {
					return $image_height / $image_width * $max_height; 
				}
			}
	}
	$width = rbk_calculate_image_width_based_on_max_height( $logo, $max_height );

	?>
	<style type="text/css">
		@media only screen and ( max-width: <?php echo $breakpoint; ?> ) {
			body {
				padding-top: 60px;
			}
			#rbk-mobile-menu-bar {
				display: block !important;
				background-color: <?php echo $mbcolor; ?>!important;
			}
			<?php echo $header_to_replace; ?> {
				display: none !important;
			}
			#rbk-mobile-logo {
				display: block;
				background-image: url( <?php echo get_option('rbk_mobile_logo'); ?> );
				background-size: contain;
				background-position: center;
				height: <?php echo $max_height . 'px'; ?>;
				width: <?php echo $width . 'px'; ?>;
				background-repeat: no-repeat;
				background-position: center;
				margin-top: 7px;
				margin-left: 7px;
				position: absolute;
			}
			#rbk-open-menu span {
				background-color: <?php echo $mbicolor; ?>!important;
			}

		}
	</style>
	<div id="rbk-mobile-menu-bar" class="override">
	<a href="<?php echo $home_url; ?>" id="rbk-mobile-logo"></a>
	<div id="rbk-open-menu" class="rbk-icon override">
		<span></span>
		<span></span>
		<span></span>
	</div>
	<nav id="rbk-mobile-menu" class="override">
		<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	</nav>
	</div>


	<?php

}
add_action( 'wp_footer', 'rbk_append_menu' );

?>