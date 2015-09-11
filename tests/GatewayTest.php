<?php

namespace Omnipay\Komoju;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var \Omnipay\Komoju\Gateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setTestMode(true);
        $this->gateway->setApiKey('mysecretkey');
        $this->gateway->setAccountId('myaccountid');
        $this->gateway->setPaymentMethod('credit_card');
    }

    public function testPurchase()
    {
        $timestamp = time();
        $charge = $this->gateway->purchase([
            'amount' => '10.00',
            'cancel_url' => 'http://www.google.com',
            'return_url' => 'http://www.yahoo.com',
            'currency' => 'USD',
            'tax' => '0',
            'transactionReference' => '1',
            'timestamp' => $timestamp
        ])->send();

        $this->assertInstanceOf('Omnipay\Komoju\Message\PurchaseResponse', $charge);
        $this->assertFalse($charge->isSuccessful());
        $this->assertTrue($charge->isRedirect());
        $this->assertContains('https://sandbox.komoju.com/en/api/myaccountid/transactions/credit_card/new?timestamp=' . $timestamp . '&transaction%5Bamount%5D=1000&transaction%5Bcancel_url%5D=http%3A%2F%2Fwww.google.com&transaction%5Bcurrency%5D=USD&transaction%5Bexternal_order_num%5D=1&transaction%5Breturn_url%5D=http%3A%2F%2Fwww.yahoo.com&transaction%5Btax%5D=0', $charge->getRedirectUrl());
    }
}