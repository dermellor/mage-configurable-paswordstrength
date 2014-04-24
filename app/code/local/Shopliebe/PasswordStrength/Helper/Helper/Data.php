<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Shopliebe
 * @package   Shopliebe_PasswordStrength
 * @author    Marcel Mellor <info@shopliebe.de>
 * @copyright 2014 Mellor Schuhmacher GbR
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.shopliebe.de
 */

class Shopliebe_PasswordStrength_Helper_Helper_Data extends Mage_Core_Helper_Abstract 
{

    private $_length = 6;
    private $_useCaseCheck;
    private $_useSpecialCharacterCheck;

    public function __construct(){
        $this->setLength(Mage::getStoreConfig('customer/password/password_length'))
            ->setCaseCheck(Mage::getStoreConfig('customer/password/password_case'))
            ->setSpecialCharacterCheck(Mage::getStoreConfig('customer/password/password_special_characters'));
        return $this;
    }

    public function isValid($password)
    {
        if($password) return false;

        $errors = array();
        
        if (strlen($password) && !Zend_Validate::is($password, 'StringLength', array($this->_length))) {
            $errors[] = Mage::helper('customer')->__('The minimum password length is %s', $this->_length);
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    public function setLength($length)
    {
        $this->_length = $length;
        return $this;
    }

    public function setCaseCheck($useCaseCheck)
    {
        $this->_useCaseCheck = $useCaseCheck;
        return $this;
    }

    public function setSpecialCharacterCheck($useSpecialCharacterCheck)
    {
        $this->_useSpecialCharacterCheck = $useSpecialCharacterCheck;
        return $this;
    }

    public function getLength()
    {
        return $this->_length;
    }

    public function getCaseCheck()
    {
        return $this->_useCaseCheck;
    }

    public function getSpecialCharacterCheck()
    {
        return $this->_useSpecialCharacterCheck;
    }
    
}
?>