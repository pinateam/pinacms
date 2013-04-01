{if $request_errors}
	{foreach from=$request_errors item=m}
		<div class="error">
			{$m.message}{if $m.subject} ({$m.subject}){/if}
		</div>
	{/foreach}
{/if}

{if $request_warnings}
	{foreach from=$request_warnings item=m}
		<div class="warning">
			{$m.message}{if $m.subject} ({$m.subject}){/if}
		</div>
	{/foreach}
{/if}

{if $request_confirmations}
	{foreach from=$request_confirmations item=m}
		<div class="confirmation">
			{$m.message}
		</div>
	{/foreach}
{/if}