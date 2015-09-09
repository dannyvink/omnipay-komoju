<?php
/**
 * Komoju Purchase Request
 */

namespace Omnipay\Komoju\Message;

/**
 * Komoju Purchase Request
 *
 * @see \Omnipay\Komoju\Gateway
 * @link https://docs.komoju.com/api/resources/payments
 */
class PurchaseRequest extends AbstractRequest
{
	/**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->getParameter('destination');
    }

    /**
     * @param string $value
     * @return AbstractRequest provides a fluent interface.
     */
    public function setDestination($value)
    {
        return $this->setParameter('destination', $value);
    }

    /**
     * @return mixedgi
     */
    public function getSource()
    {
        return $this->getParameter('source');
    }

    /**
     * @param string $value
     * @return AbstractRequest provides a fluent interface.
     */
    public function setSource($value)
    {
        return $this->setParameter('source', $value);
    }

    /**
     * @return float
     */
    public function getApplicationFee()
    {
        return $this->getParameter('applicationFee');
    }

    /**
     * @return int
     */
    public function getApplicationFeeInteger()
    {
        return (int) round($this->getApplicationFee() * pow(10, $this->getCurrencyDecimalPlaces()));
    }

    /**
     * @param string $value
     * @return AbstractRequest provides a fluent interface.
     */
    public function setApplicationFee($value)
    {
        return $this->setParameter('applicationFee', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array();

        $data['amount'] = $this->getAmountInteger();
        $data['currency'] = strtolower($this->getCurrency());
        $data['description'] = $this->getDescription();
        $data['metadata'] = $this->getMetadata();
        $data['capture'] = 'true';

        if ($this->getDestination()) {
            $data['destination'] = $this->getDestination();
        }

        if ($this->getApplicationFee()) {
            $data['application_fee'] = $this->getApplicationFeeInteger();
        }

        if ($this->getSource()) {
            $data['source'] = $this->getSource();
        } elseif ($this->getCustomerReference()) {
            $data['customer'] = $this->getCustomerReference();
            if ($this->getCardReference()) {
                $data['source'] = $this->getCardReference();
            }
        } elseif ($this->getCardReference()) {
            $data['source'] = $this->getCardReference();
        } elseif ($this->getToken()) {
            $data['source'] = $this->getToken();
        } elseif ($this->getCard()) {
            $data['source'] = $this->getCardData();
        } else {
            // one of cardReference, token, or card is required
            $this->validate('source');
        }

        return $data;
    }

    public function getEndpoint()
    {
        return $this->endpoint.'/charges';
    }
}
