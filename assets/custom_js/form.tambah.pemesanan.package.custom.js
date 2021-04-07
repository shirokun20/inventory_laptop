
	const onSetChangeData = (cb, value = '') => {
        var check = value.toString();
        var toData = '';
        var obj = new Object();
        if (check.match(',') != null) {
            const hasil = check.split(',') || new Array();
            var setArray = new Array();
            hasil.map((e) => {
                var angka = Number(e) || 0;
                var dataCheck = setArray.filter((e) => {
                	return e == angka;
                });
                if ((angka > 0) && (dataCheck.length < 1) && (setArray.length <= totalHalaman) && (angka <= totalHalaman)) {
                    setArray.push(angka);
                }
            });
            obj.data = setArray;
            obj.text = setArray.toString();
        } else if (check.match(' sd ') != null) {
            const hasil = check.split(' sd ') || new Array();
            var setArray = new Array();
            if (hasil.length > 1) {
                var angka1 = Number(hasil[0]) || 0;
                var angka2 = Number(hasil[1]) || 0;
                if (angka2 <= totalHalaman) {
                    for (let index = angka1; index <= angka2; index++) {
                        setArray.push(index);
                    }
                    obj.data = setArray;
                    obj.text = value;
                }
            }
        } else if (Number(value) <= totalHalaman && value != '') {
            var setArray = new Array();
        	setArray.push(Number(value));
        	obj.data = setArray;
            obj.text = value;
        } else {
        	obj.data = [];
            obj.text = '';
        }
        cb(obj);
        // console.log(obj.text);
        // toData = JSON.stringify(obj);
        // console.log(toData.toString());
    }
    // 
    const toRupiah = (angka = 0) => {
    	var rupiah = '';		
		var angkarev = angka.toString().split('').reverse().join('');
		for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    }
