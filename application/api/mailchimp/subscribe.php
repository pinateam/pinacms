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



require_once PATH_TABLES .'address.php';
$addressGateway = new AddressGateway;
$a = $addressGateway->get(Session::get("auth_user_id"));

$vars = array(
	'FName' => isset($a['address_firstname']) ? $a['address_firstname'] : '',
	'LName' => isset($a['address_lastname']) ? $a['address_lastname'] : '',
	'email' => $request->param('subscription_email'),
	'phone' => $a['address_phone'],
	'website' => '',
	'address' => array(
		'addr1'   => $a['address_title'],
		'city'    => $a['address_city'],
		'state'   => $a['address_state_key'],
		'zip'     => $a['address_zip'],
		'country' => $a['address_county']
	)
);

$config = getConfig();
$apikey = $config->get("mailchimp", "apikey");
$listid = $config->get("mailchimp", "listid");

if (!empty($apikey) && !empty($listid))
{
	require_once PATH_LIB .'mailchimp/MCAPI.class.php';
	$mcapi = new MCAPI($apikey);
	$r = $mcapi->listSubscribe($listid, $request->param('subscription_email'), $vars);

	if ($mcapi->errorCode) $request->error(lng('error'));
}

 