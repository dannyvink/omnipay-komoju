<?php
/**
 * Komoju Abstract Request
 */

namespace Omnipay\Komoju\Message;

/**
 * Komoju Abstract Request
 *
 * @see \Omnipay\Komoju\Gateway
 * @link https://docs.komoju.com
 * @method \Omnipay\Komoju\Message\Response send()
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveUrl = 'https://komoju.com';
    protected $testUrl = 'https://sandbox.komoju.com';

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function setTax($value)
    {
        return $this->setParameter('tax', $value);
    }

    public function getTax()
    {
        return $this->getParameter('tax');
    }

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    public function getTimestamp()
    {
        $timestamp = $this->getParameter('timestamp');
        return !empty($timestamp) ? $timestamp : time();
    }

    public function setTimestamp($value)
    {
        return $this->setParameter('timestamp', $value);
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        $endpoint = $this->getEndpoint() . '?' . http_build_query($data, '', '&');
        $hmac = hash_hmac('sha256', $endpoint, $this->getApiKey());
        $url = $this->getBaseUrl() . $endpoint . '&hmac=' . $hmac;
        return $this->response = new PurchaseResponse($this, $data, $url);
    }

    protected function getBaseUrl()
    {
        return $this->getTestMode() ? $this->testUrl : $this->liveUrl;
    }

    protected function getEndpoint()
    {
        return '/' . $this->getLocale() . '/api/' . $this->getAccountId() . '/transactions/' . $this->getPaymentMethod() . '/new';
    }
}
