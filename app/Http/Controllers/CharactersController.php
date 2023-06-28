<?php

namespace App\Http\Controllers;

use App\Services\CharactersService;
use App\Http\Requests\Character\FetchRequest;
use App\Responses\CharacterResponse;

class CharactersController extends Controller
{
    private $_characterService;

    public function __construct()
    {
        $this->_characterService = new CharactersService();
    }
    /**
     * Display a listing of the character by specifications.
     */
    public function index(FetchRequest $request)
    {
        $payload = $this->_cleanRequest($request->validated());
        $dataOut = $this->_characterService->sendOutData(collect($payload));
        return new CharacterResponse($dataOut, '200');
    }

    /**
     * Raw characters from third party
     */
    public function rawData()
    {
        return new CharacterResponse($this->_characterService->sendOutRawData(), '200');
    }

    /**
     * Data formatted by internal standard format
     */
    public function cleanData()
    {
        return new CharacterResponse($this->_characterService->sendOutFormattedData(), '200');
    }

    /**
     * Format the request for internal use
     */
    private function _cleanRequest($data)
    {
        return [
            'gender' => $data['gender'],
            'sort_direction' => $data['sortDirection'],
            'sort' => $data['sort'],
        ];
    }
}
