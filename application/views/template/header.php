<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="javascript:void(0)">
                <i class="ti-menu"></i>
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="ti-more"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <div class="sidebar_toggle"><a href="javascript;"><i class="ti-menu"></i></a></div>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="user-profile header-notification">
                    <a href="javascript:void(0)" class="waves-effect waves-light">
                        <img src="<?=base_url()?>assets/images/avatar-4.jpg" class="img-radius" alt="User-Profile-Image">
                        <span><?= $this->session->admin->user_nama; ?></span>
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
<!--                         <li class="waves-effect waves-light">
                            <a href="javascript:void(0)">
                                <i class="ti-settings"></i> Settings
                            </a>
                        </li> -->
                        <li class="waves-effect waves-light">
                            <a href="<?=site_url('logout')?>">
                                <i class="ti-layout-sidebar-left"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>