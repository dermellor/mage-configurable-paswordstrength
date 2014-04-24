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

class Shopliebe_PasswordStrength_Model_Customer extends Mage_Customer_Model_Customer
{

    /**
     * Validate customer attribute values.
     * For existing customer password + confirmation will be validated only when password is set (i.e. its change is requested)
     *
     * @return bool
     */
    public function validate()
    {
        $errors = array();

        $password = $this->getPassword();
        $validationHelper = Mage::helper('passwordstrength');

        if (strlen($password) && !Zend_Validate::is($password, 'StringLength', array($validationHelper->getLength()))) {
            $errors[] = Mage::helper('customer')->__('The minimum password length is %s', $validationHelper->getLength());
        }

        if($validationHelper->getCaseCheck() && (strtolower($password) == $password || strtoupper($password) == $password)){
            $errors[] = Mage::helper('customer')->__('The password must contain both uppercase and lowercase characters');
        }

        if($validationHelper->getSpecialCharacterCheck() && !preg_match('/[^a-zA-Z]+/', $password)){
            $errors[] = Mage::helper('customer')->__('The password must contains at least one special character');
        }

        if (empty($errors) || $password == '') {
            return parent::validate();
        }
        return $errors;
    }

}
