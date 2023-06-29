<?php

namespace App\Helpers\ThirdParty;

use Exception;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SWAPI {

    private $_httpInstance;
    public function __construct()
    {
        $this->_httpInstance = new Http();
    }

    public function films() {
        try {
            $response = Http::get('https://swapi.dev/api/films');
            return $response['results'];
        } catch (Exception $error) {
            throw new NotFoundHttpException($error->getMessage());
        }
    }

    public function characters() {
        try {
            $response = Http::get('https://swapi.dev/api/people');
            return $response['results'];
        } catch (Exception $error) {
            throw new NotFoundHttpException($error->getMessage());
        };
    }
}