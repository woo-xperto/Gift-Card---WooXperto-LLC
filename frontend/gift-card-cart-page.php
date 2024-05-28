<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// wodgc_add_item_data
add_filter('woocommerce_add_cart_item_data', 'wodgc_add_item_data', 1, 2);
if( !function_exists('wodgc_add_item_data')) {
    function wodgc_add_item_data($cart_item_data, $product_id) {
        $unique_cart_item_key=md5(microtime().rand());
        $cart_item_data['unique_key']=$unique_cart_item_key;

        /*Here, We are adding item in WooCommerce session with, gift_card_custom_val name*/
        global $woocommerce;
        $option='';
        if (wodgc_is_session_started()===FALSE) session_start();

        if (isset($_SESSION['lb_wodgc_add_to_cart_'.$product_id])) {
            $option=$_SESSION['lb_wodgc_add_to_cart_'.$product_id];
            unset($_SESSION['lb_wodgc_add_to_cart_'.$product_id]);
            $new_value=array('gift_card_custom_val'=> $option);
        }

        if(empty($option)) {
            return $cart_item_data;
        }
        else {
            if(empty($cart_item_data)) {
                return $new_value;
            } else {
                return array_merge($cart_item_data, $new_value);
            }
        }

        //Unset our custom session variable, as it is no longer needed.

    }
}




add_filter('woocommerce_get_cart_item_from_session', 'wodgc_get_cart_items_from_session', 1, 3);
if( !function_exists('wodgc_get_cart_items_from_session')) {
    function wodgc_get_cart_items_from_session($item, $values, $key) {
        if (array_key_exists('gift_card_custom_val', $values)) {
            $item['gift_card_custom_val']=$values['gift_card_custom_val'];
        }

        return $item;
    }
}


// info. form data show in Cart page 
add_filter('woocommerce_checkout_cart_item_quantity', 'wodgc_add_user_custom_option_from_session_into_cart', 1, 3);
add_filter('woocommerce_cart_item_price', 'wodgc_add_user_custom_option_from_session_into_cart', 1, 3);
if( !function_exists('wodgc_add_user_custom_option_from_session_into_cart')) {
    function wodgc_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key) {
        if(isset($values['gift_card_custom_val'])) {

            $infoData = str_replace("\\","", $values['gift_card_custom_val']['gift_card_info_form']);
            $infoForm = json_decode($infoData, true);

            // $product = wc_get_product( 64 );
            // echo $product->get_type();
            
            /*code to add custom data on Cart & checkout Page*/
            if(count($values['gift_card_custom_val']) > 0) {
                $return_string=$product_name;
                $return_string .="<table class='gift_card_options_table giftCardWallet' id='". $values['product_id'] . "'>";

                $newArray = [];
                // print_r($infoForm);
                foreach ($infoForm as $item) {
                    // $nameKey = ucfirst($item['nameKey']);
                    $nameKey = $item['nameLabel'];
                    $nameVal = $item['nameVal'];

                    $newArray[$item['nameKey']]=$nameVal;
                    if($nameVal !=""){
                        $return_string .="<tr><td>".$nameKey.": ".$nameVal."</td></tr>";
                    }
                }                
                $return_string .="</table>";

                // $cart = WC()->cart;
                // $cart_item = $cart->get_cart_item($cart_item_key);
                // $product_id = $cart_item['product_id'];
                $productId = $values['product_id'];
                $eGiftCard = get_post_meta( $productId, 'wodgc_disable_edit_card', true );
                if( is_cart() && $eGiftCard==='true'){
                    $return_string .="<button type='button' class='Click-here' onclick='wodgc_cart_page_popup_open_action(\"".$cart_item_key."\")'> Edit Card info btn</button>";
                
                    $return_string .='
                    <!-- Add Popup section Start Now -->
                    <div class="popup-wrap">

                        <div class="popup-model-main" id="wodgc_'.$cart_item_key.'">
                            <div class="popup-model-inner">
                                <div class="close-btn">×</div>
                                <div class="popup-model-wrap">
                                    <div class="pop-up-content-wrap cart-page-edit-info">';

                                    $meta_data = get_post_meta( $productId, 'gift_card_form', true );
                                    $metaData  = $meta_data ? $meta_data : '[]';

                                    // echo 'tAnViR = '.$metaData;
                                    $form_element = json_decode($metaData, true);

                                    if (count($form_element) > 0) {
                                        foreach ($form_element as $element) {
                                            $val=(isset($newArray[$element['id']])?$newArray[$element['id']]:'');

                                            if(isset($element['sr'])){
                                                $sendDateTime = ($element['sr'] === "send-date-time") ? "srDate" : "";
                                            } else {
                                                $sendDateTime = "";
                                            }
                                            // $sendDateTime = ($element['sr'] === "send-date-time") ? "srDate" : "";

                                            $requerd 	= ($element['is_required'] === "on") ? "required" : "";
                                            $requerFlag = ($element['is_required'] === "on") ? '<b class="required">*</b>' : ""; // '.$requerFlag.'

                                            if($element['element']==='input'){
                                                $return_string .= '
                                                <div class="form-element">
                                                    <h5 for="' . $element['id'] . '">'.$element['label'].': '.$requerFlag.'</h5>
                                                    <input value="'.$val.'" type="'.$element['type'].'" name="'.$element['id'].'" placeholder="'. $element['placeholder'].'" '.$requerd.' class="'.$sendDateTime.'" >
                                                </div>';
                                            } 
                                            elseif ($element['element']==='textarea'){
                                                $return_string .= '
                                                <div class="form-element">
                                                    <h5 for="'.$element['id'].'">'.$element['label'].':</h5>
                                                    <textarea name="'.$element['id'].'" rows="4" >'.$val.'</textarea>
                                                </div>';
                                            }
                                            elseif ($element['element']==='select'){ // required="'.$element['is_required'].'" 
                                                $return_string .= '
                                                <div class="form-element">
                                                    <h5 for="'.$element['id'].'">'.$element['label'].':</h5>
                                                    <select name="'.$element['id'].'" placeholder="'.$element['placeholder'].'" >';

                                                        foreach($element['options'] as $opt) { 
                                                            $return_string .= '<option value="'.$opt.'" '.($val===$opt?'selected':'').'>'.$opt.'</option>';
                                                        }
                                                    $return_string .= '
                                                    </select>
                                                </div>';
                                            }
                                            


                                        }

                                    } else {
                                        $return_string .= 'Form Not Created.';
                                    }





                                    $return_string .='
                                    
                                        <div class="update-btn form-element">

                                            <div id="sms"></div>

                                            <button type="button" class="cancel-btn" >Cancel edit</button>
                                            <button type="button" class="wodgc_cart_popup_update_btn" onclick="wodgc_cart_popup_update_btn(\''.$cart_item_key.'\',this)" data-form=\''.$metaData.'\'>Update info.</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="bg-overlay"></div>
                        </div>

                    </div>
                    <!-- Popup section The end -->';
                }

                return $return_string;
            }

            else {
                return $product_name;
            }
        }

        else {
            return $product_name;
        }
    }
}

// modify cart item image
add_filter('woocommerce_cart_item_thumbnail', 'wodgc_custom_field_modify_cart_item_thumbnail', 99, 3); //$_product->get_image(), $cart_item, $cart_item_key );
function wodgc_custom_field_modify_cart_item_thumbnail($product_image, $cart_item, $cart_item_key) {

    if(isset($cart_item["gift_card_custom_val"])) {
        $product_image='<img src="'.$cart_item["gift_card_custom_val"]["gift_card_image"].'" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" width="300" height="300">';
    }

    return $product_image;
}


add_action('woocommerce_before_cart_item_quantity_zero', 'wodgc_remove_user_custom_data_options_from_cart', 1, 1);
if( !function_exists('wodgc_remove_user_custom_data_options_from_cart')) {
    function wodgc_remove_user_custom_data_options_from_cart($cart_item_key) {
        global $woocommerce;
        // Get cart
        $cart=$woocommerce->cart->get_cart();

        // For each item in cart, if item is upsell of deleted product, delete it
        foreach($cart as $key=> $values) {
            if ($values['gift_card_custom_val']==$cart_item_key) unset($woocommerce->cart->cart_contents[ $key]);
        }
    }
}


// set custom price to cart
add_filter('woocommerce_cart_contents_changed', function($cart_contents) {
        $new_contents=[];

        foreach ($cart_contents as $k=> $cart_item) {
            if(isset($cart_item["gift_card_custom_val"])) {
                $price=$cart_item["gift_card_custom_val"]["gift_card_amount"];
                $cart_item['data']->set_price($price);
            }
            $new_contents[$k]=$cart_item;
        }

        return array_merge($cart_contents, $new_contents);
    }, 30, 1
);



// Remove Qty in cart page 
add_filter('woocommerce_is_sold_individually', 'wodgc_custom_remove_all_quantity_fields', 10, 2);
function wodgc_custom_remove_all_quantity_fields($return, $product) {

    $id=$product->get_id();

    $is_gift=$product->get_type();
    // $is_gift=get_post_meta($id, '_gift_card', true);

    if($is_gift=='advanced') {
        return true;
    } else {
        return $return;
    }

}


// gift card info form data save to order item meta
add_action('woocommerce_add_order_item_meta', 'wodgc_add_values_to_order_item_meta', 1, 2);
if( !function_exists('wodgc_add_values_to_order_item_meta')) {
    function wodgc_add_values_to_order_item_meta($item_id, $values) {
        global $woocommerce, $wpdb;

        $user_custom_values=$values['gift_card_custom_val']; // gift_card_custom_val || wodgc_user_custom_data_value

        if(!empty($user_custom_values)){

            $item 		   = new WC_Order_Item_Product($item_id);
            $product_id    = $item->get_product_id();
            $current_date  = strtotime(date('d-m-Y'));
            $expiryDateType= get_post_meta( $product_id, 'gift_card_expiry_date_type', true );
            // $expiryDate = $expiryDateNumber.' '.$expiryDateType ;	
            $dateNumber    = get_post_meta( $product_id, 'gift_card_expiry_date', true );
            $expiryDate    = $dateNumber ? $dateNumber : 1;

            $gtwExpiryDate = '+'.$expiryDate.' '.$expiryDateType; //years
            $expiry_date   = date('d-m-Y', strtotime($gtwExpiryDate, $current_date));
        
            wc_add_order_item_meta($item_id, 'gift_card_date_expiry', $expiry_date);

            $epgi       = get_post_meta( $product_id, 'gift_card_number_show', true );
            $pdfStyle   = get_post_meta( $product_id, 'gift_card_pdf', true );
            $emailStyle = get_post_meta( $product_id, 'gift_card_email', true );

            $sendReciveInfo = wodgcSenderReceiverFields($product_id);
            $modifiedSendReciveInfo = array_flip($sendReciveInfo);

            // $stripslashes = str_replace("\\","", $values['gift_card_custom_val']['gift_card_info_form']);
            $stripslashes = stripslashes($user_custom_values['gift_card_info_form']);
            $infoForm = json_decode($stripslashes, true);

            $infoFormkey = [];
            $senderReceiverDetails=array();
            foreach ($infoForm as $item) {
                $nameKey = ucfirst($item['nameKey']);

                if(in_array($item['nameKey'],$sendReciveInfo)){
                    $key = $array[$item['nameKey']];
                    wc_add_order_item_meta($item_id,$key,[$item['nameVal']]);
                    $senderReceiverDetails[$key]=$item['nameVal'];
                }

                // array_push($infoFormkey, [$nameKey,'=======']);
                array_push($infoFormkey, [$item['nameKey'],$item['nameVal']]);

                $nameVal = $item['nameVal'];
                if($nameVal !=""){
                    wc_add_order_item_meta($item_id, $nameKey, $nameVal);
                }
            }
            wc_add_order_item_meta($item_id, 'info_form_ele', $infoFormkey);

            // wc_add_order_item_meta($item_id, 'info_form', $stripslashes);
            wc_add_order_item_meta($item_id, 'photo_url', array($user_custom_values['gift_card_image']));

            $imagesUrl = $user_custom_values['gift_card_image'];

            // Get the attachment ID
            $attachment_id = attachment_url_to_postid($imagesUrl);

            if($epgi === 'true'){
                
                $idGiftCard = wodgc_generate_unique_id();

                $pieces = chunk_split($idGiftCard,4,"-");
                $piece  = explode("-", $pieces);
                // $gift_card_id = $piece[0].'-'.$product_id.$item_id.'-'.$piece[1];
                $gift_card_id = $piece[0].'-'.$product_id.'-'.$piece[1];

                wc_add_order_item_meta($item_id, 'gift_card_no', $gift_card_id );
                wc_add_order_item_meta($item_id, 'gift_card_pdf', [$pdfStyle] );
                wc_add_order_item_meta($item_id, 'gift_card_email', [$emailStyle] );

                $items 		  = new WC_Order_Item_Product($item_id);
                $total		  = $items->get_total();

                $post_type    = "gift-card-number";
                $post_title   = $gift_card_id; // .uniqid()
                $post_content = json_encode(array(
                    'product_id'     => $product_id,
                    'order_item_id'  => $item_id,
                    'gift_card_no'   => $gift_card_id,
                    'gift_card_img'  => $imagesUrl,
                    'gift_card_price'=> $total,
                    'gift_card_expiry_date' => $expiry_date
                ), JSON_UNESCAPED_UNICODE);
            
                $new_post = array(
                    'post_author' => get_current_user_id(),
                    'post_content'=> $post_content,
                    'post_title'  => $post_title,
                    'post_type'   => $post_type,
                    'post_status' => 'draft'
                );
                $post_id = wp_insert_post($new_post);

                // save as post meta
                update_post_meta( $post_id, 'gift_card_img', $imagesUrl, true );
                update_post_meta( $post_id, 'gift_card_price', $total, true );
                update_post_meta( $post_id, 'gift_card_expiry_date', $expiry_date, true );
                
                // update_post_meta($post_id, 'gift_card_coupon', true);

            // neet to condition email sent now ro 

                $emailS = get_post_meta( $product_id, 'wodgc_send_email', true );
                $emailSend  = get_post_meta( $product_id, 'gift_card_send_email_enable', true );


                if($emailS==="true"){
                    
                    if($emailSend==='wodgc_email_after_checkout'){
                        
                        $today = time() + 10; // current time and 10 second later...
                        $receiveEmail="";
                        wp_schedule_single_event($today,'wodgc_send_gift_card_action',[$post_id,$item_id, $product_id, $receiveEmail]);

                    } else {

                        if(count($senderReceiverDetails)>0){
                            $add_cron=false;
                            $cron_time=0;
                            $receiveEmail="";
                            foreach($senderReceiverDetails as $key=>$val){
                                update_post_meta( $post_id, $key, $val, true );
                                if($key==='send-date-time'){
                                    $add_cron=true;
                                    $cron_time=date('i',strtotime($val)); // Y-m-d H:i
                                }

                                if($key==='recipient-email'){
                                    $add_cron=true;
                                    $receiveEmail=$val; // Y-m-d H:i
                                }

                            }

                            // initiate a single cron to send this gift card to it's receipient
                            if($add_cron){
                                wp_schedule_single_event(time()+$cron_time,'wodgc_send_gift_card_action',[$post_id,$item_id, $product_id, $receiveEmail]);
                            }
                        }

                    }

                }


                $useCoupon = get_post_meta( $product_id, 'gift_card_no_enable_as_coupon', true );
                if($useCoupon === 'true'){
                    // wodgc_generate_coupon($product_id,$couponCode,$amount,$expiryDate);
                    wodgc_generate_coupon($product_id,$gift_card_id,$total,$expiry_date);
                    update_post_meta($post_id, 'gift_card_coupon', 'true');
                }else{
                    update_post_meta($post_id, 'gift_card_coupon', false);
                }
            

                global $wpdb;
                $table_name = $wpdb->prefix . 'wodgc_transaction';
                
                // Sample data for insertion
                $data = array(
                  'gift_card_no' => $gift_card_id,
                  'amount' => $total,
                  'current_balance' => $total,
                  't_date_time' => current_time('mysql'),
                  'user_id' => get_current_user_id(),
                  'note' => 'Gift card activation with post id = '.$post_id,
                  'approved_by' => 'Admin',
                  'approved_at' => current_time('mysql'),
                  't_type' => 1,
                  'ref_id' => 'REF123456',
                  'uuid' => '6ba7b810-9dad-11d1-80b4-00c04fd430c8' // Sample UUID
                );
                
                // Insert data into the table
                $wpdb->insert($table_name, $data);

            }

            // Update the post meta value
            update_post_meta( $attachment_id, 'gift_card_processing', false ); // true
        
        }
    }
}

// show custom gift card image at admin order detail page
add_filter('woocommerce_admin_order_item_thumbnail', 'wodgc_item_custom_thumbnail', 10, 3);
function wodgc_item_custom_thumbnail($product_get_image_thumbnail_array_title_false, $item_id, $item) {

    $productId = $item->get_product_id();
    $product   = wc_get_product( $productId );
    $is_gift   = $product->get_type();

    if($is_gift=='advanced') {
        $order_id   = $item->get_order_id();
        $giftCardImg= wc_get_order_item_meta($item_id, 'photo_url', true); 

        $product_get_image_thumbnail_array_title_false='<img src="'.$giftCardImg[0].'" class="attachment-thumbnail size-thumbnail" alt="" width="150" height="150">';
    }

    return $product_get_image_thumbnail_array_title_false;
}


// ajax process wodgc_in_cart_page_popup_update_data();
function wodgc_in_cart_page_popup_update_data() {
    global $woocommerce;
    
    $key       = $_POST['cartItemKey'];
    $gcInfoFrom= $_POST['gift_card_info_form'][0];

    WC()->cart->cart_contents[$key]['gift_card_custom_val']['gift_card_info_form']=$gcInfoFrom;
    WC()->cart->set_session();

    $message = 'Item Updated Done!';
    echo json_encode(['status'=>'ok', 'messages' => $message ]);

    exit(); // wp_die();
}
add_action('wp_ajax_wodgc_in_cart_page_popup_update_data', 'wodgc_in_cart_page_popup_update_data');
add_action('wp_ajax_nopriv_wodgc_in_cart_page_popup_update_data', 'wodgc_in_cart_page_popup_update_data');


// cron executue function
add_action('wodgc_send_gift_card_action',function($gift_card_number_post_id,$order_item_id, $product_id, $emailRecive){

	$item    = new WC_Order_Item_Product($order_item_id);
	$imgCust = wc_get_order_item_meta( $order_item_id, 'photo_url', true);
	$total	 = $item->get_total();

	$epgi    = get_post_meta( $product_id, 'gift_card_number_show', true );
	if($epgi === 'true'){
		$idGiftCard = wc_get_order_item_meta( $order_item_id, 'gift_card_no', true);
	}else{
		$idGiftCard = 'No gift card number';
	}

	$expiryDate 	  = wc_get_order_item_meta( $order_item_id, 'gift_card_date_expiry', true);	
	$infoFromElements = wc_get_order_item_meta( $order_item_id, 'info_form_ele', true);
	$emailStyleHtml   = wc_get_order_item_meta( $order_item_id, 'gift_card_email', true);

    $mainImg = '<img style="width:720px;" src="'.$imgCust[0].'" alt="" />';


	$keys_array  = array("{gift_card_img}", "{gift_card_amount}", "{gift_card_expiry_date}", "{gift_card_no}");
	$values_array= array($mainImg, $total, $expiryDate, $idGiftCard);

	for ($i = 0; $i < count($infoFromElements); $i++) {
		$key=$infoFromElements[$i][0];
		$value=$infoFromElements[$i][1];
		
		// $keys_array[]=$key;
		$keys_array[]="{".$key."}";
		$values_array[]=$value;
	}
    
	$htmlEmail = str_replace($keys_array, $values_array, $emailStyleHtml[0]);

    $to = 'tanvirmdalamint@gmail.com';
    // $to=get_bloginfo('admin_email');
    $subject = 'Your email Subject.';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if($emailRecive){
        wp_mail($emailRecive, $subject, $htmlEmail, $headers);
    }
  
},10,2);




