<?php

declare(strict_types=1);

namespace Infrangible\CatalogAttributeFilterHidden\Plugin\Catalog\Model\ResourceModel\Product\Attribute;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Collection
{
    /** @noinspection PhpUnusedParameterInspection */
    public function aroundAddIsFilterableFilter(
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection $subject,
        callable $proceed): \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection
    {
        return $subject->addFieldToFilter('additional_table.is_filterable', ['in' => [1, 2]]);
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function aroundAddIsFilterableInSearchFilter(
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection $subject,
        callable $proceed): \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection
    {
        $subject->addFieldToFilter('additional_table.is_filterable_in_search', ['gt' => 0]);
        return $subject->addFieldToFilter('additional_table.is_filterable', ['neq' => [3]]);
    }
}
