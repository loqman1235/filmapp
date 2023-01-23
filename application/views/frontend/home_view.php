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

<!-- Popular movies -->
<?php if($trendingMovies || $trendingSeries) : ?>
<!-- Movies Section -->
<section class="section homeSection" id="trendingSection">
  <!-- Section Header -->
  <div class="section_header">
      <h3><strong>Trending</strong></h3>
    </div>
    <!-- Section Body -->
    <div class="section_body swiper" id="trendingMovies">
      <div class="swiper-wrapper" id="trendingWrapper">
      <?php foreach($trendingMovies as $trendingMovie) : ?>
        <!-- Movie Start -->
        <a data-views="<?= $trendingMovie->movie_views ?>" href="<?= base_url('movies/movie/') . $trendingMovie->movie_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $trendingMovie->movie_poster_large ?>" alt="<?= $trendingMovie->movie_name ?>">
          </div>
        </a>
        <!-- Movie End -->
        <?php endforeach; ?>

        <?php foreach($trendingSeries as $trendingSerie) : ?>
        <!-- Movie Start -->
        <a data-views="<?= $trendingSerie->serie_views ?>" href="<?= base_url('series/serie/') . $trendingSerie->serie_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $trendingSerie->serie_poster_large ?>" alt="<?= $trendingSerie->serie_name ?>">
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



<?php if($recommendedMovies || $recommendedSeries) : ?>
<!-- Recommended Section -->
<section class="section homeSection" id="recommendedSection">
  <!-- Section Header -->
  <div class="section_header">
      <h3><strong>Recommended</strong></h3>
    </div>
    <!-- Section Body -->
    <div class="section_body swiper" id="recommendedMovieSerie">
      <div class="swiper-wrapper">
        <?php foreach($recommendedMovies as $recommendedMovie) : ?>
        <!-- Movie Start -->
        <a href="<?= base_url('movies/movie/') . $recommendedMovie->movie_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $recommendedMovie->movie_poster_large ?>" alt="<?= $recommendedMovie->movie_name ?>">
          </div>
        </a>
        <!-- Movie End -->
        <?php endforeach; ?>
        <?php foreach($recommendedSeries as $recommendedSerie) : ?>
        <!-- serie Start -->
        <a href="<?= base_url('series/serie/') . $recommendedSerie->serie_id ?>" class="section_movie swiper-slide">
          <div class="section_movie_poster">
            <img src="<?= $recommendedSerie->serie_poster_large ?>" alt="<?= $recommendedSerie->serie_name ?>">
          </div>
        </a>
        <!-- serie End -->
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
           <!-- Movie Details -->
           <!-- <div class="details">
            <div class="poster_large"><img src="<?= $serie->serie_backdrop ?>" alt="<?= $serie->serie_name ?>"></div>
            <div class="info">
              <h2><?= $serie->serie_name ?> <small><?= $serie->serie_year ?></small></h2>
              <ul class="genre">
                <?php foreach($serieGenres as $serieGenre) : ?>
                  <?php if($serieGenre->serie_id === $serie->serie_id) : ?>
                      <li><?= $serieGenre->genre_name ?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
              <p class="description"><?= strShortner($serie->serie_plot, 160) ?>...</p>
            </div>
          </div> -->
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

<script>

	// Order trending section
	function comparator(a, b) {
		if (a.dataset.views > b.dataset.views)
			return -1;
		if (a.dataset.views < b.dataset.views)
			return 1;
		return 0;
	}


	const indexes = document.querySelectorAll("[data-views]");
	const indexesArray = Array.from(indexes);
	let sorted = indexesArray.sort(comparator);
	sorted.forEach(e =>
		document.getElementById('trendingWrapper').appendChild(e));




</script>
