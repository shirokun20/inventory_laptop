<div>
	<div class="row">
         <div class="col-lg-4 col-12">
            <div class="card bg-c-red total-card">
                <div class="card-block">
                    <div class="text-left">
                        <h4 id="total_pesanan_aktif">0</h4>
                        <p class="m-0"><i class="fa fa-archive"></i> Pesanan Aktif</p>
                    </div>
                </div>
            </div>
         </div>
         <div class="col-lg-4 col-12">
             <div class="card bg-c-blue total-card">
                <div class="card-block">
                    <div class="text-left">
                        <h4 id="total_pesanan_selesai">0</h4>
                        <p class="m-0"><i class="fa fa-check-square-o"></i> Pesanan Selesai</p>
                    </div>
                </div>
            </div>
         </div>
         <div class="col-lg-4 col-12">
             <div class="card bg-c-green total-card">
                <div class="card-block">
                    <div class="text-left">
                        <h4 id="total_pesanan_dibatalkan">0</h4>
                        <p class="m-0"><i class="fa fa-times-rectangle-o"></i> Pesanan Dibatalkan</p>
                    </div>
                </div>
            </div>
         </div>
     </div>
     <div class="card">
        <div class="card-header">
            <h5><?=$title?></h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li>
                    	<i class="fa fa fa-wrench open-card-option"></i>
                    </li>
                    <li>
                    	<a href="<?=site_url('admin/transaksi/pemesanan/tambah/')?>">
                    		<i class="fa fa-plus" data-toggle="tooltip" title="Tambah Pesanan Baru"></i>
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
        <div class="card-block">
        	<?php  
        		$this->shiro_lib->page('admin/transaksi/pemesanan/vPemesananSearch');
        	?>
            <div class="table-responsive">
                <table class="table table-hover" id="tb_pemesanan" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Waktu Pemesanan</th>
                            <th>Konsumen</th>
                            <th data-toggle="tooltip" title="Total yang harus dibayar!">Total Bayar</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
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
<script src="<?=base_url('assets/js/datatables/js/jquery.dataTables.min.js')?>"></script>
<!--  -->
<script src="<?=base_url('assets/js/datatables/js/dataTables.bootstrap4.min.js')?>"></script>
<!--  -->
<script type="text/javascript" src="<?=base_url('assets/custom_js/pemesanan.custom.index.js')?>"></script>
