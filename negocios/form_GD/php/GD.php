<?php 

class GD{


	public  function buildReport($number,$repOff,$Off,$incident){

		$img = imagecreatefromjpeg('../_res/report.jpg');

		$color = imagecolorallocate($img, 100, 100, 100);

		
		imagettftext($img, 15, 0, 200, 215, $color, __DIR__.DIRECTORY_SEPARATOR."fonts".DIRECTORY_SEPARATOR."Bevan".DIRECTORY_SEPARATOR."Bevan-Regular.ttf", $number);

		//imagestring($img, 5, 550, 200, date('d/m/Y H:i:s'), $color);//date
		imagettftext($img, 15, 0, 550, 215, $color, __DIR__.DIRECTORY_SEPARATOR."fonts".DIRECTORY_SEPARATOR."Bevan".DIRECTORY_SEPARATOR."Bevan-Regular.ttf", date('d/m/Y H:i:s'));

		//imagestring($img, 5, 230, 240, utf8_decode($repOff), $color);//reporting officer
		imagettftext($img, 15, 0, 230, 255, $color, __DIR__.DIRECTORY_SEPARATOR."fonts".DIRECTORY_SEPARATOR."Bevan".DIRECTORY_SEPARATOR."Bevan-Regular.ttf", utf8_decode($repOff));

		//imagestring($img, 5, 610, 240, utf8_decode($Off), $color);//prepared by
		imagettftext($img, 15, 0, 610, 255, $color, __DIR__.DIRECTORY_SEPARATOR."fonts".DIRECTORY_SEPARATOR."Bevan".DIRECTORY_SEPARATOR."Bevan-Regular.ttf", utf8_decode($Off));

		//imagestring($img, 5, 120, 350, wordwrap(utf8_decode($incident),10,"<b><b>"), $color);//incident
		imagettftext($img, 15, 0, 120, 365, $color, __DIR__.DIRECTORY_SEPARATOR."fonts".DIRECTORY_SEPARATOR."Bevan".DIRECTORY_SEPARATOR."Bevan-Regular.ttf",wordwrap(utf8_decode($incident),30,"\n"));


		header('Content-type: image/jpeg');

		imagejpeg($img);

		imagedestroy($img);

	}

	public function __construct(){



	}

}


?>