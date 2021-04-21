
var url = window.location.href;
var dataBrand = new Array(),
    bi = '',
    action = '',
    loading = true;
//
//
var tagId = {
    tb_brand: $('#tb_brand'),
    formBrand: $('#formBrand'),
    textHeader: $('#textHeader'),
    bn: $('[name="brand_name"]'),
}
//
$(() => {
    //
    setTbBrand();
    setAwal();
    //
    tagId.textHeader.text('Data Master Gudang Brand/Merek');
    tagId.formBrand.on({
        submit: () => {
            if (tagId.formBrand[0].checkValidity()) simpanData();
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
            brand_id: bi,
            brand_name: tagId.bn.val(),
        },
        type: 'POST',
        dataType: 'JSON',
    });

    send.then(({ shiro }) => {
        if (shiro.status == 'berhasil') {
            CustomNotification('Berhasil!', shiro.message, 'fa fa-table', 'success');
            setResetForm();
            tagId.formBrand.slideUp('slow');
            setAwal();
        } else {
            CustomNotification('Gagal!', shiro.message, 'fa fa-table', 'danger');
        }
    });
}
//
var setAwal = () => {
    loading = true;
    dataBrand = new Array();
    setTbBrand();
    setTimeout(() => getData(), 1000);
}
//
var getData = () => {
    var send = $.ajax({
        url: `${url}/showDataBrand`,
        data: {},
        type: 'GET',
        dataType: 'JSON',
    });

    send.then(({
        shiro
    }) => {
        loading = false;
        dataBrand = shiro.data;
        setTbBrand();
    });

    send.catch((e) => {
        console.log(
            `Error Server Get Brand/Merek: ${e}`
        );
    })
}
//
var setTbBrand = () => {
    var obj = '';
    if (dataBrand.length > 0) {
        dataBrand.map((e, index) => {
            obj += '<tr>';
            obj += `<td>${index + 1}</td>`;
            obj += `<td>${e.brand_name}</td>`;
            obj += `<td>${_btn(e, index)}</td>`;
            obj += '</tr>';
        });
    } else {
        obj += _setTbBrandOther(3, `${loading ? 'Tunggu Sebentar' : 'Belum ada data'}`);
    }
    tagId.tb_brand.html(obj);
}
//
var _setTbBrandOther = (colspan = 1, text = '') => {
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
var tambahBrand = () => {
    setResetForm();
    bi = '';
    action = 'tambah';
    tagId.formBrand.slideUp('slow');
    tagId.formBrand.slideDown('slow');
    tagId.textHeader.text('Tambah Brand/Merek');
}
//
var batalClick = () => {
    setResetForm();
    action = '';
    tagId.formBrand.slideUp('slow');
}
//
var setResetForm = () => {
    tagId.textHeader.text('Data Master Gudang Brand/Merek');
    tagId.formBrand[0].reset();
}
//
var editClick = value => {
    var mengambilData = dataBrand.filter((e, index) => index == value);
    tagId.formBrand.slideUp('slow');
    if (mengambilData.length > 0) {
        action = 'edit';
        bi = mengambilData[0].brand_id;
        tagId.bn
        .val(mengambilData[0].brand_name);
        tagId.formBrand.slideDown('slow');
        tagId.textHeader.text('Edit Brand/Merek');
    } else {
        CustomNotification('Error', 'Brand/Merek tidak ditemukan!!', 'fa fa-table', 'danger');
    }
}
