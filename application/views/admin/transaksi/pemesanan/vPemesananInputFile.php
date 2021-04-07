<div class="card-block" id="cardFormFile" style="display: none;">
	<h4>Form File yang akan di print</h4>
	<div class="row">
		<div class="col-6">
			<div class="form-group row">
                <div class="col-12">
                	<select name="selectFileOrUrl" class="form-control">
                		<option value="">Pilih Url/Upload</option>
                		<option value="1">Upload</option>
                		<option value="2">Url</option>
                	</select>
                </div>
            </div>
		</div>
		<div class="col-6">
			<div class="form-material" id="urlInput" style="display: none;">
    			<div class="form-group form-default form-static-label">
                    <input type="url" placeholder="Masukan Url" name="url" class="form-control">
                </div>
            </div>
            <div class="form-material" id="fileInput" style="display: none;">
    			<div class="form-group form-default form-static-label">
                    <input type="file" accept="application/pdf" name="upload" class="form-control">
                </div>
            </div>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="form-group form-default form-static-label">
                <label class="float-label">Ukuran File</label>
                <input type="text" name="detail_file_size" class="form-control" placeholder="Ukuran File contoh: 1 MB" readonly required>
            </div>
		</div>
		<div class="col-6">
			<div class="form-group form-default form-static-label">
                <label class="float-label">Total Halaman</label>
                <input type="number" name="detail_file_total_pages" class="form-control" placeholder="Total Halaman contoh 10" readonly required>
                <span style="color: red">*</span> Sudah termasuk cover dll!
            </div>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
            <label class="float-label">Jenis Print</label>
        	<select name="printTypeId" class="form-control" required>
        		<option value="">Pilih Jenis Print</option>
        		<?php  
        			$tpt = $this->sb->mengambil('tb_print_type');
        			foreach ($tpt->result() as $key): ?>
        		<option value="<?=$key->print_type_id?>"><?=$key->print_type_nama?></option>
        		<?php endforeach ?>
        	</select>
        	<label class="float-label mt-1">
            	<span style="color: red">*</span> Jenis print mempengaruhi harga!<br>
            </label>
        </div>
		<div class="col-6">
            <label class="float-label">Print Halaman</label>
        	<select name="halamanPrintTypeId" class="form-control" required>
        		<option value="">Jenis Print Halaman</option>
        		<?php  
        			$thpt = $this->sb->mengambil('tb_halaman_print_type');
        			foreach ($thpt->result() as $key): ?>
        		<option value="<?=$key->halaman_print_type_id?>"><?=$key->halaman_print_type_nama?></option>
        		<?php endforeach ?>
        	</select>
        </div>
        <div class="col-lg-12 mt-3" id="sliderDFPPT" style="display: none;">
        	<div class="form-group form-default form-static-label">
                <label class="float-label">Halaman yang di print</label>
                <input type="text" name="detailFilePrintPagesText" class="form-control" placeholder="Contoh: 1 sd 10 atau 1,2,3,4,5">
                <label class="float-label mt-1">
                	<span style="color: red">*</span> Isi dengan benar, karena berpengaruh terhadap harga!<br>
                	<span style="color: red">*</span> Halaman di hitung dari (halaman) pertama hingga akhir atau yang ditentukan! (baik cover dll)
                </label>
            </div>
        </div>
        <div class="col-lg-12 col-12 mt-3 form-material">
            <div class="form-group form-default form-static-label">
                <textarea class="form-control" name="detailFileKeterangan" placeholder="Isi keterangan"></textarea>
                <span class="form-bar"></span>
                <label class="float-label">Keterangan</label>
            </div>
        </div>
	</div>
    <div class="row">
        <div class="col-6">
            <input type="submit" name="btnSimpanSementara" value="Masuk ke Pemesanan!" class="btn btn-danger">
        </div>
        <div class="col-6 text-right">
            Total Biaya print (<span class="ths" style="font-weight: bold;">0</span> x <span class="hps" style="font-weight: bold;">0</span>) <span class="tbps" style="font-weight: bold;">Rp. 0</span>
        </div>
    </div>
</div>