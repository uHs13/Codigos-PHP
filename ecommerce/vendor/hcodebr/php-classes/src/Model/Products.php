<?php  
namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;


class Products extends Model
{

	public static function listAll()//método que retorna todos os usuários cadastrados no banco
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");

	}// listAll()

	public static function checkList($list)
	{

		foreach ($list as &$value) {
			
			$product = new Products();
			$product->setData($value);

			$value = $product->getValues();

		}

		return $list;

	}

	public function save()
	{
		
		$sql = new Sql();

		$results = $sql->select('CALL sp_products_save(
			
			:idproduct, 
			:desproduct,
			:vlprice,
			:vlwidth,
			:vlheight,
			:vllength,
			:vlweight,
			:desurl

		)', array(

			':idproduct' => (isset($this->getValues()['idproduct'])) ? $this->getValues()['idproduct'] : 0,
			':desproduct' => $this->getdesproduct(),
			':vlprice' => $this->getvlprice(),
			':vlwidth' => $this->getvlwidth(),
			':vlheight' => $this->getvlheight(),
			':vllength' => $this->getvllength(),
			':vlweight' => $this->getvlweight(),
			':desurl' => $this->getdesurl(),

		));

		$this->setData($results[0]);

	}//save()


	public function get($idproduct)
	{

		$sql = new Sql();

		$results = $sql->select('SELECT * FROM tb_products WHERE idproduct = :idproduct', array(

			':idproduct' => $idproduct

		));

		$this->setData($results[0]);
	
	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query('DELETE FROM tb_products WHERE idproduct = :idproduct', array(

			':idproduct' => $this->getidproduct()

		));

	}//delete()


	public function checkPhoto()
	{

		/*
			
			$_SERVER['DOCUMENT_ROOT'] == "C:/xamppPHP7/htdocs"
		
		*/

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "ecommerce" . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg" )) {

			$url = "/PHP/ecommerce/res/site/img/products/" .  $this->getidproduct() . ".jpg";

		} else {

			$url = "/PHP/ecommerce/res/site/img/product.jpg";

		}

		return $this->setdesphoto($url);

	}

	public function getValues() 
	{

		$this->checkPhoto();

		$values = parent::getValues();

		return $values;

	}

	public function setPhoto($file) 
	{

		// var_dump($file);

		if (strlen($file['name']) === 0) return false;

		$extension = explode('.', $file['name']);
		$extension = end($extension);

		switch ($extension) {

			case 'jpg':
			case 'jpeg':
				$image = imagecreatefromjpeg($file['tmp_name']);
				break;
			
			case 'gif':
				$image = imagecreatefromgif($file['tmp_name']);
				break;

			case 'png':
				$image = imagecreatefrompng($file['tmp_name']);
				break;

		}

		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "ecommerce" . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg" ;

		imagejpeg($image, $dist);

		imagedestroy($image);

		$this->checkPhoto();

	}

}//Products

?>