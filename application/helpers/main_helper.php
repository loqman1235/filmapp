<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if( !function_exists('strShortner'))
{
    function strShortner($str, $amount)
    {
        return (strlen($str) > $amount) ? substr($str, 0, $amount) : $str;
    }
}

if ( ! function_exists('setActiveClass'))
{
    function setActiveClass($linkName)
    {
        $lastUrlLink = (explode('/', $_SERVER['REQUEST_URI'])[count(explode('/', $_SERVER['REQUEST_URI']))- 1] === '') ? 'home' : explode('/', $_SERVER['REQUEST_URI'])[count(explode('/', $_SERVER['REQUEST_URI']))- 1]; 

        return ($lastUrlLink === $linkName) ? 'active' : '';
    }   
}

if ( ! function_exists('displaySectionSlider'))
{
    function displaySectionSlider($sectionId, $sliderId, $title, $medias)
    {   
        $output = '';
        
        if($medias)
        {
            $output .= '<section class="section homeSection" id="'. $sectionId .'">';
            $output .= '<div class="section_header">
                            <h3><strong>'. ucfirst($title) .'</strong></h3>
                        </div>';
            
            $output .= '<div class="section_body swiper" id="'. $sliderId .'">';
            $output .= '<div class="swiper-wrapper">';
            foreach($medias as $media)
            {
                $output .= '<div class="section_movie swiper-slide" data-media-id="'. $media->media_id .'" data-media-type="'. $media->media_type .'">';
                
                $output .= '<div class="section_movie_poster" data-poster="'. $media->media_poster .'">
                                 <img src="'. $media->media_poster .'" alt="'. $media->media_name .'">
                                 <div class="movie_poster_overlay">
                                    '. (($media->media_type === 'movie') ? '<a class="play_btn" href="'. base_url('movies/movie/') . $media->media_id .'"><i class="fas fa-play"></i></a>' : '<a class="play_btn" href="'. base_url('series/serie/') . $media->media_id .'"><i class="fas fa-play"></i></a>') .'
                                    '. ((isset($_SESSION['is_logged_in'])) ? '<button data-add="true" data-id="'. $media->media_id .'" class="btn btn_outline addToListBtn watchlistBtn">Add to my list</button>' : '') .'
                                 </div>
                            </div>';
                if(strlen($media->media_name) >= 24) {
                    $output .= '<a data-media-name="'. $media->media_name .'" href="'. (($media->media_type === 'movie') ? base_url('movies/movie/') . $media->media_id : base_url('series/serie/') . $media->media_id) .'" class="section_movie_title">'. strShortner($media->media_name, 24) .'...</a>';
                } else {
                    $output .= '<a data-media-name="'. $media->media_name .'" href="'. (($media->media_type === 'movie') ? base_url('movies/movie/') . $media->media_id : base_url('series/serie/') . $media->media_id) .'" class="section_movie_title">'. $media->media_name .'</a>';
                }
                
                $output .= '<div class="section_movie_data">
                        <div class="section_movie_info">
                            <p data-media-year="'. $media->media_year .'" class="section_movie_year">'. $media->media_year .'</p>';
                            if($media->media_type === 'movie') {
                                $output .= '<div class="separator"></div>
                                <p data-media-runtime="'. $media->media_runtime .'" class="section_movie_runtime">'. $media->media_runtime .'</p>';
                            }                            
                       $output .= '</div>
                        <div data-media-age-rating="'. $media->media_age_rating .'" class="section_movie_type">'. ((empty($media->media_age_rating )) ? 'NA' : $media->media_age_rating ).'</div>';
                    $output .= '</div>';
                    $output .= '</div>';
            }
            $output .= '</div>';
            $output .= '<div class="movies_prev_btn">
                            <i class="far fa-angle-left"></i>
                        </div>
                        <div class="movies_next_btn">
                            <i class="far fa-angle-right"></i>
                        </div>';
            $output .= '</div>';
            $output .= '</section>';
        }

        return $output;
    }   
}
