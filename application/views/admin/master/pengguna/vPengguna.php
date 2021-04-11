 <div>
     <?php $this->load->view('admin/master/pengguna/vPenggunaCard'); ?>
     <div class="card">
        <div class="card-header">
            <h5>Data <?=$type_user_nama?></h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li>
                    	<i class="fa fa fa-wrench open-card-option"></i>
                    </li>
                    <li>
                    	<a href="javascript:void(0)" onclick="modalTambah()">
                    		<i class="fa fa-plus" data-toggle="tooltip" title="Tambah Pengguna"></i>
                    	</a>
                    </li>
                    <li>
                    	<a href="javascript:void(0)" onclick="reloadData()">
                    		<i class="fa fa-refresh" data-toggle="tooltip" title="Reload Data"></i>
                    	</a>
                    </li>
                </ul>
            </div>
        </div>
        <b style="display: none;" id="jabatan_id"><?=$jabatan_id?></b>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover" id="tb_pengguna" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Pengguna</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modalSet"></div>
</div>
<!--  -->
<link rel="stylesheet" href="<?=base_url('assets/js/datatables/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/pages/notification/notification.css')?>">
<!--  -->
<script src="<?=base_url('assets/js/datatables/js/jquery.dataTables.min.js')?>"></script>
<!--  -->
<script src="<?=base_url('assets/js/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
<!--  -->
<!-- notification js -->
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-growl.min.js"></script>
<!--  -->
<script type="text/javascript" src="<?=base_url('assets/custom_js/pengguna.custom.index.js')?>"></script>
<!-- Custom JS -->
<script src="<?=base_url('assets/custom_js/modal.custom.js')?>"></script>   
<script src="<?=base_url('assets/custom_js/notification.custom.js')?>"></script>    
<script src="<?=base_url('assets/custom_js/form.pengguna.custom.js')?>"></script>	