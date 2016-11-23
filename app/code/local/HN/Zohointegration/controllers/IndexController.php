<?php
class HN_Zohointegration_IndexController extends Mage_Core_Controller_Front_Action {    
	public function IndexAction(){
		echo "ZohoCRM Integration</br><pre>";
		$model = Mage::getModel('zohointegration/sync_account')->sync(95,true);
		echo "</pre>";
	}
}