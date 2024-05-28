
<?php
/**
 * The template for displaying product content in the gift-card-single-product-content.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}


?>

<style>

	/*multi giftcard*/
	.woocommerce div.product form.cart .button.single_add_to_cart_button, .hidden{
		display: none;
	}

	/* Style the buttons inside the tab */
	.img_thumbnail .tab button {
		background-color: inherit;
		float: left;
		outline: none;
		cursor: pointer;
		transition: 0.3s;
		font-size: 14px;
		padding: 10px 10px;
		border-radius: unset;
		font-weight: 500;
		margin-bottom: 5px;
		margin-right: 5px;
		border: 1px solid #000; /* BTN_BG  BTN_TC*/
		color:#666;
	}
	.radio_btn label:first-child {
		margin-left: 0;
	}
	.radio_btn label:last-child, .img_thumbnail .tab button:last-child  {
		margin-right: -5px;
	}
	.radio_btn label {
		margin-bottom: 5px;
	}

	.woocommerce-Price-amount {
		font-size: 14px !important;
		text-align: center;
	}

	#gift_card_image_box_html .box_content {
		border: 2px solid #000;
	}
	.img_thumbnail ul li img:hover,.img_thumbnail ul li img.active {
		border-color: #000;
	}
	.radio_btn label span.woocommerce-Price-amount {
		border: 1px solid #000;
	}

	.radio_btn label span.woocommerce-Price-amount:hover, .radio_btn input[type="radio"]:checked + span.woocommerce-Price-amount, .img_thumbnail .tab button.active, .img_thumbnail .tab button:hover {
		background: #000;
		color: #fff;
		transition:.3s;
	}

	.ui-state-default{
		color: #666 !important;
	}

	.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-default.ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
		border: 1px solid #000;
		background: #000;
		font-weight: normal;
		color: #ffffff !important;
		/* font-family: auto !important; */
	}
	button#submitGiftCardFormBtn {
		background: #000;
		color: #fff;
		border: 0;
	}

	button#submitGiftCardFormBtn:hover {
		background: red; /* BTN_BG_H */
	}
	.giftcardformError {
		color: red;
		font-size: 12px;
	}

	/* Product bradcum, product title, product category, product price */
	#accordion nav.woocommerce-breadcrumb, #accordion span.single-product-category, #accordion .product_title.entry-title, #accordion .price span.woocommerce-Price-amount.amount, #accordion .product_meta span.posted_in  {
		display: none;
	}
	#accordion  form + .product_meta {
		display: none;
	}



</style>

<div id="accordion">
	<h3 class="product-title-gift" id="productHeader-<?php the_ID(); ?>"><?php the_title();?> -1</h3>
	<div  id="productGift-<?php the_ID(); ?>" <?php wc_product_class( ' product-single-gift ', $product ); ?>>

		<!-- Start Left side -->
		<div class="summary entry-summary"></div>
		<?php 
			$styleTemplate = get_post_meta( $product->get_id(), 'wodgc_style_template', true ); // $product->id
			include "template/styleFrontend/".$styleTemplate.".php"; // wodgc_style_template_1.php
		?>
		<!-- The end Left side -->

		<!-- Start Right side -->
        <div class="col_6 select_image_for_cart">
			<?php 

			global $post;
			$product = wc_get_product($post->ID);
			$image_id=$product->get_image_id();

			if(wp_get_attachment_image_url($image_id,'full')) {
				$default_image=wp_get_attachment_image_url($image_id,'full');
			} else {
				$default_image=plugin_dir_url(__FILE__ ).'assets/images/4k.jpg';
			}


			$btnTabs = '';
			$imgsTab = '';

			$tabImages = get_post_meta( $product->get_id(), 'wodgc_tab_images', true );
			$tabImgCheck = get_post_meta( $product->get_id(), 'gift_card_enable_product_gallery_img', true );
			// echo $tabImgCheck. "======= <br>--------". $tabImages;

			if($tabImgCheck ==='true'){

				$tabsData = json_decode($tabImages, true);
				foreach ($tabsData as $key => $tab) {
					$btnTabs .= '<button type="button" data-index="'.$key.'" class="item-button giftcard_image_tab_'.$key.' '.(($key===0)?'active':'').'" onclick="wodgcOpenTabImg(\'giftcard_image_tab_'.$key.'\')">'.$tab['label'].'</button>';

					$imgsTab .='
					<div id="giftcard_image_tab_'.$key.'" data-index="'.$key.'" class="item-container city '.(($key===0)?'active':'').'" style="display:'.(($key===0)?'block':'none').'">

						
						<ul class="thisTabImgShow" id="wodgcTabImgShow">';

							foreach( $tab['images'] as $img){
								$imgsTab .='
								<li style="margin-right: 0px;">
									<img class="" onclick="wodgcSelectThisGiftCardImage(this)" data-class="image1" src="'.$img['url'].'" width="142">
								</li>
								';
							}	
					$imgsTab .='		
						</ul>

					</div>
					';
				}
				

			}

			if($tabImgCheck ==='true'){
				echo '
				<div class="images-tab-wrap" id="imgTabs">

					<div class="buttons-bar">
						<span id="btn-container">
						'.$btnTabs.'
						</span>
					</div>

					<div class="images-tab-element img_thumbnail" id="gift_card_image_tab_contents">
						'.$imgsTab.'
						
					</div>
				</div>';
			}

			echo'
			<h2>Select an image</h2>
			<div class="img_thumbnail">

				<div id="Cat1"class="Cat1 tabcontent"style="display: block;">
					<ul>';

						$epgi      = get_post_meta( $product->get_id(), 'gift_card_product_fetcher_img', true ); // 
						if($epgi === 'true'){
							echo '
							<li style="margin-right: 0px;">
								<img class="active" onclick="wodgcSelectThisGiftCardImage(this)" data-class="image1" src="'.$default_image.'" width="60">
							</li>';
						}else{
							echo'';
						}

						$galleryImg = get_post_meta( $product->get_id(), 'gift_card_product_gallery_img', true ); // fetcher
						if($galleryImg === 'true'){
							$gallery_image_ids=$product->get_gallery_image_ids();

							foreach ($gallery_image_ids as $image_id) {
								$image_url=wp_get_attachment_image_src($image_id, 'full');

								echo '
								<li style="margin-right: 0px;">
									<img class="" onclick="wodgcSelectThisGiftCardImage(this)" data-class="image1" src="'.$image_url[0].'" width="60">
								</li>';
							}
						}else{
							echo'';
						}
						
					echo '
					</ul>
				</div>

			</div>
			
			<input type="hidden" name="gift_card_image" value="'.$default_image.'">
			';
			



			$userImg      = get_post_meta( $product->get_id(), 'gift_card_enable_user_upload_img', true );
			if($userImg === 'true'){
			echo ' 
			<div class="tab">
                        
				<button type="button" class="tablinks upload_my_img active" onclick="wodgcOpenImgCat()">Upload Own Img</button>
			</div>

			<div class="uploadGiftImg tabcontent">
				<ul>
					<li>
						<input id="selectedFile" onchange="wodgc_file_change(this)" class="disp-none selectedFile" type="file" accept=".png, .jpg, .jpeg, .svg">
						<button id="upload-aphoto" class="upload-aphoto" type="button" onclick="wodgc_user_upload_img_shown_in_popup()"> 
						 Input Image 
						</button>
						<div class="owner-upload-img">
							<img id="confirm-img" class="confirm-img" src="" onclick="wodgcSelectThisGiftCardImage(this)" data-class="image1" width="60">
						</div>
					</li>
				</ul>
			</div>';
			}else{
				$user_img = '';
			}
















			?>

			<?php 
				echo '<h2>Select a price</h2>';

				global $post;
				$product=wc_get_product($post->ID);
				//  $is_gift=get_post_meta($post->ID, '_gift_card', true);
				$is_gift='yes';
				$regularPrice=$product->get_regular_price();
				$giftcardPrices=0;

				if($is_gift=='yes') {
					$giftcardPrices=get_post_meta($post->ID, 'gift_card_price', true);

					$prices_array=explode(',', $giftcardPrices);
					sort($prices_array);

					if(is_array($prices_array) && $giftcardPrices) {
						// count($prices_array)>1
						$pricesBTN='';
						$btnPrice=0;

						foreach ($prices_array as $key=> $value) {

							if($btnPrice>0) {
								$pricesBTN .='<label><input class="gift_card_default_amount" onchange="wodgcDefaultPrice(this)" type="radio" name="gift_card_default_price" value="'.$value.'">'.wc_price($value).'</label>';
							}
							$btnPrice++;
						}
						$hiddenPrice=$prices_array[0];
					} else {
						$hiddenPrice=$regularPrice;
					}

				} else {
					$giftcardPrices=$product->get_regular_price();
				}

				echo '
				<input type="hidden" name="gift_card_amount" value="'.$hiddenPrice.'">
				<div class="radio_btn">
					<label><input class="gift_card_default_amount" onchange="wodgcDefaultPrice(this)" checked type="radio" name="gift_card_default_price" value="'.$hiddenPrice.'">'.wc_price($hiddenPrice).'</label>'.$pricesBTN.'
				</div>';
				
			?>


			<?php 
				// global $product_object; 

				// $productId = $product_object->id;

				global $post;
				$product   = wc_get_product($post->ID);

				$meta_data = get_post_meta( $post->ID, 'gift_card_form', true );
				$metaData  = $meta_data ? $meta_data : '[]';

				// echo 'tAnViR = '.$metaData;
				$form_element = json_decode($metaData, true);

				$formHtml = '';
				if (count($form_element) > 0) {
					foreach ($form_element as $element) {

						if(isset($element['sr'])){
							$sendDateTime = ($element['sr'] === "send-date-time") ? "srDate" : "";
						} else {
							$sendDateTime = "";
						}
						// $sendDateTime = ($element['sr'] === "send-date-time") ? "srDate" : "";

						$requerd 	= ($element['is_required'] === "on") ? "required" : "";
						$requerFlag = ($element['is_required'] === "on") ? '<b class="required">*</b>' : ""; // '.$requerFlag.'

						if($element['element']==='input'){
							$formHtml .= '
							<div class="form-element">
								<h5 for="' . $element['id'] . '">'.$element['label'].': '.$requerFlag.'</h5>
								<input type="'.$element['type'].'" name="'.$element['id'].'" placeholder="'. $element['placeholder'].'" '.$requerd.' class="'.$sendDateTime.'" >
							</div>';
						} 
						elseif ($element['element']==='textarea'){
							$formHtml .= '
							<div class="form-element">
								<h5 for="'.$element['id'].'">'.$element['label'].':</h5>
								<textarea name="'.$element['id'].'" rows="4" >'.$element['placeholder'].'</textarea>
							</div>';
						}
						elseif ($element['element']==='select'){ // required="'.$element['is_required'].'" 
							$formHtml .= '
							<div class="form-element">
								<h5 for="'.$element['id'].'">'.$element['label'].':</h5>
								<select name="'.$element['id'].'" placeholder="'.$element['placeholder'].'" >';

									foreach($element['options'] as $opt) { 
										$formHtml .= '<option value="'.$opt.'">'.$opt.'</option>';
									}
								$formHtml .= '
								</select>
							</div>';
						}
						


					}

				} else {
					$formHtml .= 'Form Not Created.';
				}

				echo $formHtml;
				echo '<input type="hidden" name="product_id" value="'.$post->ID.'"/>';

			?>

				<!-- <script>
					let giftCardInfoFrom = '<?php // echo $meta_data; ?>';
					// console.log(giftCardInfoFrom);
					
				</script> -->

        </div>
		<!-- The end Right side -->

	</div>
</div>

<br>

<div class="formButton form_row" style="">
	<div class="col_6">
		<input type="number" id="qtyGiftCard" style="margin-left: 10px;width: 60px;" value="1" name="qtyGiftCard"/> 
		<button id="submitGiftCardFormBtn" class="submitGiftCardFormBtn" >Add to Cart</button>
		<a class="btn aUpdateCart" style="display:none" href="<?php echo site_url()?>/cart/">Update Cart</a>
		<!--<button id="cloneProduct">Add More Card</button>-->
	</div>
	
	<div class="col_6" id="errorText">
		
	</div>
</div>


<?php 

do_action( 'woocommerce_after_single_product' ); ?>



