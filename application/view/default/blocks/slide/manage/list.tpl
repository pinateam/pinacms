<div class="table dnd">

	<ul class="thead">
		<li class="w10">{lng lng="act_"}</li>
		<li class="w30">{lng lng="image"}</li>
		<li class="w20">ALT</li>
		<li class="w20">{lng lng="link"}</li>
	</ul>

	<div class="tbody">
	    {foreach from=$slides item=s}
	    <ul class="tr slide-{$s.slide_id}" id="{$s.slide_id}">
		{block view="slide.manage.row" slide=$s}
	    </ul>
	    {foreachelse}
	    <ul class="tr no-dnd">
		<li class="w100">
			<center>{lng lng="list_is_empty"}</center>
		</li>
	    </ul>
	    {/foreach}
	</div>

</div>