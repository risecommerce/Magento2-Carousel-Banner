<?php
/**
 * Class Banner
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_Banner
 * @author   Risecommerce <magento@risecommerce-technologies.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Banner\Block\Adminhtml;


class Banner extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */

    protected function _construct()
    {
        $this->_blockGroup = 'Risecommerce_Banner';
        $this->_controller = 'adminhtml';
        $this->_headerText = __('Banner');
        $this->_addButtonLabel = __('Add New Banner');
        parent::_construct();
        if (!$this->_authorization->isAllowed('Risecommerce_Banner::add_banner')) {
            $this->removeButton('add');
        }
    }
}
