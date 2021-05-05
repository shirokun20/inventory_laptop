<div>
	<div class="card">
        <div class="card-header">
        	<div class="row">
        		<div class="col-6">
           			<h5 id="textHeader" class="mt-2">Data Transaksi Laptop Masuk</h5>
        		</div>
        		<div class="col-6">
        			<div class="float-right">
            			<a href="<?=site_url('data/transaksi/transaksi_laptop/0')?>" class="btn btn-danger btn-sm"><i class="fa fa-plus text-white"></i> Transaksi</a>
            			<a href="javascript:void(0)" onclick="reloadData()" class="btn btn-primary btn-sm"><i class="fa fa-refresh text-white"></i> Reload Data</a>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover" id="tb_transaksi" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="20%">Tanggal</th>
                            <th width="30%">No Transaksi</th>
                            <th width="20%">Jumlah Laptop</th>
                            <th width="20%">Penanggung Jawab</th>
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
<!--  -->
<script>
    var tbj = '0';
</script>
<!--  -->
<script src="<?=base_url('assets/js/datatables/js/jquery.dataTables.min.js')?>"></script>
<!--  -->
<script src="<?=base_url('assets/js/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
<!--  -->
<script type="text/javascript">
    var url = window.location.href;
    // table
    var tabel;
    //
    var tb_transaksi = $('#tb_transaksi');
    //
    $(() => {
        datatablesAjax();
    })
    //
    let datatablesAjax = () => {
        tabel = tb_transaksi.DataTable({
            "processing": true, 
            "ordering": true, 
            "info": false, 
            "serverSide": true, 
            "order": [], 
            // Ajax
            "ajax": {
                "url": `${url}/showDataTransaksi/`,
                "type": "POST",
                "data": ( data ) => {
                    data.transaksi_barang_jenis = tbj;
                }
            },
            // Order
            "columnDefs": [{ 
                "targets": [ 0 ], 
                "orderable": false, 
            }],
        });
    }
    //
    var reloadData = () => {
        tabel.ajax.reload(0);
    }
</script>