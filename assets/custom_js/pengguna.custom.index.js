
	// url
	var url = window.location.href;
	var url_2 = url.substring(0,url.lastIndexOf('/pengguna/'));
	// table
	var tabel;
    var tagHtml;
    var inputType = '';
    var user_id = '';
	// tag
	var tb_pengguna = $('#tb_pengguna');
	var jabatan_id = $('#jabatan_id');
    var modalSet = $('.modalSet');
    // Data Sementara 
    var dataTypeUser = [];
	// ready function
	$(() => {
		datatablesAjax();
        setTimeout((e) => getJumlahPengguna(), 2000);
	});
	// functions
	let datatablesAjax = () => {
		tabel = tb_pengguna.DataTable({
			"processing": true, 
            "ordering": true, 
            "info": false, 
            "serverSide": true, 
            "order": [], 
     		// Ajax
            "ajax": {
                "url": `${url_2}/pengguna/showDataPengguna/`,
                "type": "POST",
                "data": ( data ) => {
                	data.jabatan_id = jabatan_id.text();
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
	let reloadData = () => {
		tabel.ajax.reload();
	}
    // 
    let modalTambah = () => {
        // 
        inputType = 'tambah';
        user_id = '';
        tagHtml = '';
        // 
        tagHtml = modalData('Tambah Pengguna', formTambah());
        modalSet.html(tagHtml);
        // 
        $('[name="user_nama"]').val('');
        $('[name="user_email"]').val('');
        $('[name="user_phone"]').val('');
        $('[name="user_password"]').val('');
        $('[name="jabatan_id"]').val('');
        // 
        formUse();
        // 
        modalVisible();
    }
    //
    let modalVisible = (aksi = 'show') => {
        setTimeout(() => $('#modalID').modal(aksi), 200);
    }
    // 
    let formUse = () => {
        let form = $('#form');
        form.on({
            submit: () => {
                if (form[0].checkValidity()) {
                    CustomNotification('Tunggu Sebentar!', 'Sedang menyimpan data pengguna!', 'fa fa-user', 'inverse');
                    modalVisible('hide');
                    setTimeout((e) => simpanData(), 1000);
                }
                return false;
            }
        });
    }
    // 
    let modalEdit = (data) => {
        inputType = 'edit';
        user_id = data.user_id;
        tagHtml = '';
        // 
        tagHtml = modalData('Edit Pengguna', formTambah());
        modalSet.html(tagHtml);
        // 
        $('[name="user_nama"]').val(data.user_nama);
        $('[name="user_email"]').val(data.user_email);
        $('[name="user_phone"]').val(data.user_phone);
        $('[name="user_password"]').val('');
        $('[name="jabatan_id"]').val(data.jabatan_id);
        // 
        formUse();
        // 
        modalVisible();
    }
    // 
    let editClick = async (user_id = '') => {
        try {
            const {
                shiro
            } = await $.ajax({
                url: `${url_2}/pengguna/getPengguna/`,
                dataType: "JSON",
                data: {
                    user_id,
                },
                type: "GET",
            });
            if (shiro.status == 'success') {
                modalEdit(shiro.data);
            }
        } catch (e) {
            console.log(e);
        }
    }
    //
    var simpanData = async () => {
        // 
        let form = $('#form');
        var formData = new FormData(form[0]);
        formData.append('user_id', user_id);
        formData.append('type_input', inputType);
        formData.append('simpan', $('[name="simpan"]').val());
        // 
        try {
            const {
                shiro
            } = await $.ajax({
                url: `${url_2}/pengguna/simpan/`,
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                dataType: "JSON",
            });
            _notificationWreloadData(shiro);
        } catch (e) {
            console.log(e);
        }
    } 
    // 
    var _notificationWreloadData = ({
        message,
        status
    }) => {
        if (status === 'success') {
            CustomNotification('Berhasil!', message, 'fa fa-check-circle', status);
        } else {
            CustomNotification('Gagal!', message, 'fa fa-times-circle', 'danger');
        }
        reloadData();
        getJumlahPengguna();
    }
    // 
    let hapusDataConfirm = (usr_id) => {
        var actionButton = '';
            actionButton += `<a onclick="hapusData('${usr_id}')" href="javascript:void(0)" class="btn btn-danger">Ya</a>`;
            actionButton += `<a data-dismiss="modal" href="javascript:void(0)" class="btn btn-success">Tidak</a>`;
        tagHtml = '';
        // 
        tagHtml = modalData('Hapus Pengguna', 'Apakah anda yakin akan menghapus data ini?', actionButton);
        modalSet.html(tagHtml);
        modalVisible();
    }
    // 
    let hapusData = (usr_id) => {
        modalVisible('hide');
        CustomNotification('Tunggu Sebentar!', 'Sedang menghapus data pengguna!', 'fa fa-user', 'inverse');
        setTimeout((e) => _hapusData(usr_id), 2000);
    }
    // 
    let _hapusData = async (usr_id) => {
        try {
            var d = new Date();
            const {
                shiro
            } = await $.ajax({
                url: `${url_2}/pengguna/hapusData/`,
                data: {
                    user_id: usr_id,
                    time: d,
                },
                type: "POST",
                dataType: "JSON",
            });
            _notificationWreloadData(shiro);
            getJumlahPengguna();
        } catch (e) {
            console.log(e);
        }
    }
     // 
    let ubahStatusConfirm = (usr_id, status_user_id = 1) => {
        var actionButton = '';
            actionButton += `<a onclick="ubahStatus('${usr_id}', ${status_user_id})" href="javascript:void(0)" class="btn btn-danger">Ya</a>`;
            actionButton += `<a data-dismiss="modal" href="javascript:void(0)" class="btn btn-success">Tidak</a>`;
        tagHtml = '';
        // 
        tagHtml = modalData(`${status_user_id == 1 ? 'Aktifkan' : 'Suspend'} Pengguna`, `Apakah anda yakin akan ${status_user_id == 1 ? 'mengaktifkan' : 'mengsuspend'} pengguna ini?`, actionButton);
        modalSet.html(tagHtml);
        modalVisible();
    }
     // 
    let ubahStatus = (usr_id, status_user_id) => {
        modalVisible('hide');
        CustomNotification('Tunggu Sebentar!', `Sedang ${status_user_id == 1 ? 'mengaktifkan' : 'mengsuspend'} data pengguna!`, 'fa fa-user', 'inverse');
        setTimeout((e) => _ubahStatus(usr_id, status_user_id), 2000);
    }
    // 
    let _ubahStatus = async (usr_id, status_user_id) => {
        try {
            var d = new Date();
            const {
                shiro
            } = await $.ajax({
                url: `${url_2}/pengguna/statusChange/`,
                data: {
                    user_id: usr_id,
                    status_user_id,
                    time: d,
                },
                type: "POST",
                dataType: "JSON",
            });
            _notificationWreloadData(shiro);
            getJumlahPengguna();
        } catch (e) {
            console.log(e);
        }
    }
    // 
    let getJumlahPengguna = async () => {
        try {
            const {
                shiro
            } = await $.ajax({
                url: `${url_2}/pengguna/getJumlahPengguna/`,
                type: "GET",
                dataType: "JSON",
            });
            if (shiro.status == 'success') {
                $('#total_pengguna').text(shiro.data.total_pengguna);
                $('#total_admin').text(shiro.data.total_admin);
                $('#total_operator').text(shiro.data.total_operator);
            }
        } catch (e) {  
            console.log(e);
        }
    }
    // 
    let detailPengguna = async (user_id) => {
        try {
            const {
                shiro
            } = await $.ajax({
                url: `${url_2}/pengguna/getDetail/`,
                dataType: "JSON",
                data: {
                    user_id,
                },
                type: "GET",
            });
            if (shiro.status == 'success') {
                _detailPengguna(shiro);
                tagHtml = '';
            } else {
                CustomNotification('Gagal!', 'Pengguna tidak ditemukan!', 'fa fa-times-circle', 'danger');
            }
        } catch (e) {
            console.log(e);
        }
    }
    // 
    let _detailPengguna = ({
        data,
        jumlah_order,
    }) => {
        var obj = "";
            obj += '<table class="table" style="width: 100%">';
                obj += '<tr>';
                    obj += '<td style="font-weight: bold">#ID</td>';
                    obj += '<td>:</td>';
                    obj += `<td class="text-right">USER/${data.user_id}</td>`;
                obj += '</tr>';
                obj += '<tr>';
                    obj += '<td style="font-weight: bold">Nama</td>';
                    obj += '<td>:</td>';
                    obj += `<td class="text-right">${data.user_nama}</td>`;
                obj += '</tr>';
                obj += '<tr>';
                    obj += '<td style="font-weight: bold">Email</td>';
                    obj += '<td>:</td>';
                    obj += `<td class="text-right">${data.user_email}</td>`;
                obj += '</tr>';
                obj += '<tr>';
                    obj += '<td style="font-weight: bold">Jenis Pengguna</td>';
                    obj += '<td>:</td>';
                    obj += `<td class="text-right">${data.jabatan_nama}</td>`;
                obj += '</tr>';
                obj += '<tr>';
                    obj += '<td style="font-weight: bold">Status</td>';
                    obj += '<td>:</td>';
                    obj += `<td class="text-right">${data.status_user_nama}</td>`;
                obj += '</tr>';
            obj += '</table>';
        tagHtml = modalData('Detail Pengguna', obj);
        modalSet.html(tagHtml);
        modalVisible();
    }