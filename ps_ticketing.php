<?php
/**
* 2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author    Andres Nacimiento <andresnacimiento@gmail.com>
*  @copyright 2021 Andres Nacimiento
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}


class Ps_Ticketing extends Module
{

    /* CONSTRUCT */
    public function __construct()
    {
        $this->name = 'ps_ticketing';
        $this->displayName = $this->trans('Ticketing');
        $this->description = $this->trans('Tickets on sale');
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->need_instance = 0;
        $this->author = 'Andres Nacimiento';
        $this->bootstrap = true;
        $this->module_key = '';
        $this->ps_versions_compliancy = ['min' => '1.7.2.0', 'max' => _PS_VERSION_];
        parent::__construct();
    }
    /* INSTALL */
    public function install()
    {
        return parent::install()
            /* Install Db */
            && $this->installDb()
            /* Display new elements in back office product page, left column of This hook launches modules when the back office product page is displayed */
            && $this->registerHook('displayAdminProductsMainStepLeftColumnBottom')
            /* This hook is called while saving products */
            && $this->registerHook('actionProductSave')
            /* To add JS and CSS file in Backoffice */
            //&& $this->registerHook('displayBackOfficeHeader')
            && $this->registerHook('actionAdminControllerSetMedia');

    }
    /* UNINSTALL */
    public function uninstall()
    {
        /* Delete configuration */
        return parent::uninstall()
            /* Uninstall Db */
            && $this->uninstallDB()
            /* Unregister Hooks */
            && $this->unregisterHook('displayAdminProductsMainStepLeftColumnBottom')
            && $this->unregisterHook('actionProductSave')
            //&& $this->unregisterHook('displayBackOfficeHeader')
            && $this->unregisterHook('actionAdminControllerSetMedia');
    }
    /*public function hookDisplayBackOfficeHeader()
    {
        $script = '
            <script>
                $(document).ready( function () {

                    function ticketingCheck(){
                        // Get the checkbox
                        var checkBox = document.getElementById("ticketingProductChecked");

                        // If the checkbox is checked, change value
                        if (checkBox.value == "0"{
                            checkBox.value = "1";
                        } else {
                            checkBox.value = "0";
                        }
                    }

                });
            </script>
        ';
        return $script;
    }*/
    public function hookActionAdminControllerSetMedia()
    {
        $this->context->controller->addJs($this->_path . 'views/js/admin.js');
    }
    public function getContent()
    {
        return $this->display(__FILE__, 'views/templates/admin/template.tpl');
    }
    /* Hooks */
    public function hookDisplayAdminProductsMainStepLeftColumnBottom(array $params)
    {
        return $this->display(__FILE__, 'views/templates/hook/admin.tpl');
    }
    public function hookActionProductSave()
    {
        include "classes/db.php";
        $db = new Model();

        // Get product ID
        $id = Tools::getValue('id_product');
        // Get if user has checked for ticketing in this product
        $is_checked = Tools::getValue('ticketing_product_checked');
        // Get if product it was checked
        $was_checked = $db->is_checked($id);
        $db->dump_db($was_checked);
        // Save values into data base
        $db->saveProduct($id, $is_checked);
        return true;

    }
    /* Install DB */
    public function installDb()
    {
        include "classes/db.php";
        $db = new Model();

        $db->createDBProducts();
        $db->createDBDumps();

        return true;
    }

    /* Uninstall DB */
    private function uninstallDb()
    {
        include "classes/db.php";
        $db = new Model();

        $db->deleteDBProducts();
        $db->deleteDBDumps();

        return true;
    }
}
