{*
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
*  @copyright 2020 Andres Nacimiento
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}
<div class="content">
    <div class="product_tab">
        {foreach from=$ticketing_products item=product}

            <!-- Image path -->
            {assign var='uri' value='/'|explode:$request_uri}
            Image path: <img src="{$base_dir}/{$uri[1]}/img/p/{$product['id_image'][0]}/{$product['id_image'][1]}/{$product['id_image']}.jpg" style="max-width:150px;"><br/>

            ID: {$product["id_product"]}<br/>
            {l s='Product name' mod='ps_ticketing'}: {$product["name"]}<br/>
            Descripcion: {$product["description_short"]}<br/>
            Imagen: {$product["id_image"]}<br/>

        {/foreach}
    </div>
</div>
