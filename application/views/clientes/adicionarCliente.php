  <link rel="stylesheet" href="<?php echo base_url();?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
  <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>application/views/clientes/clienteControle.js"></script>
  <div class="row-fluid" style="margin-top:0">
      <div class="span12">
          <div class="widget-box">
              <div class="widget-title">
                  <span class="icon">
                      <i class="icon-user"></i>
                  </span>
                  <h5>Cadastro de Cliente</h5>
              </div>
              <div class="widget-content nopadding">
                  <?php if ($custom_error != '') {
                      echo '<div class="alert alert-danger">' . $custom_error . '</div>';
                  } ?>
                  <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                      <div class="control-group">
                          <label for="nomeCliente" class="control-label">Nome<span class="required">*</span></label>
                          <div class="controls">
                              <input id="nomeCliente" type="text" name="nomeCliente" value="<?php echo set_value('nomeCliente'); ?>"  />
                          </div>
                      </div>
                      <div class="control-group">
                          <label for="documento" class="control-label">CPF/CNPJ<span class="required">*</span></label>
                          <div class="controls">
                              <input id="documento" type="text" name="documento" value="<?php echo set_value('documento'); ?>"  />
                          </div>
                      </div>
                      <div class="control-group">
                          <label for="telefone" class="control-label">Telefone<span class="required">*</span></label>
                          <div class="controls">
                              <input id="telefone" type="text" name="telefone" value="<?php echo set_value('telefone'); ?>"  />
                          </div>
                      </div>

                      <div class="control-group">
                          <label for="celular" class="control-label">Celular</label>
                          <div class="controls">
                              <input id="celular" type="text" name="celular" value="<?php echo set_value('celular'); ?>"  />
                          </div>
                      </div>

                      <div class="control-group">
                          <label for="email" class="control-label">Email<span class="required">*</span></label>
                          <div class="controls">
                              <input id="email" type="text" name="email" value="<?php echo set_value('email'); ?>"  />
                          </div>
                      </div>

                      <div class="control-group">
                          <label for="numero" class="control-label">Tipo<span class="required">*</span></label>
                          <div class="controls">
                            <select name="tipoPessoa" id="tipoPessoa">
                              <option value="1">Cliente</option>
                              <option value="2">Fornecedor</option>
                              <option value="3">Cliente/Fornecedor</option>
                            </select>
                          </div>
                      </div>

                      <div class="control-group" class="control-label">
                          <label for="cep" class="control-label">CEP<span class="required">*</span></label>
                          <div class="controls">
                              <input id="cep" type="text" name="cep" value="<?php echo set_value('cep'); ?>"  />
                          </div>
                      </div>

                      <div class="control-group" class="control-label">
                          <label for="cidade" class="control-label">Cidade<span class="required">*</span></label>
                          <div class="controls">
                              <input id="cidade" type="text" name="cidade" value="<?php echo set_value('nome'); ?>"  />
                              <input id="cidade_id" class="span12" type="hidden" name="cidade_id" value=""  />
                          </div>
                      </div>

                      <div class="control-group" class="control-label">
                          <label for="bairro" class="control-label">Bairro<span class="required">*</span></label>
                          <div class="controls">
                              <input id="bairro" type="text" name="bairro" value="<?php echo set_value('bairro'); ?>"  />
                          </div>
                      </div>

                      <div class="control-group" class="control-label">
                          <label for="rua" class="control-label">Rua<span class="required">*</span></label>
                          <div class="controls">
                              <input id="rua" type="text" name="rua" value="<?php echo set_value('rua'); ?>"  />
                          </div>
                      </div>

                      <div class="control-group">
                          <label for="numero" class="control-label">Número<span class="required">*</span></label>
                          <div class="controls">
                              <input id="numero" type="text" name="numero" value="<?php echo set_value('numero'); ?>"  />
                          </div>
                      </div>

                      <div class="form-actions">
                          <div class="span12">
                              <div class="span6 offset3">
                                  <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Adicionar</button>
                                  <a href="<?php echo base_url() ?>index.php/clientes" id="" class="btn"><i class="icon-arrow-left"></i> Voltar</a>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
