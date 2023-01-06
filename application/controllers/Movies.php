<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Movies extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('movie_model');
    }

    public function index()
    {
        $data['page_title'] = 'Movies';
        $data['movies'] = $this->movie_model->getMovies();
		$data['genres'] = $this->movie_model->getMovieGenre();


        $this->load->view('frontend/inc/header_view', $data);
        $this->load->view('frontend/inc/navbar_view');
        $this->load->view('frontend/movies_view', $data);
		$this->load->view('frontend/inc/footerElement_view');
        $this->load->view('frontend/inc/footer_view');

    }

}