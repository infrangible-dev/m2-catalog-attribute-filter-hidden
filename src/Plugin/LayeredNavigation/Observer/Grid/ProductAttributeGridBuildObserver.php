<?php /** @noinspection PhpDeprecationInspection */

declare(strict_types=1);

namespace Infrangible\CatalogAttributeFilterHidden\Plugin\LayeredNavigation\Observer\Grid;

use Magento\Backend\Block\Widget\Grid\Column\Extended;
use Magento\Catalog\Block\Adminhtml\Product\Attribute\Grid;
use Magento\Framework\Event\Observer;
use Magento\Framework\Module\Manager;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class ProductAttributeGridBuildObserver
{
    /** @var Manager */
    protected $moduleManager;

    public function __construct(Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
    }

    /**
     * @noinspection PhpUnusedParameterInspection
     */
    public function afterExecute(
        \Magento\LayeredNavigation\Observer\Grid\ProductAttributeGridBuildObserver $subject,
        $result,
        Observer $observer)
    {
        if (!$this->moduleManager->isOutputEnabled('Magento_LayeredNavigation')) {
            return;
        }

        /** @var Grid $grid */
        $grid = $observer->getData('grid');

        /** @var Extended $isFilterableColumn */
        $isFilterableColumn = $grid->getColumn('is_filterable');

        $options = $isFilterableColumn->getData('options');

        $lastOption = array_pop($options);

        $options[3] = __('Filterable (hidden)');
        $options[0] = $lastOption;

        $isFilterableColumn->setData('options', $options);
    }
}
