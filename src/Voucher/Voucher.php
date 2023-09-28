<?php

namespace Exbil\LexOffice\Voucher;

use Exbil\LexOffice\BaseClient;
use Exbil\LexOffice\Exceptions\CacheException;
use Exbil\LexOffice\Exceptions\LexOfficeApiException;
use Exbil\LexOffice\Voucherlist\Voucherlist as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class Voucher extends BaseClient
{
    protected string $resource = 'vouchers';

    /**
     * @param string $id
     * @param array $data
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function update(string $id, array $data)
    {
        $api = $this->api->newRequest('PUT', $this->resource . '/' . $id);

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll()
    {
        $client = new VoucherlistClient($this->api);

        /**
         * @link https://developers.lexoffice.io/docs/#vouchers-endpoint-purpose
         */
        $client->statuses = ['open', 'paid', 'paidoff', 'voided', 'transferred', 'sepadebit'];
        $client->types = ['salesinvoice', 'salescreditnote', 'purchaseinvoice', 'purchasecreditnote'];

        return $client->getAll();
    }
}
