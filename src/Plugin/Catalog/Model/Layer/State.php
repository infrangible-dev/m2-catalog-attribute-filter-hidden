<?php

declare(strict_types=1);

namespace Infrangible\CatalogAttributeFilterHidden\Plugin\Catalog\Model\Layer;

use Magento\Catalog\Model\Layer\Filter\Item;
use Magento\CatalogSearch\Model\Layer\Filter\Attribute;
use Magento\Framework\Exception\LocalizedException;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class State
{
    /** @noinspection PhpUnusedParameterInspection */
    public function afterGetFilters(\Magento\Catalog\Model\Layer\State $subject, array $result): array
    {
        $filters = [];

        /** @var Item $item */
        foreach ($result as $item) {
            try {
                $filter = $item->getFilter();

                if ($filter instanceof Attribute) {
                    $attribute = $filter->getAttributeModel();

                    if ($attribute->getIsFilterable() != 3) {
                        $filters[] = $item;
                    }
                } else {
                    $filters[] = $item;
                }
            } catch (LocalizedException $exception) {
                $filters[] = $item;
            }
        }

        return $filters;
    }
}
