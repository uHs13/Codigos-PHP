<?php 
$hierarquia = array(
	//Inicio CEO
	array(
		'nome_cargo'=>'CEO',
		//Inicio subordinados CEO
		'subordinados'=>array(
			//Inicio Presidente
			array(
				'nome_cargo'=>'Presidente',
				'subordinados'=>array(
					//Inicio Diretor Executivo
					array(
						'nome_cargo'=>'Diretor Executivo',
						'subordinados'=>array(
							//Inicio Gerente Senior
							array(
								'nome_cargo'=>'Gerente Senior',
								'subordinados'=>array(
									//inicio Chefe de Setor
									array(
										'nome_cargo'=>'Chefe de Setor',
										'subordinados'=>array(
											//inicio funcionarios
											array(
												'nome_cargo'=>'Funcionario'
											)
											//fim Funcionarios
										)
									)
									//Fim Chefe de Setor

								)
							)
							//Fim Gerente Senior
						)
					)
					//Fim Diretor Executivo
				)
			),
			//Fim Presidente
			//Inicio acionistas
			array(
				'nome_cargo'=>'Acionistas',
				'subordinados'=>array(
					array(
						'nome_cargo'=>'Detentores de Acoes',
						'subordinados'=>array(
							array(
								'nome_cargo'=>'estrutura hierarquica da empresa',
							)
						)
					)
				)
			)
			//Fim acionistas
			
		)
		//fim subordinados CEO
	)
	//FIm CEO


);

function ExibeCargos($cargos){ //como está no plural significa que é um array
	$html = '<ul>';

	foreach ($cargos as $cargo) {

		$html.='<li>';
		$html.= $cargo['nome_cargo'];

		if( isset($cargo['subordinados']) && count($cargo['subordinados']) > 0){

			$html.=ExibeCargos($cargo['subordinados']);

		}

		$html.='</li>';
		
	}

	$html.='</ul>';

	return $html;
}

echo ExibeCargos($hierarquia);

?>