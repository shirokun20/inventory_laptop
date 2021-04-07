var dataTypeUser = [];
$(() => {
    dataTypeUser.push({
        jabatan_id: '',
        jabatan_nama: 'Pilih Jenis Pengguna',  
    });
    dataTypeUser.push({
        jabatan_id: '1',
        jabatan_nama: 'Admin',  
    });
    dataTypeUser.push({
        jabatan_id: '2',
        jabatan_nama: 'Operator',  
    });
})

let formTambah = () => {
        output = '<form id="form">';
        // Input Nama
        output += '<div class="form-group">';
            output += '<label>Nama *</label>';
            output += '<input type="text" name="user_nama" class="form-control" placeholder="Masukan Nama.." required>';
        output += '</div>';
        // Email
        output += '<div class="form-group">';
            output += '<label>Email *</label>';
            output += '<input type="text" name="user_email" class="form-control" placeholder="Masukan Email.." required>';
        output += '</div>';
        // Phone
        // output += '<div class="form-group">';
        //     output += '<label>No.Hp *</label>';
        //     output += '<input type="text" name="user_phone" class="form-control" placeholder="Masukan No.Hp.." required>';
        // output += '</div>';
        // Password
        output += '<div class="form-group">';
            output += `<label>Password ${(inputType == 'tambah') ? '*' : ''}</label>`;
            output += `<input type="password" name="user_password" class="form-control" placeholder="Masukan Password.." ${(inputType == 'tambah') ? 'required' : ''}>`;
        output += '</div>';
        // Type User
        output += '<div class="form-group">';
            output += '<label>Jenis Pengguna *</label>';
            output += '<select name="jabatan_id" class="custom-select" required>';
            dataTypeUser.map((e, index) => {
                output += `<option value="${e.jabatan_id}">${e.jabatan_nama}</option>`;
            })
            output += '</select>';
        output += '</div>';
        //  Button
        output += '<input type="submit" name="simpan" class="btn btn-success pull-right" value="Simpan">';
        output += '</form>';
        return output;
    }