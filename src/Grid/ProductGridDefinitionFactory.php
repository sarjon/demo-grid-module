<?php
/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace DemoGrid\Grid;

use DemoGrid\Grid\Column\ProductInStockColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;

/**
 * Class ProductGridDefinitionFactory creates definition for our products grid
 */
final class ProductGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    /**
     * {@inheritdoc}
     */
    protected function getId()
    {
        return 'demogrid_products';
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return $this->trans('Products', [], 'Modules.DemoGrid.Admin');
    }

    /**
     * {@inheritdoc}
     */
    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add((new DataColumn('id'))
                ->setName($this->trans('ID', [], 'Modules.DemoGrid.Admin'))
                ->setOptions([
                    'field' => 'id_product',
                ])
            )
            ->add((new DataColumn('name'))
                ->setName($this->trans('Name', [], 'Modules.DemoGrid.Admin'))
                ->setOptions([
                    'field' => 'name',
                ])
            )
            ->add((new ProductInStockColumn('in_stock'))
                ->setName($this->trans('In Stock', [], 'Modules.DemoGrid.Admin'))
                ->setOptions([
                    'quantity_field' => 'quantity',
                    'with_quantity' => true,
                ])
            )
        ;
    }
}
