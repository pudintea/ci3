                    <?php defined('__PUDINTEA__') OR exit('No direct script access allowed'); ?>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?=$pdn_title;?></h1>
                        <!--
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                        -->
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-right">
                            <a href="<?=base_url($pdn_url.'/tambah');?>"  class="btn btn-primary btn-sm "><i class="fa fa-fw fa-lg fa-check-circle">&nbsp;</i>Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="pdn_mytable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Level</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					