{if $menu_items}
	{block view="menu.list"}
{else}
	{if $categoryId}
		{assign var=current_category_id value=$categoryId}
	{else}
		{assign var=current_category_id value=$categoryInfo.category_id}
	{/if}
	<ul>
		<li><a href="{link action="home"}">{lng lng="homepage"}</a></li>
		{module action="category.menu" current_category_id=$current_category_id}
		{module action="blog.menu"}
		{block view="person.menu"}
		{block view="faq.menu"}
		{module action="work.menu"}
	</ul>
{/if}