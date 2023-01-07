<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Series extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('serie_model');
        $this->load->model('movie_model');
    }

    public function index()
    {
        $data['page_title'] = 'Series';
        $data['series'] = $this->serie_model->getAllSeries();
		$data['serieGenres'] = $this->serie_model->getSerieGenre();


        $this->load->view('frontend/inc/header_view', $data);
        $this->load->view('frontend/inc/navbar_view');
        $this->load->view('frontend/series_view', $data);
		$this->load->view('frontend/inc/footerElement_view');
        $this->load->view('frontend/inc/footer_view');

    }

    public function serie($serieId)
    {


        $data['page_title'] = 'serie';
        $data['serie'] = $this->serie_model->getSerieById($serieId);
		$data['serieGenres'] = $this->serie_model->getSerieGenre();
		$data['watchListMoviesExist'] = $this->movie_model->watchListMovieExist($serieId);

        $similarSeriesQueryKeywords = $data['serie']->serie_keywords;
		$data['similarSeries'] = $this->serie_model->getSimilarSeries($similarSeriesQueryKeywords, $serieId);
		$data['serieActors'] = $this->serie_model->getSerieActorsBySerieId($serieId);
        // Get seasons
        $data['serieSeasons'] = $this->serie_model->getSeasonsBySerieId($serieId);
        // $data['serieSeasonHasEpisoded'] = $this->serie_model->serieSeasonHasEpisodes($serieId);
        $data['seasonNum'] = 0;

      

        $this->load->view('frontend/inc/header_view', $data);
        $this->load->view('frontend/inc/navbar_view');
        $this->load->view('frontend/serie_view', $data);
        $this->load->view('frontend/inc/footerElement_view');
        $this->load->view('frontend/inc/footer_view');
    }

    public function getEpisodes()
    {
        if(!empty($this->input->post('seasonId')) && !empty($this->input->post('serieId')))
        {
            $seasonId = htmlentities($this->input->post('seasonId'));
            $serieId  = htmlentities($this->input->post('serieId'));
            $episodes = $this->serie_model->getEpisodesBySerieId($seasonId, $serieId);
            $episodesNum = 0;
            $result = '';
            
            if($episodes)
            {
                foreach($episodes as $episode)
                {
                    $episodesNum++;
                    $result .= '<li><a href="'.base_url('series/episode/'). $episode->episode_id . '"><span class="ep_num">ep.'. $episodesNum .'</span> <span class="ep_name">'. $episode->episode_name .'</span></a></li>';
                }
            }
            else
            {
                $result .= '<li><p>Comming soon</p></li>';
            }
            echo json_encode($result);
        }
    }

}