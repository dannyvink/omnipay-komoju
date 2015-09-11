<?php
/**
 * Komoju Response
 */

namespace Omnipay\Komoju\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

/**
 * Komoju Response
 *
 * This is the response class for all Komoju requests.
 *
 * @see \Omnipay\Komoju\Gateway
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $redirectUrl;

    /**
     * A Komoju PurchaseResponse requires the request interface and data, as well as
     * the generated redirection URL.
     *
     * @param RequestInterface $request
     * @param mixed            $data
     * @param                  $redirectUrl
     */
    public function __construct(RequestInterface $request, $data, $redirectUrl)
    {
        $this->request = $request;
        $this->data = $data;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * With Komoju, the request is not considered successful until after the transaction
     * has finished taking place on the hosted gateway page.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * All Komoju purchase requests take place on the hosted gateway page.
     *
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Retrieve the generated redirect URL.
     *
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Retrieve the HTTP method used for redirection.
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * Retrieve the data from the response.
     *
     * @return mixed
     */
    public function getRedirectData()
    {
        return $this->getData();
    }
}
