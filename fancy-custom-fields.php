<?php
/**
* Plugin Name:       Fancy Custom Fields PRO 
* Plugin URI:        https://github.com/MaSchVam/Fancy-Custom-Fields
* Description:       This plugin adds much needed styling to Advanced Custom Fields PRO in the Gutenberg editor.
* Version:           0.2
* Requires at least: 5.2
* Author:            Brandinavian
* Author URI:        https://brandinavian.com/
* License:           MIT
* License URI:       https://opensource.org/licenses/MIT
* Text Domain:       fancy-custom-field-styles
* Domain Path:       /fancy-custom-field-styles
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
if(class_exists('ACF') && !is_plugin_active( 'advanced-custom-fields-pro/acf.php')){
function sample_admin_notice__error_no_pro() {
$class_no_pro = 'notice notice-error is-dismissible';
$message_no_pro = __( 'ACF Backend Styles unfortunately only works with ACF PRO, since the free version of ACF doesn\'t support options pages.', 'sample-text-domain' );
printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class_no_pro ), esc_html( $message_no_pro ) );
}
add_action( 'admin_notices', 'sample_admin_notice__error_no_pro' );
return; 
}elseif(class_exists('ACF')){
function sample_admin_notice__error() {
$class = 'notice notice-error is-dismissible';
$message = __( 'Advanced Custom Fields PRO is not activated. ACF Backend Styles will not be applied!', 'sample-text-domain' );
printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}
add_action( 'admin_notices', 'sample_admin_notice__error' );
return;
} else{
/**
* ACF Options Page 
*
*/
function be_acf_options_page() {
if ( ! function_exists( 'acf_add_options_page' ) )
return;
acf_add_options_page( array( 
'title'      => 'Fancy Fields',
'capability' => 'manage_options',
) );
}
add_action( 'init', 'be_acf_options_page' );

function register_fancy_fields() {
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5eacae520cc01',
	'title' => 'Fancy Field Options',
	'fields' => array(
		array(
			'key' => 'field_5eacae5aaf72a',
			'label' => 'Main area background color',
			'name' => 'main_area_background_color',
			'type' => 'color_picker',
			'instructions' => 'This is the solid background color for the main Custom Field area.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#35363a',
		),
		array(
			'key' => 'field_5eacaeacae7c6',
			'label' => 'Main area linear background gradient - Color 1',
			'name' => 'main_area_linear_background_gradient',
			'type' => 'color_picker',
			'instructions' => 'This is color #1 in the linear background gradient of the main area. Leave empty if using solid background color.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
		array(
			'key' => 'field_5eacaf1275a2a',
			'label' => 'Main area linear background gradient - Color 2',
			'name' => 'main_area_linear_background_gradient_2',
			'type' => 'color_picker',
			'instructions' => 'This is color #2 in the linear background gradient of the main area. Leave empty if using solid background color.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-fancy-fields',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));
endif;
}
add_action( 'init', 'register_fancy_fields' );

function my_acf_admin_head() {
?>
<style type="text/css">
  .edit-post-meta-boxes-area .postbox {
    margin-bottom: 3%!important;
    padding: 3%;
    border-radius: 10px;
    -webkit-box-shadow: 4px 12px 29px -6px rgba(0,0,0,0.18);
    -moz-box-shadow: 4px 12px 29px -6px rgba(0,0,0,0.18);
    box-shadow: 4px 12px 29px -6px rgba(0,0,0,0.18);
  }
  .edit-post-layout__metaboxes:not(:empty) {
    background-color:<?php the_field('main_area_background_color', 'option');
    ?>;
    background: linear-gradient(90deg, <?php the_field('main_area_linear_background_gradient', 'option');
      ?> 0%, <?php the_field('main_area_linear_background_gradient_2', 'option');
      ?>);
  }
  .edit-post-meta-boxes-area #poststuff h2.hndle {
    font-size: 200%;
    letter-spacing: 2px;
    font-weight:100;
  }
  #editor #normal-sortables {
    padding:8%!important;
  }
  .custom-title-admin {
    color: #fff;
    font-weight: 100;
    font-size: 300%;
    letter-spacing: 4px;
  }
  .custom-title-admin.push{
    margin-top: 7%;
  }
  img.brandimg {
    max-width: 203px;
    margin-left:auto;
    margin-right:auto;
    display: block;
  }
</style>
<?php
}
add_action('acf/input/admin_head', 'my_acf_admin_head');
//Add custom HTML boxes below block editor when editing post
function my_acf_admin_footer() {
?>
<script type="text/javascript">
  (function($){
    $( document ).ready(function() {
      $("<h1 class='custom-title-admin'>SEO Settings</h1>").insertBefore($(".metabox-location-normal #poststuff #normal-sortables #wpseo_meta"));
      $("<h1 class='custom-title-admin push'>Custom fields</h1>").insertBefore($(".metabox-location-normal #poststuff #normal-sortables .postbox.acf-postbox").eq(0));
    }
                       );
    $( document ).on('mousedown mouseup', function() {
      if($('.ui-sortable-helper').length > 0) {
        console.log("Boxes were deleted");
        $("h1").remove(".custom-title-admin");
        console.log("Boxes were added");
        setTimeout(function() {
          $("<h1 class='custom-title-admin'>SEO Settings</h1>").insertBefore($(".metabox-location-normal #poststuff #normal-sortables #wpseo_meta").eq(0));
          $("<h1 class='custom-title-admin push'>Custom fields</h1>").insertBefore($(".metabox-location-normal #poststuff #normal-sortables .postbox.acf-postbox").eq(0));
        }
                   , 100);
      }
      else if($('.ui-sortable-helper').length <= 0) {
      }
      else{
      }
    }
                    );
  }
  )(jQuery);
</script>
<?php
}
add_action('acf/input/admin_footer', 'my_acf_admin_footer');
}