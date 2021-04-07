<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Gudang Laptop - <?=$title?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />
    <!-- Favicon icon -->
    <link rel="icon" href="<?=base_url()?>assets/images/logo-2.png" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap/css/bootstrap.min.css">
    <!-- waves.css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/icofont/css/icofont.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/font-awesome/css/font-awesome.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/style.css">
    <!-- Javascript -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery/jquery.min.js "></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui/jquery-ui.min.js "></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap/js/bootstrap.min.js "></script>
    <!-- waves js -->
    <script src="<?=base_url()?>assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/common-pages.js"></script>
  </head>
  <body themebg-pattern="theme1">
    <!-- Pre-loader start -->
    <div class="theme-loader">
      <div class="loader-track">
        <div class="preloader-wrapper">
          <div class="spinner-layer spinner-blue">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="gap-patch">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          <div class="spinner-layer spinner-red">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="gap-patch">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          <div class="spinner-layer spinner-yellow">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="gap-patch">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
          <div class="spinner-layer spinner-green">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="gap-patch">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Pre-loader end -->
    <section class="login-block">
      <!-- Container-fluid starts -->
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <!-- Authentication card start -->
            <form class="md-float-material form-material" action="<?=base_url('welcome/logCek')?>" method="POST">
              <div class="text-center">
                <img src="<?=base_url()?>assets/images/logo-2.png" alt="logo-2.png" style="width: 150px;">
              </div>
              <div class="auth-box card">
                <div class="card-block">
                  <div class="row m-b-20">
                    <div class="col-md-12">
                      <h4 class="text-center">Gudang <strong>Laptop</strong> Ku</h4>
                    </div>
                  </div>
                  <?php if (@$this->session->flashdata('error')): ?>
                  <div>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                  </div>
                  <?php endif ?>
                  <div class="form-group form-primary">
                    <input type="text" name="email" class="form-control" required>
                    <span class="form-bar"></span>
                    <label class="float-label">Email</label>
                  </div>
                  <div class="form-group form-primary">
                    <input type="password" name="password" class="form-control" required>
                    <span class="form-bar"></span>
                    <label class="float-label">Password</label>
                  </div>
                  <div class="row m-t-25 text-left">
                    <div class="col-12">
                      <div class="checkbox-fade fade-in-primary d-">
                        <label>
                          <input type="checkbox" value="">
                          <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                          <span class="text-inverse">Remember me</span>
                        </label>
                      </div>
                      <!-- <div class="forgot-phone text-right f-right">
                        <a href="auth-reset-password.html" class="text-right f-w-600"> Forgot Password?</a>
                      </div> -->
                    </div>
                  </div>
                  <div class="row m-t-30">
                    <div class="col-md-12">
                      <input type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20" name="btnClick" value="Masuk">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center">Dibuat oleh <a href="http://shirokun20.github.io/" class="text-bold">Shiro Soft</a>.</p>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <!-- end of form -->
          </div>
          <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
      </div>
      <!-- end of container-fluid -->
    </section>
    <!-- Required Jquery -->
    <script>
      var alertData = $('.alert');
      $(() => {
        AlertHide();
        <?php if (@$this->session->flashdata('email')): ?>
          $('[name="email"]').val('<?=$this->session->flashdata('email')?>').focus(); 
        <?php endif ?>
      });
      const AlertHide = () => {
        setTimeout(() => {
          alertData.slideUp('slow');
        }, 5000);
      }
      
    </script>
  </body>
</html>