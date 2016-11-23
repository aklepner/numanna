<?php
class Transform_Slideshow_Model_Mysql4_Slide extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('slideshow/slide', 'slide_id');
    }
}