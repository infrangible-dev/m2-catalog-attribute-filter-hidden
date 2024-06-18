<?php /** @noinspection PhpDeprecationInspection */

declare(strict_types=1);

namespace Infrangible\CatalogAttributeFilterHidden\Model\Search;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\CatalogSearch\Model\Search\RequestGenerator\GeneratorResolver;

/**
 * Preference to fix aggregation for attributes with an is_filterable value in [1, 2, 3]
 * instead of only [1, 2].
 * This prevents the logging message "The bucket doesn't exist.".
 *
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class RequestGenerator
    extends \Magento\CatalogSearch\Model\Search\RequestGenerator
{
    /** @var CollectionFactory */
    private $productAttributeCollectionFactory;

    public function __construct(CollectionFactory $productAttributeCollectionFactory,
                                GeneratorResolver $generatorResolver = null)
    {
        parent::__construct($productAttributeCollectionFactory, $generatorResolver);

        $this->productAttributeCollectionFactory = $productAttributeCollectionFactory;
    }

    protected function getSearchableAttributes(): Collection
    {
        $productAttributes = $this->productAttributeCollectionFactory->create();
        $productAttributes->addFieldToFilter(['is_searchable',
            'is_visible_in_advanced_search',
            'is_filterable',
            'is_filterable_in_search'], [1, 1, [1, 2, 3], 1]);

        return $productAttributes;
    }
}
