<div>
	<div class="card">
        <div class="card-header">
            <h5>Data Master Gudang Warna</h5>
            <div class="card-header-right">
            	<a href="javascript:void(0)" class="btn btn-danger btn-sm"><i class="fa fa-plus text-white"></i> Tambah Warna</a>
            	<a href="javascript:void(0)" onclick="reloadData()" class="btn btn-primary btn-sm"><i class="fa fa-refresh text-white"></i> Reload</a>
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="30%">Kode Warna</th>
                            <th width="50%">Warna</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tb_warna"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
	var url = window.location.href;
	var dataWarna = new Array(),
		loading = true;
	//
	var tagId = {
		tb_warna: $('#tb_warna'),
	}
	//
	$(() => {
		setTbWarna();
		setAwal();
	});
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
			obj += `<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="editClick('${data.warna_kode}')">Edit</a>`;
			obj += `<a class="dropdown-item waves-light waves-effect" href="javascript:void(0)" onclick="hapusClick('${data.warna_kode}')">Hapus</a>`;
			obj += '</div>';
			obj += '</div>';
			return obj;
	}
	//
	var reloadData = () => setAwal();
</script>