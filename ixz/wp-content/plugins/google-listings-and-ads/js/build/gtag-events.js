!function(){"use strict";var t=window.wp.hooks;const e=(t,e)=>{if("function"!=typeof gtag)throw new Error("Function gtag not implemented.");window.gtag("event",t,{send_to:"GLA",...e})},n=function(t){let n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1;e("add_to_cart",{ecomm_pagetype:"cart",event_category:"ecommerce",items:[a(t,n)]})},a=(t,e)=>{var n,a;const r={id:"gla_"+t.id,quantity:e,google_business_vertical:"retail"};return t.name&&(r.name=t.name),null!=t&&null!==(n=t.categories)&&void 0!==n&&n.length&&(r.category=t.categories[0].name),null!=t&&null!==(a=t.prices)&&void 0!==a&&a.price&&(r.price=parseInt(t.prices.price,10)/10**t.prices.currency_minor_unit),r},r=t=>{var e;return glaGtagData.products[t.id]&&(t.name=glaGtagData.products[t.id].name,t.prices=(e=glaGtagData.products[t.id].price,{price:Math.round(e*10**glaGtagData.currency_minor_unit),currency_minor_unit:glaGtagData.currency_minor_unit})),t};(0,t.addAction)("experimental__woocommerce_blocks-cart-add-item","google-listings-and-ads",(t=>{let{product:e,quantity:a=1}=t;n(e,a)}));const o=function(t){const e=t.target.dataset,a=r({id:e.product_id});n(a,e.quantity||1)},i=function(t){const e=t.target.closest("form.cart");if(!e)return;const a=e.querySelector("[name=add-to-cart]");if(!a)return;const o=e.querySelector("[name=variation_id]"),i=e.querySelector("[name=quantity]"),c=r({id:parseInt(o?o.value:a.value,10)});n(c,i?parseInt(i.value,10):1)};window.onload=function(){document.querySelectorAll(".add_to_cart_button:not( .product_type_variable ):not( .product_type_grouped )").forEach((t=>{t.addEventListener("click",o)})),document.querySelectorAll(".single_add_to_cart_button").forEach((t=>{t.addEventListener("click",i)}))},"function"==typeof jQuery&&jQuery(document).on("found_variation","form.cart",(function(t,e){(t=>{null!=t&&t.variation_id&&(glaGtagData.products[t.variation_id]={name:t.display_name,price:t.display_price})})(e)}))}();