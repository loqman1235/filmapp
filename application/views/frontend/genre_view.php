    <!-- section start -->
    <section class="section" id="genre_section">
      <div class="section_header">
        <h3><strong><?= $genre->genre_name ?></strong></h3>
      </div>
      <div class="section_body genre_section">
        <?php foreach($mediasByGenre as $media) : ?>
            <!-- Movie start -->
                <div class="section_movie">
                <a href="<?= (($media->media_type === 'movie') ? base_url('movies/movie/') . $media->media_id : base_url('series/serie/') . $media->media_id) ?>" class="section_movie_poster">
                    <img
                    src="<?= $media->media_poster ?>"
                    alt="<?= $media->media_name ?>"
                    />
                </a>
                <a href="<?= (($media->media_type === 'movie') ? base_url('movies/movie/') . $media->media_id : base_url('series/serie/') . $media->media_id) ?>" class="section_movie_title"><?= (strlen($media->media_name) >= 24) ? strShortner($media->media_name, 20) . '...' : $media->media_name ?></a>
                <div class="section_movie_data">
                <div class="section_movie_info">
                    <p class="section_movie_year"><?= $media->media_year ?></p>
                    <?php if($media->media_type === 'movie') : ?>
                      <div class="separator"></div>
                      <p class="section_movie_runtime"><?= $media->media_runtime ?></p>
                    <?php endif; ?>
                  </div>
                  <div class="section_movie_type"><?= (empty($media->media_age_rating)) ? 'NA' : $media->media_age_rating ?></div>
              </div>
                </div>
            <!-- Movie end -->
            <?php endforeach; ?>
      </div>
    </section>
    <!-- section end -->



