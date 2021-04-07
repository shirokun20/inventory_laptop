<div>
	<h4>
		Pencarian
	</h4>
	<hr>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-12 col-lg-6 form-material">
			<div class="form-group form-default">
                <input type="text" name="cari" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Cari Invoice, Konsumen atau total bayar...</label>
            </div>
		</div>
		<div class="col-6 col-lg-3">
			<div class="form-group">
			  <select class="form-control" name="status_transaction_id">
			    <option value="">Pilih Status Pesanan</option>
			    <?php  
		    	$q = $this->sb->mengambil('tb_status_transaction');
		    	foreach ($q->result() as $key) { ?>
			    <option value="<?=$key->status_transaction_id?>"><?=$key->status_transaction_nama?></option>
			   <?php } ?>
			  </select>
			</div>
		</div>
		<div class="col-6 col-lg-3">
			<div class="form-group">
			  <select class="form-control" name="status_payment_id">
			    <option value="">Pilih Status Pembayaran</option>
			    <?php  
		    	$q = $this->sb->mengambil('tb_status_payment');
		    	foreach ($q->result() as $key) { ?>
			    <option value="<?=$key->status_payment_id?>"><?=$key->status_payment_nama?></option>
			   <?php } ?>
			  </select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-4 col-lg-4 form-material">
			<div class="form-group form-default form-static-label">
                <input type="date" name="tanggal_a" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Tanggal</label>
            </div>
		</div>
		<div class="col-4 col-lg-4 text-center" style="padding-top: 7px">
			<h3>S/D</h3>
		</div>
		<div class="col-4 col-lg-4 form-material">
			<div class="form-group form-default form-static-label">
                <input type="date" name="tanggal_b" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Tanggal</label>
            </div>
		</div>
	</div>
</div>