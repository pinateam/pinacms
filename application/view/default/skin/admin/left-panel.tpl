<aside id="left">

	<div class="logo">
		<a href="{link action="dashboard"}"></a>
	</div>

	{module action="config.manage.language-selector"}

	<ul class="menu">
		<li>
			<a class="icon-home {iflocation action="dashboard"}active{/iflocation}" href="{link action="dashboard"}">{lng lng="homepage"}</a>
		</li>
		{block view="account.manage.left-pane"}
		<li>
			{block view="order.manage.left-pane"}
			<ul>
				{block view="user.manage.left-pane"}
				{block view="subscription.manage.left-pane"}
			</ul>

		</li>
		<li>
			{block view="product.manage.left-pane"}
			<ul>
				{module action="category.manage.type-left-pane"}
				{block view="product-review.manage.left-pane"}
				{block view="export.manage.left-pane"}
                                {block view="import.manage.left-pane"}
			</ul>
		</li>

		<li>
			<a class="icon-book" href="{link action="post.manage.home"}">{lng lng="content"}</a>
			<ul>
				{module action="post.manage.left-pane"}
				{module action="page.manage.left-pane"}
				{block view="post-comment.manage.left-pane"}
				{block view="faq.manage.left-pane"}
				{block view="person.manage.left-pane"}
				{block view="gallery.manage.left-pane"}
				{block view="event.manage.left-pane"}
				
				{block view="bill.manage.left-pane"}
				{block view="contractor.manage.left-pane"}
				{block view="contract.manage.left-pane"}
				{block view="act.manage.left-pane"}
				
				{block view="work.manage.left-pane"}
				{block view="gift-certificate.manage.left-pane"}
                                {block view="delivery.manage.left-pane"}
				{block view="vacancy.manage.left-pane"}
				{block view="menu.manage.left-pane"}
			</ul>
		</li>

		<li>
			{block view="config.manage.left-pane"}
			<ul>
				{block view="access.manage.left-pane"}
				{block view="site.manage.left-pane"}
				{block view="module.manage.left-pane"}
				{block view="directory.manage.left-pane"}
				{block view="system.manage.left-pane"}
                                {block view="custom-field.manage.left-pane"}
			</ul>
		</li>
	</ul>

</aside>