<?php
/**
 * Class Form
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_Banner
 * @author   Risecommerce <magento@risecommerce-technologies.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Banner\Block\Adminhtml\Banner\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /**
         * FormFactory
         *
         * @var \Magento\Framework\Data\Form $form
         */
        $form = $this->_formFactory->create(
            [
            'data' => [
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            ]
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
