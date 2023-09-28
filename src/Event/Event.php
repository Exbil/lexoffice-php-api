<?php


namespace Exbil\LexOffice\Event;

use Exbil\LexOffice\BaseClient;
use Exbil\LexOffice\Exceptions\BadMethodCallException;
use Exbil\LexOffice\Exceptions\CacheException;
use Exbil\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Event extends BaseClient
{
    protected string $resource = 'event-subscriptions';

    public function get(string $id)
    {
        throw new BadMethodCallException('method get() is not supported');
    }

    /**
     * @param string $id
     * @param array $data
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data)
    {
        throw new BadMethodCallException('method update() is not implemented yet');
    }

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll()
    {
        return $this->api->newRequest('GET', 'event-subscriptions')
            ->getResponse();
    }

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function delete(string $id)
    {
        return $this->api->newRequest('DELETE', 'event-subscriptions/' . $id)
            ->getResponse();
    }
}
