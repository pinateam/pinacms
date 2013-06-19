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



	require_once PATH_TABLES.'site.php';

	$accountId = $request->param("account_id")?$request->param("account_id"):Site::accountId();

	$data = $request->params("site_domain site_path site_template");
	$data["account_id"] = intval($accountId);

	if (!empty($data["site_domain"]) && strpos($data["site_domain"], ".") === false)
	{
		$data["site_domain"] = $data["site_domain"].".".SITE_HOST;
	}

	if (empty($data["site_path"]))
	{
		$data["site_path"] = str_replace(".", "-", $data["site_domain"]);
	}

	$site = new SiteGateway();

	$s = $site->getBy("site_domain", $data["site_domain"]);
	if (!empty($s))
	{
		$request->stop("Site is already exists", "site_domain");
	}

	$site->add($data);

	$request->ok();