
	<div class="right-narrow-column">

		<fieldset class="operations">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				{if $user.user_id}
					<button class="css3 button-edit">{lng lng="save"}</button>
				{else}
					<button class="css3 button-add">{lng lng="create"}</button>
				{/if}
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>

			</div>
			{if $user.user_id}
			<div class="button-bar-2">
				<button class="css3 delete button-delete" sid="{$user.user_id}">{lng lng="delete"}</button>
			</div>
			{/if}
		</fieldset>

{*
		<fieldset>
			<h2>{lng lng="images"} <span class="icon-info" onclick="alert('This is help')"></span></h2>

			<div class="field">
				<label for="avatar">{lng lng="userpic"} <span class="icon-info" onclick="alert('This is help')"></span></label>
				<div class="image-selector">
					<div class="no-image">
						{lng lng="no_image_available"}
					</div>
				</div>
			</div>
		</fieldset>
*}

		<fieldset class="operations bottom">
			<h2>{lng lng="actions"}</h2>
			<div class="button-bar">
				{if $user.user_id}
					<button class="css3 button-edit">{lng lng="save"}</button>
				{else}
					<button class="css3 button-add">{lng lng="create"}</button>
				{/if}
				<button class="css3 additional button-cancel">{lng lng="cancel"}</button>

			</div>
			{if $user.user_id}
			<div class="button-bar-2">
				<button class="css3 delete button-delete" sid="{$user.user_id}">{lng lng="delete"}</button>
			</div>
			{/if}
		</fieldset>

	</div>

	<div class="left-wide-column">

		<fieldset>
			<h2>{lng lng="common_data"}</h2>

			{include file="skin/admin/form-line-input.tpl" name="user_login" value=$user.user_login title="login"|lng class="w50"}

			<div class="field w50">
				<label for="password">{lng lng="password"} <span class="icon-info" onclick="alert('{lng lng="user_edit_password_explanation"}')"></span></label>
				<input id="password" name="user_password" type="password" class="long-text" />
			</div>

			{include file="skin/admin/form-line-input.tpl" name="user_email" value=$user.user_email title="E-mail" class="w50"}

			<div class="field w50">
				{module action="user.manage.group-selector" value=$user.access_group_id}
			</div>
			<div class="field w50 user-status">
				<label for="user_status">{lng lng="status"} <span class="icon-info" onclick="alert('This is help')"></span></label>
				{include file="skin/admin/splitter-input.tpl" name="user_status" value=$user.user_status items=$user_status_editor}
			</div>
{*
			<div class="field w50">
				<label for="interface-lang">{lng lng="language"} <span class="icon-info" onclick="alert('This is help')"></span></label>
				<select id="interface-lang">
					<option>Русский</option>
					<option>Английский</option>
				</select>
			</div>
*}
		</fieldset>

		<fieldset>
			<h2>{lng lng="register_address"}</h2>

			{block view="user.manage.address" address=$user.register_address prefix="register_"}
		</fieldset>

		<fieldset>
			<h2>{lng lng="shipping_address"}</h2>

			<div class="field use-same-address">
				<input id="use_same_address" name="use_same_address" type="hidden" value="{if $user.shipping_address.address_id eq $user.register_address.address_id}same{else}other{/if}"/>
				<ul class="splitter">
					<li class="first orange"><a href="#" data-value="same" {if $user.shipping_address.address_id eq $user.register_address.address_id}class="selected"{/if}>{lng lng="same_as_register_address"}</a></li><li class="last orange"><a href="#" {if $user.shipping_address.address_id ne $user.register_address.address_id}selected="selected"{/if} data-value="other">{lng lng="address_other"}</a></li>
				</ul>

			{literal}
			<script language="JavaScript">
				$("div.use-same-address ul.splitter li a").click(function(){
					$("#use_same_address").val($(this).attr("data-value"));
					if ($(this).attr("data-value") == 'same')
					{
						$("#shipping_address_area").hide("medium");
					}
					else
					{
						$("#shipping_address_area").show("medium");
					}
					return false;
				});
			</script>
			{/literal}
			</div>

			<div id="shipping_address_area" {if $user.shipping_address.address_id eq $user.register_address.address_id}style="display:none"{/if}>
			{block view="user.manage.address" address=$user.shipping_address prefix="shipping_"}
			</div>
		</fieldset>

	</div>

{literal}
<script type="text/javascript">

$(document).ready(function(){
	$('#user_edit_form').managePage({
		api_delete: "user.manage.delete",
		object: "user"
	});
});

</script>
{/literal}