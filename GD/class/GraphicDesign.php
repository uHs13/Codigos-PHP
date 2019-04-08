<?php 

class GraphicDesign{

	private $image;

	//GETTERS AND SETTERS



	public function getImage(){

		return $this->image;

	}

	//FIM GETTERS AND SETTERS

	public function createDesign($posX,$posY,$content){

		header('Content-Type: image/png');

		$green = imagecolorallocate($this->getImage(), 0, 240, 50);
		$white = imagecolorallocate($this->getImage(), 255, 255, 255);

		//imagem, tamanho da fonte ( 1-5 )
		imagestring($this->getImage(), 5, $posX, $posY, $content, $white);

		imagepng($this->getImage());

		imagedestroy($this->getImage());

	}

	public function createFromJpeg($path,$content="",$mode=0){

		$this->image = imagecreatefromjpeg($path);

		header("Content-type: image/jpeg");

		$fontColor = imagecolorallocate($this->getImage(), 130, 0, 41);

		// imagestring($this->getImage(), 5, /*esquerda*/120,/*topo*/ 100, utf8_decode($content), $fontColor);

		imagettftext($this->getImage(), 10, 0, 120, 100, $fontColor, __DIR__.DIRECTORY_SEPARATOR."fonts".DIRECTORY_SEPARATOR."Bevan".DIRECTORY_SEPARATOR."Bevan-Regular.ttf", $content);
		
		imagettftext($this->getImage(), 10, 0, 120, 120, $fontColor, __DIR__.DIRECTORY_SEPARATOR."fonts".DIRECTORY_SEPARATOR."Bevan".DIRECTORY_SEPARATOR."Bevan-Regular.ttf", date('d/m/Y'));

		switch($mode){

			case 0:

				imagejpeg($this->getImage());

				break;


			case 1:
				//imagejpeg(imagem,path,qualidade)
				imagejpeg($this->getImage(),'_res/image-'.date('Y-m-d').'.jpg',50);//escala 0-100 da qualidade original do arquivo

				break;


		}
		

		imagedestroy($this->getImage());
		

	}

	public function generateThumbnail($path){

		header("Content-type: image/jpeg");
		

		/*
		atribui valores de um array a variáveis. Equivalente a:

		 $old_width = getimagesize($path)[0];
		 $old_height = getimagesize($path)[1];
			
		para pegar mais posições basta colocarmos mais variáveis

		*/
		list($old_width,$old_height) = getimagesize($path);

		$new_width = $old_width/4;
		$new_height = $old_height/4;

		
		$new_image = imagecreatetruecolor($new_width, $new_height);
		$old_image = imagecreatefromjpeg($path);

		imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

		imagejpeg($new_image);

		imagedestroy($new_image);
		imagedestroy($old_image);




	}


	public function __construct($width="",$height=""){

		if(($width && $height)!="")$this->image = imagecreate($width, $height);


		
	}


}


?>