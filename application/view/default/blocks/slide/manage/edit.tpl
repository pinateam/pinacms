<h1><span class="section-icon icon-blocks"></span> {lng lng="slide_editing"}</h1>

<form action="api.php" id="config_edit_form" method="POST">
<input type="hidden" name="action" value="slide.manage.edit" />
<input type="hidden" name="slide_id" value="{$slide.slide_id}" />

{block view="slide.manage.form"}