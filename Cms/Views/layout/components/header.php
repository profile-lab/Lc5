<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= site_url(route_to('lc_dashdoard')) ?>"><img src="/assets/lc-admin-assets/img/lc5_logo2.svg" /></a>
    <div class="container-fluid ">
        <button class="btn btn-link btn-sm order-1 order-lg-0 ml-4" id="sidebarToggle" href="#"><span class="oi oi-menu"></span></button>
        <div class="ml-auto ml-md-0 d-flex align-items-center">
            <div class="text-muted d-none d-md-block mr-2"><?= $admin_data['wellcome_mess'] ?></div>
            <a class="btn btn-sm btn-danger" href="<?= site_url(route_to('lc_logout')) ?>"><span class="oi oi-account-logout"></span>Logout</a>
        </div>
    </div>
</nav>