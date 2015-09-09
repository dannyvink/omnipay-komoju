<?php
/**
 * Komoju Gateway
 */

namespace Omnipay\Komoju;

use Omnipay\Common\AbstractGateway;

/**
 * Komoju Gateway
 *
 * @see \Omnipay\Common\AbstractGateway
 * @see \Omnipay\Komoju\Message\AbstractRequest
 * @link https://docs.komoju.com/
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Komoju';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
            'testMode' => false,
        );
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Komoju\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Komoju\Message\RefundRequest', $parameters);
    }

    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Komoju\Message\FetchTransactionRequest', $parameters);
    }

    public function fetchToken(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Komoju\Message\FetchTokenRequest', $parameters);
    }
}