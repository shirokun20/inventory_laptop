<div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
		        <div class="card-header">
		        	<div class="row">
		        		<div class="col-12">
		           			<h5 id="textHeader" class="mt-2"><a href="javascript:void(0)" onclick="return window.history.back()" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a> <?=$title?></h5>
		        		</div>
		        	</div>
		        </div>
		        <div class="card-block">
		        	<div class="row">
		        		<div class="col-lg-6">
		        			<div class="form-group">
		        				<label>No Transaksi</label>
		        				<input type="text" name="transaksi_barang_no_faktur" class="form-control" readonly>
		        			</div>
		        		</div>
		        		<div class="col-lg-6">
		        			<div class="form-group">
		        				<label>Tanggal</label>
		        				<input type="date" name="transaksi_barang_tanggal" class="form-control" value="<?=date('Y-m-d');?>">
		        			</div>
		        		</div>
		        	</div>
		        </div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
		        	<div class="row">
		        		<div class="col-12">
		           			<h5 id="textHeader" class="mt-2">Detail Transaksi</h5>
		        		</div>
		        	</div>
				</div>
				<div class="card-block">
		            <div class="table-responsive">
		                <table class="table table-hover" width="100%">
		                    <thead>
		                        <tr>
		                            <th>No</th>
		                            <th width="25%">Laptop</th>
		                            <th width="20%">Model</th>
		                            <th width="25%">Prosesor</th>
		                            <th width="20%">Qty</th>
		                            <th width="5%">Aksi</th>
		                        </tr>
		                        <form id="formDt">
		                        <tr>
		                        	<th colspan="3">
	                        			<select name="barang_kode" class="custom-select" onchange="mengambilDetailBarang(this.value)" required>
	                        				<option value="">Pilih Laptop - Model</option>
	                        			</select>
		                        	</th>
		                        	<th>
	                        			<select name="detail_barang_id" class="custom-select"
	                        			onchange="mengambilStok(this.value)" required>
	                        				<option value="">Pilih Prosessor - Warna - Ram</option>
	                        			</select>
		                        	</th>
		                        	<th>
		                        		<input type="number" class="form-control" min="0" name="transaksi_barang_detail_jml" placeholder="Masukan qty" required>
		                        	</th>
		                        	<th>
		                        		<button class="btn btn-danger btn-block btn-sm" type="submit">TAMBAHKAN!</button>
		                        	</th>
		                        </tr>
		                        </form>
		                    </thead>
		                    <tbody id="dataTd">
		                    	<tr>
		                    		<td colspan="6" class="text-center">Belum ada barang yang dipilih</td>
		                    	</tr>
		                    </tbody>
		                </table>
		            </div>
		        </div>
			</div>
		</div>
		<div class="col-lg-9"></div>
		<div class="col-lg-3" id="cSimpan" style="display: none;">
			<div class="card">
				<div class="card-block">
					<button class="btn btn-primary btn-block btn-sm"><i class="fa fa-save"></i> Simpan</button>
				</div>
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
<script src="<?=base_url('assets/custom_js/notification.custom.js')?>"></script> 
<!--  -->
<!--  -->
<script>
	var jenis_transaksi = '<?= ($jenis_transaksi == 0 ? 'm' : 'k')?>'
</script>
<script>
	// url
	var url = window.location.href;
	var url_2 = url.substring(0,url.lastIndexOf('/transaksi_laptop/'));
	//
	var sisaStok = 0;
	var dataTabelDetail = [];
	var dataBarang = [];
	var dataDetailBarang = [];
	//
	var tag = {
		formDt: $('#formDt'),
		bk: $('[name="barang_kode"]'),
		dbid: $('[name="detail_barang_id"]'),
		tbdj: $('[name="transaksi_barang_detail_jml"]'),
		dataTd: $('#dataTd'),
		cSimpan: $('#cSimpan'),
		tbnf: $('[name="transaksi_barang_no_faktur"]'),
		tbt: $('[name="transaksi_barang_tanggal"]'),
	}
	//
	$(() => {
		setAwal();
		mengambilDataBarang();
		mengambilUniqCode();
	});
	//
	tag.tbt.on({
		change: () => mengambilUniqCode(),
	});
	//
	tag.formDt.on({
		submit: () => {	
			if (tag.formDt[0].checkValidity()) simpanKeDt();
			return false;
		}
	});
	//
	var setAwal = () => {
		tag.formDt[0].reset();
		setTabelTD();
		if (dataTabelDetail.length > 0) {
			tag.cSimpan.slideDown('slow');
		} else {
			tag.cSimpan.slideUp('slow');
		}
	}
	//
	var mengambilUniqCode = () => {
		var res = $.ajax({
			url: `${url_2}/transaksi_laptop/getUniqCode`,
			type: 'GET',
			dataType: 'JSON',
			data: {
				tanggal: tag.tbt.val(),
				jenis_transaksi,
			}
		});
		res.then(({
			shiro
		}) => {
			tag.tbnf.val(shiro.uniqCode);
		})
	}
	//
	var mengambilDataBarang = () => {
		var res = $.ajax({
			url: `${url_2}/transaksi_laptop/mengambilBarang`,
			type: 'GET',
			dataType: 'JSON',
		});
		res.then(({
			shiro
		}) => {
			dataBarang = shiro.data;
			setBarang();
		})
	}
	//
	var mengambilDetailBarang = value => {
		dataDetailBarang = [];
		var res = $.ajax({
			url: `${url_2}/transaksi_laptop/mengambilDetailBarang`,
			type: 'GET',
			dataType: 'JSON',
			data: {
				barang_kode: value,
			}
		});
		res.then(({
			shiro
		}) => {
			dataDetailBarang = shiro.data;
			setDetailBarang();
		})
	}
	//
	var mengambilStok = value => {
		if (jenis_transaksi == 'k') {
			var res = $.ajax({
				url: `${url_2}/transaksi_laptop/mengambilStok`,
				type: 'GET',
				dataType: 'JSON',
				data: {
					detail_barang_id: value,
				}
			});

			res.then(({shiro}) => {
				sisaStok = shiro.jumlah_stok;
			})
		}
	}
	//
	var setBarang = () => {
		var obj = '<option value="">Pilih Laptop - Model</option>';
			dataBarang.map((e, index) => {
				obj += `<option value="${e.barang_kode}">${e.barang_name} - ${e.barang_model}</option>`
			});
		tag.bk.html(obj);
	}
	//
	var setDetailBarang = () => {
		var obj = '<option value="">Pilih Prosesor - Warna - Ram</option>';
			dataDetailBarang.map((e, index) => {
				obj += `<option value="${e.detail_barang_id}">${e.detail_barang_processor} - ${e.warna_nama} - ${e.detail_barang_ram}GB</option>`
			});
		tag.dbid.html(obj);
	}
	//
	var _setTabelTD = (text = '') => {
		var obj = '';
		obj += '<tr>';
		obj += `<td colspan="6" class="text-center">${text}</td>`;
		obj += '</tr>';
		return obj;
	}
	//
	var setBtnTD = (e, index) => {
		var obj = '<td>';
			obj += `<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-block" onclick="hapusDataDetail('${index}')">`;
			obj += '<i class="fa fa-remove"></i> Hapus';
			obj += '</a>';
			obj += '</td>';
		return obj;
	}
	//
	var setTabelTD = () => {
		var obj = '';
		if (dataTabelDetail.length > 0) {
			dataTabelDetail.map((e, index) => {
				obj += '<tr>';
				obj += `<td>${(index + 1)}</td>`;
				obj += `<td>${e.laptop}</td>`;
				obj += `<td>${e.model}</td>`;
				obj += `<td>${e.prosesor} - ${e.warna_nama} - ${e.detail_barang_ram}GB</td>`;
				obj += `<td>${e.transaksi_barang_detail_jml}</td>`;
				obj += setBtnTD(e, index);
				obj += '</tr>';
			});
		} else {
			obj += _setTabelTD('Belum ada barang yang dipilih');
		}
		tag.dataTd.html(obj);
	}
	//
	var simpanKeDt = () => {
        CustomNotification('Tunggu Sebentar!', 'sedang menambah laptop ke detail transaksi!!', 'fa fa-exchange', 'inverse');
		var checkData = dataTabelDetail.filter((e) => e.detail_barang_id = tag.dbid.val());
		if (checkData.length < 1) {
			if (jenis_transaksi == 'k' && sisaStok < parseInt(tag.tbdj.val())) {
				tag.dataTd.html(_setTabelTD('Tunggu Sebentar!'));
				setTimeout((e) => {
					setAwal();
					CustomNotification('Gagal!', `Qty (${tag.tbdj.val()}) melebihi sisa stok (${sisaStok}) !!`, 'fa fa-times-circle', 'danger');
				}, 2000);
			} else {
				_simpanKeDt();
			}
		} else {
			tag.dataTd.html(_setTabelTD('Tunggu Sebentar!'));
			setTimeout((e) => {
				setAwal();
				CustomNotification('Gagal!', 'laptop sudah ditambahkan sebelumnya!!', 'fa fa-times-circle', 'danger');
			}, 2000);
			
		}
	}

	var _simpanKeDt = () => {
		    var obj = new Object();
			obj.barang_kode = tag.bk.val();
			obj.detail_barang_id = tag.dbid.val();
			obj.transaksi_barang_detail_jml = tag.tbdj.val();
			var check = dataBarang.find((e) => e.barang_kode = obj.barang_kode);
			obj.laptop = check.barang_name;
			obj.model = check.barang_model;
			var check2 = dataDetailBarang.find((e) => e.detail_barang_id = obj.detail_barang_id);
			obj.prosesor = check2.detail_barang_processor;
			obj.warna_nama = check2.warna_nama;
			obj.detail_barang_ram = check2.detail_barang_ram;
			dataTabelDetail.push(obj);
			tag.dataTd.html(_setTabelTD('Tunggu Sebentar!'));
			setTimeout((e) => {
				setAwal();
				CustomNotification('Berhasil!', 'menambahkan laptop ke detail transaksi!!', 'fa fa-check', 'success');
			}, 2000);
	}

	var hapusDataDetail = value => {
		if (confirm('Apakah Anda Yakin?')) {
			var data = dataTabelDetail.filter((e, index) => index != value);
			dataTabelDetail = data;
			tag.dataTd.html(_setTabelTD('Tunggu Sebentar!'));
			CustomNotification('Tunggu Sebentar!', 'sedang menghapus data detail transaksi!', 'fa fa-exchange', 'inverse');
			setTimeout((e) => {
				setAwal();
				CustomNotification('Berhasil!', 'menghapus data detail transaksi!!', 'fa fa-check', 'success');
			}, 2000);
		} 
	}
</script>