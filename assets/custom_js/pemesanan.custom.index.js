
	// url
	var url = window.location.href;
	var url_2 = url.substring(0,url.lastIndexOf('/pemesanan/'));
	// table
	var tabel;
	// tag
	var tb_pemesanan = $('#tb_pemesanan');
    var cari = $('[name="cari"]');
    var status_transaction_id = $('[name="status_transaction_id"]');
    var status_payment_id = $('[name="status_payment_id"]');
    var tanggal_a = $('[name="tanggal_a"]');
    var tanggal_b = $('[name="tanggal_b"]');
	// 
    var typingTimer;                //timer identifier
    var doneTypingInterval = 1500;  //time in ms, 5 second for example
    // 
	$(() => {
		datatablesAjax();
        setTimeout((e) => getJumlahPengguna(), 2000);
	});
	// functions
	let datatablesAjax = () => {
		tabel = tb_pemesanan.DataTable({
			"processing": true, 
            "ordering": true, 
            "info": false, 
            "serverSide": true, 
            "searching": false, 
            "order": [], 
     		// Ajax
            "ajax": {
                "url": `${url_2}/pemesanan/showDataPemesanan/`,
                "type": "POST",
                "data": ( data ) => {
                    data.cari = cari.val();
                    data.status_transaction_id = status_transaction_id.val();
                    data.status_payment_id = status_payment_id.val();
                    data.tanggal_a = tanggal_a.val();
                	data.tanggal_b = tanggal_b.val();
                }
            },
     		// Order
            "columnDefs": [{ 
                "targets": [ 0 ], 
                "orderable": false, 
            }],
            "rowCallback": function( nRow, aData) {
                if (aData[6] == "Belum Lunas") {
                    $(nRow).find('td:eq(6)').css('background-color', 'red');
                    $(nRow).find('td:eq(6)').css('color', 'white');
                }
            }
		});
	}
    // 
    cari.on({
        keyup: () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => reloadData(), doneTypingInterval);
        },
        keydown: () => {
            clearTimeout(typingTimer);
        }
    });
    // 
    status_transaction_id.on({
        change: () => reloadData(),
    });
    // 
    status_payment_id.on({
        change: () => reloadData(),
    });
    // 
    tanggal_a.on({
        change: () => reloadData(),
    });
    // 
    tanggal_b.on({
        change: () => reloadData(),
    });
    // 
    var reloadData = () => {
        tabel.ajax.reload();
    }
    // 
    let getJumlahPengguna = async () => {
        try {
            const {
                jasaprint
            } = await $.ajax({
                url: `${url_2}/pemesanan/getJumlahPengguna/`,
                type: "GET",
                dataType: "JSON",
            });
            if (jasaprint.status == 'success') {
                $('#total_pesanan_aktif').text(jasaprint.data.total_pesanan_aktif);
                $('#total_pesanan_selesai').text(jasaprint.data.total_pesanan_selesai);
                $('#total_pesanan_dibatalkan').text(jasaprint.data.total_pesanan_dibatalkan);
            }
        } catch (e) {  
            console.log(e);
        }
    }
