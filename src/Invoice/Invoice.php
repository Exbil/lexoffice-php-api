<?php

namespace Exbil\LexOffice\Invoice;

use Exbil\LexOffice\BaseClient;
use Exbil\LexOffice\Exceptions\CacheException;
use Exbil\LexOffice\Exceptions\LexOfficeApiException;
use Exbil\LexOffice\Traits\DocumentClientTrait;
use Exbil\LexOffice\Voucherlist\Voucherlist as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class Invoice extends BaseClient
{
    use DocumentClientTrait;

    protected string $resource = 'invoices';

    /**
     * @param array $data
     * @param bool $finalized
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function create(array $data, $finalized = false)
    {
        $oldResource = $this->resource;

        $this->resource .= $finalized ? '?finalize=true' : '';
        $response = parent::create($data);
        $this->resource = $oldResource;

        return $response;
    }


    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll()
    {
        $client = new VoucherlistClient($this->api);

        $client->setToEverything();
        $client->types = ['invoice'];

        return $client->getAll();
    }
}
