<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\ThirdParty\SWAPI;
use Illuminate\Support\Facades\DB;

class MoviesService extends BaseService
{

    private $_swapiInstance;

    public function __construct()
    {
        $this->_swapiInstance = new SWAPI();
    }

    private function _getDataFromSwapiInstance()
    {
        return $this->_swapiInstance->films();
    }

    public function sendOutRawData()
    {
        return $this->_getDataFromSwapiInstance();
    }

    public function sendOutFormattedData()
    {
        return $this->_movieByInternalFormat();
    }

    private function _movieByInternalFormat()
    {
        $externalData = $this->_getDataFromSwapiInstance();
        $cleanData = [];
        foreach ($externalData as $dirtyData) {
            $cleanData[] = [
                "title" => $dirtyData['title'],
                "episode_id" => $dirtyData['episode_id'],
                "opening_crawl" => $dirtyData['opening_crawl'],
                "director" => $dirtyData['director'],
                "producer" => $dirtyData['producer'],
                "release_date" => $dirtyData['release_date'],
                "created" => $dirtyData['created'],
                "edited" => $dirtyData['edited'],
            ];
        }
        return $cleanData;
    }

    public function sendOutData()
    {
        $movies = $this->_movieByInternalFormat();
        usort($movies, function ($a, $b) {
            return strtotime($a['release_date']) <=> strtotime($b['release_date']);
        });

        // Iterate over movies and fetch comment count
        foreach ($movies as &$movie) {
            $comments = $this->fetchCommentCount($movie['title']);
            $movie['comment_count'] = $comments->count();
            $movie['comments'] = $comments;
        }

        return $movies;
    }

    public function fetchCommentCount($movieTitleSlug)
    {
        $title = Str::slug($movieTitleSlug, '_');
        $comments = DB::table('comments')
        ->where('movie_slug', $title)
        ->orderBy('created_at', 'desc')
        ->get(['comment', 'ip_address', 'created_at'])
        ->map(function ($comment) {
            // Limit comment length to 500 characters
            $comment->comment = substr($comment->comment, 0, 500);

            // Format UTC date & time
            $comment->created_at = Carbon::parse($comment->created_at)->utc()->format('Y-m-d H:i:s');

            return $comment;
        });
        return $comments;
    }
}
