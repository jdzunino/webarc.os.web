<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url();?>assets/js/maskmoney.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>application/views/compras/compraControle.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Editar Compra</h5>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da Compra</a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divEditarVenda">

                                <form action="<?php echo current_url(); ?>" method="post" id="formCompras">
                                    <?php echo form_hidden('idCompras',$result->idCompras) ?>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <h3>#Compra: <?php echo $result->idCompras ?></h3>
                                        <div class="span2" style="margin-left: 0">
                                            <label for="dataFinal">Data Final</label>
                                            <input id="dataCompra" class="span12 datepicker" type="text" name="dataCompra" value="<?php echo date('d/m/Y', strtotime($result->dataCompra)); ?>"  />
                                        </div>
                                        <div class="span5" >
                                            <label for="fornecedor">Fornecedor<span class="required">*</span></label>
                                            <input id="fornecedor" class="span12" type="text" name="fornecedor" value="<?php echo $result->nomeCliente ?>"  />
                                            <input id="fornecedor_id" class="span12" type="hidden" name="fornecedor_id" value="<?php echo $result->fornecedor_id ?>"  />
                                            <input id="valorTotal" type="hidden" name="valorTotal" value=""  />
                                        </div>
                                        <div class="span5">
                                            <label for="tecnico">Usuário Comprador<span class="required">*</span></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" value="<?php echo $result->nome ?>"  />
                                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value="<?php echo $result->usuarios_id ?>"  />
                                        </div>

                                    </div>




                                    <div class="span12" style="padding: 1%; margin-left: 0">

                                        <div class="span8 offset2" style="text-align: center">
                                            <?php if($result->faturado == 0){ ?>
                                            <a href="#modal-faturar" id="btn-faturar" role="button" data-toggle="modal" class="btn btn-success"><i class="icon-file"></i> Faturar</a>
                                            <?php } ?>
                                            <button class="btn btn-primary" id="btnContinuar"><i class="icon-white icon-ok"></i> Alterar</button>
                                            <a href="<?php echo base_url() ?>index.php/compras/visualizar/<?php echo $result->idCompras; ?>" class="btn btn-inverse"><i class="icon-eye-open"></i> Visualizar Compra</a>
                                            <a href="<?php echo base_url() ?>index.php/compras" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>

                                    </div>

                                </form>

                                <div class="span11 well" style="align: center">
                                        <h3>Produtos</h3>
                                        <form title="Teste" id="formProdutos" action="<?php echo base_url(); ?>index.php/compras/adicionarProduto" method="post">
                                            <div class="span6" >
                                                <input type="hidden" name="idProduto" id="idProduto" />
                                                <input type="hidden" name="idComprasProduto" id="idComprasProduto" value="<?php echo $result->idCompras?>" />
                                                <input type="hidden" name="estoque" id="estoque" value=""/>
                                                <label for="">Produto</label>
                                                <input type="text" name="produto" id="produto" placeholder="Digite o nome do produto" class="span11"/>
                                            </div>
                                            <div class="span3">
                                                <label for="">Preço Compra</label>
                                                <input type="text" placeholder="Preço" name="preco" id="preco" value="" class="span11"/>
                                            </div>
                                            <div class="span3">
                                                <label for="">Quantidade</label>
                                                <input type="text" placeholder="Quantidade" id="quantidade" name="quantidade" class="span11"/>
                                            </div>
                                            <div class="span4">
                                                <label for="">&nbsp</label>
                                                <button class="btn btn-success span11" id="btnAdicionarProduto" placeholder="Preço"><i class="icon-white icon-plus"></i> Adicionar</button>
                                            </div>
                                        </form>

                                        <div id="divProdutos" style="margin-top: 10px;">

                                            <table class="table table-bordered" id="tblProdutos">
                                                <thead>
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th>Quantidade</th>
                                                        <th>Ações</th>
                                                        <th>Sub-total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $total = 0;
                                                    foreach ($produtos as $p) {
                                                        $total = $total + $p->subTotal;
                                                        echo '<tr>';
                                                        echo '<td>'.$p->descricao.'</td>';
                                                        echo '<td>'.$p->quantidade.'</td>';
                                                        echo '<td><a href="" idAcao="'.$p->idItens.'" prodAcao="'.$p->idProdutos.'" quantAcao="'.$p->quantidade.'" title="Excluir Produto" class="btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
                                                        echo '<td>R$ '.number_format($p->subTotal,2,',','.').'</td>';
                                                        echo '</tr>';
                                                    }?>

                                                    <tr>
                                                        <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                                                        <td><strong>R$ <?php echo number_format($total,2,',','.');?></strong> <input type="hidden" id="total-venda" value="<?php echo number_format($total,2); ?>"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>


                            </div>

                        </div>

                    </div>

                </div>


.

        </div>

    </div>
</div>
</div>


<!-- Modal Faturar-->
<div id="modal-faturar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form id="formFaturar" action="<?php echo current_url() ?>" method="post">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">Faturar Compra</h3>
</div>
<div class="modal-body">

    <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
    <div class="span12" style="margin-left: 0">
      <label for="descricao">Descrição</label>
      <input class="span12" id="descricao" type="text" name="descricao" value="Fatura de Compra - #<?php echo $result->idCompras; ?> "  />

    </div>
    <div class="span12" style="margin-left: 0">
      <div class="span12" style="margin-left: 0">
        <label for="fornecedor">Fornecedor*</label>
        <input class="span12" id="fornecedor" type="text" name="fornecedor" value="<?php echo $result->nomeCliente ?>" />
        <input type="hidden" name="fornecedor_id" id="fornecedor_id" value="<?php echo $result->fornecedor_id ?>">
        <input type="hidden" name="compras_id" id="compras_id" value="<?php echo $result->idCompras; ?>">
      </div>


    </div>
    <div class="span12" style="margin-left: 0">
      <div class="span2" style="margin-left: 0">
        <label for="valor">Valor Total*</label>
        <input type="hidden" id="tipo" name="tipo" value="despesa" />
        <input class="span12 money" id="valor" type="text" name="valor" value="<?php echo number_format($total,2); ?> "  />
      </div>

    </div>



    <div class="span11 well" style="align: center">
            <h3>Parcelas</h3>
            <form title="Teste" id="formParcelas" action="<?php echo base_url(); ?>index.php/compras/faturar" method="post">
              <div class="span3" >
                <label for="vencimento">Vencimento*</label>
                <input class="span12 datepicker" id="vencimento" type="text" name="vencimento"  />
              </div>
              <div class="span2" style="margin-left: 0">
                <label for="valor">Valor*</label>
                <input type="hidden" id="tipo" name="tipo" value="despesa" />
                <input class="span12 money" id="valor" type="text" name="valor" value="<?php echo number_format($total,2); ?> "  />
              </div>
              <div class="span2" style="margin-left: 0">
                <label for="recebido">Quitado?</label>
                &nbsp &nbsp &nbsp &nbsp<input  id="recebido" type="checkbox" name="recebido" value="1" />
              </div>
              <div id="divRecebimento" class="span8" style=" display: none">
                <div class="span6">
                  <label for="recebimento">Data Pagamento</label>
                  <input class="span12 datepicker" id="recebimento" type="text" name="recebimento" />
                </div>
                <div class="span6">
                  <label for="formaPgto">Forma Pgto</label>
                  <select name="formaPgto" id="formaPgto" class="span12">
                    <option value="Dinheiro">Dinheiro</option>
                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Boleto">Boleto</option>
                    <option value="Depósito">Depósito</option>
                    <option value="Débito">Débito</option>
                  </select>
                </div>
              </div>
                <div class="span4">
                    <label for="">&nbsp</label>
                    <button class="btn btn-success span11" id="btnAdicionarParcela"><i class="icon-white icon-plus"></i> Adicionar</button>
                </div>
            </form>

            <div id="divParcelas" style="margin-top: 10px;">

                <table class="table table-bordered" id="tblParcelas">
                    <thead>
                        <tr>
                            <th>Parcela</th>
                            <th>Vencimento</th>
                            <th>Valor</th>
                            <th>Quitado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        $count = 1;
                        foreach ($parcelas as $p) {
                            $total = $total + $p->subTotal;
                            echo '<tr>';
                            echo '<td>'.$count.'</td>';
                            echo '<td>'.$p->vencimento.'</td>';
                            echo '<td>'.number_format($p->valor,2,',','.').'</td>';

                            switch ($r->baixado) {
                                case 0:
                                    $quitadoDesc = 'Não';
                                    break;
                                case 1:
                                    $quitadoDesc = 'Sim';
                                    break;
                            }

                            echo '<td>'.$quitadoDesc.'</td>';
                            echo '</tr>';
                        }?>

                        <tr>
                            <td colspan="3" style="text-align: right"><strong>Total Parcelas:</strong></td>
                            <td><strong>R$ <?php echo number_format($total,2,',','.');?></strong> <input type="hidden" id="total-venda" value="<?php echo number_format($total,2); ?>"></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>








</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true" id="btn-cancelar-faturar">Cancelar</button>
  <button class="btn btn-primary">Faturar</button>
</div>
</form>
</div>
