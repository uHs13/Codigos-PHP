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

	
}//User

?>