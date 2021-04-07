<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>jasaPrintKu - 404</title>
    <link rel="icon" href="<?=base_url()?>assets/icon/logo/printer-dua.gif" type="image/x-icon">
	<link rel="stylesheet" href="<?=base_url('assets/404/style.css')?>">
</head>
<body>
	<div class="cont_principal">
	<div class="cont_error">
	  
	<h1>Oops</h1>  
	  <p>Halaman Tidak Ditemukan!.</p>
	  </div>
	<div class="cont_aura_1"></div>
	<div class="cont_aura_2"></div>
	</div>
	<script>
		window.onload = function(){
		document.querySelector('.cont_principal').className= "cont_principal cont_error_active";  
		  
		}
	</script>
</body>
</html>