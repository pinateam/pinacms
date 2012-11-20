<script language="JavaScript">
{literal}
var PinaLng = {
	data: {},
	add: function(key, val)
	{
		this.data[key] = val;
	},
	lng: function(key)
	{
		if (this.data[key]) return this.data[key];
	}
}
{/literal}

PinaLng.add("request_sending_failed", "{lng lng="request_sending_failed"}");
PinaLng.add("are_you_sure_to_delete", "{lng lng="are_you_sure_to_delete"}");
PinaLng.add("action_executed", "{lng lng="action_executed"}");
PinaLng.add("please_wait_", "{lng lng="please_wait_"}");
PinaLng.add("information_has_been_deleted", "{lng lng="information_has_been_deleted"}");
PinaLng.add("information_has_been_saved", "{lng lng="information_has_been_saved"}");
</script>