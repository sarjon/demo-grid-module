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

use DemoGrid\Form\Type\YesAndNoChoiceType;
use DemoGrid\Grid\Column\ProductInStockColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ProductGridDefinitionFactory creates definition for our products grid
 */
final class ProductGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    /**
     * @var string
     */
    private $resetFiltersUrl;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @param string $resetFiltersUrl
     * @param string $redirectUrl
     */
    public function __construct($resetFiltersUrl, $redirectUrl)
    {
        $this->resetFiltersUrl = $resetFiltersUrl;
        $this->redirectUrl = $redirectUrl;
    }

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
            ->add((new DataColumn('id_product'))
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
            ->add((new ActionColumn('actions'))
                ->setName($this->trans('Actions', [], 'Admin.Actions'))
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return (new FilterCollection())
            ->add((new Filter('id_product', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                ])
                ->setAssociatedColumn('id_product')
            )
            ->add((new Filter('name', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                ])
                ->setAssociatedColumn('name')
            )
            ->add((new Filter('in_stock', YesAndNoChoiceType::class))
                ->setAssociatedColumn('in_stock')
            )
            ->add((new Filter('actions', SearchAndResetType::class))
                ->setTypeOptions([
                    'attr' => [
                        'data-url' => $this->resetFiltersUrl,
                        'data-redirect' => $this->redirectUrl,
                    ],
                ])
                ->setAssociatedColumn('actions')
            )
        ;
    }
}
