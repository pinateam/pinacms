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



	require_once PATH_TABLES.'user.php';

	$request->result("user_statuses", array(
	    array("value" => "active", "caption" => lng('enabled'), "color" => "green"),
	    array("value" => "disabled", "caption" => lng('disabled'), "color" => "red"),
	));

	$user = new UserGateway;
	$u = $user->get($request->param("user_id"));

	if (!empty($u["access_group_id"]))
	{
		require_once PATH_TABLES."access_group.php";
		$accessGroupGateway = new AccessGroupGateway();
		$ag = $accessGroupGateway->get($u["access_group_id"]);
		$u["access_group"] = $ag["access_group"];
	}

	$request->result("user", $u);

	$request->setLayout('admin');
	$request->ok();