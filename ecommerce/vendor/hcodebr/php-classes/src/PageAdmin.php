<?php  

namespace Hcode;//especificar sempre o namespace que a classe está

use Rain\Tpl;

class PageAdmin extends Page
{

	public function __construct($opts = array(), $tpl_dir = "/views/admin/")
	{

		parent::__construct($opts,$tpl_dir);

	}

}

?>