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

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinitionInterface;

/**
 * Class DemoGrid demonstrates how to work with new Grid component
 */
class DemoGrid extends Module
{
    /**
     * In constructor we define our module's meta data.
     * It's better tot keep constructor (and main module class itself) as thin as possible
     * and do any processing in controller.
     */
    public function __construct()
    {
        $this->name = 'demogrid';
        $this->version = '1.0.0';
        $this->author = 'sarjon';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = 'Demo module for Grid component';
    }

    /**
     * It's better to avoid rendering data in getContent()
     * so we redirect admin to our products controller which shows default page.
     */
    public function getContent()
    {
        $container = SymfonyContainer::getInstance();

        Tools::redirectAdmin($container->get('router')->generate('demogrid_admin_products'));
    }

    /**
     * Install module and register hooks to allow grid modification.
     *
     * @return bool
     */
    public function install()
    {
        return parent::install() &&
            // Register hook to allow Logs grid definition modifications.
            // Each grid's definition modification hook has it's own name. Hook name is built using
            // this structure: "action{grid_id}GridDefinitionModifier", in this case "grid_id" is "logs"
            // this means we will be modifying "Configure > Advanced Parameters > Logs" page grid.
            // You can check any definition factory service in PrestaShop\PrestaShop\Core\Grid\Definition\Factory
            // to see available grid ids. Grid id is returned by `getId()` method.
            $this->registerHook('actionLogsGridDefinitionModifier');
    }

    /**
     * Hooks allows to modify Logs grid definition.
     * This hook is a right place to add/remove columns or actions (bulk, grid).
     *
     * @param array $params
     */
    public function hookActionLogsGridDefinitionModifier(array $params)
    {
        /** @var GridDefinitionInterface $definition */
        $definition = $params['definition'];

        // Remove employee column from grid as we don't want to see that information.
        $definition->getColumns()->remove('employee');

        // Remove employee filter that is associated with "employee" column.
        // As filters are separately defined, you may or may not want to keep it after removing column.
        // If you decide to keep the filter for removed column
        // you should know that it will be rendered separately from grid table.
        $definition->getFilters()->remove('employee');
    }
}
