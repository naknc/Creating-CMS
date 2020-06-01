
								<div role="tabpanel" class="tab-pane in active fade" id="tab-1">
									<div class="row">
										<div class="form-group col-md-8">
											<label>Şirket Adı</label>
											<input class="form-control" placeholder="Şirketin ya da Sitenizin Adı" 
											name="company_name" 
											value = "<?php echo isset($form_error) ? set_value("company_name") : $item->company_name; ?>">
											<?php if(isset($form_error)){ ?>
												<small class="pull-right input-form-error"><?php echo form_error("company_name"); ?></small>
											<?php } ?>	
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-4">
											<label>Telefon 1</label>
											<input class="form-control" placeholder="Telefon numaranız" name="phone_1" 
											value = "<?php echo isset($form_error) ? set_value("phone_1") : $item->phone_1; ?>">
											<?php if(isset($form_error)){ ?>
												<small class="pull-right input-form-error"><?php echo form_error("phone_1"); ?></small>
											<?php } ?>	
										</div>
										<div class="form-group col-md-4">
											<label>Telefon 2</label>
											<input class="form-control" placeholder="Diğer telefon numaranız (opsiyonel)" name="phone_2" 
											value = "<?php echo isset($form_error) ? set_value("phone_2") : $item->phone_2; ?>">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-4">
											<label>Faks 1</label>
											<input class="form-control" placeholder="Faks numaranız" name="fax_1" 
											value = "<?php echo isset($form_error) ? set_value("fax_1") : $item->fax_1; ?>">
										</div>
										<div class="form-group col-md-4">
											<label>Faks 2</label>
											<input class="form-control" placeholder="Diğer faks numaranız (opsiyonel)" name="fax_2" 
											value = "<?php echo isset($form_error) ? set_value("fax_2") : $item->fax_2; ?>">
										</div>
									</div>
								</div><!-- .tab-pane  -->