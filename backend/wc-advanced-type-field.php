<?php

 /**
 * Add Content to Advanced Type Tab
 * 
 */
add_action( 'woocommerce_product_data_panels', 'wodgc_type_product_data_content_fun' );
function wodgc_type_product_data_content_fun() {
    global $product_object; 

    $productId = $product_object->id;
    $meta_data = get_post_meta( $productId, 'gift_card_form', true );
    $metaData  = $meta_data ? $meta_data : '[]';

    $tab_images= get_post_meta( $productId, 'wodgc_tab_images', true );
    $imgTabs   = $tab_images ? $tab_images : '[]';

    // $giftCardFormJSON = stripslashes(json_encode($metaData));
    ?>
    <div id='advanced_type_product_options' class='panel woocommerce_options_panel hidden'>
        <div class='options_group'>

            <div class="gift-wrap">
                <div class="tab-teaser">
                    <div class="tab-menu">
                        <ul>
                            <li><a href="#" class="active" data-rel="tab-1">Form</a></li>
                            <li><a href="#" data-rel="tab-2" class="">Pdf</a></li>
                            <li><a href="#" data-rel="tab-4" class="">Prices</a></li>
                            <li><a href="#" data-rel="tab-3" class="">Images</a></li>
                            <li><a href="#" data-rel="tab-5" class="">Setting</a></li>
                            <li><a href="#" data-rel="tab-6" class="">Style</a></li>
                            <li><a href="#" data-rel="tab-7" class="">Email Template</a></li>
                        </ul>
                    </div>

                    <div class="tab-main-box">

                        <div class="tab-box" id="tab-1" style="display:block;">
                            <div class="gcol-wrap">
                                <div class="gcol-1">
                                    <h3><b>Form Element</b></h3>
                                    <h2><?php // echo get_product_type( ); ?></h2>
                                    <h4 class="Click-here5"><button type="button" onclick="clickHere(point='select')" >Select +</button></h4>
                                    <h4><button type="button" onclick="clickHere(point='textArea')">TextArea +</button></h4>
                                    <h4 class="Click-here5"><button type="button" onclick="clickHere(point='input')" >Input type +</button></h4>
                                    <h4 class="Click-here5">
                                        <input type="hidden" name="gift_card_form" value='<?php echo $metaData; ?>' class="form-input-element">
                                    </h4>
                                    
                                </div>
                                <div class="gcol-2">
                                    <h3><b>Form Display</b></h3>
                                    
                                    <div class="form-create">

                                        <div class="form-body" id="giftCartSetting">

                                        <?php 
                                            // echo 'tAnViR = '.$metaData;
                                            $form_element = json_decode($metaData, true);

                                            $formHtml = '';
                                            if (count($form_element) > 0) {
                                                $i=0;
                                                foreach ($form_element as $element) {

                                                    $requerFlag = ($element['is_required'] === "on") ? '<b class="required">*</b>' : "";

                                                    if($element['element']==='input'){
                                                        $formHtml .= '
                                                        <div class="form-element" indexId="'.$i.'">
                                                            <div class="label-action">
                                                                <h5 for="' . $element['id'] . '">' . $element['label'] . ': '.$requerFlag.'</h5>
                                                                <div class="action-btn" >
                                                                    <span class="dashicons dashicons-edit editColor" onclick="wodgcEditField('.$i.')"></span> | <span class="dashicons dashicons-trash error" onclick="wodgcDeleteField('.$i.')"></span>
                                                                </div>
                                                            </div>
                                                            <input type="' . $element['type'] . '" id="' . $element['id'] . '" placeholder="' . $element['placeholder'] . '" >
                                                        </div>';
                                                    } 
                                                    elseif ($element['element']==='textarea'){
                                                        $formHtml .= '
                                                        <div class="form-element" indexId="'.$i.'">
                                                            <div class="label-action">
                                                                <h5 for="' . $element['id'] . '">' . $element['label'] . ': '.$requerFlag.'</h5>
                                                                <div class="action-btn" >
                                                                    <span class="dashicons dashicons-edit editColor" onclick="wodgcEditField('.$i.')"></span> | <span class="dashicons dashicons-trash error" onclick="wodgcDeleteField('.$i.')"></span>
                                                                </div>
                                                            </div>
                                                            <textarea id="'.$element['id'].'" rows="10" >'.$element['placeholder'].'</textarea>
                                                        </div>';
                                                    }
                                                    elseif ($element['element']==='select'){ // required="'.$element['is_required'].'" 
                                                        $formHtml .= '
                                                        <div class="form-element" indexId="'.$i.'">
                                                            <div class="label-action">
                                                                <h5 for="' . $element['id'] . '">' . $element['label'] . ': '.$requerFlag.'</h5>
                                                                <div class="action-btn" >
                                                                    <span class="dashicons dashicons-edit editColor" onclick="wodgcEditField('.$i.')"></span> | <span class="dashicons dashicons-trash error" onclick="wodgcDeleteField('.$i.')"></span>
                                                                </div>
                                                            </div>
                                                            <select id="'.$element['id'].'" placeholder="'.$element['placeholder'].'" >';

                                                                foreach($element['options'] as $opt) { 
                                                                    $formHtml .= '<option value="'.$opt.'">'.$opt.'</option>';
                                                                }
                                                            $formHtml .= '
                                                            </select>
                                                        </div>';
                                                    }
                                                    
                                                    $i++;
                                                }

                                            } else {
                                                $formHtml .= 'Form Not Created.';
                                            }

                                            echo $formHtml;?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="tab-box pdfBodyHtml" id="tab-2">

                            <div class="gcol-wrap stylePDF">
                                <div class="gcol-1">
                                    <h2><b>Select pdf style</b></h2>
                                    <?php 
                                        $pdfStyle = get_post_meta( $productId, 'wodgc_pdf_style_template', true );

                                        $pdfS1 = ("pdfStyle1" === $pdfStyle) ? "selected" : "";
                                        $pdfS2 = ("pdfStyle2" === $pdfStyle) ? "selected" : "";
                                        $pdfS3 = ("pdfStyle3" === $pdfStyle) ? "selected" : "";
                                        $pdfS4 = ("pdfStyle4" === $pdfStyle) ? "selected" : "";
                                        $pdfS5 = ("pdfStyle5" === $pdfStyle) ? "selected" : "";
                                        $pdfS6 = ("pdfStyle6" === $pdfStyle) ? "selected" : "";
                                        $pdfS7 = ("pdfStyle7" === $pdfStyle) ? "selected" : "";
                                        $pdfS8 = ("pdfStyle8" === $pdfStyle) ? "selected" : "";
                                    ?>
                                    <p>
                                    <select name="wodgc_pdf_style_template" id="wodgc_pdf_style_template" onchange="wodgcPdfImgPreview()" >
                                        <option value="pdfStyle1" <?php echo $pdfS1 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle1.jpg"; ?>" >PDF Style 1</option>
                                        <option value="pdfStyle2" <?php echo $pdfS2 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle2.jpg"; ?>" >PDF Style 2</option>
                                        <option value="pdfStyle3" <?php echo $pdfS3 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle3.jpg"; ?>" >PDF Style 3</option>
                                        <option value="pdfStyle4" <?php echo $pdfS4 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle4.jpg"; ?>" >PDF Style 4</option>
                                        <option value="pdfStyle5" <?php echo $pdfS5 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle5.jpg"; ?>" >PDF Style 5</option>
                                        <option value="pdfStyle6" <?php echo $pdfS6 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle6.jpg"; ?>" >PDF Style 6</option>
                                        <option value="pdfStyle7" <?php echo $pdfS7 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle7.jpg"; ?>" >PDF Style 7</option>
                                        <option value="pdfStyle8" <?php echo $pdfS8 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle8.jpg"; ?>" >PDF Style 8</option>
                                    </select>
                                    <span class="dashicons dashicons-visibility" onclick="wodgcPreviewImageShownInPopup()" ></span>
                                    </p>
                                </div>

                                <div class="gcol-2">
                                    <h3><b>PDF Body</b></h3>
                                    <p>{bar_code} | {qr_code} | {gift_card_img} | {gift_card_amount} | {gift_card_expiry_date} | {gift_card_no}
                                        <span class="pdf-element" id="pdfElement">
                                            <?php 
                                                $form_element = json_decode($metaData, true);
                                                if(count($form_element) > 0){
                                                    foreach($form_element as $element){
                                                        echo ' | {'.$element['id'].'}';
                                                    }
                                                }
                                            ?>
                                        </span>
                                    </p>

                                </div>
                            </div>

                            <p>
                            <?php
                                $meta_data = get_post_meta( $productId, 'gift_card_pdf', true );
                                $content   = $meta_data ? $meta_data : "Enter your pdf html";
                                wp_editor( $content, 'gift_card_pdf', array(
                                    'wpautop'       => true,
                                    'media_buttons' => true, // true | false
                                    'textarea_name' => 'gift_card_pdf',
                                    'editor_class'  => 'gift_card_pdf',
                                    'textarea_rows' => 30, // 100 not work..
                                ));
                            ?>
                            </p>
                        </div>

                        <div class="tab-box" id="tab-3">

                            <div class="gcol-wrap imgStyleTabs">
                                <div class="gcol-3">

                                    <h2><b>Images</b></h2>
                                    <?php 

                                        $fetcherImg= get_post_meta( $productId, 'gift_card_product_fetcher_img', true );
                                        if($fetcherImg === 'true'){
                                            $checked = 'checked';
                                        }else{
                                            $checked = '';
                                        }

                                        $epgi      = get_post_meta( $productId, 'gift_card_product_gallery_img', true ); // fetcher
                                        if($epgi === 'true'){
                                            $check = 'checked';
                                        }else{
                                            $check = '';
                                        }
                                        
                                        $userImg      = get_post_meta( $productId, 'gift_card_enable_user_upload_img', true );
                                        if($userImg === 'true'){
                                            $user_img = 'checked';
                                        }else{
                                            $user_img = '';
                                        }

                                        $tabs      = get_post_meta( $productId, 'gift_card_enable_product_gallery_img', true );
                                        if($tabs === 'true'){
                                            $cat = 'checked';
                                        }else{
                                            $cat = '';
                                        }

                                    ?>
                                    
                                    <p>Show Product Fetcher image 

                                        <input class="gift-input" type="checkbox" name="gift_card_product_fetcher_img" value="<?php echo $epgi; ?>" <?php echo $checked?> >

                                    </p>

                                    <p>Show Product Gallery image 

                                        <input class="gift-input" type="checkbox" name="gift_card_product_gallery_img" value="<?php echo $epgi; ?>" <?php echo $check?> >

                                    </p>

                                    <p>Enable User Upload Image <b title="if this is checked user can updoad their own image."> <span class="dashicons dashicons-editor-help"></span> </b>
                                        <input class="gift-input" type="checkbox" name="gift_card_enable_user_upload_img" value="<?php echo $userImg; ?>" <?php echo $user_img?> >
                                    </p>

                                    <p>Show Category/Tabs Images <b title="if this is checked tabs image will be shown."> <span class="dashicons dashicons-editor-help"></span> </b>
                                    <input class="gift-input" type="checkbox" name="gift_card_enable_product_gallery_img" value="<?php echo $tabs; ?>" <?php echo $cat; ?> onclick="wodgcShowImgUploadTabs()" > </p>
                                
                                </div>

                                <div class="gcol-4">

                                    <input type="hidden" name="wodgc_tab_images" value='<?php echo $imgTabs; ?>' class="form-input-element">

                                    <div class="images-tab-wrap" id="imgTabs"></div>


                                </div><!-- end gcol-4 -->
                            </div>






                        </div>

                        <div class="tab-box" id="tab-4">
                            <h2>Gift Card Prices</h2>
                            <p>
                            <input type="text" class="short" style="" name="gift_card_price" id="gift_card_price" value="<?php echo get_post_meta( $productId, 'gift_card_price', true );?>" placeholder="5,10,20,25">
                            </p>
                            <p>Example: 5,10,20,25</p>
                        </div>

                        <div class="tab-box" id="tab-5">

                            <div class="gcol-wrap addCouponFild">
                                <div class="gcol-3">
                                            
                                    <h2>Expiry Date</h2>
                                    <?php 
                                        $expiryType = get_post_meta( $productId, 'gift_card_expiry_date_type', true );

                                        $sDays   = ("days" === $expiryType) ? "selected" : "";
                                        $sMonths = ("months" === $expiryType) ? "selected" : "";
                                        $sYears  = ("years" === $expiryType) ? "selected" : "";
                                    ?>
                                    <p>
                                    <input type="number" class="short date_number" name="gift_card_expiry_date" id="gift_card_expiry_date" value="<?php echo get_post_meta($productId, 'gift_card_expiry_date', true);?>" placeholder="Enter Number">

                                    <select name="gift_card_expiry_date_type" id="gift_card_expiry_date_type">
                                        <option value="days" <?php echo $sDays ?> >Days</option>
                                        <option value="months" <?php echo $sMonths ?> >Months</option>
                                        <option value="years" <?php echo $sYears ?> >Years</option>
                                    </select>
                                    </p>

                                    <?php 

                                        $eGiftCard      = get_post_meta( $productId, 'wodgc_disable_edit_card', true );
                                        if($eGiftCard === 'true'){
                                            $editCheck = 'checked';
                                        }else{
                                            $editCheck = '';
                                        }

                                        $epgi      = get_post_meta( $productId, 'gift_card_number_show', true );
                                        if($epgi === 'true'){
                                            $check = 'checked';
                                        }else{
                                            $check = '';
                                        }

                                        $addCoupon      = get_post_meta( $productId, 'gift_card_no_enable_as_coupon', true );
                                        if($addCoupon === 'true'){
                                            $checkCoupon = 'checked';
                                        }else{
                                            $checkCoupon = '';
                                        }
                                    ?>

                                    <p>Show Gift Card number <b title="if this is unchecked Gift Card number will be shown."> <span class="dashicons dashicons-editor-help"></span> </b>

                                    <input placeholder="" class="gift-input" type="checkbox" name="gift_card_number_show" value="<?php echo $epgi; ?>" <?php echo $check?> onclick="wodgc_showCouponOption()" >
                                    </p>

                                    <p id="useCoupon" style="display:none">Use coupon
                                        <input class="gift-input" type="checkbox" name="gift_card_no_enable_as_coupon" value="<?php echo $addCoupon; ?>" <?php echo $checkCoupon; ?> onclick="wodgc_addCouponOption()" >
                                    </p>
                                        

                                    <p>Use this "<b>[gift-card-check-info]</b>" short code any where for Gift card Number Check check info.</p>

                                    <!-- <p>Enable edit card <b title="If this is checked Gift Card info. will be edit in cart page."> <span class="dashicons dashicons-editor-help"></span> </b>

                                    <input class="gift-input" type="checkbox" name="wodgc_disable_edit_card" value="<?php /// echo $eGiftCard; ?>" <?php // echo $editCheck?> >
                                    </p> -->

                                    <?php 
                                    
                                    $emailS = get_post_meta( $productId, 'wodgc_send_email', true );
                                    if ($emailS==='true') {
                                        $checkEmail = 'checked';
                                    }else{
                                        $checkEmail = "";
                                    }

                                    $emailSend  = get_post_meta( $productId, 'gift_card_send_email_enable', true );

                                    $emailSend1 = ("wodgc_email_after_checkout" === $emailSend) ? "checked" : "";
                                    $emailSend2 = ("wodgc_email_user_set_date" === $emailSend) ? "checked" : "";
                                    
                                    ?>

                                    <p>Send Email <b title="if this is unchecked Gift Card email not send."> <span class="dashicons dashicons-editor-help"></span> </b>

                                    <input class="gift-input" type="checkbox" name="wodgc_send_email" value="<?php echo $emailS; ?>" <?php echo $checkEmail?> onclick="wodgc_showEmailSendOption()">
                                    </p>
                                    <p id="emailErrorNotification"></p>

                                    <div id="sendEmail" style="display:none">
                                        <p class="radio-btn">After checkout 
                                            <input class="gift-input" type="radio" name="gift_card_send_email_enable" value="wodgc_email_after_checkout" <?php echo $emailSend1; ?> >
                                        </p>
                                        <p class="radio-btn" id="userDateTimieSet">User Set DateTime 
                                            <input class="gift-input" type="radio" name="gift_card_send_email_enable" value="wodgc_email_user_set_date" <?php echo $emailSend2; ?> >
                                        </p>
                                    </div>




                                    
                                </div><!-- end gcol-3 -->
                                <div class="gcol-4">
                                    <div class="set-coupon-fild-wrap" id="fildCoupon" style="display:none">
                                        <h2><b>General</b></h2>
                                        <?php 
                                            $discountType = get_post_meta( $productId, 'wodgc_discount_type', true );

                                            $percent   = ("percent" === $discountType) ? "selected" : "";
                                            $fixedCart = ("fixed_cart" === $discountType) ? "selected" : "";
                                            $fixedPro  = ("fixed_product" === $discountType) ? "selected" : "";


                                            $shipping      = get_post_meta( $productId, 'wodgc_free_shipping', true );
                                            if($shipping === 'true'){
                                                $shipCheck = 'checked';
                                            }else{
                                                $shipCheck = '';
                                            }

                                            $individualUse = get_post_meta( $productId, 'wodgc_individual_use', true );
                                            if($individualUse === 'true'){
                                                $useCheck = 'checked';
                                            }else{
                                                $useCheck = '';
                                            }
                                            $eSItems = get_post_meta( $productId, 'wodgc_exclude_sale_items', true );
                                            if($eSItems === 'true'){
                                                $itemCheck = 'checked';
                                            }else{
                                                $itemCheck = '';
                                            }

                                        ?>
                                    <p class=" form-field">
                                        <label for="discount_type">Discount type</label>
                                        <select style="" id="discount_type" name="wodgc_discount_type" class="select short">
                                            <option value="fixed_cart" <?php echo $fixedCart;?> >Fixed cart discount</option>
                                            <option value="fixed_product" <?php echo $fixedPro;?> >Fixed product discount</option>
                                        </select>
                                    </p>
                                    <p class="form-field">
                                        <label for="wodgc_free_shipping">Allow free shipping</label><input type="checkbox" class="checkbox" style="" name="wodgc_free_shipping" id="wodgc_free_shipping" value="<?php echo $shipping;?>" <?php echo $shipCheck;?>> <span class="description">Tick this box if the coupon grants free shipping. A <a href="https://docs.woocommerce.com/document/free-shipping/" target="_blank">free shipping method</a> must be enabled in your shipping zone and be set to require "a valid free shipping coupon" (see the "Free Shipping Requires" setting).</span>
                                    </p>

                                    <h2><b>Usage limits</b></h2>
                                    <div class="title-delete">
                                        <p class=" form-field">
                                            <label for="wodgc_usage_per_coupon">Usage limit per coupon</label>
                                            <input type="number" class="short date_number" name="wodgc_usage_per_coupon" id="wodgc_usage_per_coupon" value="<?php echo get_post_meta($productId, 'wodgc_usage_per_coupon', true);?>" placeholder="Unlimited usage">
                                        </p>
                                        <p class=" form-field">
                                            <label for="wodgc_usage_per_user">Usage limit per user</label>
                                            <input type="number" class="short date_number" name="wodgc_usage_per_user" id="wodgc_usage_per_user" value="<?php echo get_post_meta($productId, 'wodgc_usage_per_user', true);?>" placeholder="Unlimited usage">
                                        </p>
                                    </div>
                                    <h2><b>Usage restriction</b></h2>
                                    <div class="title-delete">
                                        <p class=" form-field">
                                            <label for="wodgc_minimum_spend">Minimum spend</label>
                                            <input type="number" class="short date_number" name="wodgc_minimum_spend" id="wodgc_minimum_spend" value="<?php echo get_post_meta($productId, 'wodgc_minimum_spend', true);?>" placeholder="No minimum">
                                        </p>
                                        <p class=" form-field">
                                            <label for="wodgc_maximum_spend">Maximum spend</label>
                                            <input type="number" class="short date_number" name="wodgc_maximum_spend" id="wodgc_maximum_spend" value="<?php echo get_post_meta($productId, 'wodgc_maximum_spend', true);?>" placeholder="No maximum">
                                        </p>
                                    </div>
                                    <p class="form-field">
                                        <label for="wodgc_individual_use">Individual use only</label><input type="checkbox" class="checkbox" style="" name="wodgc_individual_use" id="wodgc_individual_use" value="<?php echo $individualUse;?>" <?php echo $useCheck;?> > <span class="description">Tick this box if the coupon cannot be used in conjunction with other coupons.</span>
                                    </p>
                                    <p class="form-field">
                                        <label for="wodgc_exclude_sale_items">Exclude sale items</label><input type="checkbox" class="checkbox" style="" name="wodgc_exclude_sale_items" id="wodgc_exclude_sale_items" value="<?php echo $eSItems;?>" <?php echo $itemCheck;?> > <span class="description">Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are items in the cart that are not on sale.</span>
                                    </p>
                                
                                    <p class=" form-field">
                                        <label for="selectProducts">Products</label>
                                        <select id="selectProducts" name="wodgc_c_product_ids[]" multiple="multiple">
                                            <?php
                                            $args = array(
                                                'post_type'      => 'product',
                                                'posts_per_page' => -1,
                                            );

                                            $products = new WP_Query($args);
                                            if($products->have_posts()){
                                                while($products->have_posts()){
                                                    $products->the_post();
                                                    $product_id = get_the_ID();
                                                    $product_name = get_the_title();
                                                    $productIds = get_post_meta($productId, 'wodgc_c_product_ids', true);
                                                    if($productIds && is_array($productIds)){
                                                        $selected = in_array($product_id, $productIds) ? 'selected' : '';
                                                    }else{
                                                        $selected = '';
                                                    }

                                                    echo '<option value="'.esc_attr($product_id).'" '.$selected.'>'. esc_html($product_name).'</option>';
                                                }
                                            }
                                            wp_reset_postdata();
                                            ?>
                                        </select>
                                        <b title='Products that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.'><span class="dashicons dashicons-editor-help"></span></b>
                                    </p>
                                
                                    <p class=" form-field">
                                        <label for="selectExProducts">Exclude products</label>
                                        <select id="selectExProducts" name="wodgc_c_ex_product_ids[]" multiple="multiple">
                                            <?php
                                            $args = array(
                                                'post_type'      => 'product',
                                                'posts_per_page' => -1,
                                            );

                                            $products = new WP_Query($args);
                                            if($products->have_posts()){
                                                while($products->have_posts()){
                                                    $products->the_post();
                                                    $product_id = get_the_ID();
                                                    $product_name = get_the_title();
                                                    $productIds = get_post_meta($productId, 'wodgc_c_ex_product_ids', true);
                                                    if($productIds && is_array($productIds)){
                                                        $selected = in_array($product_id, $productIds) ? 'selected' : '';
                                                    }else{
                                                        $selected = '';
                                                    }

                                                    echo '<option value="'.esc_attr($product_id).'" '.$selected.'>'. esc_html($product_name).'</option>';
                                                }
                                            }
                                            wp_reset_postdata();
                                            ?>
                                        </select>
                                        <b title='Products that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.'> <span class="dashicons dashicons-editor-help"></span> </b>
                                    </p>
                                    <p class=" form-field">
                                        <label for="selectCategories">Product categories</label>
                                        <select id="selectCategories" name="wodgc_c_product_cat_ids[]" multiple="multiple">
                                            <?php
                                            $args = array(
                                                'taxonomy'   => 'product_cat',
                                                'hide_empty' => false,
                                            );
                                        
                                            $categories = get_terms($args);
                                            if (!empty($categories)) {
                                                foreach ($categories as $category) {
                                                    $category_id = $category->term_id;
                                                    $category_name = $category->name;
                                                    $categoryIds = get_post_meta($productId, 'wodgc_c_product_cat_ids', true);
                                                    if($categoryIds && is_array($categoryIds)){
                                                        $selected = in_array($category_id, $categoryIds) ? 'selected':'';
                                                    }else{
                                                        $selected = '';
                                                    }
                                        
                                                    echo '<option value="' . esc_attr($category_id) . '" ' . $selected . '>' . esc_html($category_name) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <b title='Product categories that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.'> <span class="dashicons dashicons-editor-help"></span> </b>
                                    </p>

                                    <p class=" form-field">
                                        <label for="selectExCategories">Exclude categories</label>
                                        <select id="selectExCategories" name="wodgc_c_product_ex_cat_ids[]" multiple="multiple">
                                            <?php
                                            $args = array(
                                                'taxonomy'   => 'product_cat',
                                                'hide_empty' => false,
                                            );
                                        
                                            $categories = get_terms($args);
                                            if (!empty($categories)) {
                                                foreach ($categories as $category) {
                                                    $category_id = $category->term_id;
                                                    $category_name = $category->name;
                                                    $categoryIds = get_post_meta($productId, 'wodgc_c_product_ex_cat_ids', true);
                                                    if($categoryIds && is_array($categoryIds)){
                                                        $selected = in_array($category_id, $categoryIds) ? 'selected':'';
                                                    }else{
                                                        $selected = '';
                                                    }
                                        
                                                    echo '<option value="' . esc_attr($category_id) . '" ' . $selected . '>' . esc_html($category_name) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        <b title='Product categories that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.'> <span class="dashicons dashicons-editor-help"></span> </b>
                                    </p>

                                    <p class=" form-field">
                                        <label for="wodgc_c_allowed_emails">Allowed emails</label>
                                        <input type="text" class="" name="wodgc_c_allowed_emails" id="wodgc_c_allowed_emails" value="<?php echo get_post_meta($productId, 'wodgc_c_allowed_emails', true);?>" placeholder="No restrictions"> <b title='List of allowed billing emails to check against when an order is placed. Separate email addresses with commas. You can also use an asterisk (*) to match parts of an email. For example "*@gmail.com" would match all gmail addresses.'> <span class="dashicons dashicons-editor-help"></span> </b>
                                    </p>


                                    </div>
                                </div><!-- end gcol-4 -->
                            </div>


                        </div>

                        <div class="tab-box" id="tab-6">

                            <div class="gcol-wrap styleLeftSide">
                                <div class="gcol-1">
                                    <h3><b>Select Style Frontend</b></h3>
                                    
                                    <?php 
                                        $styleFo = get_post_meta( $productId, 'wodgc_style_template', true );

                                        $style1 = ("wodgc_style_template_1" === $styleFo) ? "selected" : "";
                                        $style2 = ("wodgc_style_template_2" === $styleFo) ? "selected" : "";
                                        $style3 = ("wodgc_style_template_3" === $styleFo) ? "selected" : "";
                                        $style4 = ("wodgc_style_template_4" === $styleFo) ? "selected" : "";
                                        $style5 = ("wodgc_style_template_5" === $styleFo) ? "selected" : "";
                                        $style6 = ("wodgc_style_template_6" === $styleFo) ? "selected" : "";
                                        $style7 = ("wodgc_style_template_7" === $styleFo) ? "selected" : "";
                                        $style8 = ("wodgc_style_template_8" === $styleFo) ? "selected" : "";
                                    ?>
                                    <p>
                                    <select name="wodgc_style_template" id="wodgc_style_template" onchange="wodgcSetImgPreview()">
                                        <option value="wodgc_style_template_1" <?php echo $style1 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/wodgc_style_template_1.jpg"; ?>" >Style 1</option>
                                        <option value="wodgc_style_template_2" <?php echo $style2 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/wodgc_style_template_2.jpg"; ?>" >Style 2</option>
                                        <option value="wodgc_style_template_3" <?php echo $style3 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/wodgc_style_template_3.jpg"; ?>" >Style 3</option>
                                        <option value="wodgc_style_template_4" <?php echo $style4 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/wodgc_style_template_4.jpg"; ?>" >Style 4</option>
                                        <option value="wodgc_style_template_5" <?php echo $style5 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/wodgc_style_template_5.jpg"; ?>" >Style 5</option>
                                        <option value="wodgc_style_template_6" <?php echo $style6 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/wodgc_style_template_6.jpg"; ?>" >Style 6</option>
                                        <option value="wodgc_style_template_7" <?php echo $style7 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/wodgc_style_template_7.jpg"; ?>" >Style 7</option>
                                        <option value="wodgc_style_template_8" <?php echo $style8 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/wodgc_style_template_8.jpg"; ?>" >Style 8</option>
                                        
                                    </select>
                                    </p>
                                </div>

                                <div class="gcol-2">
                                    <h3><b>Preview Left Side Frontend Style</b></h3>
                                    <div class="imgPreview">
                                        <img src="<?php echo WODGC_ACC_URL."backend/assets/images/".$styleFo.".jpg"; ?>" alt="Show Preview image">
                                    </div>
                                    
                                </div>
                            </div>

                            
                            <br>


                        </div>

                        <div class="tab-box" id="tab-7">
                            
                            <br>

                            <div class="gcol-wrap emailTemp">
                                <div class="gcol-1">
                                    <h2><b>Select Email Template</b></h2>
                                    <?php 
                                    $emailTe = get_post_meta( $productId, 'wodgc_email_template', true );

                                    $emailT1 = ("wodgc_email_template_1" === $emailTe) ? "selected" : "";
                                    $emailT2 = ("wodgc_email_template_2" === $emailTe) ? "selected" : "";
                                    $emailT3 = ("wodgc_email_template_3" === $emailTe) ? "selected" : "";
                                    ?>
                                    <p>
                                    <select name="wodgc_email_template" id="wodgc_email_template" onchange="wodgcEmailTempImgPreview()">
                                        <option value="wodgc_email_template_1" <?php echo $emailT1 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle1.jpg"; ?>" >Email Style 1</option>
                                        <option value="wodgc_email_template_2" <?php echo $emailT2 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle2.jpg"; ?>" >Email Style 2</option>
                                        <option value="wodgc_email_template_3" <?php echo $emailT3 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle3.jpg"; ?>" >Email Style 3</option>
                                        <option value="wodgc_email_template_3" <?php echo $emailT3 ?> imgLink="<?php echo WODGC_ACC_URL."backend/assets/images/pdfStyle3.jpg"; ?>" >gggggggggg 3</option>
                                    </select>

                                    <span class="dashicons dashicons-visibility" onclick="wodgcPreviewEmailTempImageShownInPopup()" ></span>
                                    </p>

                                </div>

                                <div class="gcol-2">
                                    <h3><b>Email Body</b></h3>

                                    <p>{bar_code} | {qr_code} | {gift_card_img} | {gift_card_amount} | {gift_card_expiry_date} | {gift_card_no}
                                        <span class="email-element" id="emailElement">
                                            <?php 
                                                $form_element = json_decode($metaData, true);
                                                if(count($form_element) > 0){
                                                    foreach($form_element as $element){
                                                        echo ' | {'.$element['id'].'}';
                                                    }
                                                }
                                            ?>
                                        </span>
                                    </p>

                                </div>
                            </div>

                            <p>
                            <?php
                                $meta_data = get_post_meta( $productId, 'gift_card_email', true );
                                $content   = $meta_data ? $meta_data : "Enter your email html";
                                wp_editor( $content, 'gift_card_email', array(
                                    'wpautop'       => true,
                                    'media_buttons' => true, // true | false
                                    'textarea_name' => 'gift_card_email',
                                    'editor_class'  => 'gift_card_email',
                                    'textarea_rows' => 30, // 100 not work..
                                ));
                            ?>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

}


add_action( 'woocommerce_process_product_meta', 'wodgc_save_gift_card_form_field' );
function wodgc_save_gift_card_form_field(  ){

    global $post;
    // $post_id = wc_get_product($post->ID);
    $post_id  = $post->ID;

    $wc_field = $_POST['gift_card_form'];
    $wc_gc_pdf= $_POST['gift_card_pdf'];
    $email_tem= sanitize_email($_POST['gift_card_email']);
    $gc_price = sanitize_text_field($_POST['gift_card_price']);
    
    $cUsagePerCoupon = isset($_POST['wodgc_usage_per_coupon']) ? sanitize_text_field($_POST['wodgc_usage_per_coupon']) : '';
    $cUsagePerUser   = sanitize_text_field($_POST['wodgc_usage_per_user']);
    $cMinimumSpend   = sanitize_text_field($_POST['wodgc_minimum_spend']);
    $cMaximumSpend   = sanitize_text_field($_POST['wodgc_maximum_spend']);
    $cProductIds     = sanitize_text_field($_POST['wodgc_c_product_ids']);
    $cExProductIds   = sanitize_text_field($_POST['wodgc_c_ex_product_ids']);
    $cProductCatIds  = sanitize_text_field($_POST['wodgc_c_product_cat_ids']);
    $cProductExCatIds= sanitize_text_field($_POST['wodgc_c_product_ex_cat_ids']);
    $cAllowedEmails  = sanitize_text_field($_POST['wodgc_c_allowed_emails']);


    $expiryDateNumber = sanitize_text_field($_POST['gift_card_expiry_date']);
    $expiryDateType = sanitize_text_field($_POST['gift_card_expiry_date_type']);
    $pdfStyle = sanitize_text_field($_POST['wodgc_pdf_style_template']); // 555555555  | $meta_data = get_post_meta( $productId, 'gift_card_pdf', true );
    $couponDisType = sanitize_text_field($_POST['wodgc_discount_type']); 


    $leftStyle= sanitize_text_field($_POST['wodgc_style_template']);
    $emlStyle = sanitize_text_field($_POST['wodgc_email_template']);
    $imgTabs  = sanitize_text_field($_POST['wodgc_tab_images']);

    $wc_g_img = isset($_POST['gift_card_enable_product_gallery_img']) ? 'true' : '';
    $wc_coupon= isset($_POST['gift_card_no_enable_as_coupon']) ? 'true' : '';
    $gc_edit  = isset($_POST['wodgc_disable_edit_card']) ? 'true' : '';
    $wc_gallery_img = isset($_POST['gift_card_product_gallery_img']) ? 'true' : '';
    $wc_fetcher_img = isset($_POST['gift_card_product_fetcher_img']) ? 'true' : '';
    $user_upload_img = isset($_POST['gift_card_enable_user_upload_img']) ? 'true' : '';
    $giftCardNo = isset($_POST['gift_card_number_show']) ? 'true' : '';

    $couponShipping= isset($_POST['wodgc_free_shipping']) ? 'true' : 'false';
    $couponUse     = isset($_POST['wodgc_individual_use']) ? 'true' : 'false';
    $couponESItems = isset($_POST['wodgc_exclude_sale_items']) ? 'true' : 'false';
    $sendEmail     = isset($_POST['wodgc_send_email']) ? 'true' : 'false';
    $sendEmailEna  = $_POST['gift_card_send_email_enable'];

    if( !empty($wc_field)){
        update_post_meta( $post_id, 'gift_card_form', $wc_field );
    }
    if( !empty($wc_gc_pdf)){
        update_post_meta( $post_id, 'gift_card_pdf', $wc_gc_pdf );
    }
    if( !empty($email_tem)){
        update_post_meta( $post_id, 'gift_card_email', $email_tem );
    }
    if( !empty($gc_price)){
        update_post_meta( $post_id, 'gift_card_price', $gc_price );
    }
    if( !empty($expiryDateNumber)){
        update_post_meta( $post_id, 'gift_card_expiry_date', $expiryDateNumber );
    }



    update_post_meta( $post_id, 'wodgc_usage_per_coupon', $cUsagePerCoupon );
    update_post_meta( $post_id, 'wodgc_usage_per_user', $cUsagePerUser );
    update_post_meta( $post_id, 'wodgc_minimum_spend', $cMinimumSpend );
    update_post_meta( $post_id, 'wodgc_maximum_spend', $cMaximumSpend );
    update_post_meta( $post_id, 'wodgc_c_product_ids', $cProductIds );
    update_post_meta( $post_id, 'wodgc_c_ex_product_ids', $cExProductIds );
    update_post_meta( $post_id, 'wodgc_c_product_cat_ids', $cProductCatIds );
    update_post_meta( $post_id, 'wodgc_c_product_ex_cat_ids', $cProductExCatIds );
    update_post_meta( $post_id, 'wodgc_c_allowed_emails', $cAllowedEmails );
 

    

    update_post_meta( $post_id, 'gift_card_expiry_date_type', $expiryDateType );
    update_post_meta( $post_id, 'wodgc_pdf_style_template', $pdfStyle );
    update_post_meta( $post_id, 'wodgc_discount_type', $couponDisType );
    update_post_meta( $post_id, 'wodgc_style_template', $leftStyle );
    update_post_meta( $post_id, 'wodgc_email_template', $emlStyle );
    update_post_meta( $post_id, 'wodgc_tab_images', $imgTabs );

    update_post_meta( $post_id, 'gift_card_enable_product_gallery_img', $wc_g_img );
    update_post_meta( $post_id, 'gift_card_no_enable_as_coupon', $wc_coupon );
    update_post_meta( $post_id, 'wodgc_disable_edit_card', $gc_edit );
    update_post_meta( $post_id, 'gift_card_product_gallery_img', $wc_gallery_img );
    update_post_meta( $post_id, 'gift_card_product_fetcher_img', $wc_fetcher_img );
    update_post_meta( $post_id, 'gift_card_enable_user_upload_img', $user_upload_img );
    update_post_meta( $post_id, 'gift_card_number_show', $giftCardNo );

    update_post_meta( $post_id, 'wodgc_free_shipping', $couponShipping );
    update_post_meta( $post_id, 'wodgc_individual_use', $couponUse );
    update_post_meta( $post_id, 'wodgc_exclude_sale_items', $couponESItems );
    update_post_meta( $post_id, 'wodgc_send_email', $sendEmail );
    update_post_meta( $post_id, 'gift_card_send_email_enable', $sendEmailEna );
    

}



add_action('admin_footer', 'wodgc_admin_popup');
function wodgc_admin_popup() {
	?>

    <!-- Add Popup section Start Now-->
    <div class="popup-wrap">

        <!-- <div class="Click-here">Click button</div> -->
        <div class="popup-model-main">
            <div class="popup-model-inner">
                <div class="close-btn">×</div>
                <div class="popup-model-wrap">
                    <div class="pop-up-content-wrap">
                        <div id="popup_des">
                            <h3>Loding... .. .</h3>
                        </div>

                    </div>
                </div>
            </div>
            <div class="bg-overlay"></div>
        </div>

    </div>
    <!-- Popup section The end -->

    <?php
}




    