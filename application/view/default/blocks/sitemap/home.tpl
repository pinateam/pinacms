<h1>{lng lng="sitemap"}</h1>
    
{foreach from=$category_types item="category_type"}
<div class="sitemap">
    <h2> {$category_type.category_type_title} </h2>
    {module action="category.sitemap" category_id=0 category_type_id=$category_type.category_type_id}
</div>
{/foreach}

<div class="sitemap">
<h2>{lng lng="information"}</h2>
<div style="margin-bottom:15px;">
{module action="page.sitemap"}
</div>
{module action="blog.sitemap"}

{block view="order.sitemap-link"}
{block view="feedback.sitemap-link"}
{block view="wishlist.sitemap-link"}

</div>
