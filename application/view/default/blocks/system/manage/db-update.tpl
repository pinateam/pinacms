<h1><span class="section-icon icon-asterix"></span>UPGRADE DATABASE</h1>

<form action="api.php" method="POST" name="db-update" id="db-update">
    <input type="hidden" name="action" value="system.manage.db-update" />
	<div class="right-narrow-column">
		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				<button class="css3 button-add">{lng lng="update_database"}</button>
			</div>
		</fieldset>
	</div>

	<div class="left-wide-column">
		{assign var="need_update" value=false}
		{if is_array($add_tables) && count($add_tables)}
			<h2>{lng lng="add_tables"}:</h2>
			<ol>
			{foreach from=$add_tables item=table}
				<li>{$table}</li>
			{/foreach}
			</ol>
			{assign var="need_update" value=true}
		{/if}
		{if is_array($edit_tables) && count($edit_tables)}
			<h2>{lng lng="update_tables"}:</h2>
			<ol>
			{foreach from=$edit_tables key=table item=changes}
				<h2>{$table}:</h2>
				{if is_array($changes.add_fields) && count($changes.add_fields)}
					<h3>{lng lng="add_fields"}:</h3>
					<ol>
						{foreach from=$changes.add_fields item=field}
							<li>{$field}</li>
						{/foreach}
					</ol>
				{/if}
				{if is_array($changes.delete_fields) && count($changes.delete_fields)}
					<h3>{lng lng="delete_fields"}:</h3>
					<ol>
						{foreach from=$changes.delete_fields item=field}
							<li>{$field}</li>
						{/foreach}
					</ol>
				{/if}
				{if is_array($changes.edit_fields) && count($changes.edit_fields)}
					<h3>{lng lng="update_fields"}:</h3>
					<ol>
						{foreach from=$changes.edit_fields item=field}
							<li>{$field}</li>
						{/foreach}
					</ol>
				{/if}
				{if is_array($changes.add_indexes) && count($changes.add_indexes)}
					<h3>{lng lng="add_indexes"}:</h3>
					<ol>
						{foreach from=$changes.add_indexes item=field}
							<li>{$field}</li>
						{/foreach}
					</ol>
				{/if}
				{if is_array($changes.delete_indexes) && count($changes.delete_indexes)}
					<h3>{lng lng="delete_indexes"}:</h3>
					<ol>
						{foreach from=$changes.delete_indexes item=field}
							<li>{$field}</li>
						{/foreach}
					</ol>
				{/if}
				{if is_array($changes.edit_indexes) && count($changes.edit_indexes)}
					<h3>{lng lng="update_indexes"}:</h3>
					<ol>
						{foreach from=$changes.edit_indexes item=field}
							<li>{$field}</li>
						{/foreach}
					</ol>
				{/if}
			{/foreach}
			</ol>
			{assign var="need_update" value=true}
		{/if}

		{if !$need_update}{lng lng="no_updates"}{/if}
	</div>
</form>