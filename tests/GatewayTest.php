<?php

namespace Omnipay\Komoju;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var \Omnipay\Komoju\Gateway
     */
    protected $gateway;

    /**
     * Set up the GatewayTest sandbox.
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * This tests the gateway's ability to generate a proper request.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function testPurchase()
    {
        $timestamp = time();

        $request = $this->gateway->purchase(array(
            'amount' => '10.00',
            'cancel_url' => 'http://www.google.com',
            'return_url' => 'http://www.yahoo.com',
            'currency' => 'USD',
            'tax' => '0',
            'transactionReference' => '1',
            'timestamp' => $timestamp
        ));

        $this->assertInstanceOf('\Omnipay\Komoju\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('http://www.google.com', $request->getCancelUrl());
        $this->assertSame('http://www.yahoo.com', $request->getReturnUrl());
        $this->assertSame('USD', $request->getCurrency());
        $this->assertSame('0', $request->getTax());
        $this->assertSame('1', $request->getTransactionReference());
        $this->assertSame($timestamp, $request->getTimestamp());
    }
}