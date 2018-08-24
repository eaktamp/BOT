<?php
	date_default_timezone_set("Asia/Bangkok");
	function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

	$strDate = date('Y/m/d');
	$show 	 = DateThai($strDate);

//$link = 'https://abhai-donate.cpa.go.th/login.php';

$line_api = 'https://notify-api.line.me/api/notify';
$access_token = 'ca5FRUmSByYJ9TC4mzGcFX8Sygrx9tdUyEAy7UqdKd1';

//$str = 'ยอดเงินบริจาคขณะนี้ :'."".number_format($total1).""."บาท"."และมีจำนวนคนบริจาควันนี้เป็นจำนวน".$total10.""."คน"."เข้าไปตรวจสอบที่".$link;  
$str = 'สวัสดี เช้าวันที่ '.$show.' ร่ำรวยเงินทอง สุขภาพแข็งแรง';
$image_thumbnail_url = '';  // ขนาดสูงสุด 240×240px JPEG
$image_fullsize_url = '';  // ขนาดสูงสุด 1024×1024px JPEG
$sticker_package_id = 1;  // Package ID ของสติกเกอร์
$sticker_id = 410;    // ID ของสติกเกอร์

$message_data = array(
 'message' => $str,
 'imageThumbnail' => $image_thumbnail_url,
 'imageFullsize' => $image_fullsize_url,
 'stickerPackageId' => $sticker_package_id,
 'stickerId' => $sticker_id
);

$result = send_notify_message($line_api, $access_token, $message_data);
print_r($result);

function send_notify_message($line_api, $access_token, $message_data)
{
 $headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$access_token );

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $line_api);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $result = curl_exec($ch);
 // Check Error
 if(curl_error($ch))
 {
  $return_array = array( 'status' => '000: send fail', 'message' => curl_error($ch) );
 }
 else
 {
  $return_array = json_decode($result, true);
 }
 curl_close($ch);
 return $return_array;
}

?>