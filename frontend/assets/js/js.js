function wodgcCustomPriceEnable(data){
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent();
    jQuery(parent).find("input[name=gift_card_default_price]:checked").prop("checked",false);
    jQuery(data).removeAttr("readonly");
    jQuery(parent).find(".gift-card-amount-error").html("<p>Vinsamlegast sláið inn upphæðina sem þið viljið gefa</p>");
}

function wodgcCustomPriceChange(data){
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent();
    let price=jQuery(data).val();
    let min=jQuery(data).attr("data-min");
    if(parseInt(price)<parseInt(min)){
        jQuery(data).addClass("error");
        jQuery(parent).find(".gift-card-amount-error").html("<p>Custom amount should be greater than minimum amount</p>");
        jQuery(parent).find(".single_add_to_cart_button").prop("disabled",true);
        wodgcAmountShow(parent,min);
    }else{
        jQuery(parent).find(".gift-card-amount-error").html("");
        jQuery(parent).find(".single_add_to_cart_button").prop("disabled",false);
        wodgcAmountShow(parent,price);
    }

    
}

function wodgcDefaultPrice(data){
    // let parent = jQuery(data).parent().parent().parent().parent().parent().parent();
    let parent = jQuery(data).parent().parent().parent().parent();
    let price  = jQuery(data).val();
    wodgcAmountShow(parent,price);
    jQuery(parent).find("input[name=custom_price]").val("");
    jQuery(parent).find("input[name=custom_price]").attr("readonly",true);
}

function wodgcAmountShow(parent,amount){
    jQuery(parent).find("input[name=gift_card_amount]").val(amount);
    let value = accounting.formatMoney(amount, {
        symbol: 'kr.',
        decimal: ',',
        thousand: '.',
        precision: '0',
        format: '%v %s'
      });
      jQuery(parent).find(".gift_card_value").html(value);  
}

function wodgcMessagePreview(data){
    //var message = jQuery(data).val();
    var message = data.value;
    //message = jQuery.parseHTML( message.replace(/(<([^>]+)>)/gi, "").replace(/\n/g, '<br/>') );
    data.closest(".entry-summary").previousElementSibling.querySelector(".gift_card_message_text").innerHTML=message.replace(/(<([^>]+)>)/gi, "").replace(/\n/g, '<br/>');
}

// custom amount focus
function wodgcCustomAmountFocus(data){
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent();
    let price  = parseInt(jQuery(data).val());
    let min    = parseInt(jQuery(data).attr("data-min"));
    if(price>0){
        if(price<min){
            jQuery(parent).find("input[name=gift_card_default_price].gift_card_default_amount").prop("checked",true);
            wodgcAmountShow(parent,min);
            jQuery(data).val("");
            jQuery(data).attr("readonly",true); 
            jQuery(parent).find(".gift-card-amount-error").html("");
            jQuery(parent).find(".single_add_to_cart_button").prop("disabled",false);
        }
    }else{
        jQuery(parent).find("input[name=gift_card_default_price].gift_card_default_amount").prop("checked",true);
        jQuery(data).val("");
        jQuery(data).attr("readonly",true);
        jQuery(parent).find(".gift-card-amount-error").html("");
        jQuery(parent).find(".single_add_to_cart_button").prop("disabled",false);
    }
}

function wodgcSelectThisGiftCardImage(data){
    
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent();

    jQuery(parent).find("img.active").removeClass("active");
    let img = jQuery(data).attr("src");
    let cls=jQuery(data).attr("data-class");
    jQuery(data).addClass("active");

    jQuery(parent).find("img.gift_card_image").attr("src",img);
    jQuery(parent).find("input[name=gift_card_image]").val(img); // set hidden input value for add to cart
    data.closest(".select_image_for_cart").previousElementSibling.querySelector(".gift_card_image").src=img;
}

function wodgcOpenImgCat(data, evt, cityName) {
    jQuery(data).parent().find('.active').removeClass("active");
    jQuery(data).addClass("active");

    jQuery(data).parent().parent().parent().find('div.tabcontent').hide();
    jQuery(data).parent().parent().parent().find('div.'+cityName+'').show();
}


jQuery(document).ready(function() {

    jQuery('.srDate').datetimepicker();
    
    jQuery(window).on('load', function() {
        jQuery('li img.active').trigger('click');
    });

});
  

function wodgcDeliveryDate(data) {
    let parent = jQuery(data).parent().parent().parent().parent().parent().parent().parent().parent().parent();
    var wodgcDeliveryDate = jQuery(data).val();
    jQuery(parent).find('._Date').text(wodgcDeliveryDate.split("-").reverse().join("/"));
}

function wodgcToggleDateDiv(checkbox) {
    if(checkbox.checked == true){
        checkbox.closest(".wodgcToggleDateDivClass").nextElementSibling.style.display='block';
    }else{
        checkbox.closest(".wodgcToggleDateDivClass").nextElementSibling.style.display='none';
   }
}





// console.log('localStorageVariable = = '+gcAjax.localStVal);

var gparent='';
let localStVar = gcAjax.localStVal;

let oldImages=localStorage.getItem(localStVar);
if(oldImages){
    var images =JSON.parse(oldImages);
}else{
    var images =[];
}


jQuery(document).on('click', '.upload-aphoto', function () {

    gparent= jQuery(this).parent().parent().parent().parent().parent();
    //document.getElementById('selectedFile').click();
    jQuery(gparent).find("input.selectedFile").click();

    let mainId = jQuery(gparent).attr("id");

    // console.log(gparent+'Product Id === ' + mainId);

        
});



let croppi;

// Crop image function
jQuery(document).on('click', '.save-modal', function(ev) {

    jQuery('.modal-crop-img-wrap').block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });
    // jQuery('.modal-crop-img-wrap').unblock();

    croppi.croppie('result', {

        type: 'base64',
        format: 'jpeg',
        // size: 'original'
        size: {
            width: 1000,
            height: 800
        }

    })
    .then(function (resp) {
        
        // WP Ajax Call with submit function
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: gcAjax.ajaxurl,
            data: {
                action: 'wodgc_img_upload_wp_media',
                image: resp
                
            },
            success: function(response) { 
                
                if ( ! response || response.error ) return; 
                
                jQuery('.modal-crop-img-wrap').unblock();
                let sNo = jQuery(gparent).attr("id");

                let cardImg = {
                    url: response.data,
                    s_no: sNo,
                };
                if(images.length>0){
                    let oldImage=images.find(u => u.s_no === sNo);
                    if(oldImage){
                        oldImage.url=response.data;
                    }else{
                        images.push(cardImg);
                    }
                    /*let push = true;
                    images.map((item,index)=>{
                        if(item.s_no===sNo){
                            images[index].url=response.data;
                            push = false;
                        }
                    });

                    if(push)images.push(cardImg);*/

                }else{
                    images.push(cardImg);
                }
                // console.log(images);
                const imagesJSON = JSON.stringify(images);
                localStorage.setItem(localStVar, imagesJSON);

                // Get local storage img
                const imgLocalStorage = localStorage.getItem(localStVar);
                const imageAll = JSON.parse(imgLocalStorage);

                const singleImg = imageAll.find(u => u.s_no === sNo);

                // console.log('id =xx= ' + singleImg);
                if(singleImg)jQuery(gparent).find("img.confirm-img").attr('src', singleImg.url);
                
                // jQuery(gparent).find("img.confirm-img").attr('src', singleImg.url);
                // console.log(gparent);
                // console.log(singleImg.url);
                
                jQuery('#imageModalContainer').hide('fast', wodgc_croppi_destroy);
                jQuery(gparent).find("img.confirm-img").click();
            }
        });

    });
});

    

// start Crop image
jQuery(document).on('click', '.upload_my_img', function () {
    // console.log('localStorageVariable = = '+gcAjax.localStVal);

    let localStVar = gcAjax.localStVal;

    let oldImages=localStorage.getItem(localStVar);
    if(oldImages){
        var images =JSON.parse(oldImages);
    }else{
        var images =[];
    }


    let uploadImgBtn = jQuery(this).parent().parent().parent();
    //document.getElementById('selectedFile').click();
    let serialNo = jQuery(uploadImgBtn).attr("id");
    // console.log(serialNo);

    // Get local storage img
    const imgAll = images;
    //console.log(imgAll);
    if(imgAll.length>0){
        const sImg = imgAll.find(u => u.s_no === serialNo);

        // console.log(sImg);
        
        if(sImg.s_no === serialNo){
            jQuery(uploadImgBtn).find("img.confirm-img").attr('src', sImg.url);
            // console.log(sImg.url);
        } else {
            jQuery(uploadImgBtn).find("img.confirm-img").attr('src', '');
        }

    }else{
        jQuery(uploadImgBtn).find("img.confirm-img").attr('src', '');
    }
    
});




function wodgc_user_upload_img_shown_in_popup(){
    jQuery('.uploadGiftImg').find("input.selectedFile").click();
}


function wodgc_file_change(data) {
    if (data.files[0]==undefined) return;
    jQuery('#imageModalContainer').show('fast', wodgc_modal_shown);
    let reader=new FileReader();

    reader.addEventListener("load", function () {
            window.src=reader.result;
            jQuery(gparent).find("input.selectedFile").val('');



        }, false);

    if (data.files[0]) {
        reader.readAsDataURL(data.files[0]);
    }
}

// let croppi;

function wodgc_modal_shown() {
    let width=document.getElementById('crop-image-container').offsetWidth - 20;
    jQuery('#crop-image-container').height((width - 80) + 'px');

    croppi=jQuery('#crop-image-container').croppie( {
            viewport: {
                width: 300, // width
                height: 240
            },
        }
    );
    jQuery('.modal-body1').height(document.getElementById('crop-image-container').offsetHeight + 50 + 'px');

    croppi.croppie('bind', {
            url: window.src,
        }

    ).then(function () {
            croppi.croppie('setZoom', 0);
        }

    );
}

jQuery('#imageModalContainer').on('hidden.bs.modal', function() {});

function wodgc_croppi_destroy() {
    croppi.croppie('destroy');
}


// jQuery(".closeCrop").click(function() {
//     console.log('clicked Now...');
    
//     jQuery('#imageModalContainer').hide('fast', wodgc_croppi_destroy);
// });

jQuery(document).on('click', '.closeCrop', function() {
    
    jQuery('#imageModalContainer').hide('fast', wodgc_croppi_destroy);

});



function wodgc_cart_page_popup_open_action(index){
   
    jQuery("#wodgc_"+index).addClass('model-open');
}

jQuery(document).on("click", ".close-btn, .bg-overlay, .cancel-btn", function () {
    jQuery(".popup-model-main").removeClass('model-open');
});



jQuery(document).on("change","label.sms_email",function(){
    let parent = jQuery(this).parent().parent();
    // let value = jQuery(parent).find("input[name=send_recipient]:checked").val();
    let value = jQuery(parent).find("input[type=radio]:checked").val();
    //console.log(value);
    if(value == 1){ // email required
        jQuery(parent).find("span.phone_required").addClass("hidden");
        jQuery(parent).find("span.email_required").removeClass("hidden");
        jQuery(parent).find('.gift_card_phone_span').html('');
    }else if(value == 2){ // phone required
        jQuery(parent).find("span.phone_required").removeClass("hidden");
        jQuery(parent).find("span.email_required").addClass("hidden");
        jQuery(parent).find('.gift_card_recipient_email_span').html('');
    }else{
        jQuery(parent).find("span.phone_required").removeClass("hidden");
        jQuery(parent).find("span.email_required").removeClass("hidden");
    }
});




function wodgcValidEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
}


// ajax for Cart page popup with onclick='wodgc_cart_popup_update_btn()'
function wodgc_cart_popup_update_btn(cartKey,data) {
    // let popup = jQuery(".pop-up-content-wrap");
    
    let gift_card_info_form = [];
    let giftCardInfoFrom=jQuery(data).attr("data-form");

    // console.log(gcInfoF);
    // console.log('aaaaaaaa  '+gcInfoF);
    
    let info_form = [];
    if (giftCardInfoFrom.length>0) {

        let infoFrom = JSON.parse(giftCardInfoFrom);
        // console.log(typeof infoFrom);

        for (let info = 0; info < infoFrom.length; info++) {
            let element = infoFrom[info];  

            if(element.element === 'select'){
                let elementval = jQuery("#wodgc_"+cartKey).find('[name="'+element.id+'"] option:selected').val().trim();
                let nameVal    = {
                                    'nameKey' : element.id,
                                    'nameVal' : elementval,
                                    'nameLabel' : element.label
                                 };
                info_form.push(nameVal);
                
            }
            else{
                let elementval = jQuery("#wodgc_"+cartKey).find('[name="'+element.id+'"]').val().trim();
                let nameVal    = {
                                    'nameKey' : element.id,
                                    'nameVal' : elementval,
                                    'nameLabel' : element.label
                                 };
        
                info_form.push(nameVal);
            }

        }
    }
    // console.log(info_form);
    gift_card_info_form[0] = JSON.stringify(info_form);
    // email & phone vallidation end






    // WP Ajax Call with submit function
    jQuery("#"+cartKey).find('#sms').html(`<h3><span class='loding'>Í vinnslu... </span></h3>`);
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url:  gcAjax.ajaxurl,
        data: {
            action: 'wodgc_in_cart_page_popup_update_data',
            gift_card_info_form: gift_card_info_form,
            cartItemKey: cartKey,
            
        },
        success: function(response) { 
            if ( ! response || response.error ) return;
            jQuery("#"+cartKey).find('#sms').html(` `);
            if(response.status == 'ok') { 
                jQuery("#"+cartKey).find('#sms').html(`${response.messages}`);
                jQuery(".popup-model-main").removeClass('model-open');
                // jQuery('from.woocommerce-cart-form')[0].submit();
                jQuery('button[name="update_cart"]').click();
                location.reload(true);
                // console.log('xxxxxx');
                
            } else { 
                jQuery("#"+cartKey).find('#sms').html(`<p class='error'>Some problam</p>`);
            }

        }
    });


}













// gift-card-single-product-content.php

jQuery(document).on("change","label.send_mail_sms",function(){
    let parent = jQuery(this).parent().parent();
    let value = jQuery(parent).find("input[name=send_mail_to_recipient]:checked").val();
    //console.log(value);
    if(value == 1){ // email required
        jQuery(parent).find("span.phone_required").addClass("hidden");
        jQuery(parent).find("span.email_required").removeClass("hidden");
        jQuery(parent).find('.gift_card_phone_span').html('');
    }else if(value == 2){ // phone required
        jQuery(parent).find("span.phone_required").removeClass("hidden");
        jQuery(parent).find("span.email_required").addClass("hidden");
        jQuery(parent).find('.gift_card_recipient_email_span').html('');
    }else{
        jQuery(parent).find("span.phone_required").removeClass("hidden");
        jQuery(parent).find("span.email_required").removeClass("hidden");
    }
});

jQuery(document).ready(function(){

    function wodgcRemoveLastWord(str) {
        const lastIndexOfSpace = str.lastIndexOf(' ');
        if (lastIndexOfSpace === -1) {
            return str;
        }
        return str.substring(0, lastIndexOfSpace);
    }

    jQuery( function() {
        jQuery( "#accordion" ).accordion();
    } );
    
    jQuery('#cloneProduct').click(function(){
    
        var $divHeader = jQuery('#accordion h3[id^="productHeader-"]:last');
        var $div = jQuery('div[id^="productGift-"]:last');
        var numH3 = parseInt( $divHeader.prop("id").match(/\d+/g), 10 ) +1;
        var $klonH3 = $divHeader.clone().prop('id', 'productHeader-'+numH3 );
        $div.after( $klonH3.html($divHeader.html()) );
    
        var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
        var $klon = $div.clone().prop('id', 'productGift-'+num );
        $klonH3.after( $klon.html($div.html()) );
    
    
        jQuery( "#accordion" ).accordion( "refresh" );
    
    });
    
    jQuery('#qtyGiftCard').change(function(){
    
        var qtyGiftCard = jQuery(this).val();
        var countProductSingleGift = jQuery('.product-single-gift').length;
    
        if(qtyGiftCard != countProductSingleGift && qtyGiftCard > 0){
            for(var i=0; i<countProductSingleGift-1;i++){
                
                var countProductSingleGiftTemp = jQuery('.product-single-gift').length;
                if(countProductSingleGiftTemp==1){
                    break;
                }
                var $divHeader = jQuery('#accordion h3[id^="productHeader-"]:last');
                // console.log($divHeader);
                var $div = jQuery('div[id^="productGift-"]:last');
                // console.log($div);
                $divHeader.remove();
                $div.remove();
    
            }
    
            for(var i=0; i<qtyGiftCard-1;i++){
    
                var $divHeader = jQuery('#accordion h3[id^="productHeader-"]:last');
                var $div = jQuery('div[id^="productGift-"]:last');
                var numH3 = parseInt( $divHeader.prop("id").match(/\d+/g), 10 ) +1;
                var $klonH3 = $divHeader.clone().prop('id', 'productHeader-'+numH3 );
                $div.after( $klonH3.html(wodgcRemoveLastWord($divHeader.html())+' -'+(i+2)) );
                $klonH3.removeClass('ui-accordion-header-active ui-state-active');
                $klonH3.css('color','#000');
    
                
    
                var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
                let new_id = 'productGift-'+num;
                var $klon = $div.clone().prop('id', new_id);
                let item_html = $klon.html($div.html());
    
                // local storage image url change here
    
                let imgLocalStorage = localStorage.getItem(localStVar);
                if(imgLocalStorage){
                    let imageAll = JSON.parse(imgLocalStorage);
    
                    // console.log("Show Image = "+imageAll);
                    let singleImg = imageAll.find(u => u.s_no === new_id);
                    if(singleImg){
                        jQuery(item_html).find("img.confirm-img").attr('src', singleImg.url);
                    }else{
                        jQuery(item_html).find("img.confirm-img").attr('src','');
                    }
                    
                }else{
                    jQuery(item_html).find("img.confirm-img").attr('src','');
                }

                //var $klon = $div.clone().prop('id', 'productGift-'+num );
                $klonH3.after( item_html );
            }
        }
        jQuery( "#accordion" ).accordion( "refresh" );
    });

    jQuery(".submitGiftCardFormBtn").click( function(e) {
        e.preventDefault(); 

        var product_id = [];
        var gift_card_image  = [];
        var gift_card_amount = [];
        let gift_card_info_form = [];
        
        var i = 0;
        var formError = 0;
        jQuery(".product-single-gift").each(function() {

            var myID =  jQuery(this).attr('id').match(/\d+/g);

            product_id[i]  =  jQuery(this).find('[name="product_id"]').val();
            
            gift_card_image[i]  =  jQuery(this).find('[name="gift_card_image"]').val();
            gift_card_amount[i] =  jQuery(this).find('[name="gift_card_amount"]').val();

            let info_form = [];
            if (gcAjax.infoFrom.length>0) {

                let infoFrom = JSON.parse(gcAjax.infoFrom);
                // let infoFrom = JSON.parse(giftCardInfoFrom);
                // console.log(typeof infoFrom);

                for (let info = 0; info < infoFrom.length; info++) {
                    let element = infoFrom[info];  

                    if(element.element === 'select'){
                        let elementval = jQuery(this).find('[name="'+element.id+'"] option:selected').val().trim();
                        let nameVal    = {
                                            'nameKey' : element.id,
                                            'nameVal' : elementval,
                                            'nameLabel' : element.label
                                         };
                        info_form.push(nameVal);
                        
                    }
                    else{
                        let elementval = jQuery(this).find('[name="'+element.id+'"]').val().trim();
                        let nameVal    = {
                                            'nameKey' : element.id,
                                            'nameVal' : elementval,
                                            'nameLabel' : element.label
                                         };
                
                        info_form.push(nameVal);
                    }

                }
            }
            // console.log(info_form);
            gift_card_info_form[i] = JSON.stringify(info_form);

            i++;

        });

        if(formError>0){
            return false;
        }
        else{
            jQuery("#submitGiftCardFormBtn").html('Í vinnslu').prop("disabled",true).css('background-color','gray');
            jQuery.ajax({
                type : "post",
                dataType : "json",
                url : gcAjax.ajaxurl,
                data : {
                    action: "wodgc_add_to_cart", 
                    product_id : product_id,
                    gift_card_image : gift_card_image,
                    gift_card_amount : gift_card_amount,
                    gift_card_info_form : gift_card_info_form
                },
                success: function(response) {
                    //console.log(response);
                    if(response.type == "success") {
                        jQuery("#submitGiftCardFormBtn").html('Vara bætt við í körfu').prop("disabled",true).css('background-color','gray');
                        //jQuery(".aUpdateCart").show();
                        window.location.replace(gcAjax.cartUrl);
                    }
                    else {
                        jQuery("#submitGiftCardFormBtn").html(' ').prop("disabled",false).css('background-color',' ');
                        jQuery("#submitGiftCardFormBtn").html('Add to cart').prop("disabled",false).css('background-color','red');
                        response.errorMessages.forEach(function callback(value, index) {
                            // console.log(value.errorText);
                            jQuery('#errorText').append('<span class="errorSpan">'+value.errorText+'</span><br/>');
                        });
                    }
                }
            })
        }
    })
});




// onclick='wodgc_giftCardInfo()'
function wodgc_giftCardInfo() {
    let cardNo = jQuery("input[name=gift-card-no").val();
    // WP Ajax Call with submit function
    jQuery('#wodgc_giftCardInfo_sms').html(`<b>Wait..</b> `);

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: gcAjax.ajaxurl,
        data: {
            action: 'wodgc_gift_card_info',
            card_no: cardNo
        },
        success: function(response) { 
            if ( !response || response.error ) return;

            jQuery('#wodgc_giftCardInfo_sms').html(` `);
            if(response.status == 'ok') {
                jQuery('#wodgc_giftCardInfo_sms').html(`${response.message}`);
                jQuery('#information_gift_cardard').html(`
                    
                    <div class="card_info_wrap">
                        <div class="card_info_left">
                            <div class="view_gift_info_right">
                                <p>Expire date: <b>${response.data.gift_card_expiry_date}</b></p>
                                <h5>$${response.data.gift_card_price}</h5>
                            </div>
                            <div class="view_gift_info_right">
                                <p>Card No: <b>${response.data.gift_card_no}</b></p>
                                <h5></h5>
                            </div>
                        </div>
                        <div class="card_info_right">
                            <img src="${response.data.gift_card_img}" alt="">
                        </div>
                    </div>

                `);
                // console.log(response.data);
            } else { 
                jQuery('#wodgc_giftCardInfo_sms').html(`<p class='error'>${response.message}</p>`);jQuery('#information_gift_cardard').html(`
                    
                    <div class="card_info_wrap">
                        <p class='error'> <b>${response.data}</b></p>
                    </div>

                `);
            }
        
        }
    });
}


// wodgc payment geteway script

// Ajax Call onclick='wodgc_input_gift_card_number()'
function wodgc_input_gift_card_number() {
    let cardNum = jQuery("input[name='gift_claim_card_number']").val();
    let cardPay = jQuery("input[name='pay_amount']").val();

    jQuery('#processingMessage').html(`Please wait we are processing ...`);
    jQuery('.dis-btn').html(`<button disabled class="btn-gift-claim" style="cursor: not-allowed;" type="button">Claim<span class="gift_loding">&#10044;</spa></button>`);

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: gcAjax.ajaxurl,
        data: {
            action: 'wodgc_thank_page_card_info_on_popup',
            card_num: cardNum,
            pay_amount: cardPay

        },
        success: function(response) { 
        
            jQuery('#processingMessage').html('');
            jQuery('.dis-btn').html(`<button onclick='wodgc_input_gift_card_number()' class="btn-gift-claim" type="button">Claim </button>`);
            // console.log(response);

            if(response.status == 'notok') {
                if(response.message == 'Unauthenticated'){

                        //if( is_user_logged_in() ) { }
                    jQuery('#processingMessage').html(`<p class="info">${response.html}</p>`);

                }else{
                    jQuery('#processingMessage').html(`<p class="info">${response.message}</p>`);
                    // location.reload();
                }
            } else {
                jQuery(".popup-model-main.for_open").addClass('model-open');
                
                // let obj = JSON.parse(response.html);
                // console.log(response.html);

                // jQuery('#claim-card-info').html(`${response.html}`);
                jQuery('#claim-card-info').html(`
                    <div class="card_info_wrap">
                        <div class="card_info_left">
                            <div class="view_gift_info_right">
                                <p>Expire date: <b>${response.data.gift_card_expiry_date}</b></p>
                                <p>Initial <b>$${response.data.gift_card_price}</b></p>
                            </div>
                            <div class="view_gift_info_right">
                                <p>Last Time Use: <b>${response.result.t_date_time}</b></p>
                                <p>Current Blanch: <b>${response.result.current_balance}</b></p>
                            </div>
                            <div class="view_gift_info_right">
                                <p>Card No: <b>${response.data.gift_card_no}</b></p>
                                <p>need to pay: <b>${response.pay}</b></p>
                            </div>

                            <div id="claimInfoMessage"></div>
                            <div class="gift-card-info">
                                <input type="hidden" id="initialAmount" name="initialAmount" value="${response.data.gift_card_price}">
                                <input type="hidden" id="cardid" name="cardid" value="${response.data.gift_card_no}">
                                <input type="hidden" name="cardBalance" value="${response.result.current_balance}">
                                <p>Enter payment amount</p>
                                <input class="gift-input" type="number" name="cardValue" value="" placeholder="Enter Claim Value">
                                <span class="dis-btn">
                                    <button type="button" onclick="wodgc_checkout_claim()" class="btn-gift-claim">Claim</button>
                                </span>
                            </div>
                        </div>
                        <div class="card_info_right">
                            <img src="${response.data.gift_card_img}" alt="">
                        </div>
                    </div>`);
            }
        }
    });
}

// Ajax Call with onclick='wodgc_checkout_claim()'
function wodgc_checkout_claim() {

    let initialAmount  = jQuery('.gift-card-info').find("input[name='initialAmount']").val();
    let cardEntryVal   = jQuery('.gift-card-info').find("input[name='cardValue']").val();
    let cardNum        = jQuery('.gift-card-info').find("input[name='cardid']").val();
    let currentBalance = jQuery('.gift-card-info').find("input[name='cardBalance']").val();

    let orderId  = gcAjax.thankOrderId;
    let price    = gcAjax.thankTotalPrice;
    let tprice   = parseInt(price);
    let entryVal = parseInt(cardEntryVal);
    // console.log(tprice);

    if(entryVal>0 && parseInt(currentBalance) >= entryVal &&  tprice >= entryVal ) {
        jQuery('#claimInfoMessage').html(`Please wait we are processing ...`);
        jQuery('.dis-btn').html(`<button onclick='wodgc_checkout_claim()' disabled class="btn-gift-claim" style="cursor: not-allowed;" type="button">Claim <span class="gift_loding">&#10044;</span></button>`);

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: gcAjax.ajaxurl,
            data: {
                action: 'wodgc_thanks_claim',
                card_val: cardEntryVal,
                card_bal: currentBalance,
                card_num: cardNum,
                amount: initialAmount,
                order_id: orderId
            },
            success: function(response) { 
                jQuery('#claimInfoMessage').html(``);

                if(response.status === 'notok'){
                    jQuery('#processingMessage').html(`<h2 style="color: red;">${response.message}</h2>`);
                    jQuery(".popup-model-main").removeClass('model-open');
                    jQuery('.dis-btn').html(`<button onclick='wodgc_input_gift_card_number()' class="Click-here" type="button">Claim</button>`);

                }else{
                    jQuery('.dis-btn').html(`<button onclick='wodgc_checkout_claim()' class="btn-gift-claim" type="button">Claim</button>`);
                    jQuery('#discount-val').html(`${response.html}`);
                    location.reload();
                }
                
            }
        });

    } else {
        jQuery('#claimInfoMessage').html(`Please input the correct amount`);
    }

}



function wodgcOpenTabImg(tabName) {
    let i;
    let x = document.getElementsByClassName("item-container");
  
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
      x[i].classList.remove("active");
      let button = document.getElementsByClassName("item-button")[i];
      button.classList.remove("active");
    }
    document.getElementById(tabName).style.display = "block";  
    
    // Add active class to the selected button and container
    var activeButton = document.querySelector(`button[onclick="wodgcOpenTabImg('${tabName}')"]`);
    activeButton.classList.add("active");
    document.getElementById(tabName).classList.add("active");
  
  }

