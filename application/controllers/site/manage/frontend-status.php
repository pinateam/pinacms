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



	$config = getConfig();
	$frontend_status = $config->get("core", "frontend_status");
	if ($request->param("sid") && $request->param("sid") != Site::id())
	{
		$db = getDb();
		$siteId = intval($request->param("sid"));
		$frontend_status = $db->one($q = "SELECT config_value FROM cody_config WHERE site_id = '".$siteId."' AND config_key = 'frontend_status'");
	}

	$request->result("frontend_status", $frontend_status);

	$request->result("sid", $request->param("sid"));

	$request->result("frontend_status_list", array(
	    array("value" => "opened", "caption" => lng("open"), "color" => "green"),
	    array("value" => "closed", "caption" => lng("closed"), "color" => "red"),
	));

	$request->ok();