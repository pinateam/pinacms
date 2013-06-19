<h1 class="shop-cat-title whereAmI">{lng lng="address"}</h1>
{include file="skin/form-head.tpl" class="register-address-form"}
<input type="hidden" name="action" value="user.register-address" />
{module action="user.register-address-form"}
{include file="skin/button.tpl" title="save"|lng}
</form>


{literal}
<script type="text/javascript">

$(".register-address-form").ajaxPageEdit(function(){
	location.reload();
});

</script>
{/literal}