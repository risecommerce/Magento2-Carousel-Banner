<?php
/**
 * Class Collection
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_Banner
 * @author   Risecommerce <magento@risecommerce-technologies.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Banner\Model\ResourceModel\Banner;

use Risecommerce\Banner\Api\Data\BannerInterface;
use Risecommerce\Banner\Model\Banner;
use Risecommerce\Banner\Model\ResourceModel\AbstractCollection;


class Collection extends AbstractCollection
{
    /**
     * Primary field name of table
     *
     * @var string
     */
    protected $_idFieldName = 'banner_id';
    /**
     * Load data for preview flag
     *
     * @var bool
     */
    protected $_previewFlag;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Risecommerce\Banner\Model\Banner::class,
            \Risecommerce\Banner\Model\ResourceModel\Banner::class
        );
        $this->_map['fields']['banner_id'] = 'main_table.banner_id';
        $this->_map['fields']['store'] = 'store_table.store_id';
    }
    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addFieldToFilter($field, $condition = null)
    {
        switch ($field) {
            case "store":
                $condition = $this->getConnection()->prepareSqlCondition('store.store_id', $condition);
                $this->getSelect()->join(
                    ['store' => $this->getTable('risecommerce_banner_store')],
                    'main_table.banner_id = store.banner_id',
                    []
                );
                $this->getSelect()->where(sprintf('(%s OR store.store_id = 0)', $condition));
                break;
            case "customer":
                $condition = $this->getConnection()->prepareSqlCondition('customer.customer_group_id', $condition);
                $this->getSelect()->join(
                    ['customer' => $this->getTable('risecommerce_banner_customer_group')],
                    'main_table.banner_id = customer.banner_id',
                    []
                );
                $this->getSelect()->where(sprintf('(%s)', $condition));
                break;
            default:
                parent::addFieldToFilter($field, $condition);
        }
        return $this;
    }

    public function addStoreFilter($bannerId)
    {
        $this->join(
            ['banner_store' => $this->getTable('risecommerce_banner_store')],
            'main_table.banner_id= banner_store.banner_id',
            'store_id'
        );
        $this->getSelect()->reset(\Magento\Framework\DB\Select::WHERE);
        $this->addFieldToFilter('banner_id', ['eq' => $bannerId]);
        $this->addFieldToFilter('status', Banner::STATUS_ENABLED);
        foreach ($this as $data) {
            $storeIds[] = $data->getData('store_id');
        }
        return $storeIds;
    }
    /**
     * Set first store flag
     *
     * @param bool $flag
     * @return $this
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }
    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $entityMetadata = $this->metadataPool->getMetadata(BannerInterface::class);
        $this->performAfterLoad($this->getTable('risecommerce_banner_store'), $entityMetadata->getLinkField());
        $this->_previewFlag = false;

        return parent::_afterLoad();
    }
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(BannerInterface::class);
        $this->joinStoreRelationTable($this->getTable('risecommerce_banner_store'), $entityMetadata->getLinkField());
    }
}
