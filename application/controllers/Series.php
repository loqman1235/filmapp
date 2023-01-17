<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Series extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('serie_model');
        $this->load->model('movie_model');
        $this->load->library('pagination');

    }

    public function index()
    {

          // Pagination
          $config['base_url'] = base_url('/series/page/');
          $config['total_rows'] = $this->serie_model->countSeries();
          $config['per_page'] = 24;
          $config ['num_links'] = 2;
          $config['use_page_numbers'] = TRUE;
          $config['uri_segment'] = 3;
          $config['first_url'] = base_url('series/page/1');
  
          // Customizing the pagination 
          $config['first_link'] = false; 
          $config['last_link']  = false;
          $config ['prev_link'] = '<i class="far fa-angle-left"></i>';
          $config ['next_link'] = '<i class="far fa-angle-right"></i>';
          $config['prev_tag_open'] = '<li class="pagination_item prev">';
          $config['prev_tag_close'] = '</li>';
          $config['next_tag_open'] = '<li class="pagination_item next">';
          $config['next_tag_close'] = '</li>';
          $config['num_tag_open'] = '<li class="pagination_item">';
          $config['num_tag_close'] = '</li>';
          $config['cur_tag_open'] = '<li class="pagination_item active">';
          $config['cur_tag_close'] = '</li>';
          $config['full_tag_open']  = '<ul class="pagination">';
          $config['full_tag_close'] = '</ul>';
          $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
          $this->pagination->initialize($config);

        $data['page_title'] = 'Series';
        $data['series'] = $this->serie_model->getSeriesLimit($config['per_page'], $page);
		$data['serieGenres'] = $this->serie_model->getSerieGenre();
        $data['pagination'] = $this->pagination->create_links();

        $this->load->model('movie_model');
        $data['allGenres']  = $this->movie_model->getAllGenres(); 
        $data['years'] = $this->serie_model->getSerieYears();



        $this->load->view('frontend/inc/header_view', $data);
        $this->load->view('frontend/inc/navbar_view');
        $this->load->view('frontend/series_view', $data);
		$this->load->view('frontend/inc/footerElement_view');
        $this->load->view('frontend/inc/footer_view');

    }

    public function serie($serieId)
    {
        $data['serie'] = $this->serie_model->getSerieById($serieId);
        
        if($data['serie'])
        {

            $data['page_title'] = 'serie';
            $data['serieGenres'] = $this->serie_model->getSerieGenre();
            $data['watchListMoviesExist'] = $this->movie_model->watchListMovieExist($serieId);

            $similarSeriesQueryKeywords = $data['serie']->serie_keywords;
            $data['similarSeries'] = $this->serie_model->getSimilarSeries($similarSeriesQueryKeywords, $serieId);
            $data['serieActors'] = $this->serie_model->getSerieActorsBySerieId($serieId);
            // Get seasons
            $data['serieSeasons'] = $this->serie_model->getSeasonsBySerieId($serieId);
            // $data['serieSeasonHasEpisoded'] = $this->serie_model->serieSeasonHasEpisodes($serieId);
            $data['seasonNum'] = 0;

        
            // Insert views
			$this->serie_model->updateSerieVisitors($serieId);

            $this->load->view('frontend/inc/header_view', $data);
            $this->load->view('frontend/inc/navbar_view');
            $this->load->view('frontend/serie_view', $data);
            $this->load->view('frontend/inc/footerElement_view');
            $this->load->view('frontend/inc/footer_view');
        }
        else
        {
            redirect(base_url('home'));
        }
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
                    $result .= '<li class="episode" data-episode-id="'. $episode->episode_id .'"><a onclick="playEpisode(event)" data-episode-src="'.$episode->episode_embed.'" href="'.base_url('series/episode/'). $episode->episode_id . '"><span class="ep_num">ep.'. $episodesNum .'</span> <span class="ep_name">'. $episode->episode_name .'</span></a></li>';
                }
            }
            else
            {
                $result .= '<li><p>Comming soon</p></li>';
            }
            echo json_encode($result);
        }
    }

    public function filterSeries()
    {
        $genres = htmlentities($this->input->post('genres'));
       $years = htmlentities($this->input->post('years'));
       $order = htmlentities($this->input->post('order'));
       

       // Pagination
       $config['base_url'] = base_url('#');
       $config['total_rows'] = $this->serie_model->countFilteredSeries($genres, $years, $order);
       $config['per_page'] = 24; 
       $config ['num_links'] = 2;
       $config['use_page_numbers'] = TRUE;
       $config['uri_segment'] = 3;

       // Customizing the pagination 
       $config['first_link'] = false; 
       $config['last_link']  = false;
       $config ['prev_link'] = '<i class="far fa-angle-left"></i>';
       $config ['next_link'] = '<i class="far fa-angle-right"></i>';
       $config['prev_tag_open'] = '<li class="pagination_item prev">';
       $config['prev_tag_close'] = '</li>';
       $config['next_tag_open'] = '<li class="pagination_item next">';
       $config['next_tag_close'] = '</li>';
       $config['num_tag_open'] = '<li class="pagination_item">';
       $config['num_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="pagination_item active">';
       $config['cur_tag_close'] = '</li>';
       $config['full_tag_open']  = '<ul class="pagination">';
       $config['full_tag_close'] = '</ul>';
       $page = $this->uri->segment(3);
       $start = ($page - 1) * $config['per_page'];
       $this->pagination->initialize($config);
       $filteredSeries = $this->serie_model->getFilterdSeries($genres, $years, $order, $start, $config['per_page']);
	   $filteredSeriesGenres =$this->serie_model->getSerieGenre();


       $result = '';

       if($filteredSeries)
       {
            foreach($filteredSeries as $serie)
            {
                $result .= '
                <div class="section_movie animate__animated animate__fadeIn">
                <a href="'. base_url("series/serie/") . $serie->serie_id .'" class="section_movie_poster">
                    <img src="'. $serie->serie_poster .'" />
                </a>
                <a href="'. base_url("series/serie/") . $serie->serie_id .'" class="section_movie_title">'. $serie->serie_name .'</a>
                <ul class="genre">';
                foreach($filteredSeriesGenres as $genre)
                {
                    if($genre->serie_id === $serie->serie_id)
                    {
                        $result .= '<li><a href="'. base_url("home/genre/") . $genre->genre_id .'">'. $genre->genre_name .'</a></li>';
                    }
                }
                $result .= '</ul>
                </div>
                ';
            }
       }
       else
       {
            $result .= '<p>Not found!</p>';
       }
        

       $data = ['result' => $result, 'pagination' => $this->pagination->create_links()];

       echo json_encode($data);
    }

}