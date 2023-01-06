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



        $this->load->view('frontend/inc/header_view', $data);
        $this->load->view('frontend/inc/navbar_view');
        $this->load->view('frontend/serie_view', $data);
		$this->load->view('frontend/inc/footerElement_view');
        $this->load->view('frontend/inc/footer_view');
    }

}