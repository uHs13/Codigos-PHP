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
	//.checkList

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

	}
	//.save


	public function get(int $idproduct)
	{

		$sql = new Sql();

		$results = $sql->select('SELECT * FROM tb_products WHERE idproduct = :idproduct', array(

			':idproduct' => $idproduct

		));

		$this->setData($results[0]);

	}
	//.get

	public function delete()
	{

		$sql = new Sql();

		$sql->query('DELETE FROM tb_products WHERE idproduct = :idproduct', array(

			':idproduct' => $this->getidproduct()

		));

	}
	//.delete

	public function checkPhoto()
	{

		//$_SERVER['DOCUMENT_ROOT'] == "C:/xamppPHP7/htdocs"

		if (file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "PHP" . DIRECTORY_SEPARATOR . "ecommerce" . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg" )) {

			$url = "/PHP/ecommerce/res/site/img/products/" .  $this->getidproduct() . ".jpg";

		} else {

			$url = "/PHP/ecommerce/res/site/img/product.jpg";

		}

		return $this->setdesphoto($url);

	}//.checkPhoto

	public function getValues() 
	{

		$this->checkPhoto();

		$values = parent::getValues();

		return $values;

	}//.getValues

	public function setPhoto($file) 
	{

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

	}//.setPhoto

	public function getFromURL(string $desurl)
	{

		$sql = new Sql();

		$results = $sql->select("

			SELECT 
			idproduct,
			desproduct,
			vlprice,
			vlwidth,
			vlheight,
			vllength
			vlweight,
			desurl
			FROM tb_products
			WHERE desurl = :desurl
			LIMIT 1

			", array(

				":desurl" => $desurl

			)); 

		if (count($results) === 0) {

			return false;

		} else {

			$this->setData($results[0]);

		}

		}//.getFromURL

		public function getCategories()
		{

			$sql = new Sql();

			$results = $sql->select(
				"SELECT
				c.descategory,
				c.idcategory
				FROM tb_categories c
				INNER JOIN tb_productscategories pc
				ON c.idcategory = pc.idcategory
				WHERE pc.idproduct = :idproduct",

				array(
					":idproduct" => (int)$this->getidproduct()
				)
			);

			return $results;

		}//.getCategories

		public function getProductPage($page = 1, $itensPage = 5)
		{

			$start = ($page - 1) * $itensPage;

			$sql = new Sql();

			$results = $sql->select("

				SELECT SQl_CALC_FOUND_ROWS
				idproduct,
				desproduct,
				vlprice,
				vlwidth,
				vlheight,
				vllength,
				vlweight,
				desurl
				FROM tb_products
				LIMIT $start, $itensPage

				");

			$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");

			return [

				'data' => $results,
				'total' => (int)$resultTotal[0]["nrtotal"],
				'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPage)

			];

		}
		// .getProductPage

		public function getProductPageSearch($search, $page = 1, $itensPage = 5)
		{

			$start = ($page - 1) * $itensPage;

			$sql = new Sql();

			$results = $sql->select("

				SELECT SQl_CALC_FOUND_ROWS
				idproduct,
				desproduct,
				vlprice,
				vlwidth,
				vlheight,
				vllength,
				vlweight,
				desurl
				FROM tb_products
				WHERE
				idproduct = :STR OR
				desproduct LIKE :STR2 OR
				vlprice LIKE :STR4 OR
				vlwidth LIKE :STR5 OR
				vlheight LIKE :STR6 OR
				vllength LIKE :STR7 OR
				vlweight LIKE :STR8 OR
				desurl LIKE :STR9
				LIMIT $start, $itensPage

				", [

					":STR" => $search,
					":STR2" => "%$search%",
					":STR4" => "%$search%",
					":STR5" => "%$search%",
					":STR6" => "%$search%",
					":STR7" => "%$search%",
					":STR8" => "%$search%",
					":STR9" => "%$search%",

				]);

			$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");

			return [

				'data' => $results,
				'total' => (int)$resultTotal[0]["nrtotal"],
				'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPage)

			];
			
		}
		// .getProductPage

}//.Products