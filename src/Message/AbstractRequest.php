<?php
/**
 * Stripe Abstract Request
 */

namespace Omnipay\Stripe\Message;

/**
 * Stripe Abstract Request
 *
 * This is the parent class for all Stripe requests.
 *
 * Test modes:
 *
 * Stripe accounts have test-mode API keys as well as live-mode
 * API keys. These keys can be active at the same time. Data
 * created with test-mode credentials will never hit the credit
 * card networks and will never cost anyone money.
 *
 * Unlike some gateways, there is no test mode endpoint separate
 * to the live mode endpoint, the Stripe API endpoint is the same
 * for test and for live.
 *
 * Setting the testMode flag on this gateway has no effect.  To
 * use test mode just use your test mode API key.
 *
 * You can use any of the cards listed at https://stripe.com/docs/testing
 * for testing.
 *
 * @see \Omnipay\Stripe\Gateway
 * @link https://stripe.com/docs/api
 * @method \Omnipay\Stripe\Message\Response send()
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * Live or Test Endpoint URL
     *
     * @var string URL
     */
    protected $liveEndpoint = 'https://komoju.com';
    protected $testEndpoint = 'https://sandbox.komoju.com';

    /**
     * Get the gateway API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set the gateway API Key
     *
     * @return AbstractRequest provides a fluent interface.
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getMetadata()
    {
        return $this->getParameter('metadata');
    }

    public function setMetadata($value)
    {
        return $this->setParameter('metadata', $value);
    }

    abstract public function getEndpoint();

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            null,
            $data
        );
        $httpResponse = $httpRequest
            ->setHeader('Authorization', 'Basic '.base64_encode($this->getApiKey().':'))
            ->send();

        return $this->response = new Response($this, $httpResponse->json());
    }

    /**
     * @return mixed
     */
    public function getPaymentDetails()
    {
        return $this->getParameter('payment_details');
    }

    /**
     * @param $value
     * @return AbstractRequest provides a fluent interface.
     */
    public function setPaymentDetails($value)
    {
        return $this->setParameter('payment_details', $value);
    }
}
