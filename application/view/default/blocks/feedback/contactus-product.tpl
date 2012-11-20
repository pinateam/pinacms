{lng lng="contact_us_form"}
{lng lng="user"}: "{$name}" {$user_email}
{if $product_id}
	{lng lng="product_id"}: {$product_id}
	{link action="product.view" product_id=$p.product_id}
{/if}


{lng lng="message"}:
{$message}