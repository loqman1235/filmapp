<div class="movie_page">
  <input type="hidden" name="movieIdInput" id="movieIdInput" value="<?= $movie->movie_id ?>">
      
      <div class="movie_details">
        <div class="section_movie_left">
          <div class="movie_poster">
            <img
              src="<?= $movie->movie_poster ?>"
              alt=""
            />
          </div>
          <div class="movie_btns">
            <a href="<?= base_url('home/watch/') . $movie->movie_id ?>" class="btn btn_secondary">
              <i class="fas fa-play"></i> Play Now
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
            <?php else : ?>
              <a href="<?= base_url('login') ?>" class="btn btn_outline " id=""><i class="far fa-plus"></i> My list</a>
           <?php endif; ?>
          </div>
        </div>
        <div class="movie_info">
          <h5 class="movie_name">
            <strong><?= $movie->movie_name ?></strong>
          </h5>
          <div class="movie_data">
            <ul class="genre">
                  <?php foreach($genres as $genre) : ?>
                    <?php if($genre->movie_id === $movie->movie_id) : ?>
                        <li><a href="<?= base_url('home/genre/') . $genre->genre_id ?>"><?= $genre->genre_name ?></a></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
            </ul>
            <a href="#" class="year"><?= $movie->movie_year ?></a>
            <p class="time"><?= $movie->movie_runtime ?></p>
            <p class="quality"><?= $movie->movie_quality ?></p>
            <span class="movie_imdb_rating"
              ><img src="<?= base_url('assets/img/imdb-logo.png') ?>" alt="" class="imdb_logo"> <?= $movie->movie_imdb_rating ?>/10</span
            >
          </div>
          <div class="movie_plot">
            <h3><strong>Overview</strong></h3>
            <p>
            <?= $movie->movie_plot ?>
            </p>
          </div>
         <?php if($movieActors) : ?>
          <div class="movie_cast">
            <h3><strong>Cast</strong></h3>
            <div class="cast_actors">
              <?php foreach($movieActors as $actor) : ?>
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
         
        </div>
      </div>

      <!-- Similar Movies -->

    <?php if($similarMovies) : ?>
      <section class="section" id="suggestion">
        <div class="section_header">
          <h3><strong>More like this</strong></h3>
        </div>
        <div class="section_body swiper" id="suggestMovies">
          <div class="swiper-wrapper">
            <?php foreach($similarMovies as $similarMovie) : ?>
              <div class="section_movie swiper-slide">
                <div class="section_movie_poster">
                  <img
                    src="<?= $similarMovie->movie_poster ?>"
                    alt="<?= $similarMovie->movie_name ?>"
                  />
                </div>
                <a href="<?= base_url('home/movie/') . $similarMovie->movie_id ?>" class="section_movie_title"><?= $similarMovie->movie_name ?></a>
                <ul class="genre">
                  <?php foreach($genres as $genre) : ?>
                      <?php if($genre->movie_id === $similarMovie->movie_id) : ?>
                          <li><a href="<?= base_url('home/genre/') . $genre->genre_id ?>"><?= $genre->genre_name ?></a></li>
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


    <!-- footer start -->
    <footer class="footer">
      <div class="footer_top">
      <div class="footer_column">
          <h4>Browse</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Discover</a></li>
            <li><a href="#">Movies/a></li>
            <li><a href="#">Shows</a></li>
          </ul>
        </div>

        <div class="footer_column">
          <h4>Links</h4>
          <ul>
            <li><a href="#">link</a></li>
            <li><a href="#">link</a></li>
            <li><a href="#">link</a></li>
            <li><a href="#">link</a></li>
          </ul>
        </div>

        <div class="footer_column">
          <h4>Links</h4>
          <ul>
            <li><a href="#">link</a></li>
            <li><a href="#">link</a></li>
            <li><a href="#">link</a></li>
            <li><a href="#">link</a></li>
          </ul>
        </div>
        <div class="footer_column">
          <h4>Support</h4>
          <ul>
            <li><a href="#">Contact</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Terms of use</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="footer_column">
          <h4>Contact</h4>
          <ul>
            <li><i class="fal fa-map-marker-alt"></i> 233 New Hampshire 107</li>
            <li><i class="fal fa-at"></i> tonyvito@gmail.com</li>
            <li><i class="fal fa-phone"></i> +213 776 05 09 93</li>
          </ul>
          <ul class="social">
            <li>
              <a href="#"><i class="fab fa-facebook-f"></i></a>
            </li>
            <li>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </li>
            <li>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </li>
            <li>
              <a href="#"><i class="fab fa-youtube"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </footer>
    <!-- footer end -->

<script>
  const addToMyListBtn = document.getElementById('addToMyListBtn');
  const removeFromMyListBtn = document.getElementById('removeFromMyListBtn');


  const addMovieToWatchlist = async (e) => {
    e.preventDefault();
    
    let formData = new FormData();
    formData.append('movieId', '<?= $movie->movie_id ?>');
    formData.append('movieBackdrop', '<?= $movie->movie_backdrop ?>');
    formData.append('moviePoster', '<?= $movie->movie_poster ?>');
    formData.append('movieName', '<?= $movie->movie_name ?>');
    formData.append('moviePlot', `<?= $movie->movie_plot ?>`);
    formData.append('watchlistItemType', 'movie');



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
    formData.append('movieId', `<?= $movie->movie_id ?>`);
    formData.append('movieName', `<?= $movie->movie_name ?>`);

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