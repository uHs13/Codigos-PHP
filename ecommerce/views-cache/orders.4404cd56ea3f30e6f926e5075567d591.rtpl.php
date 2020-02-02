<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Pedidos
  </h1>
  <ol class="breadcrumb">
    <li><a href="/PHP/ecommerce/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><a href="/PHP/ecommerce/admin/orders">Pedidos</a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">

            <div class="box-body no-padding">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 10px">#</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Valor Total</th>
                    <th class="text-center">Valor do Frete</th>
                    <th class="text-center">Status</th>
                    <th style="width: 220px">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter1=-1;  if( isset($orders) && ( is_array($orders) || $orders instanceof Traversable ) && sizeof($orders) ) foreach( $orders as $key1 => $value1 ){ $counter1++; ?>
                  <tr class="text-center">
                    <td><?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td><?php echo htmlspecialchars( $value1["desperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td>R$<?php echo formatPrice($value1["vltotal"]); ?></td>
                    <td>R$<?php echo formatPrice($value1["vlfreight"]); ?></td>
                    <td><?php echo getStatus($value1["idstatus"]); ?></td>
                    <td>
                      <a href="/PHP/ecommerce/admin/orders/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-default btn-xs"><i class="fa fa-search"></i> Detalhes</a>
                      <a href="/PHP/ecommerce/admin/order/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/status" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Status</a>
                      <a href="/PHP/ecommerce/admin/order/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</a>
                    </td>
                  </tr>
                  <?php }else{ ?>
                  <tr>
                      <td colspan="6" class="text-danger">Nenhum pedido foi encontrado.</td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
  	</div>
  </div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->