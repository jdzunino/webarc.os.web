<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>application/views/compras/compraControle.js"></script>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Cadastro de compra</h5>
            </div>
            <div class="widget-content nopadding">


                <div class="span12" id="divProdutosServicos" style=" margin-left: 0">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDetalhes"><a href="#tab1" data-toggle="tab">Detalhes da compra</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">

                            <div class="span12" id="divCadastrarOs">
                                <?php if($custom_error == true){ ?>
                                <div class="span12 alert alert-danger" id="divInfo" style="padding: 1%;">Dados incompletos, verifique os campos com asterisco ou se selecionou corretamente fornecedor e comprador.</div>
                                <?php } ?>
                                <form action="<?php echo current_url(); ?>" method="post" id="formCompras">

                                    <div class="span12" style="padding: 1%">

                                        <div class="span2">
                                            <label for="dataInicial">Data da Compra<span class="required">*</span></label>
                                            <input id="dataCompra" class="span12 datepicker" type="text" name="dataCompra" value="<?php echo date('d/m/Y'); ?>"  />
                                        </div>
                                        <div class="span5">
                                            <label for="cliente">Fornecedor<span class="required">*</span></label>
                                            <input id="fornecedor" class="span12" type="text" name="fornecedor" value=""  />
                                            <input id="fornecedor_id" class="span12" type="hidden" name="fornecedor_id" value=""  />
                                        </div>
                                        <div class="span5">
                                            <label for="tecnico">Usuário Comprador<span class="required">*</span></label>
                                            <input id="tecnico" class="span12" type="text" name="tecnico" value=""  />
                                            <input id="usuarios_id" class="span12" type="hidden" name="usuarios_id" value=""  />
                                        </div>

                                    </div>

                                    <div class="span12" style="padding: 1%; margin-left: 0">
                                        <div class="span6 offset3" style="text-align: center">
                                            <button class="btn btn-success" id="btnContinuar"><i class="icon-share-alt icon-white"></i> Continuar</button>
                                            <a href="<?php echo base_url() ?>index.php/compras" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>


.

        </div>

    </div>
</div>
</div>
