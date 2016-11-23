<?php
class Transform_Slideshow_Model_Mysql4_Slide_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('slideshow/slide');
    }
}