    <!-- section start -->
    <section class="section">
      <div class="section_header">
        <h3><strong><?= $genre->genre_name ?></strong></h3>
      </div>
      <div class="section_body genre_section">
        <?php foreach($moviesByGenre as $movie) : ?>
            <!-- Movie start -->
                <div class="section_movie">
                <a href="<?= base_url('home/movie/') . $movie->movie_id ?>" class="section_movie_poster">
                    <img
                    src="<?= $movie->movie_poster ?>"
                    alt=""
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
    </section>
    <!-- section end -->



