<?php

namespace Exbil\LexOffice\DownPaymentInvoice;

use Exbil\LexOffice\BaseClient;
use Exbil\LexOffice\Exceptions\BadMethodCallException;
use Exbil\LexOffice\Exceptions\CacheException;
use Exbil\LexOffice\Exceptions\LexOfficeApiException;
use Exbil\LexOffice\Traits\DocumentClientTrait;
use Exbil\LexOffice\Voucherlist\Voucherlist as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class DownPaymentInvoice extends BaseClient
{
    use DocumentClientTrait;

    protected string $resource = 'down-payment-invoices';

    /**
     * @param array $data
     * @throws BadMethodCallException
     */
    public function create(array $data)
    {
        throw new BadMethodCallException('method create is not defined for ' . $this->resource);
    }


    /**
     * @param string $id
     * @param array $data
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data)
    {
        throw new BadMethodCallException('method update is not defined for ' . $this->resource);
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
        $client->types = ['downpaymentinvoice'];

        return $client->getAll();
    }
}
