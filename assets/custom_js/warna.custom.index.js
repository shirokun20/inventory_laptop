var url = window.location.href;
var dataWarna = new Array(),
	action = '',
	loading = true;
//
var tagId = {
	tb_warna: $('#tb_warna'),
	formWarna: $('#formWarna'),
	textHeader: $('#textHeader'),
	warna_kode: $('[name="warna_kode"]'),
	warna_nama: $('[name="warna_nama"]'),
}
//
$(() => {
	//
	setTbWarna();
	setAwal();
	//
	tagId.textHeader.text('Data Master Gudang Warna');
	tagId.formWarna.on({
		submit: () => {
			if (tagId.formWarna[0].checkValidity()) simpanData();
			return false;
		},
	});
});

tagId.warna_kode.on({
	keyup: () => {
		var text = tagId.warna_kode.val();
		tagId.warna_kode.val(text.toUpperCase());
	}
})
//
var setAwal = () => {
	loading = true;
	dataWarna = new Array();
	setTbWarna();
	setTimeout(() => getData(), 1000);
}
//
var getData = () => {
	var send = $.ajax({
		url: `${url}/showDataWarna`,
		data: {},
		type: 'GET',
		dataType: 'JSON',
	});

	send.then(({
		shiro
	}) => {
		loading = false;
		dataWarna = shiro.data;
		setTbWarna();
	});

	send.catch((e) => {
		console.log(
			`Error Server Get Warna: ${e}`
		);
	})
}
//
var setTbWarna = () => {
	var obj = '';
	if (dataWarna.length > 0) {
		dataWarna.map((e, index) => {
			obj += '<tr>';
			obj += `<td>${index + 1}</td>`;
			obj += `<td>${e.warna_kode}</td>`;
			obj += `<td>${e.warna_nama}</td>`;
			obj += `<td>${_btn(e, index)}</td>`;
			obj += '</tr>';
		});
	} else {
		obj += _setTbWarnaOther(4, `${loading ? 'Tunggu Sebentar' : 'Belum ada data'}`);
	}
	tagId.tb_warna.html(obj);
}
//
var _setTbWarnaOther = (colspan = 1, text = '') => {
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
var tambahWarna = () => {
	setResetForm();
	action = 'tambah';
	tagId.formWarna.slideUp('slow');
	tagId.formWarna.slideDown('slow');
	tagId.textHeader.text('Tambah Warna');
}
//
var setResetForm = () => {
	tagId.textHeader.text('Data Master Gudang Warna');
	tagId.formWarna[0].reset();
	tagId.warna_kode
		 .prop('readonly', false);
}
//
var editClick = value => {
	var mengambilData = dataWarna.filter((e, index) => index == value);
	tagId.formWarna.slideUp('slow');
	if (mengambilData.length > 0) {
		action = 'edit';
		tagId.warna_kode
		.prop('readonly', true)
		.val(mengambilData[0].warna_kode);
		tagId.warna_nama.val(mengambilData[0].warna_nama);
		tagId.formWarna.slideDown('slow');
		tagId.textHeader.text('Edit Warna');
	} else {
        CustomNotification('Error', 'Warna tidak ditemukan!!', 'fa fa-table', 'danger');
	}
}
//
var batalClick = () => {
	setResetForm();
	action = '';
	tagId.formWarna.slideUp('slow');
}
//
var simpanData = () => {
    CustomNotification('Tunggu Sebentar!', 'Sedang menyimpan data!!', 'fa fa-table', 'inverse');
    setTimeout(() => _simpanData(), 2000);
}

var _simpanData = () => {
	 var send = $.ajax({
    	url: `${url}/${action == 'tambah' ? 'simpanData/t' : 'simpanData/e'}`,
    	data: tagId.formWarna.serialize(),
    	type: 'POST',
    	dataType: 'JSON',
    });

    send.then(({ shiro }) => {
    	if (shiro.status == 'berhasil') {
    		CustomNotification('Berhasil!', shiro.message, 'fa fa-table', 'success');
    		setResetForm();
			tagId.formWarna.slideUp('slow');
			setAwal();
    	} else {
    		CustomNotification('Gagal!', shiro.message, 'fa fa-table', 'danger');
    	}
    });
}