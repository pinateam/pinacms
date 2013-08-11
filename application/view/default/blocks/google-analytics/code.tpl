{if $config.google_analytics.account_number}
{literal}
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{/literal}{$config.google_analytics.account_number}{literal}']);
  _gaq.push(['_trackPageview']);
      
{/literal}

{if $main eq "order.invoice" && $new_order && $order.order_id}

    _gaq.push(["_addTrans",
      "{$order.order_id}",           // order ID - required
      "{'Store'}",  // affiliation or store name
      "{$order.order_total}",          // total - required
      "",      // tax
      "{if $order.order_shipping_fee gt 0}{$order.order_shipping_fee}{/if}", // shipping
      "{$order.address_city|escape:javascript}",      // city
      "{$order.address_state|escape:javascript}",     // state or province
      "{$order.address_country|escape:javascript}"// country
    ]);

    {foreach from=$order.products item="product"}
      _gaq.push(["_addItem",
        "{$order.order_id}",           // order ID - required
        "{$product.product_code|escape:javascript}", // SKU/code - required
        "{$product.product_title|escape:javascript}", // product name
        "", // category or variation
        "{$product.product_price}",          // unit price - required
        "{$product.product_amount}"          // quantity - required
      ]);
    {/foreach}
    
{/if}
    
{literal}

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
{/literal}
{/if}