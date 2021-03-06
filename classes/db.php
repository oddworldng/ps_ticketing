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

class Model
{

    /* Build DB tables */
    public function createDBProducts()
    {
        
        $sql = '
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ticketing_products` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `id_product` INT(11) UNSIGNED NOT NULL,
                `is_active` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8
        ';
        $value = Db::getInstance()->ExecuteS($sql);

    }

    public function createDBDumps()
    {
        $sql_dumps = '
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ticketing_dump` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `dump` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8
        ';
        $value = Db::getInstance()->ExecuteS($sql_dumps);
    }

    /* Delete DB tales */
    public function deleteDBProducts()
    {
        $sql = '
            DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'ticketing_products`
        ';
        $value = Db::getInstance()->ExecuteS($sql);        
    }

    public function deleteDBDumps()
    {
        $sql = '
            DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'ticketing_dump`
        ';
        $value = Db::getInstance()->ExecuteS($sql);
    }

    /* Save if product is checked or unchecked */
    public function saveProduct($id, $active)
    {
        Db::getInstance()->insert('ticketing_products', array(
            'id'                => (int)'',
            'id_product'        => pSQL($id),
            'is_active'         => pSQL($active)
        ));
    }

    /* Delete product if uncheck from admin product page */
    public function delProduct($id)
    {
        $sql = '
            DELETE FROM '._DB_PREFIX_.'ticketing_products
            WHERE `id_product`='.(int)$id.'
        ';

        Db::getInstance()->ExecuteS($sql);

        return true;
    }

    /* Get all products */
    public function getProducts()
    {
        $sql = '
            SELECT *
            FROM `'._DB_PREFIX_.'ticketing_products`
            LEFT JOIN `'._DB_PREFIX_.'image_shop`
            ON `'._DB_PREFIX_.'ticketing_products`.id_product = `'._DB_PREFIX_.'image_shop`.id_product
            LEFT JOIN `'._DB_PREFIX_.'product_lang`
            ON `'._DB_PREFIX_.'ticketing_products`.id_product = `'._DB_PREFIX_.'product_lang`.id_product
        ';
        $value = Db::getInstance()->ExecuteS($sql);

        return $value;
    }

    public function is_checked($id)
    {
        $sql = '
            SELECT *
            FROM `'._DB_PREFIX_.'ticketing_products`
            WHERE `id_product`="'.pSQL($id).'"
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        return $value[0]["is_active"];
    }

    public function dump_db($dump)
    {
        Db::getInstance()->insert('ticketing_dump', array(
            'id'                => (int)'',
            'dump'              => pSQL($dump)
        ));
    }

    public function installZone($zone)
    {
        Db::getInstance()->insert('zone', array(
            'id_zone'           => (int)'',
            'name'              => pSQL($zone),
            'active'            => (int)'1',
        ));
    }

    /* GETS ID Zone (ps_zone): id_zone */
    public function getIDZone($zone)
    {
        $sql = '
            SELECT `id_zone`
            FROM `'._DB_PREFIX_.'zone`
            WHERE `name`="'.pSQL($zone).'"
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        return $value[0]["id_zone"];
    }

    public function getIDState($state)
    {
        $sql = '
            SELECT `id_state`
            FROM `'._DB_PREFIX_.'state`
            WHERE `name`="'.pSQL($state).'"
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        return $value[0]["id_state"];
    }

    /* GETS ID Country (ps_country) using country iso code */
    public function getIDCountry($country)
    {
        $sql = '
            SELECT `id_country`
            FROM `'._DB_PREFIX_.'country`
            WHERE `iso_code`="'.pSQL($country).'"
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        return $value[0]["id_country"];
    }

    /* GETS ID Tax (ps_tax) using rate (percent) */
    public function getIDTax($rate)
    {
        $sql = '
            SELECT `id_tax`
            FROM `'._DB_PREFIX_.'tax`
            WHERE `rate`='.(float)$rate.'
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        return $value[0]["id_tax"];
    }

    /* GETS (ps_lang) how many languages are installed */
    public function getLangCount()
    {
        $sql = '
            SELECT COUNT(*) AS `n`
            FROM `'._DB_PREFIX_.'lang`
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        return $value[0]["n"];
    }

    public function getIDTaxRuleGroup($taxRule)
    {
        $sql = '
            SELECT `id_tax_rules_group`
            FROM `'._DB_PREFIX_.'tax_rules_group`
            WHERE `name`="'.pSQL($taxRule).'"
        ';
        $value = Db::getInstance()->ExecuteS($sql);
        return $value[0]["id_tax_rules_group"];
    }

    public function installTax($rate)
    {
        Db::getInstance()->insert('tax', array(
            'id_tax'            => (int)'',
            'rate'              => (float)$rate,
            'active'            => (int)1,
            'deleted'           => (int)0,
        ));
    }

    public function installTaxLang($name, $taxRate)
    {
        for ($i = 1; $i <= $this->getLangCount(); $i++) {
            Db::getInstance()->insert('tax_lang', array(
                'id_tax'            => (int)$this->getIDTax($taxRate),
                'id_lang'           => (int)$i,
                'name'              => pSQL($name),
            ));
        }
    }

    public function installTaxRules($state, $taxRate, $taxGroup)
    {
        Db::getInstance()->insert('tax_rule', array(
            'id_tax'                => (int)'',
            'id_tax_rules_group'    => (int)$this->getIDTaxRuleGroup($taxGroup),
            'id_country'            => (int)$this->getIDCountry("ES"),
            'id_state'              => (int)$this->getIDState($state),
            'zipcode_from'          => pSQL("0"),
            'zipcode_to'            => pSQL("0"),
            'id_tax'                => (int)$this->getIDTax($taxRate),
            'behavior'              => (int)0,
            'description'           => pSQL("IGIC. Impuesto para Canarias"),
        ));

        return true;
    }

    /* DELETE Zone (ps_zone): Canarias */
    public function delZone($zone)
    {
        $sql = '
            DELETE FROM '._DB_PREFIX_.'zone
            WHERE `id_zone`='.(int)$this->getIDZone($zone).'
        ';

        Db::getInstance()->ExecuteS($sql);

        return true;
    }

    /* DELETE State (ps_state): Santa Cruz de Tenerfe & Las Palmas */
    public function delState($state)
    {
        $sql = '
            DELETE FROM '._DB_PREFIX_.'state
            WHERE `id_state`='.(int)$this->getIDState($state).'
        ';

        Db::getInstance()->ExecuteS($sql);

        return true;
    }

    /* DELETE Tax lang (ps_tax_lang): IGIC 7% */
    public function delTaxLang($taxLang)
    {
        $sql = '
            DELETE FROM '._DB_PREFIX_.'tax_lang
            WHERE `name`="'.pSQL($taxLang).'"
        ';

        Db::getInstance()->ExecuteS($sql);

        return true;
    }

    /* DELETE Tax (ps_tax): 7.000 or 3.000 */
    public function delTax($taxRate)
    {
        $sql = '
            DELETE FROM '._DB_PREFIX_.'tax
            WHERE `rate`='.(float)$taxRate.'
        ';

        Db::getInstance()->ExecuteS($sql);

        return true;
    }

    /* DELETE Tax Rules (ps_tax_rule): 7.000 or 3.000 */
    public function delTaxRule($taxRuleDesc)
    {
        $sql = '
            DELETE FROM '._DB_PREFIX_.'tax_rule
            WHERE `description`="'.pSQL($taxRuleDesc).'"
        ';

        Db::getInstance()->ExecuteS($sql);

        return true;
    }
}
