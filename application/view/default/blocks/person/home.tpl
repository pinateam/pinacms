<h1>{lng lng="team"}</h1>
<div>	
	{foreach from=$persons item=person name=person}
	<div>
		{module action="image.image" image_id=$person.image_id class="alignleft" width=$config.image.person_photo_width|default:400}

		<h3>{$person.person_title}</h3>

		<p><strong>{$person.person_position}</strong></p>

		{$person.person_description|format_description}

		<hr class="clearer" />
	</div>
	{/foreach}
</div>