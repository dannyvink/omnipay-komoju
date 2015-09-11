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
     * Assemble the data to send with the request.
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array();

        $data['timestamp'] = $this->getTimestamp();
        $data['transaction[amount]'] = $this->getAmountInteger();
        $data['transaction[cancel_url]'] = $this->getCancelUrl();
        $data['transaction[currency]'] = strtoupper($this->getCurrency());
        $data['transaction[external_order_num]'] = $this->getTransactionReference();
        $data['transaction[return_url]'] = $this->getReturnUrl();
        $data['transaction[tax]'] = $this->getTax();

        return $data;
    }
}
