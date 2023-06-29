<?php

namespace App\Services;

use App\Helpers\ThirdParty\SWAPI;

class CharactersService extends BaseService
{

    private $_swapiInstance;

    public function __construct()
    {
        $this->_swapiInstance = new SWAPI();
    }

    private function _getDataFromSwapiInstance()
    {
        return $this->_swapiInstance->characters();
    }

    private function _charactersByInternalFormat(): array
    {
        $externalData = $this->_getDataFromSwapiInstance();
        $cleanData = [];
        foreach ($externalData as $dirtyData) {
            $cleanData[] = [
                "name" => $dirtyData['name'],
                "height" => $dirtyData['height'],
                "mass" => $dirtyData['mass'],
                "hair_color" => $dirtyData['hair_color'],
                "skin_color" => $dirtyData['skin_color'],
                "eye_color" => $dirtyData['eye_color'],
                "birth_year" => $dirtyData['birth_year'],
                "gender" => $dirtyData['gender'],
                "created" => $dirtyData['created'],
                "edited" => $dirtyData['edited'],
            ];
        }
        return $cleanData;
    }

    public function sendOutData($payload)
    {
        $gender = $payload->get('gender');
        $sortDirection = $payload->get('sort_direction');
        $sort = $payload->get('sort');
        $preparedData = $this->_charactersByInternalFormat();
        if (!empty($gender)) {
            $preparedData = array_filter($preparedData, function ($character) use ($gender) {
                return strtolower($character['gender']) === strtolower($gender);
            });
        }

        // sort directions
        $preparedData = collect($preparedData)
            ->sortBy($sort, SORT_NATURAL, $sortDirection === 'desc')
            ->values();

        // metadata area
        $totalCharacters = count($preparedData);
        $totalHeightCm = array_sum(array_column($preparedData->toArray(), 'height'));
        $totalHeightInches = $totalHeightCm * 0.3937;
        $totalHeightFeet = floor($totalHeightInches / 12);
        $totalHeightInchesRemaining = round($totalHeightInches - ($totalHeightFeet * 12), 2);

        return [
            'metadata' => [
                'totalCharacters' => $totalCharacters,
                'totalHeightCm' => $totalHeightCm.'cm',
                'totalHeightFeet' => $totalHeightFeet.'ft',
                'totalHeightInches' => $totalHeightInchesRemaining.'inches',
            ],
            'characters' => $preparedData,
        ];
    }

    public function sendOutRawData()
    {
        return $this->_getDataFromSwapiInstance();
    }

    public function sendOutFormattedData()
    {
        return $this->_charactersByInternalFormat();
    }
}
