<nav class="navbar" id="navbar">
      <a href="<?= base_url('home') ?>" class="brand">Film.<span>Io</span></a>
      <ul class="nav_links_left">
        <li class="<?= setActiveClass('home') ?>"><a href="<?= base_url('home') ?>">Home</a></li>
        <li class="<?= setActiveClass('movies') ?>"><a href="<?= base_url('movies') ?>">Movies</a></li>
        <li class="<?= setActiveClass('series') ?>"><a href="<?= base_url('series') ?>">Series</a></li>
        <li class="<?= setActiveClass('kids') ?>"><a href="<?= base_url('kids') ?>">Kids</a></li>
        <?php if($this->session->userdata('is_logged_in')) : ?>
          <li class="<?= setActiveClass('mylist') ?>"><a href="<?= base_url('mylist') ?>">My List</a></li>
        <?php endif; ?>
      </ul>
      <ul class="nav_links_right">
         <li>
          <button class="search_btn"><span class="material-symbols-rounded">search</span></button>
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

            <div class="userProfileDropdownBtn" id="userProfileDropdownBtn"><span class="material-symbols-rounded">expand_more</span></div>

            <ul class="userProfileDropdown">
              <li><a href="#"><span class="material-symbols-rounded">account_circle</span> Account</a></li>
              <li><a href="<?= base_url('mylist') ?>"><span class="material-symbols-rounded">bookmark</span> My list</a></li>
               <li><a href="<?= base_url('logout') ?>"><span class="material-symbols-rounded">logout</span> Logout</a></li>
            </ul>

          </li>
          <!-- <li><a href="<?= base_url('logout') ?>">Logout</a></li> -->
        <?php endif; ?>
       
      </ul>
    </nav>