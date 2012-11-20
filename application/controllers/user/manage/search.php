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
* @copyright � 2010 Dobrosite ltd.
*/

if (!defined('PATH')){ exit; }


	require_once PATH_MODEL.'finder/user.php';
	require_once PATH_CORE.'classes/Paging.php';

	$rules = $request->param("rules");
	Session::set("user_manage_search_rules", $rules);

	$paging = new Paging($request->param("page"), 10);

	// Задаем sorting
	$sort = $request->param('sort');
	$sort_up = $request->param('sort_up');
	$sorting = new Sorting($sort, $sort_up?"asc":"desc");
	
	$user = new UserFinder;
	$us = $user->search($rules, $sorting, $paging);

	$request->result("users", $us);
	$request->result("paging", $paging->fetch());
	$request->result("sorting", $sorting->fetch());

	$request->result("search_rules", $rules);

	$request->result("user_statuses", array(
	    array("value" => "active", "caption" => lng('enabled'), "color" => "green"),
	    array("value" => "disabled", "caption" => lng('disabled'), "color" => "red"),
	));

	$request->setLayout("admin");
	$request->ok();