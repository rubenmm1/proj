<div class="main-header nav nav-item hor-header">
  <div class="container">
    <div class="main-header-left ">
      <a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
      <a class="header-brand" href="inicio.php">
        <img src="assets/img/brand/logo-white.png" class="desktop-dark">
        <img src="assets/img/brand/logo.png" class="desktop-logo">
        <img src="assets/img/brand/favicon.png" class="desktop-logo-1">
        <img src="assets/img/brand/favicon-white.png" class="desktop-logo-dark">
      </a>
      <!--
      <div class="main-header-center  ms-4">
        <input class="form-control" placeholder="Search for anything..." type="search"><button class="btn"><i class="fe fe-search"></i></button>
      </div>
    -->
    </div><!-- search -->
    <div class="main-header-right">
      <ul class="nav nav-item  navbar-nav-right ms-auto">

        <li class="nav-item full-screen fullscreen-button">
          <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
        </li>
        <li class="dropdown main-profile-menu nav nav-item nav-link">
          <a class="profile-user d-flex" href=""><?php echo $_SESSION['razon_social']?></a>
          <div class="dropdown-menu">
            <div class="main-header-profile bg-primary p-3">
              <div class="d-flex wd-100p">
                <!-- <div class="main-img-user"><img alt="" src="assets/img/faces/6.jpg" class=""></div> -->
                <div class="ms-3 my-auto">
                  <h6><?php echo $_SESSION['razon_social']?></h6><span>Cliente</span>
                </div>
              </div>
            </div>
           
            <a class="dropdown-item" href="logout.php"><i class="bx bx-log-out"></i>Salir</a>
          </div>
        </li>        
      </ul>
    </div>
  </div>
</div>
