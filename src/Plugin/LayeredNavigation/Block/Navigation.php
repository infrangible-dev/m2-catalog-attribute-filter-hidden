<?php

declare(strict_types=1);

namespace Infrangible\CatalogAttributeFilterHidden\Plugin\LayeredNavigation\Block;

use Magento\CatalogSearch\Model\Layer\Filter\Attribute;
use Magento\Framework\Exception\LocalizedException;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Navigation
{
    /** @noinspection PhpUnusedParameterInspection */
    public function afterGetFilters(\Magento\LayeredNavigation\Block\Navigation $subject, array $result): array
    {
        $filters = [];

        foreach ($result as $filter) {
            if ($filter instanceof Attribute) {
                try {
                    $attribute = $filter->getAttributeModel();

                    if ($attribute->getIsFilterable() != 3) {
                        $filters[] = $filter;
                    }
                } catch (LocalizedException $exception) {
                    $filters[] = $filter;
                }
            } else {
                $filters[] = $filter;
            }
        }

        return $filters;
    }
}