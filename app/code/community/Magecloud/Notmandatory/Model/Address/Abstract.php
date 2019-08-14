<?php
class Magecloud_Notmandatory_Model_Address_Mandatory extends Mage_Customer_Model_Address
{
    public function validate()
    {
        $errors = array();
        $this->implodeStreetAddress();
        if (!Zend_Validate::is($this->getFirstname(), 'NotEmpty')) {
            $errors[] = Mage::helper('customer')->__('Please enter the first name.');
        }

        if (!Zend_Validate::is($this->getLastname(), 'NotEmpty')) {
            $errors[] = Mage::helper('customer')->__('Please enter the last name.');
        }

        if (!Zend_Validate::is($this->getStreet(1), 'NotEmpty')) {
            $errors[] = Mage::helper('customer')->__('Please enter the street.');
        }

        if (!Zend_Validate::is($this->getCity(), 'NotEmpty')) {
            $errors[] = Mage::helper('customer')->__('Please enter the city.');
        }
		
		if(Mage::getStoreConfig('customer/address/telephone_show') == 1)
		{
			if (!Zend_Validate::is($this->getTelephone(), 'NotEmpty')) 
			{
				$errors[] = Mage::helper('customer')->__('Please enter the telephone number.');
			}
		}

        $_havingOptionalZip = Mage::helper('directory')->getCountriesWithOptionalZip();
        if (!in_array($this->getCountryId(), $_havingOptionalZip)
            && !Zend_Validate::is($this->getPostcode(), 'NotEmpty')
        ) {
            $errors[] = Mage::helper('customer')->__('Please enter the zip/postal code.');
        }

        if (!Zend_Validate::is($this->getCountryId(), 'NotEmpty')) {
            $errors[] = Mage::helper('customer')->__('Please enter the country.');
        }
		
		if(Mage::getStoreConfig('customer/address/region_show') == 1)
		{

			if ($this->getCountryModel()->getRegionCollection()->getSize()
               && !Zend_Validate::is($this->getRegionId(), 'NotEmpty')
               && Mage::helper('directory')->isRegionRequired($this->getCountryId())) 
				{
					$errors[] = Mage::helper('customer')->__('Please enter the state/province.');
			    }
        } 

        if (empty($errors) || $this->getShouldIgnoreValidation()) {
            return true;
        }
        return $errors;
    }
}