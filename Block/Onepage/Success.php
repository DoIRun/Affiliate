<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Checkout
 */

namespace DoIRun\Affiliate\Block\Onepage;

use Magento\Checkout\Model\Session;
use Magento\Customer\Model\Customer;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\OrderFactory;
use \Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

/**
 * Class Details
 */
class Success extends Template
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var CollectionFactory
     */
    protected $orderCollection;

    public function __construct(
        Template\Context $context,
        Session $session,
        CollectionFactory $orderCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->session = $session;
        $this->orderCollection = $orderCollection;
    }

    /**
     * Retrieve current order model instance
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->session->getLastRealOrder();
    }
    /**
     * Retrieve current order customer
     *
     * @return Customer
     */
    public function getCustomer()
    {
        /** @var $customer Customer */
        $customer = $this->session->getLastRealOrder()->getCustomer();
        return $customer;
    }
    /**
     * Get count of order to registered user
     *
     * @return CollectionFactory
     */
    public function getCustomerOrderCount()
    {
        if ($this->getCustomer()->getId()) {
            /** @var $count CollectionFactory */
            $count = $this->orderCollection->create()->addFieldToSelect('*')->addFieldToFilter('customer_id', $this->getCustomer()->getId())->setOrder('created_at', 'desv')->count();
            return $count;
        }
    }
}
