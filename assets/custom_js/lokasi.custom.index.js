
var url = window.location.href;
var dataLokasi = new Array(),
	lbi = '',
	action = '',
	loading = true;
//
//
var tagId = {
	tb_lokasi: $('#tb_lokasi'),
	formLokasi: $('#formLokasi'),
	textHeader: $('#textHeader'),
	lbn: $('[name="lokasi_barang_nama"]'),
}
//
$(() => {
	//
	setTbLokasi();
	setAwal();
	//
	tagId.textHeader.text('Data Master Gudang Lokasi/Rak');
	tagId.formLokasi.on({
		submit: () => {
			if (tagId.formLokasi[0].checkValidity()) simpanData();
			return false;
		},
	});
});
//
var simpanData = () => {
    CustomNotification('Tunggu Sebentar!', 'Sedang menyimpan data!!', 'fa fa-table', 'inverse');
    setTimeout(() => _simpanData(), 2000);
}
//
var _simpanData = () => {
	 var send = $.ajax({
    	url: `${url}/${action == 'tambah' ? 'simpanData/t' : 'simpanData/e'}`,
    	data: {
    		lokasi_barang_id: lbi,
    		lokasi_barang_nama: tagId.lbn.val(),
    	},
    	type: 'POST',
    	dataType: 'JSON',
    });

    send.then(({ shiro }) => {
    	if (shiro.status == 'berhasil') {
    		CustomNotification('Berhasil!', shiro.message, 'fa fa-table', 'success');
    		setResetForm();
			tagId.formLokasi.slideUp('slow');
			setAwal();
    	} else {
    		CustomNotification('Gagal!', shiro.message, 'fa fa-table', 'danger');
    	}
    });
}
//
var setAwal = () => {
	loading = true;
	dataLokasi = new Array();
	setTbLokasi();
	setTimeout(() => getData(), 1000);
}
//
var getData = () => {
	var send = $.ajax({
		url: `${url}/showDataLokasi`,
		data: {},
		type: 'GET',
		dataType: 'JSON',
	});

	send.then(({
		shiro
	}) => {
		loading = false;
		dataLokasi = shiro.data;
		setTbLokasi();
	});

	send.catch((e) => {
		console.log(
			`Error Server Get Lokasi/Rak: ${e}`
		);
	})
}
//
var setTbLokasi = () => {
	var obj = '';
	if (dataLokasi.length > 0) {
		dataLokasi.map((e, index) => {
			obj += '<tr>';
			obj += `<td>${index + 1}</td>`;
			obj += `<td>${e.lokasi_barang_nama}</td>`;
			obj += `<td>${_btn(e, index)}</td>`;
			obj += '</tr>';
		});
	} else {
		obj += _setTbLokasiOther(3, `${loading ? 'Tunggu Sebentar' : 'Belum ada data'}`);
	}
	tagId.tb_lokasi.html(obj);
}
//
var _setTbLokasiOther = (colspan = 1, text = '') => {
	var obj = '';
	obj += '<tr>';
	obj += `<td colspan="${colspan}" class="text-center">`;
	obj += text;
	obj += '</td>';
	obj += '</tr>';
	return obj;
}
//
var _btn = (data, index) => {
	var obj = '<div class="dropdown-primary dropdown open">';
		obj += `<button 
					class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light"
					type="button"
					id="dropdown-${index}"
					data-toggle="dropdown"
					aria-haspopup="true"
					aria-expanded="true">Aksi</button>`;
		obj += `<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-${index}" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">`;
		obj += `<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="editClick(${index})">Edit</a>`;
		obj += '</div>';
		obj += '</div>';
		return obj;
}
//
var reloadData = () => setAwal();
//
var tambahLokasi = () => {
	setResetForm();
	lbi = '';
	action = 'tambah';
	tagId.formLokasi.slideUp('slow');
	tagId.formLokasi.slideDown('slow');
	tagId.textHeader.text('Tambah Lokasi/Rak');
}
//
var batalClick = () => {
	setResetForm();
	action = '';
	tagId.formLokasi.slideUp('slow');
}
//
var setResetForm = () => {
	tagId.textHeader.text('Data Master Gudang Lokasi/Rak');
	tagId.formLokasi[0].reset();
}
//
var editClick = value => {
	var mengambilData = dataLokasi.filter((e, index) => index == value);
	tagId.formLokasi.slideUp('slow');
	if (mengambilData.length > 0) {
		action = 'edit';
		lbi = mengambilData[0].lokasi_barang_id;
		tagId.lbn
		.val(mengambilData[0].lokasi_barang_nama);
		tagId.formLokasi.slideDown('slow');
		tagId.textHeader.text('Edit Lokasi/Rak');
	} else {
        CustomNotification('Error', 'Lokasi/Rak tidak ditemukan!!', 'fa fa-table', 'danger');
	}
}