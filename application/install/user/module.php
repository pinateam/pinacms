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



require_once PATH_TABLES."access.php";
$accessGateway = new AccessGateway();
$accessGateway->put(array(
	"module_key" => "user.manage",
	"access_title" => lng_key("user_management"),
	"access_group_id" => 2,//admin
    	"access_enabled" => "Y"
));
$accessGateway->put(array(
	"module_key" => "user.manage",
	"access_title" => lng_key("user_management"),
	"access_group_id" => 3,//merchant
    	"access_enabled" => "Y"
));

require_once PATH_TABLES."user.php";
$userGateway = new UserGateway();
$userGateway->useAccountId = false;
$userAdmin = $userGateway->getBy("access_group_id", "2");
if (empty($userAdmin))
{
	$userAdmin = $userGateway->getBy("user_login", "admin");
}
if (empty($userAdmin))
{
	$userGateway->add(array(
	    
	    "account_id" => 0,
	    
	    "user_login" => "admin",
	    "user_password" => passwordHash("admin"),
	    "access_group_id" => 2,
	    "user_status" => 'active'
	));
}