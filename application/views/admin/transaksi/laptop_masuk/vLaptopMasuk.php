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
                <table class="table table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="20%">Tanggal</th>
                            <th width="30%">No Faktur</th>
                            <th width="20%">Jumlah Laptop</th>
                            <th width="20%">Penanggung Jawab</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tb_brand"></tbody>
                </table>
            </div>
        </div>
	</div>
</div>