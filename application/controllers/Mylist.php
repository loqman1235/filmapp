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
        $this->load->view('frontend/inc/footerElement_view');
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

            if(!empty($this->input->post('movieId')) && !empty($this->input->post('movieName')) && !empty($this->input->post('movieBackdrop')) && !empty($this->input->post('moviePlot')) && !empty($this->input->post('moviePoster')) && !empty($this->input->post('moviePosterLarge')))
            {


            if(!$this->movie_model->watchListMovieExist($this->input->post('movieId'), $this->input->post('watchlistItemType')))
            {
                    $insertToWatchListData = 

                    [
                        'watchlist_movieId'          => $this->input->post('movieId'),
                        'watchlist_movieName'        => $this->input->post('movieName'),
                        'watchlist_movieBackdrop'    => $this->input->post('movieBackdrop'),
                        'watchlist_moviePoster'      => $this->input->post('moviePoster'),
                        'watchlist_moviePosterLarge' => $this->input->post('moviePosterLarge'),
                        'watchlist_moviePlot'        => $this->input->post('moviePlot'),
                        'watchlist_movieYear'        => $this->input->post('movieYear'),
                        'watchlist_movieRuntime'     => $this->input->post('movieRuntime'),
                        'watchlist_movieAgeRating'   => $this->input->post('movieAgeRating'),
                        'watchlist_movieImdbRating'  => $this->input->post('movieImdbRating'),
                        'watchlist_type'             => $this->input->post('watchlistItemType'),
                        'user_id'                    => $this->session->userdata('userId')

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

                if($this->movie_model->removeMovieFromWatchlist($movieId, $movieName))
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
            $this->load->model('serie_model');
            $result = '';
            $watchlistMovies = $this->movie_model->getWatchlistMoviesByUserId();
            $moviesGenres = $this->movie_model->getMovieGenre();
            $seriesGenres = $this->serie_model->getSerieGenre();
            $countListItems = $this->movie_model->countWatchlistMoviesByUserId();

            if($watchlistMovies)
            {
                $result .= '<div class="section_body genre_section">';
                foreach($watchlistMovies as $watchlistMovie)
                {
                    $result .= '<div class="section_movie animate__animated animate__fadeIn">';
                    if($watchlistMovie->watchlist_type === 'movie') {

                        $result .= '<a href="'. base_url('movies/movie/') . $watchlistMovie->watchlist_movieId .'" class="section_movie_poster">';
                    }
                    else 
                    {
                        $result .= '<a href="'. base_url('series/serie/') . $watchlistMovie->watchlist_movieId .'" class="section_movie_poster">';
                    }
                    $result .= '<img
                    src="'.$watchlistMovie->watchlist_moviePoster.'"
                    alt=""
                    />';
                    $result .= '<button title="remove from your watchlist" data-name="'.$watchlistMovie->watchlist_movieName.'" data-id="'.$watchlistMovie->watchlist_movieId.'" onclick="removeMovieFromWatchlist(event)" class="removeFromMyWatchlistBtn"><i class="far fa-minus"></i></button>';
                    $result .= '</a>';
                    $result .= ($watchlistMovie->watchlist_type === 'movie') ? '<a href="'.base_url('movies/movie/') . $watchlistMovie->watchlist_movieId.'" class="section_movie_title">'. strShortner($watchlistMovie->watchlist_movieName, 24) .'</a>' : '<a href="'.base_url('series/serie/') . $watchlistMovie->watchlist_movieId.'" class="section_movie_title">'. strShortner($watchlistMovie->watchlist_movieName, 24).'</a>';
                    
                    $result .= '<div class="section_movie_data">
                    <div class="section_movie_info">
                        <p class="section_movie_year">'. $watchlistMovie->watchlist_movieYear .'</p>';
                       
                       if($watchlistMovie->watchlist_type === 'movie') {
                            $result .= '<div class="separator"></div>
                            <p class="section_movie_year">'. $watchlistMovie->watchlist_movieRuntime .'</p>';
                       }
                       
                        $result .= '</div>';

                        if(empty($watchlistMovie->watchlist_movieAgeRating)) {
                            $result .= '<div class="section_movie_type">NA</div>';
                        } else {
                            $result .= '<div class="section_movie_type">'. ($watchlistMovie->watchlist_movieAgeRating) .'</div>';
                        }
                       
                        
                    $result .= '</div>';

                    $result .= '</div>';

                }

                $result .= '</div>';
            }
            else
            {
                $result .= '<p>Your list is empty</p>';
            }


            echo json_encode(['result' => $result, 'listCounter' => $countListItems]);
        }
        else
        {
            redirect(base_url('home'));
        }

    }


    public function addMediaToWatchlist()
    {
        
        if($this->session->userdata('is_logged_in'))
       {
            $response = [];
            if(!empty($this->input->post('mediaId')))
            {
                if(!$this->movie_model->watchListMovieExist($this->input->post('mediaId'), $this->input->post('mediaType')))
                {
                    $watchlistData = 

                        [
                            'watchlist_movieId'          => $this->input->post('mediaId'),
                            'watchlist_movieName'        => $this->input->post('mediaName'),
                            'watchlist_moviePoster'      => $this->input->post('mediaPoster'),
                            'watchlist_movieYear'        => $this->input->post('mediaYear'),
                            'watchlist_movieRuntime'     => $this->input->post('mediaRuntime'),
                            'watchlist_movieAgeRating'   => $this->input->post('mediaAgeRating'),
                            'watchlist_type'             => $this->input->post('mediaType'),
                            'user_id'                    => $this->session->userdata('userId')

                        ];

                        if($this->movie_model->insertWatchlist($watchlistData))
                        {
                            $response['success'] = true;
                            $response['message'] = 'Item has been added to your list';
                        }
                }
                else
                {
                    $response['error'] = true;
                    $response['message'] = 'Item already added';
                }

            }
        }
        else
        {
            $response['error'] = true;
            $response['message'] = 'Login to use this feature';
            
        }
        echo json_encode($response);
    }


    public function mediaExistInWatchlist()
    {
        if($this->movie_model->watchListMovieExist($this->input->post('mediaId'), $this->input->post('mediaType')))
        {
            $result = true;
        }
        else 
        {
            $result = false;
        }

        echo json_encode($result);
    }


    public function removeMediaFromList()
    {
        if($this->input->post('mediaId') !== null) {
            
            if($this->movie_model->removeMovieFromWatchlist($this->input->post('mediaId'), $this->input->post('mediaName')))
            {
                $response['success'] = true;
            }
        }

        echo json_encode($response);
    }


}