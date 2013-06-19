<h1><span class="section-icon icon-colors"></span> {lng lng="xml_sitemap_settings"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="config.manage.update" />
<input type="hidden" name="module_key" value="xml_sitemap" />

{include file="skin/admin/page-operations-save-cancel.tpl"}

<div class="left-wide-column">

	<fieldset>
		<h2>{lng lng="common_data"}</h2>

		{block view="category.manage.xml-config" value=$config.xml_sitemap.cat_priority}
                {block view="product.manage.xml-config" value=$config.xml_sitemap.prod_priority}
                {block view="post.manage.xml-config" value=$config.xml_sitemap.post_priority}   

                {include file="skin/admin/form-line-input.tpl" name="max_urls" value=$config.xml_sitemap.max_urls title="max_urls"|lng class="w50" width="short-text"}
                
	</fieldset>
</div>

</form>