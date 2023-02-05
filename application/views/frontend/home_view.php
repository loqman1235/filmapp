<?php if($this->session->userdata('is_logged_in') && $watchlistMovies) : ?>
<!-- List Section -->
<section class="section homeSection" id="listMoviesSection">
  <!-- Section Header -->
  <div class="section_header">
      <h3><strong>My list</strong></h3>
    </div>
    <!-- Section Body -->
    <div class="section_body swiper" id="listMovies">
      <div class="swiper-wrapper">
      <?php foreach($watchlistMovies as $watchlistMovie) : ?>
        <!-- Movie Start -->
        <a href="<?= ($watchlistMovie->watchlist_type === 'movie') ? base_url('movies/movie/') . $watchlistMovie->watchlist_movieId : base_url('series/serie/') . $watchlistMovie->watchlist_movieId ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= (empty($watchlistMovie->watchlist_moviePoster)) ? $watchlistMovie->	watchlist_movieBackdrop : $watchlistMovie->watchlist_moviePoster ?>" alt="<?= $watchlistMovie->watchlist_movieName ?>">
          </div>
          <p class="section_movie_title"><?= ((strlen($watchlistMovie->watchlist_movieName) >= 24) ? strShortner($watchlistMovie->watchlist_movieName, 24) . '...' : $watchlistMovie->watchlist_movieName) ?></p>
          <div class="section_movie_data">
                <div class="section_movie_info">
                    <p class="section_movie_year"><?= $watchlistMovie->watchlist_movieYear ?></p>
                    <?php if($watchlistMovie->watchlist_type === 'movie') : ?>
                        <div class="separator"></div>
                       <p class="section_movie_runtime"><?= $watchlistMovie->watchlist_movieRuntime ?></p>
                      <?php endif; ?>
                </div>
                <div class="section_movie_type"><?= (empty($watchlistMovie->watchlist_movieAgeRating)) ? 'NA' : $watchlistMovie->watchlist_movieAgeRating ?></div>
            </div>
        </a>
        <!-- Movie End -->
        <?php endforeach; ?>
      </div>
      <div class="movies_prev_btn">
          <i class="fal fa-chevron-left"></i>
        </div>
        <div class="movies_next_btn">
          <i class="fal fa-chevron-right"></i>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Recommended -->
<?= displaySectionSlider('recommendedSection', 'recommendedMovieSerie', 'Recommended', $recommendedMedias) ?>
<!-- Recommended ends -->

<!-- Upcoming -->
<?= displaySectionSlider('upcomingSection', 'upcomingSlider', 'Upcoming', $upcomingMedias) ?>
<!-- Upcoming ends -->

<!-- New Releases -->
<?= displaySectionSlider('newReleaseSection', 'newReleaseSlider', 'New Releases', $newlyReleasedMedias) ?>
<!-- New Releases ends -->

<!-- Popular -->
<?= displaySectionSlider('trendingSection', 'trendingMovies', 'Popular', $trendingMedias) ?>
<!-- Popular ends -->

<?php foreach($mediasByGenre as $key => $value) : ?>
  <?= displaySectionSlider(lcfirst($key) . 'Section', lcfirst($key) . 'Slider', $key , $value) ?>
<?php endforeach; ?>



<!-- Popular -->
<?= displaySectionSlider('recentlyAddedSection', 'recentlyAddedSlider', 'Recently Added', $recentMedias) ?>
<!-- Popular ends -->

<script>
const buttons = document.querySelectorAll(".watchlistBtn");

buttons.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    addItemToDB(btn);
  });

  checkItemExist(btn).then((itemExist) => {
    if (itemExist) {
      btn.textContent = "Remove from My List";
      btn.dataset.add = false;
      btn.classList.remove("add-to-watchlist-btn");
      btn.classList.add("remove-from-watchlist-btn");
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        removeItemFromDB(btn);
      });
    }
  });
});


//  Add media to watchlist
async function addItemToDB(btn) {
  // Check if item exist in DB
  checkItemExist(btn).then(async (itemExist) => {
    if (!itemExist) {
      //  Add Item
      let formData = new FormData();

      const itemId = btn.parentElement.parentElement.parentElement.dataset.mediaId;
      const itemPoster = btn.parentElement.parentElement.dataset.poster;
      const itemName = btn.parentElement.parentElement.nextElementSibling.dataset.mediaName;
      const itemYear = btn.parentElement.parentElement.parentElement.lastElementChild.firstElementChild.firstElementChild.dataset.mediaYear;
      const itemRuntime = btn.parentElement.parentElement.parentElement.lastElementChild.firstElementChild.lastElementChild.dataset.mediaRuntime;
      const itemAgeRating = btn.parentElement.parentElement.parentElement.lastElementChild.lastElementChild.dataset.mediaAgeRating;
      const itemType = btn.parentElement.parentElement.parentElement.dataset.mediaType;

      formData.append("mediaId", itemId);
      formData.append("mediaPoster", itemPoster);
      formData.append("mediaName", itemName);
      formData.append("mediaYear", itemYear);
      formData.append("mediaRuntime", itemRuntime);
      formData.append("mediaAgeRating", itemAgeRating);
      formData.append("mediaType", itemType);

     

      const response = await fetch("<?= base_url('mylist/addMediaToWatchlist') ?>", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        // Display a message to msg to inform use that the media is added to watchlist
        document.querySelectorAll(".watchlistBtn").forEach((itemButton) => {
          if (
            itemButton.parentElement.parentElement.parentElement.dataset.mediaId 
            === 
            btn.parentElement.parentElement.parentElement.dataset.mediaId
          ) {
            itemButton.textContent = "Remove from My List";
            itemButton.dataset.add = false;
            itemButton.classList.remove("add-to-watchlist-btn");
            itemButton.classList.add("remove-from-watchlist-btn");
            itemButton.addEventListener('click', (e) => {
                e.preventDefault();
                removeItemFromDB(itemButton);
            });
          }
        });
      } else {
        alert(result.message);
      }
    } 
  });
}

// Remove Media from watchlist
async function removeItemFromDB(btn) {
  checkItemExist(btn).then(async (itemExist) => {
    if (itemExist) {
      let formData = new FormData();
      formData.append("mediaId", btn.parentElement.parentElement.parentElement.dataset.mediaId);
      formData.append("mediaName", btn.parentElement.parentElement.nextElementSibling.dataset.mediaName);

      const response = await fetch("<?= base_url('mylist/removeMediaFromList') ?>", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();
      if (result.success) {
        document.querySelectorAll("button").forEach((itemButton) => {
          if (
            itemButton.parentElement.parentElement.parentElement.dataset.mediaId 
            === 
            btn.parentElement.parentElement.parentElement.dataset.mediaId
          ) {
            itemButton.textContent = "Add to My List";
            itemButton.dataset.add = true;
            itemButton.classList.remove("remove-from-watchlist-btn");
            itemButton.classList.add("add-to-watchlist-btn");
          }
        });
      }
    }
  });
}


// Check media exist
async function checkItemExist(btn) {
  let formData = new FormData();
  formData.append("mediaId", btn.parentElement.parentElement.parentElement.dataset.mediaId);
  formData.append("mediaType", btn.parentElement.parentElement.parentElement.dataset.mediaType);

  const response = await fetch("<?= base_url('mylist/mediaExistInWatchlist') ?>", {
    method: "POST",
    body: formData,
  });

  const result = await response.json();
  if (result) return true;
  else return false;
}



</script>