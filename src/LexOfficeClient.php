<?php

namespace Exbil\LexOffice;

use Exbil\LexOffice\Contact\Contact as ContactClient;
use Exbil\LexOffice\Country\Country as CountryClient;
use Exbil\LexOffice\CreditNote\CreditNote as CreditNoteClient;
use Exbil\LexOffice\DownPaymentInvoice\DownPaymentInvoice as DownPaymentInvoiceClient;
use Exbil\LexOffice\Event\Event as EventClient;
use Exbil\LexOffice\File\File as FileClient;
use Exbil\LexOffice\Invoice\Invoice as InvoiceClient;
use Exbil\LexOffice\OrderConfirmation\OrderConfirmation;
use Exbil\LexOffice\OrderConfirmation\OrderConfirmation as OrderConfirmationClient;
use Exbil\LexOffice\Payment\Payment as PaymentClient;
use Exbil\LexOffice\PaymentCondition\PaymentCondition as PaymentConditionClient;
use Exbil\LexOffice\PostingCategory\PostingCategory;
use Exbil\LexOffice\Profile\Profile as ProfileClient;
use Exbil\LexOffice\PostingCategory\PostingCategory as PostingCategoryClient;
use Exbil\LexOffice\Quotation\Quotation as QuotationClient;
use Exbil\LexOffice\Traits\CacheResponseTrait;
use Exbil\LexOffice\RecurringTemplate\RecurringTemplate as RecurringTemplateClient;
use Exbil\LexOffice\Voucher\Voucher as VoucherClient;
use Exbil\LexOffice\Voucherlist\Voucherlist as VoucherlistClient;
use Exbil\LexOffice\Exceptions\LexOfficeApiException;
use Exbil\LexOffice\Exceptions\CacheException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LexOfficeClient
{
    use CacheResponseTrait;

    /**
     * the library version
     */
    public const VERSION = "0.14.1";

    /**
     * the lex-office api url
     *
     * @var string $apiUrl
     */
    public string $apiUrl = 'https://api.lexoffice.io';

    /**
     * the lex-office api version
     *
     * @var string $apiVersion
     */
    protected string $apiVersion = 'v1';

    /**
     * the lex-office api key
     *
     * @var string $apiKey
     */
    protected string $apiKey;

    /**
     * @var Client $client
     */
    protected Client $client;

    /**
     * @var Request|null $request
     */
    public ?Request $request = null;

    /**
     * LexOffice constructor.
     * @param string $apiKey
     * @param Client|null $client
     */
    public function __construct(string $apiKey, Client $client = null)
    {
        if (is_null($client)) {
            $client = new Client();
        }

        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * @param $method
     * @param $resource
     * @param array $headers
     * @return $this
     */
    public function newRequest($method, $resource, $headers = []): self
    {
        $this->setRequest(
            new Request($method, $this->createApiUrl($resource), $headers)
        );

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return $this
     */
    public function setRequest(RequestInterface $request)
    {
        $request = $request
            ->withHeader('Authorization', 'Bearer ' . $this->apiKey)
            ->withHeader('Accept', 'application/json');


        if (!$request->hasHeader('Content-Type') && in_array($request->getMethod(), ['POST', 'PUT'])) {
            $request = $request->withHeader('Content-Type', 'application/json');
        }

        $this->request = $request;

        return $this;
    }

    /**
     * @param string $resource
     * @return string
     */
    protected function createApiUrl(string $resource): string
    {
        return $this->apiUrl . '/' . $this->apiVersion . '/' . $resource;
    }

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getResponse()
    {
        $cache = null;
        if ($this->cacheInterface) {
            $response = $cache = $this->getCacheResponse($this->request);
        }

        // when no cacheInterface is set or the cache is invalid
        if (!isset($response) || !$response) {
            try {
                $response = $this->client->send($this->request);
            } catch (GuzzleException $exception) {
                throw new LexOfficeApiException(
                    $exception->getMessage(),
                    $exception->getCode(),
                    $exception
                );
            }
        }

        // set cache response when cache is invalid
        if ($this->cacheInterface && !$cache) {
            $this->setCacheResponse($this->request, $response);
        }

        return $response;
    }

    /**
     * @return ContactClient
     */
    public function contact(): ContactClient
    {
        return new ContactClient($this);
    }

    /**
     * @return CountryClient
     */
    public function country(): CountryClient
    {
        return new CountryClient($this);
    }

    /**
     * @return EventClient
     */
    public function event(): EventClient
    {
        return new EventClient($this);
    }

    /**
     * @return InvoiceClient
     */
    public function invoice(): InvoiceClient
    {
        return new InvoiceClient($this);
    }

    /**
     * @return DownPaymentInvoiceClient
     */
    public function downPaymentInvoice(): DownPaymentInvoiceClient
    {
        return new DownPaymentInvoiceClient($this);
    }

    /**
     * @return OrderConfirmationClient
     */
    public function orderConfirmation(): OrderConfirmationClient
    {
        return new OrderConfirmationClient($this);
    }

    /**
     * @return PaymentClient
     */
    public function payment(): PaymentClient
    {
        return new PaymentClient($this);
    }

    /**
     * @return PaymentConditionClient
     */
    public function paymentCondition(): PaymentConditionClient
    {
        return new PaymentConditionClient($this);
    }

    /**
     * @return CreditNoteClient
     */
    public function creditNote(): CreditNoteClient
    {
        return new CreditNoteClient($this);
    }

    /**
     * @return QuotationClient
     */
    public function quotation(): QuotationClient
    {
        return new QuotationClient($this);
    }

    /**
     * @return VoucherClient
     */
    public function voucher(): VoucherClient
    {
        return new VoucherClient($this);
    }

    /**
     * @return RecurringTemplateClient
     */
    public function recurringTemplate(): RecurringTemplateClient
    {
        return new RecurringTemplateClient($this);
    }

    /**
     * @return VoucherlistClient
     */
    public function voucherlist(): VoucherlistClient
    {
        return new VoucherlistClient($this);
    }

    /**
     * @return ProfileClient
     */
    public function profile(): ProfileClient
    {
        return new ProfileClient($this);
    }

    /**
     * @return PostingCategoryClient
     */
    public function postingCategory(): PostingCategoryClient
    {
        return new PostingCategoryClient($this);
    }

    /**
     * @return FileClient
     */
    public function file(): FileClient
    {
        return new FileClient($this);
    }
}
