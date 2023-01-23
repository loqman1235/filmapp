    <!-- Serie Seasons -->
    <?php if($serieSeasons) :?>
    <div class="movie_embed" id="seriePlayer">
        <iframe id="serieIframe" allowfullscreen="allowfullscreen" src=""></iframe>
    </div>
    <div class="serie_seasons_container">
    <ul class="seasons">
    <?php foreach($serieSeasons as $season) : ?>
        <?php $seasonNum++; ?>
        <li class="season" data-season-id="<?= $season->season_id ?>"><a href="#">Season <?= $seasonNum ?> <span class="seasonYear">(<?= $season->season_year ?>)</span></a></li>
        <?php endforeach; ?>
    </ul>
    <ul class="episodes" id="episodes">
    </ul>
    </div>
    <!-- Serie Seasons end -->
    <!-- else comming soon -->
    <?php endif; ?>



<script>

// Get Episodes By Season Id
const getEpisodesBySeasonId = async (seasonId) => 
{

  let formData = new FormData();
  formData.append('seasonId', seasonId);
  formData.append('serieId', `<?= $serie->serie_id ?>`)

  const response = await fetch('<?= base_url('series/getEpisodes') ?>', {
    method: 'POST',
    body: formData
  });

  const result = await response.json();
  return result;

}


const seasons = document.querySelectorAll('.season');
const episodesEl = document.getElementById('episodes');


// Display Episodes and play the first episode
const showEpisodes = async () => {
  episodesEl.innerHTML = await getEpisodesBySeasonId(seasons[0].dataset.seasonId);

  // Play First episode by default
  episodesEl.children[0].classList.add('active');
  serieIframe.src = episodesEl.children[0].firstElementChild.dataset.episodeSrc

}

showEpisodes();

seasons[0].classList.add('active');

seasons.forEach(season => {
  season.addEventListener('click', async (e) => {
    e.preventDefault();
    const seasonId = season.dataset.seasonId;
    document.querySelectorAll('.season').forEach(season => season.classList.remove('active'));
    season.classList.add('active');
    episodesEl.innerHTML = await getEpisodesBySeasonId(seasonId);
  })
})


function playEpisode(e)
{
  e.preventDefault();
  document.querySelectorAll('.episode').forEach(ep => ep.classList.remove('active'));
  e.target.parentElement.classList.add('active');
  serieIframe.src = e.target.dataset.episodeSrc;
  
}


function scrollToSeriePlayer() {
  const seriePlayer = document.getElementById('seriePlayer');
  seriePlayer.scrollIntoView({ behavior: 'smooth', block: 'end'});
}

</script>
