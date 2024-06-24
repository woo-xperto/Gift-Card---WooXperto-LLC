<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	require 'vendor/autoload.php';
	
	// reference the Dompdf namespace
	use Dompdf\Dompdf;
	use Dompdf\Options;

	// instantiate and use the dompdf class
	$options 	  = new Options();
	$options->set('defaultFont', 'Courier');
	$options->set('isRemoteEnabled', true);
	$options->setIsHtml5ParserEnabled(true);
	$dompdf 	  = new Dompdf($options);
	$item 		  = new WC_Order_Item_Product($orderLineItemId);

	$custome_image= wc_get_order_item_meta( $orderLineItemId, 'photo_url', true);
	$total		  = $item->get_total();

	$product_id   = $item->get_product_id();

	$epgi      = get_post_meta( $product_id, 'gift_card_number_show', true );
	if($epgi === 'true'){
		
		$idGiftCard = wc_get_order_item_meta( $orderLineItemId, 'gift_card_no', true);
		
	}else{
		$idGiftCard = 'No gift card number';
	}

	$expiryDateType   = get_post_meta( $product_id, 'gift_card_expiry_date_type', true );	
	$expiryDateNumber = get_post_meta( $product_id, 'gift_card_expiry_date', true );
	$expiryDate 	  = wc_get_order_item_meta( $orderLineItemId, 'gift_card_date_expiry', true);	
	$infoFromElements = wc_get_order_item_meta( $orderLineItemId, 'info_form_ele', true);
	$pdfStyleHtml 	  = wc_get_order_item_meta( $orderLineItemId, 'gift_card_pdf', true);
	
	$user_input_data=array();
	$mainImg = '<img style="width:720px;" src="'.$custome_image[0].'" alt="" />';

	$keys_array  = array("{gift_card_img}", "{gift_card_amount}", "{gift_card_expiry_date}", "{gift_card_no}");
	$values_array= array($mainImg, $total, $expiryDate, $idGiftCard);

	// var_dump($infoFromElements);
	// exit();

	for ($i = 0; $i < count($infoFromElements); $i++) {
		$key=$infoFromElements[$i][0];
		$value=$infoFromElements[$i][1];
		
		// $keys_array[]=$key;
		$keys_array[]="{".$key."}";
		$values_array[]=$value;
	}
	
	$pdfBody = str_replace($keys_array, $values_array, $pdfStyleHtml[0]); // $keys_array = $search | $values_array = $replace

	$html	 ='
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Document</title>
		</head>
		<body>
			'.$pdfBody.'
		</body>
	</html>';
	
	$dompdf->loadHtml($html);
	$dompdf->setPaper('legal', 'portrait');

	// Render the HTML as PDF
	$dompdf->render();

	if(!isset($output)){
		// Output the generated PDF to Browser
		$dompdf->stream('gjafakort.pdf');
		exit();

	}else{
		$attachment    = $dompdf->output();
		$pdf_file_name = $orderLineItemId.'-gjafakort.pdf';
		file_put_contents($pdf_file_name, $attachment);
		
	}

	