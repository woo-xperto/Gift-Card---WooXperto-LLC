
// jQuery(document).ready(function() {
    jQuery( "#giftCartSetting" ).sortable({
        update: function(event, ui) {

            let formElement  = jQuery(".gcol-1 input[name=gift_card_form]").val();
            let form_element = formElement ? JSON.parse(formElement) : [];


            let trs=jQuery("#giftCartSetting .form-element");
            let desiredOrder=[];
            jQuery(trs).each(function(index,elem){
                let oldIndex = jQuery(elem).attr("indexid");
                desiredOrder.push(parseInt(oldIndex));
            });

            var rearrangedArray = [];
            for (var i = 0; i < desiredOrder.length; i++) {
                rearrangedArray.push(form_element[desiredOrder[i]]);
            }

            // Using the spread operator s1
            form_element = [...rearrangedArray];

            // Using the slice() method s2
            // form_element = rearrangedArray.slice(0);

            // console.log('________________________');
            // console.log(form_element);
        

            const jsonString = JSON.stringify(form_element);
            jQuery(".gcol-1 input[name=gift_card_form]").val(jsonString);
            wodgc_form_display();


        }
    });
// });


    jQuery('.tab-menu li a').on('click', function () {
        let target = jQuery(this).attr('data-rel');
        jQuery('.tab-menu li a').removeClass('active');
        jQuery(this).addClass('active');
        jQuery("#" + target).fadeIn('slow').siblings(".tab-box").hide();
        return false;
    });

    // Popup javaScript
    jQuery(".Click-here").on('click', function () {
        // jQuery("#popup_des").html(jQuery(this).attr("data-des"));
        jQuery(".popup-model-main").addClass('model-open');
    });


    function clickHere(input) {
        if(input==='input') {
            jQuery("#popup_des").html(inputField);
            jQuery(".popup-model-main").addClass('model-open');
        } else if (input==='select') {
            jQuery("#popup_des").html(selectField);
            jQuery(".popup-model-main").addClass('model-open');
        } else if (input==='textArea') {
            jQuery("#popup_des").html(textArea);
            jQuery(".popup-model-main").addClass('model-open');
        } else {
            jQuery("#popup_des").html(`<i class="fa-solid fa-spinner fa-spin-pulse"></i>`);
            jQuery(".popup-model-main").removeClass('model-open');
        }
    }

    jQuery(".close-btn, .bg-overlay").click(function () {
        jQuery(".popup-model-main").removeClass('model-open');
    });


let inputField = `
    <h3>Label: <input class="input-data-label" name="label" type="text"></h3>
    <h3>Placeholder: <input class="input-data-pla" name="placeholder" type="text"></h3>
    <h3>Required: <input class="input-data-req" name="required" type="checkbox"></h3>
    <h3>Unique id: <b class="required">*</b> <input class="input-data-id" name="id" type="text"></h3>
    <h3>Type: <b class="required">*</b> 
        <select class="input-data-type" name="type">
            <option value="text" selected>Text</option>
            <option value="email">Email</option>
            <option value="number">Number</option>
            <option value="date">Date</option>
            <option value="time">Time</option>
        </select>
    </h3>
    <h3>Select One:
        <select class="input-data-sr" name="sr" onchange="wodgcSetInputType()">
            <option value="" selected></option>
            <option value="send-date-time">Send dateTime</option>
            <option value="sender-name">Sender name</option>
            <option value="sender-email">Sender Email</option>
            <option value="sender-phone">Sender Phone</option>
            <option value="recipient-name">Recipient Name</option>
            <option value="recipient-email">Recipient Email</option>
            <option value="recipient-phone">Recipient Phone</option>
        </select>
    </h3>
    <h3><button type="button" onclick="wodgc_add_input_field(type='inputField')">Save</button></h3>
`;

let selectField = `
    <h3>Label: <input class="select-data-label" name="label" type="text"></h3>
    <h3>Placeholder: <input class="select-data-pla" name="placeholder" type="text"></h3>
    <h3>Options : 
        <textarea class="select-data-opt" name="options" rows="4" cols="30">Enter option by comma.
        </textarea>
    </h3>
    <h3>Required: <input class="select-data-req" name="required" type="checkbox"></h3>
    <h3>Unique id: <b class="required">*</b> <input class="select-data-id" name="id" type="text"></h3>
    <h3><button type="button" onclick="wodgc_add_input_field(type='selectField')" >Save</button></h3>
`;

let textArea = `
    <h3>Label: <input class="text-data-label" name="label" type="text"></h3>
    <h3>Placeholder: <input class="text-data-pla" name="placeholder" type="text"></h3>
    <h3>Required: <input class="text-data-req" name="required" type="checkbox"></h3>
    <h3>Unique id: <b class="required">*</b> <input class="text-data-id" name="id" type="text"></h3>
    <h3><button type="button" onclick="wodgc_add_input_field(type='textArea')">Save</button></h3>
`;

let pdfStyle1 = `
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr>
			<td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top">
				<table cellspacing="0" cellpadding="0" width="100%" align="center" style="margin-bottom:30px">
					<tr>
						<td align="center"><img src="<?php echo plugin_dir_url(__FILE__) . 'images/PDF-Wooxperto.png'; ?>" height="70" ></td>
					</tr>
				</table>

				<table cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td style="text-align:center;">
							{gift_card_img}
						</td>
					</tr>
				</table>


				<table cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top:10px;">
					<tr>
						<td width="100%" style="background-color:#ffffff; padding:50px;border: 2px solid #014189;" valign="top">
							<div style="width:100%;">
								<table cellpadding="0" cellspacing="0" width="100%" style="margin-top: -44px">
									<tr>
										<td style="width:60%;" valign="top">
											<p style="font-size: 16px;">Dagsetning: {gift_card_send_date}</p>
											<p style="font-size: 16px;">Expiry Date: {gift_card_expiry_date}</p>
											<table style="width:100%;">
												<tr>
													<td>
														<div style="min-height:200px;">
															<p style="font-size: 16px;margin-top:-10px;">{gift_card_message}</p>
														</div>
														<div style="text-align:center;">
                                                            {bar_code}
															<p style="font-size: 16px;margin-top:0px;">Gift Card No: {gift_card_no}</p>
														</div>
													</td>
												</tr> 
											</table>
										</td>
										<td style="width:40%;vertical-align:top;" align="right">
											<p style="text-align: right; font-size:25px; font-weight: 700; color: #2C2E35;">{gift_card_amount}</p>
											{qr_code}
										</td>
									</tr>
								</table>
								
								
							</div>
						</td>
					</tr>               
				</table>

				<table width="100%" align="center" style="border-top:2px solid #43454B;margin-top:10px;">
					<tr>
						<td><p>Congratulations on your GiftToWallet gift card. Scan the QR code and get the gift card directly into an electronic wallet on your phone. Unfortunately, it is currently not possible to pay with a gift card in the GiftToWallet online store.</p></td>		
					</tr>
				</table>
						
			</td>
		</tr>
	</table>
`;
let pdfStyle2 = `
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr>
			<td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top">
				
				<table cellpadding="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td style="text-align:center;">
							{gift_card_img}
						</td>
					</tr>
				</table>


				<table cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top:10px;">
					<tr>
						<td width="100%" style="background-color:#ffffff; padding:50px;border: 2px solid #014189;" valign="top">
							<div style="width:100%;">
								<table cellpadding="0" cellspacing="0" width="100%" style="margin-top: -44px">
									<tr>
										<td style="width:60%;" valign="top">
											<p style="font-size: 16px;">Dagsetning: {gift_card_send_date}</p>
											<p style="font-size: 16px;">Expiry Date: {gift_card_expiry_date}</p>
											<table style="width:100%;">
												<tr>
													<td>
														<div style="min-height:200px;">
															<p style="font-size: 16px;margin-top:-10px;">{gift_card_message}</p>
														</div>
														<div style="text-align:center;">
                                                            {bar_code}
															<p style="font-size: 16px;margin-top:0px;">Gift Card No: {gift_card_no}</p>
														</div>
													</td>
												</tr> 
											</table>
										</td>
										<td style="width:40%;vertical-align:top;" align="right">
											<p style="text-align: right; font-size:25px; font-weight: 700; color: #2C2E35;">{gift_card_amount}</p>
											{qr_code}
										</td>
									</tr>
								</table>
								
								
							</div>
						</td>
					</tr>               
				</table>
						
			</td>
		</tr>
	</table>
`;
let pdfStyle3 = `
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr><td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top"><h2>PDF Style 3</h2></td></tr>
	</table>
`;
let pdfStyle4 = `
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr><td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top"><h2>PDF Style 4</h2></td></tr>
	</table>
`;
let pdfStyle5 = `
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr><td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top"><h2>PDF Style 5</h2></td></tr>
	</table>
`;
let pdfStyle6 = `
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr><td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top"><h2>PDF Style 6</h2></td></tr>
	</table>
`;
let pdfStyle7 = `
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr><td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top"><h2>PDF Style 7</h2></td></tr>
	</table>
`;
let pdfStyle8 = `
	<table cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr><td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top"><h2>PDF Style 8</h2></td></tr>
	</table>
`;
let imgSingleTab = `
    <div id="London" class="w3-container city">
        <b>Set Tab Name</b>
        <p><input type="text" id="tab_name" name="tabName" placeholder="Enter Tab/Category Name"></p>
        <b>Upload your image</b>
        <p><input type="file" id="file_name" name="imagesFile"></p>
        <div class="thisTabImgShow"></div>
    </div>
`;


let formElementSelect = `
    <div class="form-element">
        <h5 for="selected">Selected Field:</h5>
        <select id="selected" name="selected" placeholder="Selecte one"  required="on" >
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="fiat" selected="">Fiat</option>
            <option value="audi">Audi</option>
        </select>
    </div>
`;

let formElementMessage = `
    <div class="form-element">
        <h5 for="sms">Message here:</h5>
        <textarea id='sms' name="message" rows="4" >Write your message now </textarea>
    </div>
`;

let formElementText = `
    <div class="form-element">
        <h5 for="name">Name:</h5>
        <input type="text" name="name" id="name" placeholder="name" required="on" >
    </div>
`;

function wodgc_edit_input_field(input, indexNo) {
    let formElement  = jQuery(".gcol-1 input[name=gift_card_form]").val();
    let form_element = formElement ? JSON.parse(formElement) : []; // console.log(typeof form_element);
    let idUnique     = jQuery('.pop-up-content-wrap input[name=id]').val().trim();

    // Vallidation
    if(idUnique == '' || idUnique == null){
        jQuery(".pop-up-content-wrap input[name=id]").css('border-color','red');
        jQuery(".pop-up-content-wrap input[name=id]").parent().addClass('error');
        jQuery(".pop-up-content-wrap input[name=id]").focus();	
        jQuery(".pop-up-content-wrap input[name=id]").after(`<p class="error">Unique id is required</p>`);
        
        return false;
    }
    else{
        
        jQuery(".pop-up-content-wrap input[name=id]").parent().find('.error').remove();

        // form_element[indexNo].id = uniqueId;
        if(form_element[indexNo].id === idUnique){

            jQuery(".pop-up-content-wrap input[name=id]").css('border','0px');
            jQuery(".pop-up-content-wrap input[name=id]").parent().removeClass('error');
            jQuery(".pop-up-content-wrap input[name=id]").parent().find('.error').remove();

        } else {

            // Check unique id exists:
            const idExists = wodgcIsIdExists(form_element, idUnique ); // formElement

            if(idExists){

                jQuery(".pop-up-content-wrap input[name=id]").after(`<p class="error">Unique id "${idUnique }" is exists: ${idExists}</p>`);
                return false;

            } else {
                jQuery(".pop-up-content-wrap input[name=id]").css('border','0px');
                jQuery(".pop-up-content-wrap input[name=id]").parent().removeClass('error');
                jQuery(".pop-up-content-wrap input[name=id]").parent().find('.error').remove();
            }

        }

    }

    // update code here
    if(input==='inputField') {
        
        let label       = jQuery('.input-data-label').val().trim();
        let placeholder = jQuery('.input-data-pla').val().trim();
        let uniqueId    = jQuery('.input-data-id').val().trim();
        let type        = jQuery('.input-data-type').val().trim();

        let require = 'off';
        if(jQuery('.input-data-req').is(':checked')){
            require = "on";
        }

        console.log(require + "updaddddddd");
        
        let send_recive = jQuery('.input-data-sr').val().trim();
        /*
        let inputFieldData = {
            'element': 'input',
            'label': label,
            'placeholder': placeholder,
            'id': uniqueId,
            'type': type,
            'is_required':require,
            'display_order':0
        };
        */

        form_element[indexNo].label = label;
        form_element[indexNo].placeholder = placeholder;
        form_element[indexNo].id = uniqueId;
        form_element[indexNo].type = type;
        form_element[indexNo].is_required = require;
        form_element[indexNo].sr = send_recive;
        // form_element[indexNo].display_order = 0;
        // form_element.push(inputFieldData);

    } else if (input==='selectField') {

        let label       = jQuery('.select-data-label').val().trim();
        let placeholder = jQuery('.select-data-pla').val().trim();
        let uniqueId    = jQuery('.select-data-id').val().trim();
        let require = 'off';
        if(jQuery('.select-data-req').is(':checked')){
            require = "on";
        }
        let optionValue = jQuery('.select-data-opt').val().trim();
        let options     = optionValue.split(",");;
        /*
        let selectFieldData = {
            'element': 'select',
            'label': label,
            'placeholder': placeholder,
            'id': uniqueId,
            'is_required':require,
            'display_order':0,
            'options': options
        };
        */

        form_element[indexNo].label = label;
        form_element[indexNo].placeholder = placeholder;
        form_element[indexNo].id = uniqueId;
        form_element[indexNo].is_required = require;
        form_element[indexNo].options = options;
        // form_element.push(selectFieldData);

    } else if (input==='textArea') {
        
        let label       = jQuery('.text-data-label').val().trim();
        let placeholder = jQuery('.text-data-pla').val().trim();
        let uniqueId    = jQuery('.text-data-id').val().trim();
        // let require     = jQuery('.text-data-req').val().trim();
        let require = 'off';
        if(jQuery('.text-data-req').is(':checked')){
            require = "on";
        }
        /*
        let textAreaData = {
            'element': 'textarea',
            'label': label,
            'placeholder': placeholder,
            'id': uniqueId,
            'is_required':require,
            'display_order':0
        };
        */

        form_element[indexNo].label = label;
        form_element[indexNo].placeholder = placeholder;
        form_element[indexNo].id = uniqueId;
        form_element[indexNo].is_required = require;
        // form_element.push(textAreaData);

    } 

    const jsonString = JSON.stringify(form_element);
    jQuery(".gcol-1 input[name=gift_card_form]").val(jsonString);
    wodgc_form_display();

    jQuery(".popup-model-main").removeClass('model-open');

}

// let form_element= [];
// element
function wodgc_add_input_field(input) {

    let formElement  = jQuery(".gcol-1 input[name=gift_card_form]").val();
    let form_element = formElement ? JSON.parse(formElement) : []; // console.log(typeof form_element);
    let idUnique     = jQuery('.pop-up-content-wrap input[name=id]').val().trim();

    // Vallidation
    if(idUnique == '' || idUnique == null){
        jQuery(".pop-up-content-wrap input[name=id]").css('border-color','red');
        jQuery(".pop-up-content-wrap input[name=id]").parent().addClass('error');
        jQuery(".pop-up-content-wrap input[name=id]").focus();	
        jQuery(".pop-up-content-wrap input[name=id]").after(`<p class="error">Unique id is required</p>`);
        
        return false;
    }
    else{
        
        jQuery(".pop-up-content-wrap input[name=id]").parent().find('.error').remove();

        // Check unique id exists:
        const idExists = wodgcIsIdExists(form_element, idUnique ); // formElement

        if(idExists){

            jQuery(".pop-up-content-wrap input[name=id]").after(`<p class="error">Unique id "${idUnique }" is exists: ${idExists}</p>`);
            return false;

        } else {
            jQuery(".pop-up-content-wrap input[name=id]").css('border','0px');
            jQuery(".pop-up-content-wrap input[name=id]").parent().removeClass('error');
            jQuery(".pop-up-content-wrap input[name=id]").parent().find('.error').remove();
        }
    }


    if(input==='inputField') {
        
        let label       = jQuery('.input-data-label').val().trim();
        let placeholder = jQuery('.input-data-pla').val().trim();
        let uniqueId    = jQuery('.input-data-id').val().trim();
        let type        = jQuery('.input-data-type').val().trim();
        let require = 'off';
        if(jQuery('.input-data-req').is(':checked')){
            require = "on";
        }
        
        let send_recive = jQuery('.input-data-sr').val().trim();
        let inputFieldData = {
            'element': 'input',
            'label': label,
            'placeholder': placeholder,
            'id': uniqueId,
            'type': type,
            'is_required':require,
            'sr':send_recive,
            'display_order':0
        };

        form_element.push(inputFieldData);

    } else if (input==='selectField') {
        let label       = jQuery('.select-data-label').val().trim();
        // let element  = jQuery('.select-data-ele').val().trim();
        let placeholder = jQuery('.select-data-pla').val().trim();
        let uniqueId    = jQuery('.select-data-id').val().trim();
        let require = 'off';
        if(jQuery('.select-data-req').is(':checked')){
            require = "on";
        }
        let optionValue = jQuery('.select-data-opt').val().trim();
        let options     = optionValue.split(",");;
        let selectFieldData = {
            'element': 'select',
            'label': label,
            'placeholder': placeholder,
            'id': uniqueId,
            'is_required':require,
            'display_order':0,
            'options': options
        };

        form_element.push(selectFieldData);

    } else if (input==='textArea') {
        
        let label       = jQuery('.text-data-label').val().trim();
        // let element  = jQuery('.text-data-ele').val().trim();
        let placeholder = jQuery('.text-data-pla').val().trim();
        let uniqueId    = jQuery('.text-data-id').val().trim();
        let require = 'off';
        if(jQuery('.text-data-req').is(':checked')){
            require = "on";
        }
        let textAreaData = {
            'element': 'textarea',
            'label': label,
            'placeholder': placeholder,
            'id': uniqueId,
            'is_required':require,
            'display_order':0
        };

        form_element.push(textAreaData);

    }

    const jsonString = JSON.stringify(form_element);

    // const data = JSON.parse(jsonString);
    jQuery(".gcol-1 input[name=gift_card_form]").val(jsonString);
    
    wodgc_form_display();

    jQuery(".popup-model-main").removeClass('model-open');

    
}

// Function to check if the given id exists in the array
function wodgcIsIdExists(arr, id) {

    if(arr.length>0){
        for(const obj of arr){
            if(obj.id === id){
                return true; // The id exists in the array
            }
        }
    }
    return false; // The id does not exist in the array
}

// Delete Field onclick="wodgcDeleteField($indexNo)"
function wodgcDeleteField(indexNo){
    let formElement  = jQuery(".gcol-1 input[name=gift_card_form]").val();
    let form_element = formElement ? JSON.parse(formElement) : [];

    form_element.splice(indexNo, 1);

    const jsonString = JSON.stringify(form_element);
    jQuery(".gcol-1 input[name=gift_card_form]").val(jsonString);
    
    wodgc_form_display();

}

// Update Field onclick="wodgcEditField(${i})"
function wodgcEditField(indexNo){
    let formElement  = jQuery(".gcol-1 input[name=gift_card_form]").val();
    let form_element = formElement ? JSON.parse(formElement) : []; 

    // console.log( form_element);
    
    if(form_element[indexNo].element==='input') {
        jQuery("#popup_des").html(`
            <h3>Label: <input class="input-data-label" name="label" type="text" value="${form_element[indexNo].label}" ></h3>
            <h3>Placeholder: <input class="input-data-pla" name="placeholder" type="text" value="${form_element[indexNo].placeholder}" ></h3>
            <h3>Required: <input class="input-data-req" name="required" type="checkbox" ${(form_element[indexNo].is_required === "on") ? "checked" : ""} ></h3>
            <h3>Unique id: <b class="required">*</b> <input class="input-data-id" name="id" type="text" value="${form_element[indexNo].id}" ></h3>
            <h3>Type: <b class="required">*</b> 
                <select class="input-data-type" name="type">
                    <option value="text" ${(form_element[indexNo].type==='text') ? "selected" : ""} >Text</option>
                    <option value="email" ${(form_element[indexNo].type==='email') ? "selected" : ""} >Email</option>
                    <option value="number" ${(form_element[indexNo].type==='number') ? "selected" : ""} >Number</option>
                    <option value="date" ${(form_element[indexNo].type==='date') ? "selected" : ""} >Date</option>
                    <option value="time" ${(form_element[indexNo].type==='time') ? "selected" : ""} >Time</option>
                </select>
            </h3>
            <h3>Select One:
                <select class="input-data-sr" name="sr" onchange="wodgcSetInputType()">
                    <option value="" ${(form_element[indexNo].sr==='') ? "selected" : ""} ></option>
                    <option value="send-date-time" ${(form_element[indexNo].sr==='send-date-time') ? "selected" : ""} >Send dateTime</option>
                    <option value="sender-name" ${(form_element[indexNo].sr==='sender-name') ? "selected" : ""} >Sender name</option>
                    <option value="sender-email" ${(form_element[indexNo].sr==='sender-email') ? "selected" : ""} >Sender Email</option>
                    <option value="sender-phone" ${(form_element[indexNo].sr==='sender-phone') ? "selected" : ""} >Sender Phone</option>
                    <option value="recipient-name" ${(form_element[indexNo].sr==='recipient-name') ? "selected" : ""} >Recipient Name</option>
                    <option value="recipient-email" ${(form_element[indexNo].sr==='recipient-email') ? "selected" : ""} >Recipient Email</option>
                    <option value="recipient-phone" ${(form_element[indexNo].sr==='recipient-phone') ? "selected" : ""} >Recipient Phone</option>
                </select>
            </h3>
            <h3><button type="button" onclick="wodgc_edit_input_field(type='inputField', ${indexNo})">Update Field Now</button></h3>
        `);
        jQuery(".popup-model-main").addClass('model-open');

    } else if (form_element[indexNo].element==='select') {

        jQuery("#popup_des").html(`
            <h3>Label: <input class="select-data-label" name="label" type="text" value="${form_element[indexNo].label}" ></h3>
            <h3>Placeholder: <input class="select-data-pla" name="placeholder" type="text" value="${form_element[indexNo].placeholder}" ></h3>
            <h3>Options : 
                <textarea class="select-data-opt" name="options" rows="4" cols="30">${form_element[indexNo].options.join()}
                </textarea>
            </h3>
            <h3>Required: <input class="select-data-req" name="required" type="checkbox" ${(form_element[indexNo].is_required === "on") ? "checked" : ""}></h3>
            <h3>Unique id: <b class="required">*</b> <input class="select-data-id" name="id" type="text" value="${form_element[indexNo].id}" ></h3>
            <h3><button type="button" onclick="wodgc_edit_input_field(type='selectField', ${indexNo})" >Update Field Now</button></h3>
        `);
        jQuery(".popup-model-main").addClass('model-open');

    } else if (form_element[indexNo].element==='textarea') {

        jQuery("#popup_des").html( `
            <h3>Label: <input class="text-data-label" name="label" type="text" value="${form_element[indexNo].label}" ></h3>
            <h3>Placeholder: <input class="text-data-pla" name="placeholder" type="text" value="${form_element[indexNo].placeholder}" ></h3>
            <h3>Required: <input class="text-data-req" name="required" type="checkbox" ${(form_element[indexNo].is_required === "on") ? "checked" : ""} ></h3>
            <h3>Unique id: <b class="required">*</b> <input class="text-data-id" name="id" type="text" value="${form_element[indexNo].id}" ></h3>
            <h3><button type="button" onclick="wodgc_edit_input_field(type='textArea', ${indexNo})">Update Field Now</button></h3>
        `);
        jQuery(".popup-model-main").addClass('model-open');

    } else {

        jQuery("#popup_des").html(`<i class="fa-solid fa-spinner fa-spin-pulse"></i>`);
        jQuery(".popup-model-main").removeClass('model-open');

    }


}


// Form Display
function wodgc_form_display(){
    
    let pdfEle = "";
    let formHtml = "";
    let jsonString   = jQuery(".gcol-1 input[name=gift_card_form]").val();
    let form_element = JSON.parse(jsonString);
    
    
    if (form_element.length>0) {
        for (let i = 0; i < form_element.length; i++) {
            let element = form_element[i];
            // console.log(element);
			
            let requerFlag = (element.is_required === "on") ? '<b class="required">*</b>' : "";

            if(element.element === 'input') { // required="${element.is_required}  '.$requerFlag.'
                 formHtml += `
                    <div class="form-element" indexId="${i}">
                        <div class="label-action">
                            <h5 for="${element.id}">${element.label}: ${(element.is_required === "on") ? '<b class="required">*</b>' : ""}</h5>
                            <div class="action-btn" >
                                <span class="dashicons dashicons-edit editColor" onclick="wodgcEditField(${i})"></span> | <span class="dashicons dashicons-trash error" onclick="wodgcDeleteField(${i})"></span>
                            </div>
                        </div>
                        <input type="${element.type}" id="${element.id}" placeholder="${element.placeholder}" " >
                    </div>
                `;
                
                jQuery('#giftCartSetting').html(formHtml);

                pdfEle +=` | {${element.id}}`;
                jQuery('#pdfElement').html(pdfEle);
            } 
            else if (element.element === 'textarea') {
                 formHtml += `
                    <div class="form-element" indexId="${i}">
                        <div class="label-action">
                            <h5 for="${element.id}">${element.label}:${requerFlag}</h5>
                            <div class="action-btn" >
                                <span class="dashicons dashicons-edit editColor" onclick="wodgcEditField(${i})"></span> | <span class="dashicons dashicons-trash error" onclick="wodgcDeleteField(${i})"></span>
                            </div>
                        </div>
                        <textarea id="${element.id}" rows="10" >${element.placeholder}</textarea>
                    </div>
                `;
                
                jQuery("#giftCartSetting").html(formHtml);
                pdfEle +=` | {${element.id}}`;
                jQuery('#pdfElement').html(pdfEle);
            }
            else if (element.element === 'select') {
                 formHtml += `
                    <div class="form-element" indexId="${i}">
                        <div class="label-action">
                            <h5 for="${element.id}">${element.label}:${requerFlag}</h5>
                            <div class="action-btn" >
                                <span class="dashicons dashicons-edit editColor" onclick="wodgcEditField(${i})"></span> | <span class="dashicons dashicons-trash error" onclick="wodgcDeleteField(${i})"></span>
                            </div>
                        </div>
                        <select id="${element.id}" placeholder="${element.placeholder}">`;

                        for (let op = 0; op < element.options.length; op++) {
                            let option = element.options[op];
                            // console.log(option);
                            
                            formHtml += `<option value="${option}">${option}</option>`;
                        }
                        formHtml += `
                        </select>
                    </div>
                `;

                jQuery("#giftCartSetting").html(formHtml);
                pdfEle +=` | {${element.id}}`;
                jQuery('#pdfElement').html(pdfEle);

            }
            else {
                jQuery("#giftCartSetting").html(formHtml);
                jQuery('#pdfElement').html(pdfEle);
            }
        
        }
    } 
    

}



function wodgcSetInputType(){

    let selectedValue  = jQuery('.input-data-sr').val().trim();
    let dataTypeSelect = jQuery('#popup_des').find('.input-data-type');

    if(selectedValue === 'send-date-time' || selectedValue === 'sender-name' || selectedValue === 'recipient-name'){

        dataTypeSelect.val('text').attr('selected');

    }else if(selectedValue === 'sender-email' || selectedValue === 'recipient-email'){

        dataTypeSelect.val('email').attr('selected');

    }else if(selectedValue === 'sender-phone' || selectedValue === 'recipient-phone'){

        dataTypeSelect.val('number').attr('selected');

    }

}

// onchange="wodgcSetImgPreview()" 
function wodgcSetImgPreview() {
    let selectStyle  = jQuery('#wodgc_style_template option:selected').attr('imgLink');

    jQuery('.styleLeftSide').find(".imgPreview img").attr("src", selectStyle);

    // console.log(selectStyle);
    
}

// onchange="wodgcPdfImgPreview()" 
function wodgcPdfImgPreview() {
    let pdfStyle  = jQuery('#wodgc_pdf_style_template option:selected').attr('imgLink');
    let pdfBody   = jQuery('#wodgc_pdf_style_template option:selected').val();

    jQuery('.stylePDF').find(".pdfPreview img").attr("src", pdfStyle);
    
    if(pdfBody === "pdfStyle1"){

        // tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_pdf').setContent(pdfStyle1);
        // jQuery('.pdfBodyHtml').find("textarea#gift_card_pdf").val(pdfStyle1);
        // console.log(pdfBody+"  ****  "+pdfStyle1);
        
    }
    else if(pdfBody === "pdfStyle2"){

        tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_pdf').setContent(pdfStyle2);
        
    }
    else if(pdfBody === "pdfStyle3"){

        tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_pdf').setContent(pdfStyle3);

    }
    else if(pdfBody === "pdfStyle4"){

        tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_pdf').setContent(pdfStyle4);

    }
    else if(pdfBody === "pdfStyle5"){

        tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_pdf').setContent(pdfStyle5);

    }
    else if(pdfBody === "pdfStyle6"){

        tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_pdf').setContent(pdfStyle6);

    }
    else if(pdfBody === "pdfStyle7"){

        tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_pdf').setContent(pdfStyle7);

    }
    else if(pdfBody === "pdfStyle8"){

        tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_pdf').setContent(pdfStyle8);

    }

    // console.log(pdfStyle);
    
}

// Update Field onclick="wodgcPreviewImageShownInPopup()" // <h3> ${pdfStyle}</h3>
function wodgcPreviewImageShownInPopup(){
    let pdfStyle  = jQuery('#wodgc_pdf_style_template option:selected').attr('imgLink');

    jQuery("#popup_des").html(`
            <h2 align="center"><b>Preview pdf style</b></h2>
            <div class="pdfPreview">
                <img src="${pdfStyle}" alt="Show Preview image">
            </div>
        `);
    jQuery(".popup-model-main").addClass('model-open');
    
}

//  onclick="wodgcShowImgUploadTabs()"
function wodgcShowImgUploadTabs(){
    let checkVal = jQuery("input[name=gift_card_enable_product_gallery_img]").is(":checked");

    if(checkVal){
        jQuery("#imgTabs").html(wodgc_image_tab_html());
        // console.log("Tabs ... checked = x = " + checkVal);
    } else {
        jQuery("#imgTabs").html(``);
        // console.log("Tabs ... False __x__ " + checkVal);

    }
    
}

function wodgcOpenCity(cityName) {
  let i;
  let x = document.getElementsByClassName("item-container");

  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
    x[i].classList.remove("active");
    let button = document.getElementsByClassName("item-button")[i];
    button.classList.remove("active");
  }
  document.getElementById(cityName).style.display = "block";  
  
  // Add active class to the selected button and container
  var activeButton = document.querySelector(`button[onclick="wodgcOpenCity('${cityName}')"]`);
  activeButton.classList.add("active");
  document.getElementById(cityName).classList.add("active");

}




// image tabs html
let targetProxy=[];

// onkeyup="wodgcTabNameChange(this)"
function wodgcTabNameChange(data){

    let tabConId = jQuery(data).parent().parent().attr("id");
    let index    = jQuery(data).parent().parent().attr("data-index");
    let tabName  = data.value;

    let tabsElement  = jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val();
    let tabs_element = tabsElement ? JSON.parse(tabsElement) : []; 

    tabs_element[index].label = tabName;

    jQuery("#"+tabConId).find('.tab_name').text(tabName); // change h3 title text 
    jQuery("#btn-container").find('.'+tabConId).text(tabName); // change btn text

    // set target input value here
    const jsonString = JSON.stringify(tabs_element);
    jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val(jsonString);

}

function wodgc_image_tab_html(){

    let tabsElement  = jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val();
    let img_tabs_data = tabsElement ? JSON.parse(tabsElement) : []; 

    let html=`
    <h2 align="center"><b>Tabs view...</b></h2>
    <div class="buttons-bar">
        <span id="btn-container">`;
            let tab_contents='';
            if(img_tabs_data.length>0){
                for(let i=0;i<img_tabs_data.length;i++){
                    html+=`<button type="button" data-index="${i}" class="item-button giftcard_admin_image_tab_${i} ${(i===0?'active':'')}" onclick="wodgcOpenCity('giftcard_admin_image_tab_${i}')">${img_tabs_data[i].label}</button>`;
                    
                    tab_contents+=`
                    <div id="giftcard_admin_image_tab_${i}" data-index="${i}" class="item-container city ${(i===0?'active':'')}" style="display:${(i===0?'block':'none')}">

                        <div class="title-delete">
                            <h3 class="tab_name">${img_tabs_data[i].label}</h3>
                            <span class="error" onclick="wodgcTabDelete(${i})">Delete Tab <span class="dashicons dashicons-trash"></span></span>
                        </div>
                        
                        <b>Tab title</b>
                        <div class="title-delete">
                            <input type="text" id="tab_name_${i}" name="tabName" placeholder="Enter Tab/Category Name" value="${img_tabs_data[i].label}" onkeyup="wodgcTabNameChange(this)">
                            <button type="button" class="wodgc-tab-img-upload-btn" id="file_name_${i}" >Upload your tab images</button>
                        </div>
                        <div class="thisTabImgShow" id="wodgcTabImgShow">`;

                        if(img_tabs_data[i].images.length>0){
                            for (const image of img_tabs_data[i].images) {
                                tab_contents+=`
                                    <span class="tab-img" id="imgAttchId_${image.id}" ><span class="tab-img-remove" onclick="wodgcRemoveTabImg('giftcard_admin_image_tab_${i}', ${image.id})" >×</span> <img src="${image.url}" style="max-height:100px;" /></span>
                                `;
                                // console.log(`ID: ${image.id}, URL: ${image.url}`);
                            }
                        }

                        tab_contents+=`
                        </div>

                    </div>`;
                }
            }
        html+=`
        </span>
        <button type="button" class="item-button" onclick="wodgc_create_new_tab_panel()">+</button>
    </div>

    <div class="images-tab-element" id="gift_card_image_tab_contents">
        `+tab_contents+`
    </div>
`;

return html;

}

function wodgc_create_new_tab_panel(){
    let index = jQuery("#btn-container button").length;
    let i=1;
    if(index>0)i=index+1;

    let tabsElement  = jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val();
    let tabs_element = tabsElement ? JSON.parse(tabsElement) : [];

    let obj = {
        label:'Tab '+i,
        images:[]
    };

    tabs_element.push(obj);
    // set target input value here
    const jsonString = JSON.stringify(tabs_element);
    jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val(jsonString);

    let response = wodgc_image_tab_html();
    jQuery("#imgTabs").html(response);
}



jQuery(document).ready(function(){
    wodgcShowImgUploadTabs();
    wodgc_showCouponOption();
    wodgc_addCouponOption();
    wodgc_showEmailSendOption();


    // jQuery('#wodgc_email_template').on('change', wodgcEmailTempImgPreview);

    jQuery("#selectProducts").select2({
        placeholder: "Search for a product...",
        allowClear: true,
    });
    jQuery("#selectExProducts").select2({
        placeholder: "Search for a product...",
        allowClear: true,
    });
    jQuery("#selectCategories").select2({
        placeholder: "Any category",
        allowClear: true,
    });
    jQuery("#selectExCategories").select2({
        placeholder: "No categories",
        allowClear: true,
    });

    function wodgc_tab_img_upload(button_class) {
        
        jQuery('body').on('click', button_class, function(e) {

            let button     = jQuery(this).attr('id');
            let tabContent = jQuery(this).parent().parent();
            let tabConId   = jQuery(tabContent).attr('id');
            let index      = jQuery("#"+tabConId).attr("data-index");

            // console.log(tabContent);
            // console.log(tabConId);
            
            let tabsElement = jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val();
            let tabs_element= tabsElement ? JSON.parse(tabsElement) : [];
            
            wp.media.editor.send.attachment = function(props, attachment){

                let galleryContainer = jQuery(tabContent).find('#wodgcTabImgShow');
                /*
                    // Check if the existing gallery container exists, if not create it.
                    // let galleryContainer = jQuery(tabContent).find('.wodgcTabImgShow');
                    if (!galleryContainer.length) {
                        galleryContainer = jQuery('<div class="wodgcTabImgShow"></div>');
                        jQuery(tabContent).append(galleryContainer);
                    }
                */
                galleryContainer.append(`<span class="tab-img" id="imgAttchId_${attachment.id}" ><span class="tab-img-remove" onclick="wodgcRemoveTabImg('${tabConId}', ${attachment.id})" >×</span> <img src="${attachment.url}" style="max-height:100px;" /></span>`);

                /*
                    jQuery(tabContent).find('#wodgcTabImgShow').html(`<span class="tab-img" id="imgAttchId_${attachment.id}" ><span class="tab-img-remove" onclick="wodgcRemoveTabImg('${tabConId}', ${attachment.id})" >×</span> <img src="${attachment.url}" style="max-height:100px;" /></span>`);
                */

                // upload tabe image 
                let imgObj = {
                    url:attachment.url, 
                    id:attachment.id
                };
                tabs_element[index].images.push(imgObj);
                // set target input value here
                const jsonString = JSON.stringify(tabs_element);
                jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val(jsonString);
                
            }

            wp.media.editor.open(button, {
                multiple: true, // Enable multiple image selection
            });

            // Change the button text after an image is selected
            // jQuery(button_class).text('Insert Tab image');

            return false;
        });
    }
    wodgc_tab_img_upload('.wodgc-tab-img-upload-btn'); 

});

// onkeyup="test_select2()"
// function test_select2(){

//     let selectVal = jQuery("#selectProducts").val();
//     console.log(selectVal);
    
// }





// delete tab onclick="wodgcTabDelete(indexNo)"
function wodgcTabDelete(indexNo){
    let tabsElement  = jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val();
    let tabs_element = tabsElement ? JSON.parse(tabsElement) : [];
    tabs_element.splice(indexNo, 1);
    // set target input value here
    const jsonString = JSON.stringify(tabs_element);
    jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val(jsonString);
    jQuery("#imgTabs").html(wodgc_image_tab_html());
}

function wodgcRemoveTabImg(conId, attachment_id){
    jQuery("#"+conId).find('#imgAttchId_'+attachment_id).remove(); // remove tab img by attachment_id from html

    let index  = jQuery("#"+conId).attr("data-index");
    let tabsElement  = jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val();
    let tabs_element = tabsElement ? JSON.parse(tabsElement) : [];

    let singleTabImgs= tabs_element[index].images;
    let images = singleTabImgs.filter(image => image.id !== attachment_id); // Delete tab img by attachment_id from array
    tabs_element[index].images = images.slice(0);
    // tabs_element.forEach(tab => { 
    //     tab.images = filterImages(tab.images);
    // });

    // set target input value here
    const jsonString = JSON.stringify(tabs_element);
    jQuery(".imgStyleTabs input[name=wodgc_tab_images]").val(jsonString);
    
}


//  onclick="wodgc_showCouponOption()"
function wodgc_showCouponOption(){
    let checkVal = jQuery("input[name=gift_card_number_show]").is(":checked");

    if(checkVal){
        jQuery("#useCoupon").show(); // css({ display: "block" })
    } else {
        jQuery("#useCoupon").hide(); // .hide()

    }
    
}

//  onclick="wodgc_addCouponOption()"
function wodgc_addCouponOption(){
    let checkVal = jQuery("input[name=gift_card_no_enable_as_coupon]").is(":checked");

    if(checkVal){
        jQuery("#fildCoupon").show();
        // jQuery("#fildCoupon").html(wodgc_image_tab_html());
    } else {
        jQuery("#fildCoupon").hide();

    }
    
}



// onchange="wodgcEmailTempImgPreview()" 
function wodgcEmailTempImgPreview() {

    let pdfStyle  = jQuery('#wodgc_email_template option:selected').attr('imgLink');
    let emailBody = jQuery('#wodgc_email_template option:selected').val();

    // jQuery('.emailTemp').find(".pdfPreview img").attr("src", pdfStyle);
    
    if(emailBody === "wodgc_email_template_1"){

        // tinyMCE.get('gift_card_pdf').setContent(" ");
        tinyMCE.get('gift_card_email').setContent("");
        tinyMCE.get('gift_card_email').setContent(pdfStyle1);
        // jQuery('.emailBodyHtml').find("textarea#gift_card_email").val(pdfStyle1);
        // console.log(emailBody+"  ****  "+pdfStyle1);
        
    }
    else if(emailBody === "wodgc_email_template_2"){

        tinyMCE.get('gift_card_email').setContent(" ");
        tinyMCE.get('gift_card_email').setContent(pdfStyle2);
        
    }
    else if(emailBody === "wodgc_email_template_3"){

        tinyMCE.get('gift_card_email').setContent(" ");
        tinyMCE.get('gift_card_email').setContent(pdfStyle3);

    }
    else{
        tinyMCE.get('gift_card_email').setContent(pdfStyle1);
    }

    // console.log(pdfStyle);
    
}

// Update Field onclick="wodgcPreviewEmailTempImageShownInPopup()" // <h3> ${pdfStyle}</h3>
function wodgcPreviewEmailTempImageShownInPopup(){
    let emailStyle  = jQuery('#wodgc_email_template option:selected').attr('imgLink');

    jQuery("#popup_des").html(`
            <h2 align="center"><b>Preview email style</b></h2>
            <div class="emailPreview">
                <img src="${emailStyle}" alt="Show Preview image">
            </div>
        `);
    jQuery(".popup-model-main").addClass('model-open');
    
}



//  onclick="wodgc_showEmailSendOption()"
function wodgc_showEmailSendOption(){
    let checkVal    = jQuery("input[name=wodgc_send_email]").is(":checked");
    
    let formElement  = jQuery(".gcol-1 input[name=gift_card_form]").val();
    let gcCheckFrom = formElement ? JSON.parse(formElement) : [];

    let foundItem = jQuery(gcCheckFrom).filter(function() {
        return this.sr === "recipient-email";
    });

    if(checkVal){
        jQuery("#sendEmail").show(); // css({ display: "block" })

        // jQuery("#emailErrorNotification").text('Yes. Recipient email inputfild Found.');
        // jQuery("input[name=wodgc_send_email]").prop("checked",true);
        
            if (foundItem.length > 0) {
                jQuery("#emailErrorNotification").hide();
                jQuery("input[name=wodgc_send_email]").prop("checked",true);
            }else{
                jQuery("#emailErrorNotification").text('Pleae set Recipient email inputfild.');
                jQuery("input[name=wodgc_send_email]").prop("checked",false);
                jQuery("#sendEmail").hide(); // .hide()
            }
        
        
    } else {
        jQuery("#sendEmail").hide(); // .hide()

    }
    
}

jQuery("#userDateTimieSet").change(function(){

    let formElement  = jQuery(".gcol-1 input[name=gift_card_form]").val();
    let gcCheckFrom = formElement ? JSON.parse(formElement) : [];

    let setDateItem = jQuery(gcCheckFrom).filter(function() {
        return this.sr === "send-date-time";
    });
    
    if (setDateItem.length > 0) {
        jQuery("input[name=gift_card_send_email_enable]").prop("checked",true);
    }else{
        alert("Pleae set Date time inputfild.");
        jQuery("input[name=gift_card_send_email_enable]").prop("checked",false);
    }
    
});