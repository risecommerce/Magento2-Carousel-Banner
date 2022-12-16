<?php
/**
 * Class SaveHandler
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_Banner
 * @author   Risecommerce <magento@risecommerce-technologies.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Banner\Model\ResourceModel\Banner\Relation\CustomerGroup;

use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Risecommerce\Banner\Api\Data\BannerInterface;
use Risecommerce\Banner\Model\ResourceModel\Banner;
use Magento\Framework\EntityManager\MetadataPool;

/**
 * Class SaveHandler
 */
class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var Banner
     */
    protected $resourceBanner;

    /**
     * @param MetadataPool $metadataPool
     * @param Banner $resourceBanner
     */
    public function __construct(
        MetadataPool $metadataPool,
        Banner $resourceBanner
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceBanner = $resourceBanner;
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return object
     * @throws \Exception
     */
    public function execute($entity, $arguments = [])
    {
        $entityMetadata = $this->metadataPool->getMetadata(BannerInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $connection = $entityMetadata->getEntityConnection();

        $oldCustomer = $this->resourceBanner->lookupCustomerGroupIds((int)$entity->getId());

        $newCustomer = (array)$entity->getCustomerGroup();

        if (empty($newCustomer)) {
            $newCustomer = (array)$entity->getCustomerGroupId();
        }

        $table = $this->resourceBanner->getTable('risecommerce_banner_customer_group');

        $delete = array_diff($oldCustomer, $newCustomer);

        if ($delete) {

            $where = [
                $linkField . ' = ?' => (int)$entity->getData($linkField),
                'customer_group_id IN (?)' => $delete,
            ];
            $connection->delete($table, $where);
        }

        $insert = array_diff($newCustomer, $oldCustomer);

        if ($insert) {

            $data = [];
            foreach ($insert as $customerGroupId) {
                $data[] = [
                    $linkField => (int)$entity->getData($linkField),
                    'customer_group_id' => (int)$customerGroupId
                ];
            }

            $connection->insertMultiple($table, $data);
        }

        return $entity;
    }
}
