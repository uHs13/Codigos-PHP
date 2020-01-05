<?php
namespace Hcode\Model;

use Hcode\Model;
use Hcode\Model\Order;

class Boleto extends Model
{

	public function build($idorder)
	{

		$order = $this->getOrderData($idorder);

		// DADOS DO BOLETO PARA O SEU CLIENTE
		$dias_de_prazo_para_pagamento = 5;
		$taxa_boleto = 1.00;
		$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
		$valor_cobrado = $order->getvltotal(); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

		$dadosboleto["nosso_numero"] = '13131313';  // Nosso numero - REGRA: Máximo de 8 caracteres!
		$dadosboleto["numero_documento"] = $order->getidorder();	// Num do pedido ou nosso numero
		$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
		$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = $order->getdesperson();
		$dadosboleto["endereco1"] = $order->getdesaddress().
		" "
		. $order->getdescomplement()
		. " ";//"Av. Paulista, 500";
		$dadosboleto["endereco2"] = $order->getdescity()
		. " - "
		. $order->getdesstate()
		. " - "
		. $order->getdeszipcode();//"Cidade - Estado -  CEP: 00000-000";

		// INFORMACOES PARA O CLIENTE
		$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja The GS";
		$dadosboleto["demonstrativo2"] = "Taxa bancária - R$ 1,00";
		$dadosboleto["demonstrativo3"] = "";
		$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
		$dadosboleto["instrucoes2"] = "- Receber até 5 dias após o vencimento";
		$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: suporte@gmail.com";
		$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema The GS";

		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$dadosboleto["quantidade"] = "";
		$dadosboleto["valor_unitario"] = "";
		$dadosboleto["aceite"] = "";		
		$dadosboleto["especie"] = "R$";
		$dadosboleto["especie_doc"] = "";

		// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

		// DADOS DA SUA CONTA - ITAÚ
		$dadosboleto["agencia"] = "1690"; // Num da agencia, sem digito
		$dadosboleto["conta"] = "48781";	// Num da conta, sem digito
		$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

		// DADOS PERSONALIZADOS - ITAÚ
		$dadosboleto["carteira"] = "175";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

		// SEUS DADOS
		$dadosboleto["identificacao"] = "The GS";
		$dadosboleto["cpf_cnpj"] = "13.133.133/13131-31";
		$dadosboleto["endereco"] = "Rua A, 234 - LA, 01234-567";
		$dadosboleto["cidade_uf"] = "So Far - LA";
		$dadosboleto["cedente"] = "The GS";

		// NÃO ALTERAR!
		$path = $_SERVER["DOCUMENT_ROOT"]
		. DIRECTORY_SEPARATOR
		. "PHP"
		. DIRECTORY_SEPARATOR
		. "ecommerce"
		. DIRECTORY_SEPARATOR;

		require_once($path . "res/boletophp/include/funcoes_itau.php"); 
		require_once($path . "res/boletophp/include/layout_itau.php");

	}
// .build

	public function getOrderData($idorder)
	{

		$order = new Order();

		$order->get($idorder);

		return $order;

	}
	// .getOrderData

}
// .Boleto