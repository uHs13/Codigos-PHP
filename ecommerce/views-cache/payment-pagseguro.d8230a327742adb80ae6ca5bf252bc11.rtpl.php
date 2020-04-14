<?php if(!class_exists('Rain\Tpl')){exit;}?><div style="position: relative; left: 40%; right: 50%;margin: 10px;">
    <!-- Declaração do formulário -->
    <form method="post" target="pagseguro" action="https://pagseguro.uol.com.br/v2/checkout/payment.html">

        <!-- Campos obrigatórios -->
        <input name="receiverEmail" type="hidden" value="heitorhenriquedias@gmail.com">
        <input name="currency" type="hidden" value="BRL">

        <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
        <!-- Itens do pagamento (ao menos um item é obrigatório) -->
        <input name="itemId<?php echo htmlspecialchars( $key1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="hidden" value="<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="itemDescription<?php echo htmlspecialchars( $key1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="hidden" value="<?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="itemAmount<?php echo htmlspecialchars( $key1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="hidden" value="<?php echo htmlspecialchars( $value1["vltotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="itemQuantity<?php echo htmlspecialchars( $key1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="hidden" value="<?php echo htmlspecialchars( $value1["nrqtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="itemWeight<?php echo htmlspecialchars( $key1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" type="hidden" value="<?php echo htmlspecialchars( $value1["vlweight"] * 1000, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <?php } ?>

        <!-- Código de referência do pagamento no seu sistema (opcional) -->
        <input name="reference" type="hidden" value="TGS13">

        <!-- Informações de frete (opcionais) -->
        <input name="shippingType" type="hidden" value="1">
        <input name="shippingAddressPostalCode" type="hidden" value="<?php echo htmlspecialchars( $clientData["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="shippingAddressStreet" type="hidden" value="<?php echo htmlspecialchars( $clientData["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="shippingAddressNumber" type="hidden" value="<?php echo htmlspecialchars( $clientData["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="shippingAddressComplement" type="hidden" value="<?php echo htmlspecialchars( $clientData["descomplement"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="shippingAddressDistrict" type="hidden" value="<?php echo htmlspecialchars( $clientData["desdistrict"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="shippingAddressCity" type="hidden" value="<?php echo htmlspecialchars( $clientData["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="shippingAddressState" type="hidden" value="<?php echo htmlspecialchars( $clientData["desstate"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="shippingAddressCountry" type="hidden" value="BRA">

        <!-- Dados do comprador (opcionais) -->
        <input name="senderName" type="hidden" value="<?php echo htmlspecialchars( $clientData["desperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="senderAreaCode" type="hidden" value="<?php echo htmlspecialchars( $clientData["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="senderPhone" type="hidden" value="<?php echo htmlspecialchars( $clientData["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
        <input name="senderEmail" type="hidden" value="<?php echo htmlspecialchars( $clientData["desemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">

        <!-- submit do form (obrigatório) -->
        <input alt="Pague com PagSeguro" name="submit" type="image"
            src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/120x53-pagar.gif" />

    </form>
</div>