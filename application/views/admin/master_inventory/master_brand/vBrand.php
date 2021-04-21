<div>
	<?php $this->load->view('template/info_message', [
		'message' => '<h6>Harap mengisi data dengan <b style="color: #ec3305">Benar</b> dikarenakan data master Brand Atau Merek <b style="color: #ec3305">menyambung</b> dengan <b style="color: #ec3305">transaksi laptop</b> masuk dan keluar, data lainnya dan tidak adanya fitur <b style="color: #ec3305">hapus</b> data!!</h6>',
	]); ?>
	<div class="card">
        <div class="card-header">
        	<div class="row">
        		<div class="col-6">
           			<h5 id="textHeader" class="mt-2"></h5>
        		</div>
        		<div class="col-6">
        			<div class="float-right">
            			<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="tambahBrand()"><i class="fa fa-plus text-white"></i> Tambah Brand</a>
            			<a href="javascript:void(0)" onclick="reloadData()" class="btn btn-primary btn-sm"><i class="fa fa-refresh text-white"></i> Reload</a>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="card-block">
        	<form id="formBrand" style="display: none;">
                <? $this->load->view('admin/master_inventory/master_brand/vBrandForm'); ?>
        	</form>
            <div class="table-responsive">
                <table class="table table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="95%">Brand Atau Merek</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tb_brand"></tbody>
                </table>
            </div>
        </div>
	</div>
</div>
<link rel="stylesheet" href="<?=base_url('assets/pages/notification/notification.css')?>">
<!--  -->
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-growl.min.js"></script>
<script src="<?=base_url('assets/custom_js/notification.custom.js')?>"></script>    
<!--  -->
<script type="text/javascript" src="<?=base_url('assets/custom_js/brand.custom.index.js')?>"></script>
