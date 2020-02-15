<?php  
namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;

class Category extends Model
{

	public static function listAll()//método que retorna todos os usuários cadastrados no banco
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");

	}// listAll()

	public function save()
	{
		
		$sql = new Sql();

		$results = $sql->select('CALL sp_categories_save(:id, :descat)', array(

			':id' => (isset($this->getValues()['idcategory'])) ? $this->getValues()['idcategory'] : 0,
			':descat' => $this->getdescategory()

		));

		$this->setData($results[0]);

		Category::updateFile();

	}//save()


	public function get($idcategory)
	{

		$sql = new Sql();

		$results = $sql->select('SELECT * FROM tb_categories WHERE idcategory = :idcategory', array(

			':idcategory' => $idcategory

		));

		$this->setData($results[0]);

	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query('DELETE FROM tb_categories WHERE idcategory = :idcategory', array(

			':idcategory' => $this->getidcategory()

		));

		Category::updateFile();

	}//delete()

	public static function updateFile()
	{

		$categories = Category::listAll();

		$html = [];

		foreach ($categories as $row) {
			
			array_push($html, "<li><a href='/PHP/ecommerce/category/".$row['idcategory']."'>".$row['descategory']."</a></li>");

		}

		file_put_contents($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR ."PHP" . DIRECTORY_SEPARATOR . "ecommerce". DIRECTORY_SEPARATOR ."views" . DIRECTORY_SEPARATOR . "categoriesMenu.html" , implode('', $html));

	}

	public function getProducts($related = true)
	{
		/* $realted indica se serão retornados os produtos de determinada categoria ou todos */
		$sql = new Sql();

		if ($related === true) {

			return $sql->select("

				SELECT * from tb_products where idproduct in(
				SELECT p.idproduct from tb_products p
				inner join tb_productscategories cp
				on  p.idproduct = cp.idproduct
				where idcategory = :idcategory
				);

				", [

					':idcategory' => $this->getidcategory()

				]);

		} else {

			return $sql->select("

				SELECT * from tb_products where idproduct NOT in(
				SELECT p.idproduct from tb_products p
				inner join tb_productscategories cp
				on  p.idproduct = cp.idproduct
				where idcategory = :idcategory
				);

				", [

					':idcategory' => $this->getidcategory()

				]);

		}

	}
	//.getProducts

	public function addProduct(Products $product)
	{

		$sql = new Sql();

		$sql->query("

			INSERT INTO tb_productscategories (idcategory, idproduct)
			values (:idcategory, :idproduct)

			", array(

				":idcategory" => $this->getidcategory(),
				":idproduct" => $product->getidproduct()

			));

	}
	//addProduct

	public function removeProduct(Products $product)
	{

		$sql = new Sql();

		$sql->query("

			DELETE FROM tb_productscategories
			WHERE idcategory = :idcategory and
			idproduct = :idproduct

			", array(

				":idcategory" => $this->getidcategory(),
				":idproduct" => $product->getidproduct()

			));

	}
	//removeProduct

	public function getProductPage($page = 1, $itensPage = 10)
	{

		$start = ($page - 1) * $itensPage;

		$sql = new Sql();

		$results = $sql->select(
			"select sql_calc_found_rows
			p.idproduct,
			p.desproduct,
			p.vlprice,
			p.desurl
			from tb_products p
			inner join tb_productscategories pc
			on pc.idproduct = p.idproduct
			inner join tb_categories c
			on pc.idcategory = c.idcategory
			where pc.idcategory = :idCategory
			limit $start, $itensPage
			"
			,
			array(
				":idCategory" => $this->getidcategory()
			));

		$resultTotal = $sql->select("select found_rows() as 'nrtotal';");

		return [
			
			'data' => $results,
			'total' => (int)$resultTotal[0]['nrtotal'],
			'pages' => ceil( $resultTotal[0]['nrtotal'] / $itensPage)

		];

	}
	// .getProductPage

	public function getCategoryPage($page = 1, $itensPage = 5)
	{

		$start = ($page - 1) * $itensPage;

		$sql = new Sql();

		$results = $sql->select("

			SELECT SQL_CALC_FOUND_ROWS
			idcategory,
			descategory
			FROM tb_categories
			LIMIT $start, $itensPage

			");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");

		return [

			'data' => $results,
			'total' => (int)$resultTotal[0]["nrtotal"],
			'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPage)

		];

	}
	// .getCategoryPage

	public function getCategoryPageSearch($search, $page = 1, $itensPage = 5)
	{

		$start = ($page - 1) * $itensPage;

		$sql = new Sql();

		$results = $sql->select("

			SELECT SQL_CALC_FOUND_ROWS
			idcategory,
			descategory
			FROM tb_categories
			WHERE
			idcategory = :idcategory OR
			descategory LIKE :descategory
			LIMIT $start, $itensPage

			", [

				":idcategory" => $search,
				":descategory" => "%$search%"

			]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal");

		return [

			'data' => $results,
			'total' => (int)$resultTotal[0]["nrtotal"],
			'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPage)

		];

	}
	// .getCategoryPage

}//Category
