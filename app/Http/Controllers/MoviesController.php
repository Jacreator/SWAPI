<?php

namespace App\Http\Controllers;

use App\Services\MoviesService;
use App\Responses\MovieResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class MoviesController extends Controller
{
    private $_movieService;

    public function __construct()
    {
        $this->_movieService = new MoviesService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Cache::remember('movies_cache', 60, function () {
            $movies = $this->_movieService->sendOutData();

            // Convert to a collection if needed
            if (!($movies instanceof Collection)) {
                $movies = collect($movies);
            }
            
            // Update the comment count for each movie
            $movies = $movies->map(function ($movie) {
                $movie['comment_count'] = $this->_movieService->fetchCommentCount($movie['title']);
                return $movie;
            });

            return $movies;
        });
        return new MovieResponse($movies->toArray(), '200');
    }

    /**
     * Raw characters from third party
     */
    public function rawData()
    {
        return new MovieResponse($this->_movieService->sendOutRawData(), '200');
    }

    /**
     * Data formatted by internal standard format
     */
    public function cleanData()
    {
        return new MovieResponse($this->_movieService->sendOutFormattedData(), '200');
    }
}
