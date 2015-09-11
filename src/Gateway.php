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
            'accountId' => '',
            'paymentMethod' => 'credit_card',
            'testMode' => false,
            'locale' => 'en'
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

    public function getTax()
    {
        return $this->getParameter('tax');
    }

    public function setTax($value)
    {
        return $this->setParameter('tax', $value);
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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Komoju\Message\PurchaseRequest', $parameters);
    }

    /*
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
    */
}
