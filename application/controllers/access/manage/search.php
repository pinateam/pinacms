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


	require PATH_TABLES . "access.php";

	$rules = $request->param("rules");
	Session::set("access_manage_search_rules", $rules);

	$access = new AccessGateway();

	$as = array();

	if (!empty($rules["access_group_id"]) && $rules["access_group_id"] != "*")
	{
		$as = $access->findBy("access_group_id", $rules["access_group_id"]);
	} else {
		$as = $access->findAll();
	}

	$db = getDB();
	$ags = $db->table("SELECT access_group_id as value, access_group as caption FROM cody_access_group");
	$ags[] = array("value" => "*", "caption" => lng("filter_all"));
	$request->result("access_group_filter", $ags);

	$groups = array();
	foreach ($ags as $k => $v)
	{
		$groups[$v["value"]] = $v["caption"];
	}

	$request->result("groups", $groups);


	$request->result("access_statuses", array(
	    array("value" => "Y", "caption" => lng('enabled'), "color" => "green"),
	    array("value" => "N", "caption" => lng('disabled'), "color" => "red"),
	));

	$request->result("accesses", $as);
	$request->ok();