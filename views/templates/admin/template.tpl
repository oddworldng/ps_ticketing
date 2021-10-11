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

{foreach from=$ticketing_products item=product}

    <div class="container-fluid">
        <div class="module-item-wrapper-list row">
            <div class="col-sm-12 col-md-12 col-lg-1 text-sm-center">
                <div class="module-logo-thumb-list">
                    <!-- Image path -->
                    {assign var='uri' value='/'|explode:$request_uri}
                    <img src="{$base_dir}/{$uri[1]}/img/p/{$product['id_image'][0]}/{$product['id_image'][1]}/{$product['id_image']}.jpg" class="text-md-center" alt="{$product["name"]}" style="max-width: 85px;">
                </div>
            </div>
            <div class="col-md-12 col-lg-11 row">
                <div class="col-sm-12 col-md-10 col-lg-11">
                    <h3 class="text-ellipsis module-name-list" data-toggle="pstooltip" data-placement="top" title="" data-original-title="{$product["name"]}">
                        {$product["name"]} <b>({$product["id_product"]})<b/>
                    </h3>
                </div>

                <div class="col-sm-12 col-md-8 col-lg-7">
                    {$product["description_short"]}
                </div>
            </div>
        </div>
    </div>

{/foreach}
