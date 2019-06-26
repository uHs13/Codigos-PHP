<?php  
namespace Hcode\Model;


use Hcode\DB\Sql;
use Hcode\Model;
use Hcode\Mailer;


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

}//Category

?>