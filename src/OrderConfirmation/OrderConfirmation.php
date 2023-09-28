<?php

namespace Exbil\LexOffice\OrderConfirmation;

use Exbil\LexOffice\BaseClient;
use Exbil\LexOffice\Exceptions\CacheException;
use Exbil\LexOffice\Exceptions\LexOfficeApiException;
use Exbil\LexOffice\Traits\DocumentClientTrait;
use Exbil\LexOffice\Voucherlist\Voucherlist as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class OrderConfirmation extends BaseClient
{
    use DocumentClientTrait;

    protected string $resource = 'order-confirmations';

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll()
    {
        $client = new VoucherlistClient($this->api);

        $client->setToEverything();
        $client->types = ['orderconfirmation'];

        return $client->getAll();
    }
}
