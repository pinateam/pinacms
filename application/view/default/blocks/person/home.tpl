<h1>{lng lng="team"}</h1>
<div>	
	{foreach from=$persons item=person name=person}
	<div>
		{if $person.person_photo_filename}
			<img
				src="{img img=$person.person_photo_filename type="person_photo"}"
				alt="{$person.person_title}"
				class="alignleft"
			/>
		{/if}

		<h3>{$person.person_title}</h3>

		<p><strong>{$person.person_position}</strong></p>

		{$person.person_description|format_description}

		<hr />
	</div>
	{/foreach}
</div>