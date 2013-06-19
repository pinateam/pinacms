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


	require_once PATH_MODEL.'finder/string.php';
	require_once PATH_CORE.'classes/Paging.php';

	//TODO: выдели этот блок в отдельный класс по типовой обработке контроллеров
	$rules = $request->param("rules");

	if (empty($rules["base_language_code"])) $rules["base_language_code"] = 'ru';
	if (empty($rules["language_code"])) $rules["language_code"] = 'en';

	Session::set("string_manage_search_rules", $rules);
	$request->result("search_rules", $rules);

	$paging = new Paging($request->param("page"), 25);
	$sort = $request->param("sort");
	if (empty($sort))
	{
		$sort = "string_key";
	}
	$sort_up = intval($request->param("sort_up"));

	$string = new StringFinder;
	$ss = $string->search($rules, $sort, $sort_up, $paging);

	$request->result("sorting", array("field" => $sort, "direction" => $sort_up == "1"?"asc":"desc"));
	$request->result("strings", $ss);
	$request->result("paging", $paging->fetch());

	$request->ok();