<!-- Section start -->
<section class="section" id="series_section">
    <div class="section_header">
        <h3><strong>Series</strong></h3>
    </div>
    <?php if($series) : ?>
    <div class="section_body genre_section">
        <?php foreach($series as $serie) : ?>
            <div class="section_movie">
                <a href="<?= base_url('series/serie/') . $serie->serie_id ?>" class="section_movie_poster">
                    <img src="<?= $serie->serie_poster ?>" alt="<?= $serie->serie_name ?>">
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
        <?php endforeach; ?>
    </div>
    <?php else : ?>
        <p>No Series Found</p>
     <?php endif; ?>
</section>
<!-- Section end -->