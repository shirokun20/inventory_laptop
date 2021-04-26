<div>
	<?php $this->load->view('template/info_message', [
		'message' => '<h6>Harap mengisi data dengan <b style="color: #ec3305">Benar</b> dikarenakan data master laptop <b style="color: #ec3305">menyambung</b> dengan <b style="color: #ec3305">transaksi laptop</b> masuk dan keluar, data lainnya dan tidak adanya fitur <b style="color: #ec3305">hapus</b> data!!</h6>',
	]); ?>
	<div class="card">
        <div class="card-header">
        	<div class="row">
        		<div class="col-6">
           			<h5 id="textHeader" class="mt-2">Data Laptop</h5>
        		</div>
        		<div class="col-6">
        			<div class="float-right">
            			<a href="<?=site_url('admin/master_inventory/master_laptop/tambah')?>" class="btn btn-danger btn-sm"><i class="fa fa-plus text-white"></i> Tambah Laptop</a>
            			<a href="javascript:void(0)" onclick="reloadData()" class="btn btn-primary btn-sm"><i class="fa fa-refresh text-white"></i> Reload</a>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover" id="tb_laptop" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="15%">Kode</th>
                            <th width="25%">Laptop</th>
                            <th width="20%">Brand</th>
                            <th width="20%">Model</th>
                            <th width="10%">Stok</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
	</div>
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
<script>
    //
    var url = window.location.href;
    var tabel;
    //
    var tag = {
        tb_laptop: $('#tb_laptop'),
    }
    //
    $(() => {
        datatablesAjax();
    });
    //
    let datatablesAjax = () => {
        tabel = tag.tb_laptop.DataTable({
            "processing": true, 
            "ordering": true, 
            "info": false, 
            "serverSide": true, 
            "order": [], 
            // Ajax
            "ajax": {
                "url": `${url}/showDataLaptop/`,
                "type": "POST",
            },
            // Order
            "columnDefs": [{ 
                "targets": [ 0 ], 
                "orderable": false, 
            }],
        });
    }

    let reloadData = () => {
        tabel.ajax.reload();
    }
    //
</script>