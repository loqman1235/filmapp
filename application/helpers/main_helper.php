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
                if($media->media_type === 'movie')
                {
                    $output .= '<a href="'. base_url('movies/movie/') . $media->media_id .'" class="section_movie swiper-slide">';
                }
                else 
                {
                    $output .= '<a href="'. base_url('series/serie/') . $media->media_id .'" class="section_movie swiper-slide">';
                }
                
                $output .= '<div class="section_movie_poster">
                  <img src="'. $media->media_poster .'" alt="'. $media->media_name .'">
                    </div>';
                $output .= '</a>';
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
