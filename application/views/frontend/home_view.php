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
            <img src="<?= (empty($watchlistMovie->watchlist_moviePosterLarge)) ? $watchlistMovie->	watchlist_movieBackdrop : $watchlistMovie->watchlist_moviePosterLarge ?>" alt="<?= $watchlistMovie->watchlist_movieName ?>">
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

<?php if($recommendedMedias) : ?>
<!-- Recommended Section -->
<section class="section homeSection" id="recommendedSection">
  <!-- Section Header -->
  <div class="section_header">
      <h3><strong>Recommended</strong></h3>
    </div>
    <!-- Section Body -->
    <div class="section_body swiper" id="recommendedMovieSerie">
      <div class="swiper-wrapper">
        <?php foreach($recommendedMedias as $recommendedMedia) : ?>
        <!-- Movie Start -->
        <a href="<?= ($recommendedMedia->media_type === 'movie') ? base_url('movies/movie/') . $recommendedMedia->media_id : base_url('series/serie/') . $recommendedMedia->media_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $recommendedMedia->media_poster_large ?>" alt="<?= $recommendedMedia->media_name ?>">
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


<!-- Popular movies -->
<?php if($trendingMedias) : ?>
<!-- Movies Section -->
<section class="section homeSection" id="trendingSection">
  <!-- Section Header -->
  <div class="section_header">
      <h3><strong>Popular</strong></h3>
    </div>
    <!-- Section Body -->
    <div class="section_body swiper" id="trendingMovies">
      <div class="swiper-wrapper" id="trendingWrapper">
      <?php foreach($trendingMedias as $trendingMedia) : ?>
        <!-- Movie Start -->
        <a href="<?= ($trendingMedia->media_type === 'movie') ? base_url('movies/movie/') . $trendingMedia->media_id : base_url('series/serie/') . $trendingMedia->media_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $trendingMedia->media_poster_large ?>" alt="<?= $trendingMedia->media_name ?>">
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
<!-- Popular ends -->



<?php if($movies) : ?>
<!-- Movies Section -->
<section class="section homeSection" id="latestMoviesSection">
  <!-- Section Header -->
  <div class="section_header">
      <h3><strong>Movies</strong></h3>
    </div>
    <!-- Section Body -->
    <div class="section_body swiper" id="latestMovies">
      <div class="swiper-wrapper">
      <?php foreach($movies as $movie) : ?>
        <!-- Movie Start -->
        <a href="<?= base_url('movies/movie/') . $movie->movie_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $movie->movie_poster_large ?>" alt="<?= $movie->movie_name ?>">
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



<?php if($series) : ?>
<!-- Series Section -->
<section class="section homeSection" id="latestSeriesSection">
  <!-- Section Header -->
  <div class="section_header">
      <h3><strong>Series</strong></h3>
    </div>
    <!-- Section Body -->
    <div class="section_body swiper" id="latestSeries">
      <div class="swiper-wrapper">
      <?php foreach($series as $serie) : ?>
        <!-- Movie Start -->
        <a href="<?= base_url('series/serie/') . $serie->serie_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $serie->serie_poster_large ?>" alt="<?= $serie->serie_name ?>">
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


<!-- Animation -->

<?php if($animationMovies || $animationSeries) : ?>
<!-- Series Section -->
<section class="section homeSection" id="animationSection">
  <!-- Section Header -->
  <div class="section_header">
      <h3><strong>Animation</strong></h3>
    </div>
    <!-- Section Body -->
    <div class="section_body swiper" id="animation">
      <div class="swiper-wrapper" id="animation-wrapper">
      <?php foreach($animationMovies as $animationMovie) : ?>
        <a data-release-date="<?= $animationMovie->movie_release_date ?>" href="<?= base_url('movies/movie/') . $animationMovie->movie_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $animationMovie->movie_poster_large ?>" alt="<?= $animationMovie->movie_name ?>">
          </div>
        </a>
        <?php endforeach; ?>

        <?php foreach($animationSeries as $animationSerie) : ?>
        <a data-release-date="<?= $animationSerie->serie_release_date ?>" href="<?= base_url('series/serie/') . $animationSerie->serie_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $animationSerie->serie_poster_large ?>" alt="<?= $animationSerie->serie_name ?>">
          </div>
        </a>
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
