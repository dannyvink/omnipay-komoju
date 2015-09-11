<?php
/**
 * Komoju Abstract Request
 */

namespace Omnipay\Komoju\Message;

/**
 * Komoju Abstract Request
 *
 * @see  \Omnipay\Komoju\Gateway
 * @link https://docs.komoju.com
 * @method \Omnipay\Komoju\Message\Response send()
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * The live API endpoint.
     *
     * @var string
     */
    protected $liveUrl = 'https://komoju.com';

    /**
     * The test API endpoint.
     *
     * @var string
     */
    protected $testUrl = 'https://sandbox.komoju.com';

    /**
     * Get the API Key
     *
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set the API Key
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * Get the tax.
     *
     * @return mixed
     */
    public function getTax()
    {
        return $this->getParameter('tax');
    }

    /**
     * Set the tax.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setTax($value)
    {
        return $this->setParameter('tax', $value);
    }

    /**
     * Get the account ID.
     *
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    /**
     * Set the account ID.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    /**
     * Get the payment method.
     *
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    /**
     * Set the payment method.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    /**
     * Get the locale.
     *
     * @return mixed
     */
    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    /**
     * Set the locale.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Get the timestamp.
     *
     * @return mixed
     */
    public function getTimestamp()
    {
        $timestamp = $this->getParameter('timestamp');
        return !empty($timestamp) ? $timestamp : time();
    }

    /**
     * Set the timestamp.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setTimestamp($value)
    {
        return $this->setParameter('timestamp', $value);
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        $endpoint = $this->getEndpoint() . '?' . http_build_query($data, '', '&');
        $hmac = hash_hmac('sha256', $endpoint, $this->getApiKey());
        $url = $this->getBaseUrl() . $endpoint . '&hmac=' . $hmac;
        return $this->response = new PurchaseResponse($this, $data, $url);
    }

    /**
     * Retrieve the appropriate base URL.
     *
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->getTestMode() ? $this->testUrl : $this->liveUrl;
    }

    /**
     * Generate the endpoint based on the current options.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        $locale = $this->getLocale();
        $account = $this->getAccountId();
        $method = $this->getPaymentMethod();
        return '/' . $locale . '/api/' . $account . '/transactions/' . $method . '/new';
    }
}
