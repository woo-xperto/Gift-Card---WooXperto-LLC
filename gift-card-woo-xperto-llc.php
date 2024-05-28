<?php 
/*
Plugin Name: Gift Card - WooXperto LLC
Requires Plugins: woocommerce
Plugin URI: http://wooxperto.com/plugins/gift-card-wooxperto-llc
Description: This plugin for every WordPress theme. Gift Card for WooCommerce is the fastest, fully customizable gift-card. # Designed, Developed, Maintained & Supported by wooXperto.
Version: 1.0.1
Author: wooXperto
Author URI: http://wooxperto.com
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Text Domain: gift-card-wooxperto-llc

*/
// prefix : wodgc WODGC | gift-card-wooxperto-llc

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if(!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){return;}

// Define Gift Card plugin 
define( 'WODGC_ACC_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
define( 'WODGC_ACC_PATH', plugin_dir_path( __FILE__ ) );

require_once( WODGC_ACC_PATH . 'backend/wc-advanced-type-field.php' );

require 'vendor/autoload.php';

// 
function wodgc_transaction_gift_card(){
  global $wpdb;
  $table_name = $wpdb->prefix.'wodgc_transaction'; // gift_card_number
  $sql = "CREATE TABLE {$table_name} (
      id BIGINT NOT NULL AUTO_INCREMENT,
      gift_card_no VARCHAR(250),
      amount BIGINT,
      current_balance BIGINT,
      t_date_time DATETIME,
      user_id BIGINT,
      note VARCHAR(250),
      approved_by VARCHAR(250),
      approved_at VARCHAR(250),
      uuid VARCHAR(250),
      t_type INT,
      ref_id VARCHAR(250),
      PRIMARY KEY (id)
  );";
  require_once (ABSPATH."wp-admin/includes/upgrade.php");
  dbDelta($sql);

}
register_activation_hook(__FILE__, "wodgc_transaction_gift_card");


// wp admin Dashboard Left side menu page
function wodgc_setting_fun(){
  ?>
  <div class="gift-card-setting-wrap">
    <form action="options.php" method="post">
      <?php wp_nonce_field('update-options'); ?>
      <table>
        <tr>
          <td>Disable edit card info in cart page</td>
          <td>
            <input type="checkbox" name="wodgc_disable_edit_card" value="false" <?php if( get_option('wodgc_disable_edit_card') == 'true'){ echo 'checked="checked"'; } ?> >
          </td>
        </tr>
        <tr>
          <td>Disable SMS Send</td>
          <td>
            <input type="checkbox" name="wodgc_disable_sms_send" value="false">
          </td>
        </tr>
        <tr>
          <td>SMS Send user id</td>
          <td>
            <input type="text" name="wodgc_sms_user_id" value="<?php echo get_option('wodgc_sms_user_id') ?>">
          </td>
        </tr>
        <tr>
          <td>SMS Send user password</td>
          <td>
            <input type="password" name="wodgc_sms_user_pass" value="<?php echo get_option('wodgc_sms_user_pass') ?>">
          </td>
        </tr>
        <tr>
          <td>SMS Body</td>
          <td>
            <textarea placeholder="{recipient_name}, þú varst að fá sent gjafakort frá Kringlan. Sendandi er {sender_name} með kveðjunni: {gift_card_message} Smelltu á hlekkinn til að bæta gjafakortinu í Wallet hjá þér: {pass_link}" id="txtid" name="wodgc_sms_body" rows="4" cols="30"></textarea>
          </td>
        </tr>
        <tr>
          <td>
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="page_options" value="wodgc_disable_edit_card, wodgc_disable_sms_send, wodgc_sms_user_id, wodgc_sms_user_pass, wodgc_sms_body">
              <input type="submit" name="submit" value="<?php _e('Save Changes', 'gift-card-wooxperto-llc') ?>">
          </td>
        </tr>
      </table>
    </form>
  </div>
  <?php
}

// Registering Gift Card files 
add_action('wp_enqueue_scripts', 'wodgc_fontend_assets');
function wodgc_fontend_assets() {

  wp_enqueue_style('jquery-uri-accordion-css', plugin_dir_url(__FILE__) . 'frontend/assets/css/jquery-ui.css');
  wp_enqueue_style('datetimepicker-css', plugin_dir_url(__FILE__) . 'frontend/assets/css/dateTime.css');
  wp_enqueue_style('gift-card-wooxperto-llc', plugin_dir_url(__FILE__) . 'frontend/assets/css/style.css');

  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-datepicker'); 

  wp_enqueue_script('wc_product_type_accounting_js_script', plugin_dir_url(__FILE__ ) . 'frontend/assets/js/accounting.min.js');
  wp_enqueue_script('wc_product_type_custom_script', plugin_dir_url(__FILE__ ) . 'frontend/assets/js/js.js', array('jquery','jquery-ui-accordion','jquery-ui-datepicker'));
  wp_enqueue_script('datetimepicker_script', plugin_dir_url(__FILE__ ) . 'frontend/assets/js/jquery.datetimepicker.full.js', array('jquery')); // , '1.0.0', true
  wp_enqueue_script('crop_js_script', plugin_dir_url(__FILE__ ) . 'frontend/assets/js/crop.min.js', array('jquery'), true);


  global $post, $wp;
  if($post){
    $pageId = $post->ID;
  }else{
    $pageId = 0;
  }
  // $pageId = $post->ID ? $post->ID : 999999;

  $meta_data = get_post_meta( $pageId, 'gift_card_form', true );
	$fromData  = $meta_data ? $meta_data : '[]';

  if( is_wc_endpoint_url( 'order-received' )){
    $order_id = absint( $wp->query_vars['order-received'] );
    $order  = wc_get_order($order_id);

    $total_payment_before = get_post_meta($order_id, 'total_payment', true );
    $productAmount = $order->get_total();

    if($total_payment_before){
        $totalP = $productAmount - $total_payment_before; 
    }else {
        $totalP = $order->get_total();
    }

  }else{
    $order_id = '';
    $totalP   = '';
  }
  
  wp_localize_script('wc_product_type_custom_script', 'gcAjax', array(
      'ajaxurl'=> admin_url('admin-ajax.php'),
      'thankOrderId'=> $order_id,
      'thankTotalPrice'=> $totalP,
      'infoFrom'=> $fromData,
      'cartUrl'=> wc_get_cart_url(),
      'localStVal' => 'myUploadCropImages' . $pageId
  ));


}

add_action('admin_enqueue_scripts', 'wodgc_backend_assets');
function wodgc_backend_assets() {
  wp_enqueue_style('select2', plugin_dir_url(__FILE__) . 'backend/assets/css/select2.min.css');
  wp_enqueue_style('gift-card-wooxperto-llc', plugin_dir_url(__FILE__) . 'backend/assets/css/gift_card_backend_style.css');

  // Ensure jQuery is enqueued first
  wp_enqueue_script('jquery'); 
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-datepicker');

  wp_enqueue_script('select2', plugin_dir_url(__FILE__) . 'backend/assets/js/select2.min.js', array('jquery'), '4.0.13', true );
  // wp_enqueue_script('jquery-ui', plugin_dir_url(__FILE__) . 'backend/assets/js/jquery-ui.js', array('jquery'), '4.0.13', true );
  wp_enqueue_script('wp_admin_script', plugin_dir_url(__FILE__ ) . 'backend/assets/js/wp_admin.js', array('jquery','jquery-ui-core', 'jquery-ui-datepicker'), '5.0.55', true );


  wp_localize_script('wp_admin_script', 'wodgcBkAjax', array(
    'url'=> admin_url('admin-ajax.php'),
    'cartUrl'=> wc_get_cart_url()
  ));

}


class WODGC_Product_Type_Plugin {
  /**
   * Build the instance
   */
  public function __construct() {
    add_action( 'woocommerce_loaded', array( $this, 'load_plugin' ) );
    add_filter( 'product_type_selector', array( $this, 'add_type' ) );
    // register_activation_hook( __FILE__, array( $this, 'install' ) );
    add_action( 'woocommerce_product_options_general_product_data', array($this,'enable_js_on_wc_product') );

    // Adding Product Type tab and panel
    add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_tab' ), 50 );
    // add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_tab_content' ) );

    add_action( 'woocommerce_process_product_meta_advanced', array( $this, 'save_advanced_settings' ) ); // Save WooCommerce Advance Product Type

    add_action( "woocommerce_advanced_add_to_cart", function() {
      do_action( 'woocommerce_simple_add_to_cart' );
    });
  }
 
  /**
   * Load WC Dependencies
   *
   * @return void
   */
  public function load_plugin() {
    require_once 'backend/class-wc-product-advanced.php';
  }

  /**
   * Advanced Type
   *
   * @param array $types
   * @return void
   */
  public function add_type( $types ) {
    $types['advanced'] = __( 'Gift Card Type', 'gift-card-wooxperto-llc' );
    
    return $types;
  }


  /**
   * Installing on activation
   *
   * @return void
   */
  // Showing Regular pricing Options for a custom WooCommerce Product Type | hide shipping tabs
  public function enable_js_on_wc_product() {
    global $product_object;
    
    wc_enqueue_js( "
       jQuery('select#product-type').change(function(){
          let ptype = jQuery(this).val();
          if(ptype=='advanced'){
              jQuery('.product_data_tabs .general_options').show();
              jQuery('.product_data_tabs .inventory_tab').show();
              jQuery('.product_data_tabs li.active').removeClass('active');
              jQuery('.product_data_tabs .advanced_type_tab').addClass('active');
              jQuery('div.panel').hide();
              jQuery('div.panel.woocommerce_options_panel').hide();
              jQuery('.pricing').show();
              jQuery('#advanced_type_product_options').show();
              jQuery('.product_data_tabs .inventory_tab').addClass('hide_if_advanced').hide();
              jQuery('.product_data_tabs .shipping_tab').addClass('hide_if_advanced').hide();
              jQuery('.product-data-wrapper .tips').show();
          }else{
              jQuery('.product_data_tabs .inventory_tab').removeClass('hide_if_advanced').show();
              jQuery('.product_data_tabs .shipping_tab').removeClass('hide_if_advanced').show();
          }
       });
    ");
    
    global $product_object;
    if ( $product_object && 'advanced' === $product_object->get_type() ) {
      wc_enqueue_js("
          jQuery('.product_data_tabs .general_options').show();
          jQuery('.product_data_tabs .inventory_tab').show();
          jQuery('.product_data_tabs li.active').removeClass('active');
          jQuery('.product_data_tabs .advanced_type_tab').addClass('active');
          jQuery('div.panel').hide();
          jQuery('div.panel.woocommerce_options_panel').hide();
          jQuery('.pricing').show();
          jQuery('#advanced_type_product_options').show();
          jQuery('.product_data_tabs .inventory_tab').addClass('hide_if_advanced').hide();
          jQuery('.product_data_tabs .shipping_tab').addClass('hide_if_advanced').hide();
          jQuery('.product-data-wrapper .tips').show();
      ");
    }

  }


  // Adding Product Type tab and panel Start
   
    /**
     * Adding Product Type tab and panel Start.
     *
     * @param array $tabs
     *
     * @return mixed
     */
    public function add_product_tab( $tabs ) {

    $tabs['advanced_type'] = array(
      'label'    => __( 'Gift Card', 'gift-card-wooxperto-llc' ),
      'target' => 'advanced_type_product_options',
      'class'  => 'show_if_advanced',
    );
    $tabs['attribute']['class'][] = 'hide_if_attribute';
      return $tabs;
    }
    
    

  // Adding Product Type tab and panel The End
 
  /**
   * @param $post_id
   */
  public function save_advanced_settings( $post_id ) {
    
    $giftCart = isset( $_POST['_gift_cart'] ) ? sanitize_text_field( $_POST['_gift_cart'] ) : '';

    // update_post_meta( $post_id, '_member_price', $price );
    update_post_meta( $post_id, '_gift_cart', $giftCart );
  }


}
new WODGC_Product_Type_Plugin();

// gift-card-single-product-content page template part used by WooCommerce.
add_filter( 'wc_get_template_part', 'wodgc_single_product_page_wc_template_part', 10, 3 );

function wodgc_single_product_page_wc_template_part( $template, $slug, $name ) {
    
    $product = wc_get_product( get_the_ID() );

    $is_gift = $product->get_type();

  if ( 'content' === $slug && 'single-product' === $name  && $is_gift === 'advanced' ) {

    // Remove default "Sale!" label
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
    
    $template = dirname(__FILE__) . '/frontend/gift-card-single-product-content.php';

  }

  return $template;
}



// test add to cart
function wodgc_is_session_started() {
  if (php_sapi_name() !=='cli') {
      if (version_compare(phpversion(), '5.4.0', '>=')) {
          return session_status()===PHP_SESSION_ACTIVE ? TRUE: FALSE;
      }

      else {
          return session_id()===''? FALSE: TRUE;
      }
  }

  return FALSE;
}


add_action("wp_ajax_wodgc_add_to_cart", "wodgc_add_to_cart");
add_action("wp_ajax_nopriv_wodgc_add_to_cart", "wodgc_add_to_cart");

function wodgc_add_to_cart() {
  
  //check error end
  for($i=0; $i<count($_POST['product_id']); $i++) {
    if($i>0) sleep(1);

    $product_id         = sanitize_text_field($_POST['product_id'][$i]);
    $gift_card_image    = $_POST['gift_card_image'][$i];
    $gift_card_amount   = sanitize_text_field($_POST['gift_card_amount'][$i]);
    $gift_card_info_form= sanitize_text_field($_POST['gift_card_info_form'][$i]);
    $unique_cart_item_key = md5(microtime() . rand());

    $gift_card_item_add_to_cart_meta=array(
      'gift_card_image' => $gift_card_image,
      'gift_card_amount'=> $gift_card_amount,
      'gift_card_info_form'=> $gift_card_info_form,
      'unique_key' => $unique_cart_item_key
    );

    if ( wodgc_is_session_started()===FALSE ) session_start();

    $_SESSION['lb_wodgc_add_to_cart_'.$product_id] = $gift_card_item_add_to_cart_meta;
    // WC()->cart->add_to_cart($product_id);
    WC()->cart->add_to_cart( $product_id,1,0,array(),$gift_card_item_add_to_cart_meta);

    // echo $product_id." Test here ".$gift_card_item_add_to_cart_meta;
  }

  $response['type']='success';
  $response['successMessages']='Gift Cards added to cart successfully';
  echo json_encode($response);
  exit;

}


add_filter('body_class', 'wodgc_add_body_class');
function wodgc_add_body_class($classes) {
    if (is_shop() || is_product_category() || is_cart() || is_checkout() || is_product()) {
        $classes[]='wodgc_gift_card';
    }

    return $classes;
}

// pdf make
add_action('init', function() {
  //echo get_option('gift_to_wallet_token');
  if(isset($_GET["gift-card-pdf"]) && isset($_GET["gcpdf"])) {
    if($_GET["gift-card-pdf"]=='true'&& !empty($_GET["gcpdf"]) && base64_decode($_GET["gcpdf"])>0) {
      $orderLineItemId = base64_decode($_GET["gcpdf"]);
      $productId = $_GET["id"];
      $link = 'aaa';
      //$output=true;
      include('gift-card-pdf.php');
    }
  }
});


// show pdf download link in order success page
add_action('woocommerce_order_item_meta_end', 'wodgc_item_pdf_download_link', 10, 3);
function wodgc_item_pdf_download_link($item_id, $item, $order) {

  $productId = $item->get_product_id();
  $product   = wc_get_product( $productId );
  $is_gift   = $product->get_type();

  if($is_gift=='advanced') {
    echo'<a style="clear:both;display:block;" target="_blank" href="'.site_url().'?gift-card-pdf=true&gcpdf='.base64_encode($item_id).'&id='.$productId.'" class="gift-card-pdf-download-link home-back">Download a gift card</a>';
  }

}

// show pdf download in admin order page
add_action('woocommerce_after_order_itemmeta', 'wodgc_admin_item_pdf_download_link', 10, 3);
function wodgc_admin_item_pdf_download_link($item_id, $item, $product) {

  if(!is_null($product)){
    $product_id = $item->get_product_id();
    $is_gift    = $product->get_type();
    if($is_gift=='advanced') {
      echo'<a style="clear:both;display:block;" target="_blank" href="'.site_url().'?gift-card-pdf=true&gcpdf='.base64_encode($item_id).'&id='.$productId.'" class="gift-card-pdf-download-link home-back">Download a gift card</a>';
    }
  }

}

// 8 digit unique id
function wodgc_generate_unique_id() {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $idGiftCard = '';
  for ($i = 0; $i < 8; $i++) {
    $idGiftCard .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $idGiftCard;
}



// add from Short code
add_shortcode('gift-card-check-info','wodgc_check_info_fun');
function wodgc_check_info_fun($jekono){ 
  $result = shortcode_atts(array( 
    'title' =>'',
  ),$jekono);
  extract($result);
  ob_start();
  ?>
  <!-- Start html code here  -->
  <div class="gift-card-from-wrap">
    <div class="gift-info-left">
      <h4>Gift card check info here</h4>
      <form action="#">
        <label for="gift-card-no"><?php echo $title; ?>:</label><br>
        <input type="text" id="gift-card-no" name="gift-card-no" placeholder="Enter gift card number">
        <br>
        <!-- <input type="submit" value="Submit"> -->
        <p id="wodgc_giftCardInfo_sms"></p>
        <button type="button" onclick='wodgc_giftCardInfo()'>Submit</button>
      </form> 
    </div>
    <div class="gift-info-right">
      <h4>Show gift card information here.</h4>
      <div id="information_gift_cardard"></div>
    </div>
  </div>
  <!-- End html code here  -->
  <?php
  return ob_get_clean();
}

// upload image in localStorage 
add_action('wp_footer', 'wodgc_my_upload_image_in_localstorage');
function wodgc_my_upload_image_in_localstorage() {
  global $post;
  $pid=$post->ID;

  ?>
  <div class=""id="imageModalContainer" style="display:none;">
    <div class="crop-container-bg closeCrop"></div>
    <div class="modal-crop-img-wrap">
      <div class="crop-header">
        <h5 class="crop-title">Crop Image</h5>
        <button type="button"class="crop-btn-close closeCrop closeEdit">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="crop-body">
        <div id='crop-image-container'></div>
      </div>
      <div class="crop-footer">
        <button type="button"class="crop-btn closeCrop cancelEdit">cancelUpload</button>
        <button type="button"class="crop-btn save-modal">Save</button>
      </div>
    </div>
  </div>
  
  <?php
}



function wodgc_my_upload_image_save($base64_img, $title) {

    // Upload dir.
    $upload_dir      = wp_upload_dir();
    $upload_path     = str_replace('/', DIRECTORY_SEPARATOR, $upload_dir['path']) . DIRECTORY_SEPARATOR;

    $img             = str_replace('data:image/jpeg;base64,', '', $base64_img);
    $img             = str_replace(' ', '+', $img);
    $decoded         = base64_decode($img);
    $filename        = $title . '.jpeg';
    $file_type       = 'image/jpeg';
    $hashed_filename = md5($filename . microtime()) . '_'. $filename;

    // Save the image in the uploads directory.
    $upload_file     = file_put_contents($upload_path . $hashed_filename, $decoded);

    $attachment=array(
        'post_mime_type'=> $file_type,
        'post_title'    => preg_replace('/\.[^.]+$/', '', basename($hashed_filename)),
        'post_content'  => '',
        'post_status'   => 'inherit',
        'guid'          => $upload_dir['url'] . '/'. basename($hashed_filename)
    );

    $attach_id = wp_insert_attachment($attachment, $upload_dir['path'] . '/'. $hashed_filename);

    // Update the post meta value
    update_post_meta( $attach_id, 'gift_card_processing', true ); // false

    

    return wp_get_attachment_image_url($attach_id,'full');
}


// ajax process & file upload to wp_media
function wodgc_img_upload_wp_media() {


    $image  = $_POST["image"]; // UploadFile
    $title  = time();
    $imgUrl = wodgc_my_upload_image_save($image, $title); // upload_users_file($image); 

    // echo $imgUrl;
    wp_send_json_success($imgUrl);

exit();
}

add_action('wp_ajax_wodgc_img_upload_wp_media', 'wodgc_img_upload_wp_media');
add_action('wp_ajax_nopriv_wodgc_img_upload_wp_media', 'wodgc_img_upload_wp_media');



// ajax process show gift card info.
function wodgc_gift_card_info() {

  $post_title = sanitize_text_field($_POST['card_no']);
  $post = get_page_by_title( $post_title, OBJECT, "gift-card-number" );

  if($post){
      $post_id = $post->ID;
      $post_content = get_post_field( 'post_content', $post_id );
      $data = json_decode($post_content,true);

      $sms = 'Look gift card info. on the right side';
      echo json_encode(['status'=>'ok', 'message' => $sms, 'data' => $data ]);
  }else{
    $data = 'Gift Card not found.';
    $sms = 'The gift card is not found in your given number';
    echo json_encode(['status'=>'notok', 'message' => $sms, 'data' => $data ]);
  }

  exit(); // wp_die();
}

add_action('wp_ajax_wodgc_gift_card_info', 'wodgc_gift_card_info');
add_action('wp_ajax_nopriv_wodgc_gift_card_info', 'wodgc_gift_card_info');


// Coupon generate
function wodgc_generate_coupon($productId,$couponCode,$amount,$expiryDate){
  
  $discountType = get_post_meta( $productId, 'wodgc_discount_type', true );
  $freeShipping = get_post_meta( $productId, 'wodgc_free_shipping', true );
  $individualUse= get_post_meta( $productId, 'wodgc_individual_use', true );
  $eSItems      = get_post_meta( $productId, 'wodgc_exclude_sale_items', true );

  $cProductIds  = get_post_meta( $productId, 'wodgc_c_product_ids', true );
  $cExProductIds= get_post_meta( $productId, 'wodgc_c_ex_product_ids', true );
  $cProCatIds   = get_post_meta( $productId, 'wodgc_c_product_cat_ids', true );
  $cProExCatIds = get_post_meta( $productId, 'wodgc_c_product_ex_cat_ids', true );
  $allowedEmail = get_post_meta( $productId, 'wodgc_c_allowed_emails', true );

  $usagePerCoup = get_post_meta( $productId, 'wodgc_usage_per_coupon', true );
  $usagePerUser = get_post_meta( $productId, 'wodgc_usage_per_user', true );
  
  $minimumSpend = get_post_meta( $productId, 'wodgc_minimum_spend', true );
  $maximumSpend = get_post_meta( $productId, 'wodgc_maximum_spend', true );


    $coupon = new WC_Coupon();

    $coupon->set_code($couponCode);

    // $coupon->set_description( 'Some coupon description.' );

    // General tab

    // discount type can be 'fixed_cart', 'percent' or 'fixed_product', defaults to 'fixed_cart'
    $coupon->set_discount_type($discountType);

    // discount amount
    $coupon->set_amount($amount); // $amount

    // allow free shipping
    $coupon->set_free_shipping($freeShipping); // true | false

    // coupon expiry date
    $coupon->set_date_expires($expiryDate); // '31-12-2022' 

    // Usage Restriction

    // minimum spend
    $coupon->set_minimum_amount($minimumSpend);

    // maximum spend
    $coupon->set_maximum_amount($maximumSpend);

    // individual use only
    $coupon->set_individual_use($individualUse); // true | false

    // exclude sale items
    $coupon->set_exclude_sale_items($eSItems); // true | false

    // products
    $coupon->set_product_ids( $cProductIds ); // 2,4,9,10 array($cProductIds)

    // exclude products
    $coupon->set_excluded_product_ids( $cExProductIds ); // array($cExProductIds) 

    // categories
    $coupon->set_product_categories( $cProCatIds ); // array($cProCatIds) 

    // exclude categories
    $coupon->set_excluded_product_categories( $cProExCatIds ); // array($cProExCatIds) 

    // allowed emails
    $coupon->set_email_restrictions( 
      array($allowedEmail)
    );


    // Usage limit tab

    // usage limit per coupon
    $coupon->set_usage_limit($usagePerCoup);

    // limit usage to X items
    // $coupon->set_limit_usage_to_x_items( 10 );
      
    // usage limit per user
    $coupon->set_usage_limit_per_user($usagePerUser);
    $coupon->save();
  /*
    $couponId = $coupon->get_id();
    // Save extra coupon meta
    $gift_card_coupon = true;
    update_post_meta($couponId, 'gift_card_coupon', $gift_card_coupon);
  */
  
}

function wodgcSenderReceiverFields($productId){

  $meta_data    = get_post_meta( $productId, 'gift_card_form', true );
  $form_element = json_decode($meta_data, true);

  $formHtml = '';
  if (count($form_element) > 0) {
      $i=0;

      $sender_receiver = [];
      foreach ($form_element as $field) {
          if (isset($field['sr']) && $field['sr'] !== '') {
              $sender_receiver[$field['sr']] = $field['id'];
          }
      }

      return $sender_receiver;
      $i++;
  }
}


