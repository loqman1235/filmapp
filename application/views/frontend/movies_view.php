<!-- Section start -->
<section class="section">
    <div class="section_header">
        <h3><strong>Movies</strong></h3>
    </div>
    <?php if($movies) : ?>
    <div class="section_body genre_section">
        <?php foreach($movies as $movie) : ?>
            <div class="section_movie">
                <a href="<?= base_url('home/movie/') . $movie->movie_id ?>" class="section_movie_poster">
                    <img src="<?= $movie->movie_poster ?>" alt="<?= $movie->movie_name ?>">
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
        <?php endforeach; ?>
    </div>
    <?php else : ?>
        <p>No Movies Found</p>
     <?php endif; ?>
</section>
<!-- Section end -->