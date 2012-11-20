
<div id="slides">
<div class="slides_container">
{foreach from=$slides item=slide name=slides}
	{block view="slide.item" slide=$slide}
{assign var="cnt" value=$smarty.foreach.slides.total}
{/foreach}
</div>
</div>

{literal}
<script type="text/javascript">
$(function(){
{/literal}
	$('#slides ul.pagination').css("width", ({$cnt}*14)+"px");
{literal}
});
</script>
{/literal}