<div class="field w50">
	<label for="person_enabled">{lng lng="status"}</label>
	{include file="skin/admin/splitter-input.tpl" name="person_enabled"  value=$person.person_enabled|default:'Y' items=$person_statuses}
</div>
<th>
	{include file="skin/admin/form-line-input.tpl" name="person_title" value=$person.person_title title="person_title"|lng}
</th>
<th>
	{include file="skin/admin/form-line-input.tpl" name="person_position" value=$person.person_position title="person_position"|lng}
</th>
<th>
	{include file="skin/admin/form-line-input.tpl" name="person_email" value=$person.person_email title="person_email"|lng}
</th>
<th>
	{include file="skin/admin/form-line-input.tpl" name="person_phone" value=$person.person_phone title="person_phone"|lng}
</th>

<div class="field">
	<label for="person_description"> {lng lng="description"}</label>
	<textarea name="person_description" class="html-text" rows="10" cols="50">{$person.person_description}</textarea>
</div>

