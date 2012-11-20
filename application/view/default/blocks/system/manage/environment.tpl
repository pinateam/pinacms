<h1><span class="section-icon icon-colors"></span> {lng lng="environment_testing"}</h1>

<h2>{lng lng="php_version"}</h2>
<ul class="test-environment">
	<li class="{$php_version.warning_type}">{lng lng="php_version"} >= {$php_version.expected} <span class="current">({lng lng="current_version"}: {$php_version.value})</span></li>
</ul>

<h2>{lng lng="required_php_extensions"}</h2>
<ul class="test-environment">
{foreach from=$php_extensions_required item=ext}
	<li class="{if $ext.loaded}ok{else}error{/if}"><span class="icon-info" onclick="alert('{$ext.info}')"></span> {$ext.title}</li>
{/foreach}
</ul>

<h2>{lng lng="php_settings_values"}</h2>
<ul class="test-environment">
{foreach from=$php_directives item=dir key=dir_name}
	<li class="{$dir.warning_type}">{$dir_name} {$dir.expected} <span class="current">({lng lng="current_value}: {$dir.value})</span></li>
{/foreach}
</ul>

{if $apache_modules_recommended}
<h2>{lng lng="recommended_apache_modules"}</h2>
<ul class="test-environment">
{foreach from=$apache_modules_recommended item=mod}
	<li class="{if $mod.loaded}ok{else}warning{/if}"><span class="icon-info" onclick="alert('{$mod.info}')"></span> {$mod.title}</li>
{/foreach}
</ul>
{/if}

<div class="button-bar">
	<button class="css3" onclick="location.reload(); return false;">{lng lng="check_again"}</button>
</div>