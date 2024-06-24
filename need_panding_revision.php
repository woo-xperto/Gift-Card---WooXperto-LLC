<?php 
/*
## Data Must be Sanitized, Escaped, and Validated
Gift-Card---WooXperto-LLC-main/backend/wc-advanced-type-field.php:708 $wc_gc_pdf= $_POST['gift_card_pdf'];
Gift-Card---WooXperto-LLC-main/backend/wc-advanced-type-field.php:707 $wc_field = $_POST['gift_card_form'];

## Nonces and User Permissions Needed for Security

Please add a nonce to your POST calls to prevent unauthorized access.

Keep in mind, check_admin_referer alone is not bulletproof security. Do not rely on nonces for authorization purposes. Use current_user_can() in order to prevent users without the right permissions from accessing things.

If you use wp_ajax to trigger submission checks, remember they also need a nonce check.

You also must avoid checking for post submission outside of functions. Doing so means the check runs on every single load of the plugin which means every single person who views any page on a site using your plugin will check for a submission. Doing that makes your code slow and unwieldy for users on any high-traffic site, causing instability and crashes.

The following links may assist you in development:

https://developer.wordpress.org/plugins/security/nonces/
https://developer.wordpress.org/plugins/javascript/ajax/#nonce
https://developer.wordpress.org/plugins/settings/settings-api/

Example(s) from your plugin:

FILE: /Gift-Card---WooXperto-LLC-main/gift-card-woo-xperto-llc.php

---------------------------------------
FOUND 9 ERRORS AFFECTING 8 LINES

---------------------------------------
LINE 310: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)
LINE 310: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)

---------------------------------------
308: ··public·function·save_advanced_settings(·$post_id·)·{
309: ····
>> 310: ····$giftCart·=·isset(·$_POST['_gift_cart']·)·?·sanitize_text_field(·$_POST['_gift_cart']·)·:·'';
311:
312: ····//·update_post_meta(·$post_id,·'_member_price',·$price·);

---------------------------------------
LINE 365: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)

---------------------------------------
363: ··
364: ··//check·error·end
>> 365: ··for($i=0;·$i<count($_POST['product_id']);·$i++)·{
366: ····if($i>0)·sleep(1);
367:

---------------------------------------
LINE 368: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)

---------------------------------------
366: ····if($i>0)·sleep(1);
367:
>> 368: ····$product_id·········=·sanitize_text_field($_POST['product_id'][$i]);
369: ····$gift_card_image····=·$_POST['gift_card_image'][$i];
370: ····$gift_card_amount···=·sanitize_text_field($_POST['gift_card_amount'][$i]);

---------------------------------------
LINE 369: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)

---------------------------------------
367:
368: ····$product_id·········=·sanitize_text_field($_POST['product_id'][$i]);
>> 369: ····$gift_card_image····=·$_POST['gift_card_image'][$i];
370: ····$gift_card_amount···=·sanitize_text_field($_POST['gift_card_amount'][$i]);
371: ····$gift_card_info_form=·sanitize_text_field($_POST['gift_card_info_form'][$i]);

---------------------------------------
LINE 370: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)

---------------------------------------
368: ····$product_id·········=·sanitize_text_field($_POST['product_id'][$i]);
369: ····$gift_card_image····=·$_POST['gift_card_image'][$i];
>> 370: ····$gift_card_amount···=·sanitize_text_field($_POST['gift_card_amount'][$i]);
371: ····$gift_card_info_form=·sanitize_text_field($_POST['gift_card_info_form'][$i]);
372: ····$unique_cart_item_key·=·md5(microtime()·.·rand());

---------------------------------------
LINE 371: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)

---------------------------------------
369: ····$gift_card_image····=·$_POST['gift_card_image'][$i];
370: ····$gift_card_amount···=·sanitize_text_field($_POST['gift_card_amount'][$i]);
>> 371: ····$gift_card_info_form=·sanitize_text_field($_POST['gift_card_info_form'][$i]);
372: ····$unique_cart_item_key·=·md5(microtime()·.·rand());
373:

---------------------------------------
LINE 564: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)

---------------------------------------
562:
563:
>> 564: ····$image··=·$_POST["image"];·//·UploadFile
565: ····$title··=·time();
566: ····$imgUrl·=·wodgc_my_upload_image_save($image,·$title);·//·upload_users_file($image);·

---------------------------------------
LINE 582: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)

---------------------------------------
580: function·wodgc_gift_card_info()·{
581:
>> 582: ··$post_title·=·sanitize_text_field($_POST['card_no']);
583: ··$post·=·get_page_by_title(·$post_title,·OBJECT,·"gift-card-number"·);
584:

---------------------------------------

FILE: ...p/Gift-Card---WooXperto-LLC-main/backend/wc-advanced-type-field.php


--------------------------
FOUND 33 ERRORS AFFECTING 32 LINES


--------------------------
LINE 707: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
705: ····$post_id··=·$post->ID;
706:
>> 707: ····$wc_field·=·$_POST['gift_card_form'];
708: ····$wc_gc_pdf=·$_POST['gift_card_pdf'];
709: ····$email_tem=·sanitize_email($_POST['gift_card_email']);


--------------------------
LINE 708: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
706:
707: ····$wc_field·=·$_POST['gift_card_form'];
>> 708: ····$wc_gc_pdf=·$_POST['gift_card_pdf'];
709: ····$email_tem=·sanitize_email($_POST['gift_card_email']);
710: ····$gc_price·=·sanitize_text_field($_POST['gift_card_price']);


--------------------------
LINE 709: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
707: ····$wc_field·=·$_POST['gift_card_form'];
708: ····$wc_gc_pdf=·$_POST['gift_card_pdf'];
>> 709: ····$email_tem=·sanitize_email($_POST['gift_card_email']);
710: ····$gc_price·=·sanitize_text_field($_POST['gift_card_price']);
711: ····


--------------------------
LINE 710: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
708: ····$wc_gc_pdf=·$_POST['gift_card_pdf'];
709: ····$email_tem=·sanitize_email($_POST['gift_card_email']);
>> 710: ····$gc_price·=·sanitize_text_field($_POST['gift_card_price']);
711: ····
712: ····$cUsagePerCoupon·=·isset($_POST['wodgc_usage_per_coupon'])·?·sanitize_text_field($_POST['wodgc_usage_per_coupon'])·:·'';


--------------------------
LINE 712: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)
LINE 712: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
710: ····$gc_price·=·sanitize_text_field($_POST['gift_card_price']);
711: ····
>> 712: ····$cUsagePerCoupon·=·isset($_POST['wodgc_usage_per_coupon'])·?·sanitize_text_field($_POST['wodgc_usage_per_coupon'])·:·'';
713: ····$cUsagePerUser···=·sanitize_text_field($_POST['wodgc_usage_per_user']);
714: ····$cMinimumSpend···=·sanitize_text_field($_POST['wodgc_minimum_spend']);


--------------------------
LINE 713: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
711: ····
712: ····$cUsagePerCoupon·=·isset($_POST['wodgc_usage_per_coupon'])·?·sanitize_text_field($_POST['wodgc_usage_per_coupon'])·:·'';
>> 713: ····$cUsagePerUser···=·sanitize_text_field($_POST['wodgc_usage_per_user']);
714: ····$cMinimumSpend···=·sanitize_text_field($_POST['wodgc_minimum_spend']);
715: ····$cMaximumSpend···=·sanitize_text_field($_POST['wodgc_maximum_spend']);


--------------------------
LINE 714: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
712: ····$cUsagePerCoupon·=·isset($_POST['wodgc_usage_per_coupon'])·?·sanitize_text_field($_POST['wodgc_usage_per_coupon'])·:·'';
713: ····$cUsagePerUser···=·sanitize_text_field($_POST['wodgc_usage_per_user']);
>> 714: ····$cMinimumSpend···=·sanitize_text_field($_POST['wodgc_minimum_spend']);
715: ····$cMaximumSpend···=·sanitize_text_field($_POST['wodgc_maximum_spend']);
716: ····$cProductIds·····=·sanitize_text_field($_POST['wodgc_c_product_ids']);


--------------------------
LINE 715: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
713: ····$cUsagePerUser···=·sanitize_text_field($_POST['wodgc_usage_per_user']);
714: ····$cMinimumSpend···=·sanitize_text_field($_POST['wodgc_minimum_spend']);
>> 715: ····$cMaximumSpend···=·sanitize_text_field($_POST['wodgc_maximum_spend']);
716: ····$cProductIds·····=·sanitize_text_field($_POST['wodgc_c_product_ids']);
717: ····$cExProductIds···=·sanitize_text_field($_POST['wodgc_c_ex_product_ids']);


--------------------------
LINE 716: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
714: ····$cMinimumSpend···=·sanitize_text_field($_POST['wodgc_minimum_spend']);
715: ····$cMaximumSpend···=·sanitize_text_field($_POST['wodgc_maximum_spend']);
>> 716: ····$cProductIds·····=·sanitize_text_field($_POST['wodgc_c_product_ids']);
717: ····$cExProductIds···=·sanitize_text_field($_POST['wodgc_c_ex_product_ids']);
718: ····$cProductCatIds··=·sanitize_text_field($_POST['wodgc_c_product_cat_ids']);


--------------------------
LINE 717: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
715: ····$cMaximumSpend···=·sanitize_text_field($_POST['wodgc_maximum_spend']);
716: ····$cProductIds·····=·sanitize_text_field($_POST['wodgc_c_product_ids']);
>> 717: ····$cExProductIds···=·sanitize_text_field($_POST['wodgc_c_ex_product_ids']);
718: ····$cProductCatIds··=·sanitize_text_field($_POST['wodgc_c_product_cat_ids']);
719: ····$cProductExCatIds=·sanitize_text_field($_POST['wodgc_c_product_ex_cat_ids']);


--------------------------
LINE 718: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
716: ····$cProductIds·····=·sanitize_text_field($_POST['wodgc_c_product_ids']);
717: ····$cExProductIds···=·sanitize_text_field($_POST['wodgc_c_ex_product_ids']);
>> 718: ····$cProductCatIds··=·sanitize_text_field($_POST['wodgc_c_product_cat_ids']);
719: ····$cProductExCatIds=·sanitize_text_field($_POST['wodgc_c_product_ex_cat_ids']);
720: ····$cAllowedEmails··=·sanitize_text_field($_POST['wodgc_c_allowed_emails']);


--------------------------
LINE 719: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
717: ····$cExProductIds···=·sanitize_text_field($_POST['wodgc_c_ex_product_ids']);
718: ····$cProductCatIds··=·sanitize_text_field($_POST['wodgc_c_product_cat_ids']);
>> 719: ····$cProductExCatIds=·sanitize_text_field($_POST['wodgc_c_product_ex_cat_ids']);
720: ····$cAllowedEmails··=·sanitize_text_field($_POST['wodgc_c_allowed_emails']);
721:


--------------------------
LINE 720: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
718: ····$cProductCatIds··=·sanitize_text_field($_POST['wodgc_c_product_cat_ids']);
719: ····$cProductExCatIds=·sanitize_text_field($_POST['wodgc_c_product_ex_cat_ids']);
>> 720: ····$cAllowedEmails··=·sanitize_text_field($_POST['wodgc_c_allowed_emails']);
721:
722:


--------------------------
LINE 723: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
721:
722:
>> 723: ····$expiryDateNumber·=·sanitize_text_field($_POST['gift_card_expiry_date']);
724: ····$expiryDateType·=·sanitize_text_field($_POST['gift_card_expiry_date_type']);
725: ····$pdfStyle·=·sanitize_text_field($_POST['wodgc_pdf_style_template']);·//·555555555··|·$meta_data·=·get_post_meta(·$productId,·'gift_card_pdf',·true·);


--------------------------
LINE 724: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
722:
723: ····$expiryDateNumber·=·sanitize_text_field($_POST['gift_card_expiry_date']);
>> 724: ····$expiryDateType·=·sanitize_text_field($_POST['gift_card_expiry_date_type']);
725: ····$pdfStyle·=·sanitize_text_field($_POST['wodgc_pdf_style_template']);·//·555555555··|·$meta_data·=·get_post_meta(·$productId,·'gift_card_pdf',·true·);
726: ····$couponDisType·=·sanitize_text_field($_POST['wodgc_discount_type']);·


--------------------------
LINE 725: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
723: ····$expiryDateNumber·=·sanitize_text_field($_POST['gift_card_expiry_date']);
724: ····$expiryDateType·=·sanitize_text_field($_POST['gift_card_expiry_date_type']);
>> 725: ····$pdfStyle·=·sanitize_text_field($_POST['wodgc_pdf_style_template']);·//·555555555··|·$meta_data·=·get_post_meta(·$productId,·'gift_card_pdf',·true·);
726: ····$couponDisType·=·sanitize_text_field($_POST['wodgc_discount_type']);·
727:


--------------------------
LINE 726: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
724: ····$expiryDateType·=·sanitize_text_field($_POST['gift_card_expiry_date_type']);
725: ····$pdfStyle·=·sanitize_text_field($_POST['wodgc_pdf_style_template']);·//·555555555··|·$meta_data·=·get_post_meta(·$productId,·'gift_card_pdf',·true·);
>> 726: ····$couponDisType·=·sanitize_text_field($_POST['wodgc_discount_type']);·
727:
728:


--------------------------
LINE 729: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
727:
728:
>> 729: ····$leftStyle=·sanitize_text_field($_POST['wodgc_style_template']);
730: ····$emlStyle·=·sanitize_text_field($_POST['wodgc_email_template']);
731: ····$imgTabs··=·sanitize_text_field($_POST['wodgc_tab_images']);


--------------------------
LINE 730: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
728:
729: ····$leftStyle=·sanitize_text_field($_POST['wodgc_style_template']);
>> 730: ····$emlStyle·=·sanitize_text_field($_POST['wodgc_email_template']);
731: ····$imgTabs··=·sanitize_text_field($_POST['wodgc_tab_images']);
732:


--------------------------
LINE 731: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
729: ····$leftStyle=·sanitize_text_field($_POST['wodgc_style_template']);
730: ····$emlStyle·=·sanitize_text_field($_POST['wodgc_email_template']);
>> 731: ····$imgTabs··=·sanitize_text_field($_POST['wodgc_tab_images']);
732:
733: ····$wc_g_img·=·isset($_POST['gift_card_enable_product_gallery_img'])·?·'true'·:·'';


--------------------------
LINE 733: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
731: ····$imgTabs··=·sanitize_text_field($_POST['wodgc_tab_images']);
732:
>> 733: ····$wc_g_img·=·isset($_POST['gift_card_enable_product_gallery_img'])·?·'true'·:·'';
734: ····$wc_coupon=·isset($_POST['gift_card_no_enable_as_coupon'])·?·'true'·:·'';
735: ····$gc_edit··=·isset($_POST['wodgc_disable_edit_card'])·?·'true'·:·'';


--------------------------
LINE 734: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
732:
733: ····$wc_g_img·=·isset($_POST['gift_card_enable_product_gallery_img'])·?·'true'·:·'';
>> 734: ····$wc_coupon=·isset($_POST['gift_card_no_enable_as_coupon'])·?·'true'·:·'';
735: ····$gc_edit··=·isset($_POST['wodgc_disable_edit_card'])·?·'true'·:·'';
736: ····$wc_gallery_img·=·isset($_POST['gift_card_product_gallery_img'])·?·'true'·:·'';


--------------------------
LINE 735: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
733: ····$wc_g_img·=·isset($_POST['gift_card_enable_product_gallery_img'])·?·'true'·:·'';
734: ····$wc_coupon=·isset($_POST['gift_card_no_enable_as_coupon'])·?·'true'·:·'';
>> 735: ····$gc_edit··=·isset($_POST['wodgc_disable_edit_card'])·?·'true'·:·'';
736: ····$wc_gallery_img·=·isset($_POST['gift_card_product_gallery_img'])·?·'true'·:·'';
737: ····$wc_fetcher_img·=·isset($_POST['gift_card_product_fetcher_img'])·?·'true'·:·'';


--------------------------
LINE 736: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
734: ····$wc_coupon=·isset($_POST['gift_card_no_enable_as_coupon'])·?·'true'·:·'';
735: ····$gc_edit··=·isset($_POST['wodgc_disable_edit_card'])·?·'true'·:·'';
>> 736: ····$wc_gallery_img·=·isset($_POST['gift_card_product_gallery_img'])·?·'true'·:·'';
737: ····$wc_fetcher_img·=·isset($_POST['gift_card_product_fetcher_img'])·?·'true'·:·'';
738: ····$user_upload_img·=·isset($_POST['gift_card_enable_user_upload_img'])·?·'true'·:·'';


--------------------------
LINE 737: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
735: ····$gc_edit··=·isset($_POST['wodgc_disable_edit_card'])·?·'true'·:·'';
736: ····$wc_gallery_img·=·isset($_POST['gift_card_product_gallery_img'])·?·'true'·:·'';
>> 737: ····$wc_fetcher_img·=·isset($_POST['gift_card_product_fetcher_img'])·?·'true'·:·'';
738: ····$user_upload_img·=·isset($_POST['gift_card_enable_user_upload_img'])·?·'true'·:·'';
739: ····$giftCardNo·=·isset($_POST['gift_card_number_show'])·?·'true'·:·'';


--------------------------
LINE 738: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
736: ····$wc_gallery_img·=·isset($_POST['gift_card_product_gallery_img'])·?·'true'·:·'';
737: ····$wc_fetcher_img·=·isset($_POST['gift_card_product_fetcher_img'])·?·'true'·:·'';
>> 738: ····$user_upload_img·=·isset($_POST['gift_card_enable_user_upload_img'])·?·'true'·:·'';
739: ····$giftCardNo·=·isset($_POST['gift_card_number_show'])·?·'true'·:·'';
740:


--------------------------
LINE 739: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
737: ····$wc_fetcher_img·=·isset($_POST['gift_card_product_fetcher_img'])·?·'true'·:·'';
738: ····$user_upload_img·=·isset($_POST['gift_card_enable_user_upload_img'])·?·'true'·:·'';
>> 739: ····$giftCardNo·=·isset($_POST['gift_card_number_show'])·?·'true'·:·'';
740:
741: ····$couponShipping=·isset($_POST['wodgc_free_shipping'])·?·'true'·:·'false';


--------------------------
LINE 741: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
739: ····$giftCardNo·=·isset($_POST['gift_card_number_show'])·?·'true'·:·'';
740:
>> 741: ····$couponShipping=·isset($_POST['wodgc_free_shipping'])·?·'true'·:·'false';
742: ····$couponUse·····=·isset($_POST['wodgc_individual_use'])·?·'true'·:·'false';
743: ····$couponESItems·=·isset($_POST['wodgc_exclude_sale_items'])·?·'true'·:·'false';


--------------------------
LINE 742: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
740:
741: ····$couponShipping=·isset($_POST['wodgc_free_shipping'])·?·'true'·:·'false';
>> 742: ····$couponUse·····=·isset($_POST['wodgc_individual_use'])·?·'true'·:·'false';
743: ····$couponESItems·=·isset($_POST['wodgc_exclude_sale_items'])·?·'true'·:·'false';
744: ····$sendEmail·····=·isset($_POST['wodgc_send_email'])·?·'true'·:·'false';


--------------------------
LINE 743: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
741: ····$couponShipping=·isset($_POST['wodgc_free_shipping'])·?·'true'·:·'false';
742: ····$couponUse·····=·isset($_POST['wodgc_individual_use'])·?·'true'·:·'false';
>> 743: ····$couponESItems·=·isset($_POST['wodgc_exclude_sale_items'])·?·'true'·:·'false';
744: ····$sendEmail·····=·isset($_POST['wodgc_send_email'])·?·'true'·:·'false';
745: ····$sendEmailEna··=·$_POST['gift_card_send_email_enable'];


--------------------------
LINE 744: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
742: ····$couponUse·····=·isset($_POST['wodgc_individual_use'])·?·'true'·:·'false';
743: ····$couponESItems·=·isset($_POST['wodgc_exclude_sale_items'])·?·'true'·:·'false';
>> 744: ····$sendEmail·····=·isset($_POST['wodgc_send_email'])·?·'true'·:·'false';
745: ····$sendEmailEna··=·$_POST['gift_card_send_email_enable'];
746:


--------------------------
LINE 745: ERROR Processing form data without nonce verification.
(WordPress.Security.NonceVerification.Missing)


--------------------------
743: ····$couponESItems·=·isset($_POST['wodgc_exclude_sale_items'])·?·'true'·:·'false';
744: ····$sendEmail·····=·isset($_POST['wodgc_send_email'])·?·'true'·:·'false';
>> 745: ····$sendEmailEna··=·$_POST['gift_card_send_email_enable'];
746:
747: ····if(·!empty($wc_field)){


--------------------------

----------------------------------------------

Please note that due to the significant effort this reviews require, we are doing basic reviews the first time we review your plugin. Once the issues we shared above are fixed, we will do a more in-depth review that might surface other issues.

We recommend that you get ahead of us by checking for some common issues that require a more thorough review such as the use of nonces or determining plugin and content directories correctly.

Your next steps are:

Make all the corrections related to the issues we listed.
Review your entire code following best practices and the guidelines to ensure there are no other related issues.
Go to "Add your plugin" and upload an updated version of this plugin. You can update the code there whenever you need to along the review process, we will check the latest version.
Reply to this email telling us that you have updated it and letting us know if there is anything we need to know or have in mind. It is not necessary to list the changes, as we will check the whole plugin again.

To make this process as quick as possible and to avoid burden on the volunteers devoting their time to review this plugin's code, we ask you to thoroughly check all shared issues and fix them before sending the code back to us.

We encourage all plugin authors to use tools like Plugin Check to ensure that most basic issues are fixed first. If you haven't used it yet, give it a try, it will save us both time and speed up the review process.
Please note: Automated tools can give false positives, or may miss issues. Plugin Check and other tools cannot guarantee that our reviewers won't find an issue that needs fixing or clarification.

We again remind you that should you wish to alter your permalink (not the display name, the plugin slug), you must explicitly tell us what you want it to be. We require to you clearly state in the body of your email what your desired permalink is. Permalinks cannot be altered after approval, and we generally do not accept requests to rename should you fail to inform us during the review. If you previously asked for a permalink change and got a reply that is has been processed, you're all good! While these emails will still use the original display name, you don't need to panic. If you did not get a reply that we processed the permalink, let us know immediately.

While we have tried to make this review as exhaustive as possible we, like you, are humans and may have missed things. As such, we will re-review the entire plugin when you send it back to us. We appreciate your patience and understanding.

If the corrections we requested in this initial review are not completed within 3 months (90 days), we will reject this submission in order to keep our queue manageable.

If you have questions, concerns, or need clarification, please reply to this email and just ask us.


--
WordPress Plugin Review Team | plugins@wordpress.org
https://make.wordpress.org/plugins/
https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/

{#HS:2568534196-484413#} 
On Tue, May 28, 2024 at 11:05 AM UTC, WooXperto <support@wooxperto.com> wrote:
Dear WordPress Plugin Review Team,


*/


