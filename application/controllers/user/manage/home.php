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



	$rules = Session::get("user_manage_search_rules");
	$request->result("search_rules", $rules);

	$db = getDB();
	$ags = $db->table("SELECT access_group_id as value, access_group as caption FROM cody_access_group");
	$ags[] = array("value" => "*", "caption" => lng('filter_all'));
	$request->result("access_group_filter", $ags);

	$request->result("user_status_filter", array(
	    array("value" => "active", "caption" => lng('enabled'), "color" => "green"),
	    array("value" => "disabled", "caption" => lng('disabled'), "color" => "red"),
	    array("value" => "*", "caption" => lng('filter_all'), "color" => ""),
	));

	$request->setLayout('admin');
	$request->ok(lng("users"));