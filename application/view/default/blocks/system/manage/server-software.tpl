<h1><span class="section-icon icon-colors"></span> {lng lng="server_software_configuration"}</h1>
<div>
	{if $server_software eq "apache"}
		{module action="system.manage.get-apache"}
	{elseif $server_software eq "nginx"}
		{module action="system.manage.get-nginx"}
	{else}
		undefined
	{/if}
</div>