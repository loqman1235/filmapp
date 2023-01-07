
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
          </div>
          <div class="movie_details">
            <h1><?= $featuredMovie->movie_name ?></h1>
            <ul class="genre">
              <?php foreach($genres as $genre) : ?>
                <?php if($genre->movie_id === $featuredMovie->movie_id) : ?>
                    <li><a href="<?= base_url('home/genre/') . $genre->genre_id ?>"><?= $genre->genre_name ?></a></li>
                 <?php endif; ?>
              <?php endforeach; ?>
            </ul>
            <p class="movie_details_info_plot">
              <?= strShortner($featuredMovie->movie_plot, 200) ?>...
            </p>
            <div class="hero_btns">
              <a href="#" class="btn btn_secondary">
                <i class="fas fa-play"></i> Play Now
              </a>
              <a href="<?= base_url('home/movie/') . $featuredMovie->movie_id ?>" class="btn btn_outline">
                <i class="far fa-info-circle"></i> More information
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
            <h1><?= $featuredSerie->serie_name ?></h1>
            <ul class="genre">
              <?php foreach($serieGenres as $serieGenre) : ?>
                <?php if($serieGenre->serie_id === $featuredSerie->serie_id) : ?>
                    <li><a href="<?= base_url('home/genre/') . $serieGenre->genre_id ?>"><?= $serieGenre->genre_name ?></a></li>
                 <?php endif; ?>
              <?php endforeach; ?>
            </ul>
            <p class="movie_details_info_plot">
              <?= strShortner($featuredSerie->serie_plot, 200) ?>...
            </p>
            <div class="hero_btns">
              <a href="#" class="btn btn_secondary">
                <i class="fas fa-play"></i> Play Now
              </a>
              <a href="<?= base_url('home/serie/') . $featuredSerie->serie_id ?>" class="btn btn_outline">
                <i class="far fa-info-circle"></i> More information
              </a>
            </div>
          </div>
        </div>
        <!-- Hero Movie end -->
        <?php endforeach; ?>
      </div>
    </div>
    <!-- Hero Slider end -->