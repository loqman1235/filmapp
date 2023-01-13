<?php if($recommendedMovies || $recommendedSeries) : ?>
    <!-- recommended section start -->
    <section class="section homeSection" id="recommendedSection">
      <div class="section_header">
        <h3><strong>Recommended</strong></h3>
      </div>
      <div class="section_body swiper" id="recommendedMovieSerie">
        <div class="swiper-wrapper">
          <?php foreach($recommendedMovies as $recommendedMovie) : ?>
          <!-- Movie start -->
            <div class="section_movie swiper-slide">
              <a href="<?= base_url('home/movie/') . $recommendedMovie->movie_id ?>" class="section_movie_poster">
                <img
                  src="<?= $recommendedMovie->movie_poster ?>"
                  alt="<?= $recommendedMovie->movie_name ?><"
                />
              </a>
              <a href="<?= base_url('home/movie/') . $recommendedMovie->movie_id ?>" class="section_movie_title"><?= $recommendedMovie->movie_name ?></a>
              <ul class="genre">
                <?php foreach($genres as $genre) : ?>
                  <?php if($genre->movie_id === $recommendedMovie->movie_id) : ?>
                      <li><a href="<?= base_url('home/genre/') . $genre->genre_id ?>"><?= $genre->genre_name ?></a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </div>
          <!-- Movie end -->
          <?php endforeach; ?>

          <?php foreach($recommendedSeries as $recommendedSerie) : ?>
          <!-- serie start -->
            <div class="section_movie swiper-slide">
              <a href="<?= base_url('series/serie/') . $recommendedSerie->serie_id ?>" class="section_movie_poster">
                <img
                  src="<?= $recommendedSerie->serie_poster ?>"
                  alt="<?= $recommendedSerie->serie_name ?><"
                />
              </a>
              <a href="<?= base_url('series/serie/') . $recommendedSerie->serie_id ?>" class="section_movie_title"><?= $recommendedSerie->serie_name ?></a>
              <ul class="genre">
              <?php foreach($serieGenres as $serieGenre) : ?>
                  <?php if($serieGenre->serie_id === $recommendedSerie->serie_id) : ?>
                      <li><a href="<?= base_url('home/genre/') . $serieGenre->genre_id ?>"><?= $serieGenre->genre_name ?></a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </div>
          <!-- serie end -->
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
    <!-- recommended section end -->
<?php endif; ?>




<?php if($movies) : ?>
    <!-- section start -->
    <section class="section homeSection" id="latestMoviesSection">
      <div class="section_header">
        <h3><strong>Movies</strong></h3>
      </div>
      <div class="section_body swiper" id="latestMovies">
        <div class="swiper-wrapper">
          <?php foreach($movies as $movie) : ?>
          <!-- Movie start -->
            <div class="section_movie swiper-slide">
              <a href="<?= base_url('home/movie/') . $movie->movie_id ?>" class="section_movie_poster">
                <img
                  src="<?= $movie->movie_poster ?>"
                  alt="<?= $movie->movie_name ?><"
                />
              </a>
              <a href="<?= base_url('home/movie/') . $movie->movie_id ?>" class="section_movie_title"><?= $movie->movie_name ?></a>
              <ul class="genre">
                <?php foreach($genres as $genre) : ?>
                  <?php if($genre->movie_id === $movie->movie_id) : ?>
                      <li><a href="<?= base_url('home/genre/') . $genre->genre_id ?>"><?= $genre->genre_name ?></a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </div>
          <!-- Movie end -->
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
    <!-- section end -->
<?php endif; ?>


<?php if($series) : ?>
    <!-- section start -->
    <section class="section homeSection" id="latestSeriesSection">
      <div class="section_header">
        <h3><strong>Series</strong></h3>
      </div>
      <div class="section_body swiper" id="latestSeries">
        <div class="swiper-wrapper">
          <?php foreach($series as $serie) : ?>
          <!-- Movie start -->
            <div class="section_movie swiper-slide">
              <a href="<?= base_url('series/serie/') . $serie->serie_id ?>" class="section_movie_poster">
                <img
                  src="<?= $serie->serie_poster ?>"
                  alt="<?= $serie->serie_name ?>"
                />
              </a>
              <a href="<?= base_url('series/serie/') . $serie->serie_id ?>" class="section_movie_title"><?= $serie->serie_name ?></a>
              <ul class="genre">
                <?php foreach($serieGenres as $serieGenre) : ?>
                  <?php if($serieGenre->serie_id === $serie->serie_id) : ?>
                      <li><a href="<?= base_url('home/genre/') . $serieGenre->genre_id ?>"><?= $serieGenre->genre_name ?></a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </div>
          <!-- Movie end -->
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
    <!-- section end -->
<?php endif; ?>

 


