<ul class="customer_navi alignright">
{if $user.user_id}
	<li><a href="{link action="user.change-password"}">{lng lng="change_password"}</a></li>
	<li><a href="{link action="user.register-address"}">{lng lng="address"}</a></li>
	{block view="wishlist.menu-items"}
	{block view="order.menu-items"}
	{ifpermitted action="dashboard"}<li><a href="{link action="dashboard"}">{lng lng="dashboard"}</a></li>{/ifpermitted}
	<li><a href="{link api="user.logout"}">{lng lng="sign_out"}</a></li>
{else}
	<li><a href="{link action="user.enter"}" rel="div.overlay:eq(0)">{lng lng="sign_in"}</a></li>
	<li><a href="{link action="user.register"}">{lng lng="register"}</a></li>
{/if}
	{module action="order.minicart" nowrapper=1}
</ul>