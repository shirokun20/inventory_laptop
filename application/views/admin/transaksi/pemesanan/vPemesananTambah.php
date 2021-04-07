<div>
	<div class="row" style="margin-bottom: 10px;">
		<div class="col-12 col-sm-3">
			<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="return window.history.back();">
        		<i class="fa fa-arrow-left"></i> Kembali
        	</a>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-lg-12">
			<div class="card">
			    <div class="card-header">
			        <h5>Info Pemesanan</h5>
			    </div>
			    <div class="card-block no-padding">
			    	<div class="table-responsive">
			    		<table class="table table-bordered" width="100%">
			    			<thead>
			    				<tr>
				    				<th>INVOICE</th>
				    				<th class="text-center">:</th>
				    				<th class="text-right transaction_invoice" style="font-weight: bold;"></th>
				    				<th>Tanggal Pemesanan</th>
				    				<th class="text-center">:</th>
				    				<th class="text-right" style="font-weight: bold;"><?=date('d/m/Y')?></th>
				    			</tr>
			    			</thead>
			    		</table>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-lg-12">
			<div class="card">
			    <div class="card-header">
			        <h5>Detail <i>File</i> pemesanan</h5>
			        <div class="float-right">
			        	<a href="javascript:void(0)" class="btn btn-primary btn-sm" id="btnTFile">
        					<i class="fa fa-plus"></i> Tambah File
        				</a>
			        </div>
			    </div>
			    <form id="formFile">
				    <?php  
		        		$this->shiro_lib->page('admin/transaksi/pemesanan/vPemesananInputFile');
		        	?>
			    </form>
			    <div class="card-block">
			    	<div class="table-responsive">
			    		<table class="table table-hover" width="100%">
			    			<thead>
			    				<tr>
			    					<th>#</th>
			    					<th title="Nama File/Url (yang mengirimkan filenya berupa google driver)" data-toggle="tooltip">Nama/Url</th>
			    					<th title="Jenis Print (Warna/Non Warna)" data-toggle="tooltip">Jenis</th>
			    					<th>Size (MB)</th>
			    					<th title="Halaman berapa saja yang di print!" data-toggle="tooltip">Halaman</th>
			    					<th title="Jumlah Halaman" data-toggle="tooltip">Total</th>
			    					<th title="Keterangan" data-toggle="tooltip">Ket</th>
			    					<th>Aksi</th>
			    				</tr>
			    			</thead>
			    			<tbody id="dataSementaraTbl"></tbody>
			    		</table>
			    	</div>
			    </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-lg-8">
			<div class="card">
			    <div class="card-header">
			        <h5>Info Pembayaran</h5>
			    </div>
			    <div class="card-block no-padding">
			    	<div class="table-responsive">
			    		<table class="table table-bordered" width="100%">
			    			<thead>
			    				<tr>
				    				<th>Total Print Warna</th>
				    				<th class="text-center">:</th>
				    				<th class="text-right" style="font-weight: bold;">(<span class="totalHalamanWarna">0</span> x <span class="Print_Warna_Harga">0</span>) <span class="totalBiayaPrintWarna"></span></th>
				    			</tr>
				    			<tr>
				    				<th>Total Print Hitam/Putih</th>
				    				<th class="text-center">:</th>
				    				<th class="text-right" style="font-weight: bold;">(<span class="totalHalamanHP">0</span> x <span class="Print_Hitam_Putih_Harga">0</span>) <span class="totalBiayaPrintHp"></span></th>
				    			</tr>
				    			<tr>
				    				<th>Total yang harus dibayar</th>
				    				<th class="text-center">:</th>
				    				<th class="text-right" style="font-weight: bold;"><span class="totalBiayaPrint"></span></th>
				    			</tr>
				    		</thead>
			    		</table>
			    	</div>
			    </div>
			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="card cardBtnOrder hidden">
			    <div class="card-block">
			    	<button class="btn btn-success btn-block" onclick="orderNow()">Order Now</button>
			    </div>
			</div>
		</div>
	</div>
</div>
<!-- Notifikasi local -->
<link rel="stylesheet" href="<?=base_url('assets/pages/notification/notification.css')?>">
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-growl.min.js"></script>
<script src="<?=base_url('assets/custom_js/notification.custom.js')?>"></script>    
<!-- package/plugin -->
<script src="<?=base_url('assets/js/pdfjs/build/pdf.js')?>"></script>
<script>
	var jenisPrint = <?= json_encode($this->sb->mengambil('tb_print_type')->result())?>;
	var halamanPrint = <?= json_encode($this->sb->mengambil('tb_halaman_print_type')->result())?>;
</script>
<!--  -->
<script type="text/javascript">
	// url
	var url = window.location.href;
	var url_2 = url.substring(0,url.lastIndexOf('/transaksi/'));
	// tag
	let cardFormFile = $('#cardFormFile'),
		formFile = $('#formFile'),
		dataSementaraTbl = $('#dataSementaraTbl'),
		// untuk info pembayaran
		$thw = $('.totalHalamanWarna'),
		$thhp = $('.totalHalamanHP'),
		$pwh = $('.Print_Warna_Harga'),
		$phph = $('.Print_Hitam_Putih_Harga'),
		$tbpw = $('.totalBiayaPrintWarna'),
		$tbphp = $('.totalBiayaPrintHp'),
		$tbp = $('.totalBiayaPrint'),
		$inv = $('.transaction_invoice');
		$cbtnOrder = $('.cardBtnOrder'),
		// untuk tag data sementara
		$ths = $('.ths'),
		$hps = $('.hps'),
		$tbps = $('.tbps'),
		// 
		selectFileOrUrl = $('[name="selectFileOrUrl"]'),
		urlInput = $('[name="url"]'),
		fileInput = $('[name="upload"]'),
		detailFileSize = $('[name="detail_file_size"]'),
		detailFileTotalPages = $('[name="detail_file_total_pages"]'),
		sHalamanPrintTypeId = $('[name="halamanPrintTypeId"]'),
		sPrintTypeId = $('[name="printTypeId"]'),
		detailFilePrintPagesText = $('[name="detailFilePrintPagesText"]'),
		detailFileKeterangan = $('[name="detailFileKeterangan"]'),
		btnSimpanSementara = $('[name="btnSimpanSementara"]'),
		//
		urlForm = $('#urlInput'),
		fileForm = $('#fileInput'),
		sliderDFPPT = $('#sliderDFPPT'),
		btnTFile = $('#btnTFile');
	// 
	var totalHalaman = 0;
	// Untuk info pembayaran
	var printWarnaPrice = 0;
	var printHitamPutihPrice = 0;
	var totalHalamanPWarna = 0;
	var totalHalamanPHP = 0;
	var totalBiayaPWarna = 0;
	var totalBiayaPHP = 0;
	var totalBiayaP = 0;
	// Untuk data sementara 
	var totalBiayaSementara = 0;
	// 
	var typingTimer;
	var doneTypingInterval = 1000;
	// 
	var dataItemSementara = new Array();
	var dataItemListSementara = new Array();
	var fileSementara = '';
	// 
	pdfjsLib.GlobalWorkerOptions.workerSrc = "./../../../../assets/js/pdfjs/build/pdf.worker.js";
	//  Ready Function 
	$(() => {
		getDataWarnaPrice();
		setDefault();
		setDefaultDataSementara();
		tabelDataSementara();
		getInvoice();
	});
	// 
	let setDefault = () => {
		totalBiayaP = parseInt(totalBiayaPWarna) + parseInt(totalBiayaPHP);
		$thw.text(totalHalamanPWarna);
		$thhp.text(totalHalamanPHP);
		$pwh.text(printWarnaPrice);
		$phph.text(printHitamPutihPrice);
		$tbpw.text(toRupiah(totalBiayaPWarna));
		$tbphp.text(toRupiah(totalBiayaPHP));
		$tbp.text(toRupiah(totalBiayaP));
		detailFileTotalPages.val(totalHalaman);
	}
	// 
	let setDefaultDataSementara = () => {
		var totalHalamanPrintSementara = 0;
		totalBiayaSementara = 0;
		// 
		if (sHalamanPrintTypeId.val() == '1') {
			totalHalamanPrintSementara = totalHalaman;
		} else if (sHalamanPrintTypeId.val() == '2') {
			totalHalamanPrintSementara  = dataItemSementara.length;
			console.log(dataItemSementara);
		}
		// 
		var hargaPrintSementara = 0;
		if (sPrintTypeId.val() == '1') {
			hargaPrintSementara = printWarnaPrice;
		} else if (sPrintTypeId.val() == '2') {
			hargaPrintSementara  = printHitamPutihPrice;
		}
		// 
		totalBiayaSementara = (totalHalamanPrintSementara * hargaPrintSementara);
		// 
		$hps.text(hargaPrintSementara);
		$ths.text(totalHalamanPrintSementara);
		$tbps.text(`${toRupiah(totalBiayaSementara)}`);
	}
	// 
	let _setDefaultDataSementara = () => {
		 if (sHalamanPrintTypeId.val() == '1' && sPrintTypeId.val() != '') {
		 	CustomNotification('Tunggu Sebentar!', 'Sedang menghitung total biaya print item yang akan ditambahkan!', 'fa fa-print', 'inverse');
		 	setTimeout(() => setDefaultDataSementara(), 1000);
		 } else if (sHalamanPrintTypeId.val() == '2' && sPrintTypeId.val() != '' && dataItemSementara.length > 0) {
		 	CustomNotification('Tunggu Sebentar!', 'Sedang menghitung total biaya print item yang akan ditambahkan!', 'fa fa-print', 'inverse');
		 	setTimeout(() => setDefaultDataSementara(), 1000);
		 } else {
		 	setDefaultDataSementara();
		 }
	}
	// 
	let setDefaultFormAndSlider = () => {
		urlForm.slideUp('slow');
		fileForm.slideUp('slow');
		sliderDFPPT.slideUp('slow');
		// 
		urlInput.prop({
			required: false,
		});
		fileInput.prop({
			required: false,
		});
		detailFilePrintPagesText.prop({
			required: false,
		});
		// 
		detailFileSize.prop({
			readonly: true,
		});
		detailFileTotalPages.prop({
			readonly: true,
		});
		// 
		detailFileSize.val('');
		detailFileTotalPages.val('');
		fileInput.val('');
		urlInput.val('');
		detailFilePrintPagesText.val('');
		sHalamanPrintTypeId.val('');
	}
	// 
	let setDefaultsliderDFPPT = () => {
		dataItemSementara = [];
		sliderDFPPT.slideUp('slow');
		// 
		detailFilePrintPagesText.prop({
			required: false,
		});
		// 
		detailFilePrintPagesText.val('');
	}
	// ambil harga per jenis print
	let getDataWarnaPrice = async () => {
		try {
			const {
				jasaprint
			} = await $.ajax({
				url: url_2 + '/setting/atur_harga/ambilDataHarga/',
				type: "GET",
				dataType: "JSON",
			});
			if (jasaprint.status == "success") {
				printWarnaPrice = jasaprint.data.hargaPrintWarna;
				printHitamPutihPrice = jasaprint.data.hargaPrintHP;
			}
		} catch (e) {
			console.log(e);
		}

		setTimeout(() => setDefault(), 1000);
	}
	// 
	formFile.on({
		submit: () => {
			return false;
		}
	})
	// 
	btnTFile.on({
		click: () => {
			fileSementara = '';
			cardFormFile.slideToggle('slow');
			formFile[0].reset();
			_selectFileOrUrl();
		}
	});
	// 
	selectFileOrUrl.on({
		change: () => {
			 _selectFileOrUrl();
		}
	});
	// 
	sHalamanPrintTypeId.on({
		change: () => {
			_sHalamanPrintTypeId();
		}
	});
	// 
	sPrintTypeId.on({
		change: () => {
			_setDefaultDataSementara();
		}
	});
	// on press btnSimpanSementara.
	btnSimpanSementara.on({
		click: () => {
			 if (formFile[0].checkValidity()) insertToDataSementara();
		}
	})
	// 
	detailFilePrintPagesText.on({
		keyup: () => {
			if (totalHalaman > 0) {
				clearTimeout(typingTimer);
				typingTimer = setTimeout(() => onSetChangeData((obj) => {
					dataItemSementara = obj.data;
			        setTimeout(() => detailFilePrintPagesText.val(obj.text), doneTypingInterval);
					_setDefaultDataSementara();
				}, detailFilePrintPagesText.val()), doneTypingInterval);
			}
		},
		keydown: () => {
			clearTimeout(typingTimer);
		}
	});
	// 
	detailFileTotalPages.on({
		keyup: () => totalHalaman = detailFileTotalPages.val(),
	})
	//
	let _sHalamanPrintTypeId = () => {
		setDefaultsliderDFPPT();
		if (sHalamanPrintTypeId.val() == '2') {
			sliderDFPPT.slideDown('slow');
			detailFilePrintPagesText.prop({
				required: true,
			});
		} 
		
		_setDefaultDataSementara();
	} 
	// 
	let _selectFileOrUrl = () => {
		// 
		setDefaultFormAndSlider();
		// 
		if (selectFileOrUrl.val() == '1') {
			fileForm.slideDown('slow');
			fileInput.prop({
				required: true,
			});
		} else if (selectFileOrUrl.val() == '2') {
			urlForm.slideDown('slow');
			urlInput.prop({
				required: true,
			});
			detailFileSize.prop({
				readonly: false,
			});
			detailFileTotalPages.prop({
				readonly: false,
			});
		} 
	}

	fileInput.on({
		change: (e) => {
			totalHalaman = 0;
			var file = fileInput[0].files[0];
			if (file) {
				CustomNotification('Tunggu Sebentar!', 'Sedang menghitung jumlah halaman dan Ukuran file!', 'fa fa-print', 'inverse');
		    	_readFile(file);
		    	_readFileAsBase64(file);
		    } 
		}
	});
	// 
	let tabelDataSementara = () => {
		var obj = '';
		if (dataItemListSementara.length > 0) {
			dataItemListSementara.map((e, index) => {
				var jenis = jenisPrint.find(a => a.print_type_id == e.print_type_id)
				obj += '<tr>';
					obj += `<td>${index + 1}</td>`;
					obj += `<td>${e.detail_file_nama.length > 0 ? e.detail_file_nama : `<a target="_blank" href="${e.detail_file_url}">${e.detail_file_url}</a>`}</td>`;
					obj += `<td>${jenis.print_type_nama}</td>`;
					obj += `<td>${e.detail_file_size}</td>`;
					obj += `<td>${e.halaman_print_type_id == 1 ? 'Semua' : e.detail_file_print_pages_text }</td>`;
					obj += `<td>${e.halaman_print_type_id == 1 ?  e.detail_file_total_pages : e.detail_file_print_pages.length }</td>`;
					obj += `<td>${e.detail_file_keterangan.length > 0 ? e.detail_file_keterangan : '-'}</td>`;
					obj += `<td>
								<a href="javascript:void(0)" onclick="hapusDataSementara('${e.id}')" class="btn btn-danger">
									<i class="fa fa-trash"></i> Hapus
								</a>
							</td>`;
				obj += '</tr>';
			});
		} else {
			obj += '<tr>';
			obj += `<td class="text-center" colspan="8">Belum ada halaman yang akan di print</td>`;
			obj += '</tr>';
		}
		hitungTotalPrint();
		dataSementaraTbl.html(obj);
		cardShowBtnOrder();
	}
	//
	let cardShowBtnOrder = () => {
		if (dataItemListSementara.length > 0) {
			$cbtnOrder.slideDown('slow');
		} else {
			$cbtnOrder.slideUp('slow');
		}
	}
	//
	let hitungTotalPrint = () => {
		var tPrintWarna = 0,
			tPrintNonWarna = 0;
		dataItemListSementara.map((e, index) => {
			if (e.print_type_id == 1) {
				tPrintWarna += parseInt(e.halaman_print_type_id == 1 ?  e.detail_file_total_pages : e.detail_file_print_pages.length);
			} else {
				tPrintNonWarna += parseInt(e.halaman_print_type_id == 1 ?  e.detail_file_total_pages : e.detail_file_print_pages.length);
			}
		});
		totalHalamanPWarna = tPrintWarna;
		totalHalamanPHP = tPrintNonWarna;
		totalBiayaPWarna = parseInt(totalHalamanPWarna) * parseInt(printWarnaPrice);
		totalBiayaPHP = parseInt(totalHalamanPHP) * parseInt(printHitamPutihPrice);
		setDefault();
	}
	//
	let hapusDataSementara = (id) => {
		var data = dataItemListSementara.filter((e) => e.id != id);
		CustomNotification('Berhasil!', 'Berhasil menghapus file yang akan di print!', 'fa fa-check', 'success');
		dataItemListSementara = data;
		console.log(data);
		tabelDataSementara();
	} 
	//
	let insertToDataSementara = () => {
		var obj = dataItemListSementara;
			obj.push({
				id: dataItemListSementara.length + 1,
				detail_file_nama: selectFileOrUrl.val() == '1' ? fileInput[0].files[0].name : '',
				detail_file_url: selectFileOrUrl.val() == '2' ? urlInput.val() : '',
				file: fileSementara,
				detail_file_size: detailFileSize.val(),
				detail_file_total_pages: detailFileTotalPages.val(),
				detail_file_print_pages_text: detailFilePrintPagesText.val(),
				print_type_id: sPrintTypeId.val(),
				halaman_print_type_id: sHalamanPrintTypeId.val(),
				detail_file_keterangan: detailFileKeterangan.val(),
				detail_file_print_pages: dataItemSementara,
			});
		dataItemListSementara = obj;
		CustomNotification('Berhasil!', 'Berhasil menambahkan file yang akan di print!', 'fa fa-check', 'success');
		cardFormFile.slideUp('slow');
		formFile[0].reset();
		tabelDataSementara();
		console.log(dataItemListSementara);
	}
	//
	const toBase64 = file => new Promise((resolve, reject) => {
	    const reader = new FileReader();
	    reader.readAsDataURL(file);
	    reader.onload = () => resolve(reader.result);
	    reader.onerror = error => reject(error);
	});
	// 
	let _readFileAsBase64 = async (file) => {
		const res = await toBase64(file);
		fileSementara = res;
	}
	//
	let _readFile = (file) => {
		_fileInputSize(file.size);
		var fileReader = new FileReader();
		// 
	    fileReader.onload = function (e) {
    	  const data = e.target.result;
	      readPDFFile(new Uint8Array(data));
	    };
	    // 
	    fileReader.readAsArrayBuffer(file);
	    setTimeout((e) => setDefault(), 1000);
	}

	let readPDFFile = (pdf) => {
	  pdfjsLib.getDocument({data: pdf}).promise.then(function(doc) {
	  	totalHalaman = doc.numPages;
	  });
	}
	//
	let _fileInputSize = (value) => {
		// 
		var _size = value;
        var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
    	i=0;
    	while(_size>900) {
    		_size/=1024;
    		i++;
    	}
        var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
        // 
        detailFileSize.val(exactSize);
        
	}
	//
	let getInvoice = async () => {
		try {
			const {
				jasaprint
			} = await $.ajax({
				url: `${url_2}/transaksi/pemesanan/checkCodeUniq/`,
				type: "GET",
				dataType: "JSON",
			});
			$inv.text(jasaprint.uniqe)
		} catch (e) {
			console.log(e);
		}
	}
	// 
	let orderNow = () => {
		if (dataItemListSementara.length < 1) {
			CustomNotification('Error!', 'Belum ada file yang akan di print!', 'fa fa-remove', 'danger');
		} else {
			CustomNotification('Tunggu Sebentar!', 'Sedang proses menyimpan!', 'fa fa-print', 'inverse');
			setTimeout(() => _orderNow(), 1000);
		}
	}
	// 
	let _orderNow = async () => {
		try {
			var req = {
				invoice: $inv.text(),
				transaction_print_color_total_page: totalHalamanPWarna,
				transaction_print_without_color_total_page: totalHalamanPHP,
				transaction_print_color_price: totalBiayaPWarna,
				transaction_print_without_color_price: totalBiayaPHP,
				transaction_total_payment: totalBiayaP,
			};
			req.detail_files = dataItemListSementara;
			const res = await $.ajax({
				url: `${url_2}/transaksi/pemesanan/simpan/`,
				type: 'POST',
				data: req,
				dataType: "JSON",
			});
			console.log(res);
		} catch (e) {
			console.log(e);
		}
	}
</script>
<script src="<?=base_url('assets/custom_js/form.tambah.pemesanan.package.custom.js')?>"></script>