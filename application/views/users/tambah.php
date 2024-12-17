					<?php defined('__PUDINTEA__') OR exit('No direct script access allowed'); ?>
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?=$pdn_title;?></h1>
                        <!--
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                        -->
                    </div>
					<div class="card shadow mb-4">
                        <div class="card-body">
                        	<div class="text-center mb-5">
                        		<h4><?=$pdn_title;?></h4>
                        	</div>
                        	</hr>
                        	<?= form_open_multipart(base_url($pdn_uform), 'class="form-horizontal" role="form"'); ?>
								<div class="tile-body">
									<div class="form-group row">
										<label class="control-label col-md-3">Nama</label>
										<div class="col-md-8">
											<?php echo form_input($nama);?>
											<?=form_error('nama','<small class="text-danger pl-3">','</small>');?>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3">Email</label>
										<div class="col-md-8">
											<?php echo form_input($email);?>
											<?=form_error('email','<small class="text-danger pl-3">','</small>');?>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3">Level</label>
										<div class="col-md-8">
											<select class="form-control" id="pDn_Select1" name="level">
												<option value="Guest">Guest</option>
												<option value="Admin">Admin</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label col-md-3">Password</label>
										<div class="col-md-8">
											<?php echo form_input($password1);?>
											<?=form_error('password1','<small class="text-danger pl-3">','</small>');?>
											<?php echo form_input($password2);?>
										</div>
									</div>
								</div>
								<div class="tile-footer">
									<div class="row ">
										<div class="col-md-12 text-right mt-5">
											<a class="btn btn-secondary" href="<?=base_url($pdn_url);?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Kembali</a>
											<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><?=$pdn_page;?></button>
										</div>
									</div>
								</div>
							<?= form_close();?>
                        </div>
                    </div>