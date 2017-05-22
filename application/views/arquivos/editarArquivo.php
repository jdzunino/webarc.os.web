<link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/validate.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>application/views/arquivos/arquivoControle.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-hdd"></i>
                </span>
                <h5>Cadastro de Arquivo</h5>
            </div>
            <div class="widget-content nopadding">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formArquivo" method="post" class="form-horizontal" >


                    <div class="control-group">
                        <label for="nome" class="control-label">Nome do Arquivo*</label>
                        <div class="controls">
                            <input id="nome" type="text" name="nome" value="<?php echo $result->documento; ?> " />

                            <input id="idDocumentos" type="hidden" name="idDocumentos" value="<?php echo $result->idDocumentos; ?> " />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descricao" class="control-label">Descrição</label>
                        <div class="controls">
                            <textarea rows="3" cols="30" name="descricao" id="descricao"><?php echo $result->descricao; ?></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="descricao" class="control-label">Data</label>
                        <div class="controls">
                            <input id="data" type="text" class="datepicker" name="data" value="<?php echo date('d/m/Y',strtotime($result->cadastro));?>" />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Alterar</button>
                                <a href="<?php echo base_url() ?>index.php/arquivos" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
