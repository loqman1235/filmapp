    <!-- Hero Slider -->
    <div class="heroSlider swiper">
      <div class="swiper-wrapper">
        <?php foreach($featuredMovies as $featuredMovie) : ?>
          <!-- Hero Movie start -->
        <div class="movie swiper-slide">
          <div class="movie_backdrop">
            <img
              src="<?= $featuredMovie->movie_backdrop ?>"
              alt=""
            />
            <!-- <div class="playBtnContainer">
             <a href="#" class="playBtn"><i class="fas fa-play"></i></a>
            </div> -->
          </div>
          <div class="movie_details">
            <h1><a href="<?= base_url('movies/movie/') . $featuredMovie->movie_id ?>"><?= $featuredMovie->movie_name ?></a></h1>
            <div class="movie_data">
              <ul class="genre">
                <?php foreach($genres as $genre) : ?>
                  <?php if($genre->movie_id === $featuredMovie->movie_id) : ?>
                      <li><a href="<?= base_url('home/genre/') . $genre->genre_id ?>"><?= $genre->genre_name ?></a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
              <span class="seperator"></span>
              <p class="time"><?= $featuredMovie->movie_runtime ?></p>
              <span class="seperator"></span>
              <p class="quality"><?= $featuredMovie->movie_quality ?></p>
              <span class="seperator"></span>
              <span class="movie_imdb_rating">
                <img class="imdb_logo" src="<?= base_url('assets/img/imdb-logo.png') ?>" alt="imdb"> <?= $featuredMovie->movie_imdb_rating ?>
              </span>
            </div>
            <p class="movie_details_info_plot">
              <?= strShortner($featuredMovie->movie_plot, 200) ?>...
            </p>
            <div class="hero_btns">
              <a href="<?= base_url('movies/watch/') . $featuredMovie->movie_id ?>" class="btn btn_secondary">
              <span class="material-symbols-rounded">play_arrow</span> Play Now
              </a>
              <a href="<?= base_url('movies/movie/') . $featuredMovie->movie_id ?>" class="btn btn_outline">
                <span class="material-symbols-rounded">info</span> More Info
              </a>
            </div>
          </div>
        </div>
        <!-- Hero Movie end -->
        <?php endforeach; ?>
                
        <!-- Featured Series -->
        <?php foreach($featuredSeries as $featuredSerie) : ?>
          <!-- Hero Movie start -->
        <div class="movie swiper-slide">
          <div class="movie_backdrop">
            <img
              src="<?= $featuredSerie->serie_backdrop ?>"
              alt=""
            />
          </div>
          <div class="movie_details">
          <h1><a href="<?= base_url('series/serie/') . $featuredSerie->serie_id ?>"><?= $featuredSerie->serie_name ?></a></h1>

          <div class="movie_data">
              <ul class="genre">
                <?php foreach($serieGenres as $serieGenre) : ?>
                  <?php if($serieGenre->serie_id === $featuredSerie->serie_id) : ?>
                      <li><a href="<?= base_url('home/genre/') . $serieGenre->genre_id ?>"><?= $serieGenre->genre_name ?></a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
              <span class="seperator"></span>
              <p class="quality"><?= $featuredSerie->serie_quality ?></p>
              <span class="seperator"></span>
              <span class="movie_imdb_rating">
                <img class="imdb_logo" src="<?= base_url('assets/img/imdb-logo.png') ?>" alt="imdb"> <?= $featuredSerie->serie_imdb_rating ?>
              </span>
            </div>
            <p class="movie_details_info_plot">
              <?= strShortner($featuredSerie->serie_plot, 200) ?>...
            </p>
            <div class="hero_btns">
              <a href="<?= base_url('series/watch/') . $featuredSerie->serie_id ?>" class="btn btn_secondary">
                <span class="material-symbols-rounded">play_arrow</span> Play Now
              </a>
              <a href="<?= base_url('series/serie/') . $featuredSerie->serie_id ?>" class="btn btn_outline">
              <span class="material-symbols-rounded">info</span> More Info
              </a>
            </div>
          </div>
        </div>
        <!-- Hero Movie end -->
        <?php endforeach; ?>
      </div>
    </div>
    <!-- Hero Slider end -->