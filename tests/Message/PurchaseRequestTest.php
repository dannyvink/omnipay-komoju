<?php

namespace Omnipay\Komoju\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var \Omnipay\Komoju\Message\PurchaseRequest
     */
    protected $request;

    /**
     * Set up the PurchaseRequestTest sandbox.
     */
    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * This test verifies that a redirect URL is generated correctly.
     */
    public function testPurchaseRedirect()
    {
        $timestamp = time();
        $response = $this->initializeRequest()->send();

        $this->assertInstanceOf('Omnipay\Komoju\Message\PurchaseResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertContains('https://sandbox.komoju.com/en/api/myaccountid/transactions/credit_card/new?timestamp=' . $timestamp . '&transaction%5Bamount%5D=1000&transaction%5Bcancel_url%5D=http%3A%2F%2Fwww.google.com&transaction%5Bcurrency%5D=USD&transaction%5Bexternal_order_num%5D=1&transaction%5Breturn_url%5D=http%3A%2F%2Fwww.yahoo.com&transaction%5Btax%5D=0', $response->getRedirectUrl());
    }

    /**
     * Initialize a test request.
     *
     * @param null $timestamp Optionally pass in a timestamp for the transaction.
     * @return $this
     */
    private function initializeRequest($timestamp = null)
    {
        $options = array(
            'amount'               => '10.00',
            'cancel_url'           => 'http://www.google.com',
            'return_url'           => 'http://www.yahoo.com',
            'currency'             => 'USD',
            'tax'                  => '0',
            'transactionReference' => '1',
            'apiKey'               => 'mysecretkey',
            'accountId'            => 'myaccountid',
            'payment_method'       => 'credit_card',
            'locale'               => 'en',
            'testMode'             => true
        );

        if ($timestamp) $options['timestamp'] = $timestamp;

        return $this->request->initialize($options);
    }
}