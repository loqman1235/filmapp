<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Mylist extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('movie_model');
    }


    public function index()
    {
      if($this->session->userdata('is_logged_in'))
      {
        $data['page_title'] = 'My list';
        $data['listMovies'] = $this->movie_model->getWatchlistMoviesByUserId();
        $data['countListMovies'] = $this->movie_model->countWatchlistMoviesByUserId();
		$data['genres'] = $this->movie_model->getMovieGenre();

        $this->load->view('frontend/inc/header_view', $data);
        $this->load->view('frontend/inc/navbar_view');
        $this->load->view('frontend/mylist_view', $data);
        $this->load->view('frontend/inc/footer_view');
      }
      else
      {
        redirect(base_url('home'));
      }
    }


    // Add a movie to watchlist
    public function addToWatchList()
    {

       if($this->session->userdata('is_logged_in'))
       {

            if(!empty($this->input->post('movieId')) && !empty($this->input->post('movieName')) && !empty($this->input->post('movieBackdrop')) && !empty($this->input->post('moviePlot')) && !empty($this->input->post('moviePoster')))
            {


            if(!$this->movie_model->watchListMovieExist($this->input->post('movieId')))
            {
                    $insertToWatchListData = 

                    [
                        'watchlist_movieId'        => $this->input->post('movieId'),
                        'watchlist_movieName'      => $this->input->post('movieName'),
                        'watchlist_movieBackdrop'  => $this->input->post('movieBackdrop'),
                        'watchlist_moviePoster'    => $this->input->post('moviePoster'),
                        'watchlist_moviePlot'      => $this->input->post('moviePlot'),
                        'watchlist_type'           => $this->input->post('watchlistItemType'),
                        'user_id'                  => $this->session->userdata('userId')

                    ];


                    if($this->movie_model->insertWatchlist($insertToWatchListData))
                    {
                        $response = 
                        [
                            'success'   => true, 
                            'msg'       => $this->input->post('movieName') . ' has been added to your list'
                        ];
                    }

            }
            else 
            {
                    $response = 
                    [
                        'error'   => true, 
                        'msg'       => 'Movie already added to your list'
                    ];
            }

                echo json_encode($response);

            }
       }
       else
       {
        redirect(base_url('home'));
       }
        
    }

    public function removeFromWatchList()
    {
        if($this->session->userdata('is_logged_in'))
        {
            if(!empty($this->input->post('movieId')) && !empty($this->input->post('movieName')))
            {

                $movieId = $this->input->post('movieId');
                $movieName = $this->input->post('movieName');

                if($this->movie_model->removeMovieFromWatchlist($movieId))
                {
                    $response = ["success" => true, 'msg' => $movieName . ' deleted from your list'];
                }
        
            }


            echo json_encode($response);
        }
        else
        {
            redirect(base_url('home'));
        }
    }


    public function getWatchlist() 
    {
        if($this->session->userdata('is_logged_in'))
        {
            $result = '';
            $watchlistMovies = $this->movie_model->getWatchlistMoviesByUserId();
            $genres = $this->movie_model->getMovieGenre();

            if($watchlistMovies)
            {
                $result .= '<div class="section_body genre_section">';
                foreach($watchlistMovies as $watchlistMovie)
                {
                    $result .= '<div class="section_movie">';
                    $result .= '<div class="section_movie_poster">';
                    $result .= '<img
                    src="'.$watchlistMovie->watchlist_moviePoster.'"
                    alt=""
                    />';
                    $result .= '<button title="remove from your watchlist" data-name="'.$watchlistMovie->watchlist_movieName.'" data-id="'.$watchlistMovie->watchlist_movieId.'" onclick="removeMovieFromWatchlist(event)" class="removeFromMyWatchlistBtn"><i class="far fa-minus"></i></button>';
                    $result .= ($watchlistMovie->watchlist_type === 'movie') ? '<div class="type">Movie</div>' : '<div class="type">Serie</div>';
                    $result .= '</div>';
                    $result .= ($watchlistMovie->watchlist_type === 'movie') ? '<a href="'.base_url('home/movie/') . $watchlistMovie->watchlist_movieId.'" class="section_movie_title">'. $watchlistMovie->watchlist_movieName .'</a>' : '<a href="'.base_url('series/serie/') . $watchlistMovie->watchlist_movieId.'" class="section_movie_title">'. $watchlistMovie->watchlist_movieName .'</a>';
                    $result .= '<ul class="genre">';
                    foreach($genres as $genre)
                    {
                        if($genre->movie_id === $watchlistMovie->watchlist_movieId)
                        {
                            $result .= ' <li><a href="'. base_url('home/genre/') . $genre->genre_id .'">'. $genre->genre_name  .'</a></li>';
                        }
                    }
                    $result .= '</ul>';
                    $result .= '</div>';

                }

                $result .= '</div>';
            }
            else
            {
                $result .= '<p>You didn\'t add any movie yet</p>';
            }


            echo json_encode($result);
        }
        else
        {
            redirect(base_url('home'));
        }

    }


}