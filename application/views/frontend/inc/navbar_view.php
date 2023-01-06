<nav class="navbar" id="navbar">
      <a href="<?= base_url('home') ?>" class="brand">Film.<span>Io</span></a>
      <ul class="nav_links_left">
        <li class="<?= setActiveClass('home') ?>"><a href="<?= base_url('home') ?>">Home</a></li>
        <li class="<?= setActiveClass('movies') ?>"><a href="<?= base_url('movies') ?>">Movies</a></li>
        <li class="<?= setActiveClass('series') ?>"><a href="<?= base_url('series') ?>">Series</a></li>
        <?php if($this->session->userdata('is_logged_in')) : ?>
          <li class="<?= setActiveClass('mylist') ?>"><a href="<?= base_url('mylist') ?>">My List</a></li>
        <?php endif; ?>
      </ul>
      <ul class="nav_links_right">
         <li>
          <button class="search_btn"><i class="far fa-search"></i></button>
        </li>
        <?php if(!$this->session->userdata('is_logged_in')) : ?>
        <li><a href="<?= base_url('login') ?>">Login</a></li>
        <li><a href="<?= base_url('register') ?>">Sign Up</a></li>
        <?php else : ?>
          <li class="user_profile">
            <div class="profileDetails">
              <div class="profileImg">
                <img src="<?= $this->session->userdata('userPic') ?>" alt="">
              </div>
              <p class="username"><?= $this->session->userdata('userName') ?></p>
            </div>

            <div class="userProfileDropdownBtn" id="userProfileDropdownBtn"><i class="far fa-caret-down"></i></div>

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