<?php
/**
 * Plugin Name: Change Add to Cart Button Text WC 
 * Description: From ths plugin help you to Change woocomerce Add to cart button text.
 * Version: 1.1.1
 * Author: Dipen Desai
 * Text Domain: CATCBTW
 */

defined( 'ABSPATH' ) || exit;


add_action('admin_menu', 'CATCBTW_admin_menu_settings');

function CATCBTW_admin_menu_settings() {

	//create new top-level menu
	add_menu_page('CATCBTW Settings', 'CATCBTW Settings', 'administrator','CATCBTW-setting', 'CATCBTW_settings_page' ,'' );
	//call register settings function
	add_action( 'admin_init', 'register_CATCBTW_settings' );
	
    
}

function register_CATCBTW_settings() {
	//register our settings
	register_setting( 'CATCBTW-settings-group', 'addtocart_btn_text_simple' );
	register_setting( 'CATCBTW-settings-group', 'addtocart_btn_text_variable' );
	register_setting( 'CATCBTW-settings-group', 'addtocart_btn_text_external' );
	register_setting( 'CATCBTW-settings-group', 'addtocart_btn_text_grouped' );
	
	
}

function CATCBTW_settings_page() {
?>
<div class="wrap">
<h1>Change Woocomerce Add to cart button text Settings</h1>
<form method="post" action="options.php" enctype="multipart/form-data">
    <?php settings_fields( 'CATCBTW-settings-group' ); ?>
    <?php do_settings_sections( 'CATCBTW-settings-group' ); ?>
    <div id="header_sec_1" style="">
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><?php echo __( 'Add To Cart Button Text For Simple Product', 'CATCBTW' ) ?> </th>
            <td><input type="text" name="addtocart_btn_text_simple" value="<?php echo esc_attr( get_option('addtocart_btn_text_simple') ); ?>" /></td>
        </tr>
		<tr valign="top">
            <th scope="row"><?php echo __( 'Add To Cart Button Text Variable Product', 'CATCBTW' ) ?> </th>
            <td><input type="text" name="addtocart_btn_text_variable" value="<?php echo esc_attr( get_option('addtocart_btn_text_variable') ); ?>" /></td>
        </tr>
		<tr valign="top">
            <th scope="row"><?php echo __( 'Add To Cart Button Text External Product', 'CATCBTW' ) ?> </th>
            <td><input type="text" name="addtocart_btn_text_external" value="<?php echo esc_attr( get_option('addtocart_btn_text_external') ); ?>" /></td>
        </tr>
		<tr valign="top">
            <th scope="row"><?php echo __( 'Add To Cart Button Text Grouped Product', 'CATCBTW' ) ?> </th>
            <td><input type="text" name="addtocart_btn_text_grouped" value="<?php echo esc_attr( get_option('addtocart_btn_text_grouped') ); ?>" /></td>
        </tr>
    </table>
    </div>
    
    <?php submit_button(); ?>
</form>
</div>

<?php } 
add_filter( 'woocommerce_booking_single_add_to_cart_text', 'CATCBTW_WC_product_add_to_cart_text' ,10,2);
add_filter( 'woocommerce_loop_add_to_cart_link' , 'CATCBTW_WC_product_add_to_cart_text'  ,10,2);
add_filter( 'woocommerce_product_single_add_to_cart_text', 'CATCBTW_WC_product_add_to_cart_text'  ,10,2);


function CATCBTW_WC_product_add_to_cart_text( $var, $instance) {
	global $product;
	$options_simple =get_option('addtocart_btn_text_simple');
	$options_variable =get_option('addtocart_btn_text_variable');
	$options_external =get_option('addtocart_btn_text_external');
	$options_grouped =get_option('addtocart_btn_text_grouped');
	
	$product_type = $product->product_type;

	if (is_product ()) {
		if( $product_type == "external" && $options_external != ""){
			echo __( $options_external , 'CATCBTW' );
		}
		elseif( $product_type == "simple" && $options_simple != ""){
			echo __( $options_simple , 'CATCBTW' );
			
		}
		elseif( $product_type == "variable" && $options_variable != ""){
			echo __( $options_variable , 'CATCBTW' );
		}
		elseif( $product_type == "grouped" && $options_grouped != ""){
			echo __( $options_grouped , 'CATCBTW' );
		}
		
		else{
			return $var;
		}
		
		
	}
	else {
	
		if( $product_type == "external" && $options_external != "" ){
			return sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">'.__($options_external, 'CATCBTW').'</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $class ) ? $class : 'button' ),
			$product->add_to_cart_text()
			);
		}
		elseif( $product_type == "simple" && $options_simple != ""){
			
			return sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="button product_type_simple add_to_cart_button ajax_add_to_cart">'.__($options_simple, 'CATCBTW').'</a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                esc_attr( $product->get_id() ),
                esc_attr( $product->get_sku() ),
                esc_attr( isset( $class ) ? $class : 'button' ),
                $product->add_to_cart_text()
                );
			
		}
		elseif( $product_type == "variable" && $options_variable != ""){			
			return sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">'.__($options_variable, 'CATCBTW').'</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $class ) ? $class : 'button' ),
			$product->add_to_cart_text()
			);
			//return $var ="Select";
		}
		elseif( $product_type == "grouped" && $options_grouped != ""){
			
			return sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="button product_type_simple add_to_cart_button ajax_add_to_cart">'.__($options_grouped, 'CATCBTW').'</a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                esc_attr( $product->get_id() ),
                esc_attr( $product->get_sku() ),
                esc_attr( isset( $class ) ? $class : 'button' ),
                $product->add_to_cart_text()
                );
		}
		
		else{
			return $var;
		}
	
		
	}
	
}