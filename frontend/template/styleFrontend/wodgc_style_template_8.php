<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="col_6 left_side_main_img">
    
    <?php
        global $product;

        $product_id = $product->get_id();
        $image_id	= $product->get_image_id();
        $rootFolder = plugin_dir_url(__FILE__) . '../../../';
        
        if(wp_get_attachment_image_url($image_id,'full')) {
            $default_image = wp_get_attachment_image_url($image_id,'full');
        } else {
            $default_image=$rootFolder.'images/afmaelii-3.jpg';
        }
        
        
        
        $currency	   = get_woocommerce_currency_symbol();
        
        $min_price	   = 0;
        $min_price	   = get_post_meta($product_id,'_giftcard_min_price',true);
        
        $prices_array  = explode(',', $min_price);
        sort($prices_array);
        
        if(is_array($prices_array) && $min_price) {
            $showPrice = $prices_array[0];
        } else {
            $showPrice = $product->get_regular_price();
        }

    ?>

    <div id="gift_card_image_box_html">
        
        <div id="product-top-images"><img src="<?php echo $rootFolder . 'images/gifttowallet-logo.svg'; ?>"></div>
        <div class="image_box">
            <?php
                echo  '<img src="'.$default_image.'" id="gift_card_image" class="gift_card_image gcard-image image1" style="display:block;">';
            ?>
        </div>
        <div class="box_content">
            <div class="min_price">
                <p><strong>Dagsetning:</strong> <span id="Date" class="Date _Date"></span></p>
                <p id="gift_card_value" class="gift_card_value"><?php echo wc_price($showPrice)?></p>
            </div>
            <div class="rec_name">
                <p style="display:none;"><span id="gift_card_recipient_name_text"></span></p>
                <p style="display:none;">Frá: <span id="gift_card_recipient_email_text"></span></p>
            </div>
            <div class="barcode-text-box">
                <div class="card_mgs">
                    <p id="gift_card_message_text"  class="gift_card_message_text"></p>
                </div>
                <div class="barcode-image">
                    <img class="qrcode-image" style="width: 130px;" src="<?php echo $rootFolder . 'images/qrCode-gifttowallet.com.png';?>">
                </div>
            </div>
            <div class="barcode-image-second">
                <img class="qrcode-image-second-mini" style="max-width: 230px;" src="<?php echo $rootFolder . 'images/barcode-gifttowallet.gif';?>">
            </div>
        </div>

        <hr class="divider-line-hr">

        <table class="padding-bottom-table">
            <tr class="border-hide-product-page">
                <td class="product-table-bottom-text product-table-bottom-mobile">
                    <p class="product-bottom-text">Congratulations on your GiftToWallet gift card. Scan the QR code and get the gift card directly into an electronic wallet on your phone. Unfortunately, it is currently not possible to pay with a gift card in the GiftToWallet online store.</p>
                </td>
            </tr>
        </table>

    </div>

</div> 
