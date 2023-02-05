<div class="watch_page" style="background: url(<?= $movie->movie_backdrop ?>) no-repeat fixed center; background-size: cover;">
    <div class="film_player">
    <h2 class="media_title"><?= $movie->movie_name ?> <span class="media_year">(<?= $movie->movie_year ?>)</span></h2>
        <iframe src="<?= $movie->movie_embed ?>" allow="fullscreen"></iframe>
    </div>
</div>