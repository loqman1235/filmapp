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