<?php

namespace Exbil\LexOffice\Payment;

use Exbil\LexOffice\BaseClient;
use Exbil\LexOffice\Exceptions\BadMethodCallException;
use Exbil\LexOffice\Exceptions\CacheException;
use Exbil\LexOffice\Exceptions\LexOfficeApiException;
use Exbil\LexOffice\Traits\DocumentClientTrait;
use Exbil\LexOffice\Voucherlist\Voucherlist as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class Payment extends BaseClient
{
    protected string $resource = 'payments';

    /***
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
     * @throws BadMethodCallException
     */
    public function getAll()
    {
        throw new BadMethodCallException('method getAll is not defined for ' . $this->resource);
    }
}
