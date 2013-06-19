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



require_once PATH_CORE.'classes/BaseFinder.php';
require_once PATH_CORE.'classes/ExtManager.php';

class StringFinder extends BaseFinder
{
	function search($rules, $sort, $sort_up, $paging)
	{
		$db = getDB();

		if (empty($rules["base_language_code"]) || empty($rules["language_code"]))
			return false;

		$this->addField("DISTINCT s.string_key");
		$this->addField("s2.language_code");
		$this->setFrom("cody_string s");

		$this->addField("s1.string_value as string_value_base");
		$this->addJoin("left", "cody_string s1", array(
		    "string_key" => array ("s" => "string_key"),
		    "language_code" => $rules["base_language_code"]
		));

		$this->addField("s2.string_value as string_value");
		$this->addJoin("left", "cody_string s2", array(
		    "string_key" => array ("s" => "string_key"),
		    "language_code" => $rules["language_code"]
		));

		if (!empty($rules["key"]))
		{
			$this->addWhere("s.string_key LIKE '%".$rules["key"]."%'");
		}

		if (!empty($rules["base_value"]))
		{
			$this->addWhere("s1.string_value LIKE '%".$rules["base_value"]."%'");
		}

		if (!empty($rules["value"]))
		{
			$this->addWhere("s2.string_value LIKE '%".$rules["value"]."%'");
		}

		if (!empty($rules["status"]) && $rules["status"] != "*")
		{
			if ($rules["status"] == "untranslated")
			{
				$this->addWhere("s2.string_value IS NULL OR s2.string_value = ''");
			}

			if ($rules["status"] == "translated")
			{
				$this->addWhere("s2.string_value IS NOT NULL AND s2.string_value <> ''");
			}

			if ($rules["status"] == "no-base-text")
			{
				$this->addWhere("s1.string_value IS NULL OR s1.string_value = ''");
			}
		}

		$sort = $db->escape($sort);
		if (!empty($sort))
		{
			$this->addOrderBy($sort.($sort_up?" ASC":" DESC"));
		}

		if (!empty($paging))
		{
			$paging->setTotal(
				$db->one(
					$this->constructSelect("DISTINCT s.string_key")
				)
			);
			$this->setPaging($paging);
		}
		$sql = $this->constructSelect();
		#echo $sql;
		return $db->table($sql);
	}
}