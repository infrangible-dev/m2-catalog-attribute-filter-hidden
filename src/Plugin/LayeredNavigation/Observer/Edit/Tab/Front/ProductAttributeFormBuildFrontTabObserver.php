<?php /** @noinspection PhpDeprecationInspection */

declare(strict_types=1);

namespace Infrangible\CatalogAttributeFilterHidden\Plugin\LayeredNavigation\Observer\Edit\Tab\Front;

use Magento\Framework\Data\Form;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Fieldset;
use Magento\Framework\Event\Observer;
use Magento\Framework\Module\Manager;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class ProductAttributeFormBuildFrontTabObserver
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
        \Magento\LayeredNavigation\Observer\Edit\Tab\Front\ProductAttributeFormBuildFrontTabObserver $subject,
        $result,
        Observer $observer): void
    {
        if (!$this->moduleManager->isOutputEnabled('Magento_LayeredNavigation')) {
            return;
        }

        /** @var Form $form */
        $form = $observer->getData('form');

        /** @var Fieldset $fieldSet */
        $fieldSet = $form->getElement('front_fieldset');

        /** @var AbstractElement $element */
        foreach ($fieldSet->getElements() as $element) {
            if ($element->getId() === 'is_filterable') {
                $values = $element->getData('values');

                $values[] = [
                    'value' => '3',
                    'label' => __('Filterable (hidden)')
                ];

                $element->setData('values', $values);
            }
        }
    }
}
