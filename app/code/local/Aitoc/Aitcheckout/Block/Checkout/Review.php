<?php
class Aitoc_Aitcheckout_Block_Checkout_Review extends Mage_Checkout_Block_Onepage_Review
{
    /**
     *
     * @return Aitoc_Autcheckout_Helper_Sagepay
     */
    public function getDefaultHelper()
    {
        return Mage::helper('aitcheckout/sagepay');
    }

    public function isSagePayFormPaymentModeActive()
    {
        $post = $this->getRequest()->getPost();
        return isset($post['payment']['method']) && ('sagepayform' == $post['payment']['method']);
    }

    public function getReviewUrl()
    {
        
        if ($this->getDefaultHelper()->checkIfEbizmartsSagePaySuiteFormModeActiveOnly() && $this->isSagePayFormPaymentModeActive())
        {
            return $this->getUrl('sgps/payment/onepageSaveOrder', array('_secure'=>true));
        }
        else
        {
            return $this->getUrl('aitcheckout/checkout/saveOrder', array('form_key' => Mage::getSingleton('core/session')->getFormKey(), '_secure'=>true));
        }
    }
    
    /**
     * Validate if order amount is allowed to purchase
     *
     * @return boolean
     */
    public function isDisabled()
    {
        return Mage::helper('aitcheckout')->isPlaceOrderDisabled();
    }
    
	  /**
     * @return boolean
     */
    public function isSaveOrderAction()
    {
        return (Mage::app()->getRequest()->getActionName() == 'saveOrder');
    }
  
}