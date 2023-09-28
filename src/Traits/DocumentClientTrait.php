<?php

namespace Exbil\LexOffice\Traits;

use Exbil\LexOffice\Exceptions\CacheException;
use Exbil\LexOffice\Exceptions\LexOfficeApiException;
use Exbil\LexOffice\File\File as FileClient;
use Psr\Http\Message\ResponseInterface;

trait DocumentClientTrait
{
    /**
     * @param string $id
     * @param bool $asContent
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function document(string $id, bool $asContent = false)
    {
        $response = $this->api->newRequest('GET', $this->resource . '/' . $id . '/document')
            ->getResponse();

        if ($asContent === false) {
            return $response;
        }

        $content = $this->getAsJson($response);
        $fileClient = new FileClient($this->api);

        return $fileClient->get($content->documentFileId);
    }
}