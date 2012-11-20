<?php
/*
* PinaCMS
* 
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
* "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
* LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
* A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
* OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
* SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
* LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
* DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
* THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
* OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* @copyright © 2010 Dobrosite ltd.
*/

if (!defined('PATH')){ exit; }



    require_once PATH_TABLES.'product.php';
    require_once PATH_DOMAIN.'cart.php';

    $cart = new CartDomain;
    $product = new ProductGateway;

    $product_id = $request->param('product_id');
    $order_product_amount = $request->param('order_product_amount');
    $options = $request->param('options');
	
	$config = getConfig();
	
	if ($product->reportIsEgood($product_id))
	{
		$product_egood = 'Y';
		
		if ($config->get('egood', 'allow_egood_amount_select') != 'Y')
		{
			$order_product_amount = 1;
		}
	}
	else
	{
		$product_egood = 'N';
	}
    
    if (!$product->reportIsAvailable($product_id, $order_product_amount + $cart->addedProductAmount($product_id)))
    {
        $request->error(lng("product_disabled"));
    }
    $request->trust();
    
    $cart->add($product_id, $options, $order_product_amount, $product_egood);

    if ($config->get("order", "redirect_customer_to_cart") == "Y")
    {
	$request->setRedirect(href(array("action" => "order.cart")));
    }
    $request->ok();
