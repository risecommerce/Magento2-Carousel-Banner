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
namespace Risecommerce\Banner\Controller\Adminhtml;


class Banner extends Actions
{
    /**
     * Form session key
     *
     * @var string
     */
    protected $formSessionKey = 'risecommerce_banner_form_data';

    /**
     * Allowed Key
     *
     * @var string
     */
    protected $allowedKey = 'Risecommerce_Banner::manage_banners';

    /**
     * Model class name
     *
     * @var string
     */
    protected $modelClass = \Risecommerce\Banner\Model\Banner::class;

    /**
     * Active menu key
     *
     * @var string
     */
    protected $activeMenu = 'Risecommerce_Banner::banner';

    /**
     * Status field name
     *
     * @var string
     */
    protected $statusField = 'is_active';

    /**
     * Save request params key
     *
     * @var string
     */
    protected $paramsHolder = 'post';
}
