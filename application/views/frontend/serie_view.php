<div class="movie_page">
  <input type="hidden" name="movieIdInput" id="movieIdInput" value="<?= $serie->serie_id ?>">
      <div class="movie_backdrop">
        <img
          src="<?= $serie->serie_backdrop ?>"
          alt="<?= $serie->serie_name ?>"
        />
      </div>
      <div class="movie_details">
        <div class="movie_poster">
          <img
            src="<?= $serie->serie_poster ?>"
            alt="<?= $serie->serie_name ?>"
          />
        </div>
        <div class="movie_info">
          <h5 class="movie_name">
            <strong><?= $serie->serie_name ?></strong>
          </h5>
          <div class="movie_data">
            <ul class="genre">
                  <?php foreach($serieGenres as $serieGenre) : ?>
                    <?php if($serieGenre->serie_id === $serie->serie_id) : ?>
                        <li><a href="<?= base_url('home/genre/') . $serieGenre->genre_id ?>"><?= $serieGenre->genre_name ?></a></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
            </ul>
            <a href="#" class="year"><?= $serie->serie_year ?></a>
            <span class="movie_imdb_rating"
              ><i class="fas fa-star"></i> <?= $serie->serie_imdb_rating ?>/10</span
            >
          </div>
          <div class="movie_plot">
            <h3><strong>Overview</strong></h3>
            <p>
            <?= $serie->serie_plot ?>
            </p>
          </div>
         <?php if($serieActors) : ?>
          <div class="movie_cast">
            <h3><strong>Cast</strong></h3>
            <div class="cast_actors">
              <?php foreach($serieActors as $actor) : ?>
                  <a href="<?= base_url('actor/') . $actor->actor_id ?>" class="cast_actor">
                  <div class="actor_img">
                    <img
                      src="<?= $actor->actor_pic ?>"
                      alt=""
                    />
                  </div>
                  <div class="actor_details">
                    <div class="actor_name"><?= $actor->actor_name ?></div>
                    <div class="actor_moviename"><?= $actor->actor_as ?></div>
                  </div>
                </a>
                <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>
          <div class="movie_btns">
            <a href="<?= base_url('home/watch/') . $serie->serie_id ?>" class="btn btn_secondary">
              <i class="far fa-play"></i> Watch Now
            </a>
            <button class="btn btn_outline" id="trailerBtn">
              <i class="far fa-video"></i> Trailer
            </button>
            <?php if($this->session->userdata('is_logged_in')) :?>
            <div class="deleteBtnContainer" id="deleteBtnContainer">
                <?php if(!$watchListMoviesExist) :?>
                  <button class="btn btn_outline addToMyListBtn" id="addToMyListBtn"><i class="far fa-plus"></i> My list</button>
                  <?php else: ?>
                    <button class="btn btn_outline removeFromMyListBtn" id="removeFromMyListBtn"><i class="far fa-check"></i> My list</button>
                  <?php endif; ?>
            </div>
           <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Similar Movies -->

    <?php if($similarSeries) : ?>
      <section class="section" id="suggestion">
        <div class="section_header">
          <h3><strong>More like this</strong></h3>
        </div>
        <div class="section_body swiper" id="suggestMovies">
          <div class="swiper-wrapper">
            <?php foreach($similarSeries as $similarSerie) : ?>
              <div class="section_movie swiper-slide">
                <div class="section_movie_poster">
                  <img
                    src="<?= $similarSerie->serie_poster ?>"
                    alt="<?= $similarSerie->serie_name ?>"
                  />
                </div>
                <a href="<?= base_url('series/serie/') . $similarSerie->serie_id ?>" class="section_movie_title"><?= $similarSerie->serie_name ?></a>
                <ul class="genre">
                <?php foreach($serieGenres as $serieGenre) : ?>
                    <?php if($serieGenre->serie_id === $similarSerie->serie_id) : ?>
                        <li><a href="<?= base_url('home/genre/') . $serieGenre->genre_id ?>"><?= $serieGenre->genre_name ?></a></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              </div>
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

      
    </div>


<script>
  const addToMyListBtn = document.getElementById('addToMyListBtn');
  const removeFromMyListBtn = document.getElementById('removeFromMyListBtn');


  const addMovieToWatchlist = async (e) => {
    e.preventDefault();
    
    let formData = new FormData();
    formData.append('movieId', '<?= $serie->serie_id ?>');
    formData.append('movieBackdrop', '<?= $serie->serie_backdrop ?>');
    formData.append('moviePoster', '<?= $serie->serie_poster ?>');
    formData.append('movieName', '<?= $serie->serie_name ?>');
    formData.append('moviePlot', `<?= $serie->serie_plot ?>`);
    formData.append('watchlistItemType', 'serie');


    const response = await fetch('<?= base_url('mylist/addToWatchList') ?>', {
      method: 'POST',
      body: formData
    });


    const result = await response.json();


    if(result.success)
    {
      // alert(result.msg);
     document.getElementById('deleteBtnContainer').innerHTML = ' <button onclick="removeMovieFromWatchlist(event)"  class="btn btn_outline removeFromMyListBtn" id="removeFromMyListBtn"><i class="far fa-check"></i> My list</button>';
    }

    if(result.error)
    {
      alert(result.msg);
    }
    

  }

  // Add movie to user's watchlist 
 if(addToMyListBtn !== null)  addToMyListBtn.addEventListener('click', addMovieToWatchlist);




  const removeMovieFromWatchlist = async (e) => {
    e.preventDefault();

    let formData = new FormData();
    formData.append('movieId', `<?= $serie->serie_id ?>`);
    formData.append('movieName', `<?= $serie->serie_name ?>`);

    const response = await fetch('<?= base_url('mylist/removeFromWatchList') ?>',{
      method: 'POST',
      body: formData
    });

    const result = await response.json();

    if(result.success)
    {
      // alert(result.msg);
      document.getElementById('deleteBtnContainer').innerHTML = '<button onclick="addMovieToWatchlist(event)" class="btn btn_outline addToMyListBtn" id="addToMyListBtn"><i class="far fa-plus"></i> My list</button>';
    }

  }

  // Remove movie from user's watchlist

  if(removeFromMyListBtn !== null) removeFromMyListBtn.addEventListener('click', removeMovieFromWatchlist);


</script>