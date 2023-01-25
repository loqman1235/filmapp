    <!-- Hero Slider -->
    <div class="heroSlider swiper">
      <div class="swiper-wrapper">
        <?php foreach($featuredMedias as $featuredMedia) : ?>
          <!-- Hero Movie start -->
        <div class="movie swiper-slide">
          <div class="movie_backdrop">
            <img
              src="<?= $featuredMedia->media_backdrop ?>"
              alt=""
            />
            <!-- <div class="playBtnContainer">
             <a href="#" class="playBtn"><i class="fas fa-play"></i></a>
            </div> -->
          </div>
          <div class="movie_details">
            <h1><a href="#"><?= $featuredMedia->media_name ?></a></h1>
            <div class="movie_data">
              <ul class="genre">
                <?php if($featuredMedia->media_type === 'movie') : ?>
                <?php foreach($genres as $genre) : ?>
                  <?php if($genre->movie_id === $featuredMedia->media_id) : ?>
                      <li><a href="<?= base_url('home/genre/') . $genre->genre_id ?>"><?= $genre->genre_name ?></a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
                <?php else : ?>
                  <?php foreach($serieGenres as $serieGenre) : ?>
                  <?php if($serieGenre->serie_id === $featuredMedia->media_id) : ?>
                      <li><a href="<?= base_url('home/genre/') . $serieGenre->genre_id ?>"><?= $serieGenre->genre_name ?></a></li>
                  <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
              </ul>
              <?php if($featuredMedia->media_type === 'movie') : ?>
                <span class="seperator"></span>
                <p class="time"><?= $featuredMedia->media_runtime ?></p>
                <?php else: ?>
                  <span class="seperator"></span>
                  <p class="time"><?= $featuredMedia->media_year ?></p>
              <?php endif; ?>
              <span class="seperator"></span>
              <!-- <p class="quality"><?= $featuredMovie->movie_quality ?></p> -->
              <!-- <span class="seperator"></span> -->
              <span class="movie_imdb_rating">
                <img class="imdb_logo" src="<?= base_url('assets/img/imdb-logo.png') ?>" alt="imdb"> <?= $featuredMedia->media_imdb_rating ?>
              </span>
            </div>
            <p class="movie_details_info_plot">
              <?= strShortner($featuredMedia->media_plot, 200) ?>...
            </p>
            <div class="hero_btns">
              <a href="<?= ($featuredMedia->media_type === 'movie') ? base_url('movies/watch/') . $featuredMedia->media_id : base_url('series/watch/') . $featuredMedia->media_id ?>" class="btn btn_secondary btn_lg">
              <i class="fas fa-play"></i> Play Now
              </a>
              <a href="<?= ($featuredMedia->media_type === 'movie') ? base_url('movies/movie/') . $featuredMedia->media_id : base_url('series/serie/') . $featuredMedia->media_id ?>" class="btn btn_outline btn_lg">
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