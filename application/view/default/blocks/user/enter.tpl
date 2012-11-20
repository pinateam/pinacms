{include file="skin/content-header.tpl" title="sign_in"|lng}
<table style="width:99%;border-top:none;">
<tr>
<td style="width:50%;">
{block view="user.login-form" redirect_action=$redirect_action}
</td>
<td style="vertical-align:middle;">
<p style="text-align:left;padding: 30px;">
    <a href="{if $redirect_action}{link action="user.register" redirect_action=$redirect_action}{else}{link action="user.register"}{/if}">{lng lng="register"} &#8594;</a>
</p>
</td>
</tr>
</table>