<nav class="navbar" id="navbar">
      <a href="<?= base_url('home') ?>" class="brand">Film.<span>Io</span></a>
      <ul class="nav_links_left">
        <li class="<?= setActiveClass('home') ?>"><a href="<?= base_url('home') ?>"><i class="far fa-home"></i> Home</a></li>
        <li class="<?= setActiveClass('movies') ?>"><a href="<?= base_url('movies') ?>"><i class="far fa-video"></i> Movies</a></li>
        <li class="<?= setActiveClass('series') ?>"><a href="<?= base_url('series') ?>"><i class="far fa-tv-alt"></i> Series</a></li>
        <li class="<?= setActiveClass('trending') ?>"><a href="<?= base_url('trending') ?>"><i class="far fa-fire"></i> Trending</a></li>
        <?php if($this->session->userdata('is_logged_in')) : ?>
          <li class="<?= setActiveClass('mylist') ?>"><a href="<?= base_url('mylist') ?>"><i class="far fa-bookmark"></i> My List</a></li>
        <?php endif; ?>
      </ul>
      <ul class="nav_links_right">
         <li>
          <button class="search_btn"><i class="far fa-search"></i></button>
        </li>
        <?php if(!$this->session->userdata('is_logged_in')) : ?>
        <li><a href="<?= base_url('login') ?>"> <i class="far fa-user"></i> Login</a></li>
        <li><a href="<?= base_url('register') ?>"> <i class="far fa-user-plus"></i> Sign Up</a></li>
        <?php else : ?>
          <li class="user_profile">
            <div class="profileDetails">
              <div class="profileImg">
                <img src="<?= $this->session->userdata('userPic') ?>" alt="">
              </div>
              <p class="username"><?= $this->session->userdata('userName') ?></p>
            </div>

            <div class="userProfileDropdownBtn" id="userProfileDropdownBtn"><i class="far fa-angle-down"></i></div>

            <ul class="userProfileDropdown">
              <li><a href="#"><i class="far fa-user-circle"></i> Account</a></li>
              <li><a href="<?= base_url('mylist') ?>"><i class="far fa-list-alt"></i> My list</a></li>
               <li><a href="<?= base_url('logout') ?>"><i class="far fa-sign-out"></i> Logout</a></li>
            </ul>

          </li>
          <!-- <li><a href="<?= base_url('logout') ?>">Logout</a></li> -->
        <?php endif; ?>
       
      </ul>
    </nav>