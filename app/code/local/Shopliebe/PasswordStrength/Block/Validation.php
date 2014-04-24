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

class Shopliebe_PasswordStrength_Block_Validation extends Mage_Core_Block_Template
{

    private $_validationHelper;

    public function getValidationMessage()
    {
        $validitionHelper = Mage::helper('passwordstrength');
        $message = '';

        $message .= $this->__('Please use %s characters.', $validitionHelper->getLength());

        $validations = array();
        foreach(array('Case' => 'both uppercase and lowercase characters', 'SpecialCharacter' => 'at least one special character') as $type => $validation){
            $check = 'get' . $type . 'Check';
            if($validitionHelper->$check()){
                $validations[] = $this->__($validation);
            }
        }

        return $message . $this->typesToMessage($validations);
    }

    public function getValidationScript()
    {
        $validitionHelper = Mage::helper('passwordstrength');
        $script = 'if (pass.length < ' . $validitionHelper->getLength() . '){return false;}';

        if($validitionHelper->getCaseCheck()){
            $script .= 'if (pass.toLowerCase() == pass || pass.toUpperCase() == pass){return false;}';
        }
        if($validitionHelper->getSpecialCharacterCheck()){
            $script .= 'if (!(/[^a-zA-Z]+/.test(pass))){return false;}';
        }

        return $script;
    }

    private function typesToMessage($types)
    {
        if(empty($types)) return '';
        $lastEntry = array_pop($types);

        $validations = (!empty($types) ? ' ' . (implode(', ', $types) . ' ' . $this->__('and')) : '');
        $validations .= ' ' . $lastEntry ;

        $message = ' ' . $this->__('The Password must contain %s.', $validations);

        return $message;
    }
}
