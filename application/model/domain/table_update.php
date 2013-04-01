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



	class TableUpdateDomain
	{
		var $gatewayFiles = array();
		var $tables       = array();

		function __construct($gateway)
		{
                        $this->gateway = new $gateway;
                        $this->db = getDB();
		}
                
                public function constructField($field)
                {
			if (!is_array($this->gateway->fields[$field])) return $this->gateway->fields[$field];

                        $constructField = $this->gateway->fields[$field]['Type'].($this->gateway->fields[$field]['Null'] == 'NO' ? ' NOT NULL ' : ' NULL ');
                        if(isset($this->gateway->fields[$field]['Default']) && $this->gateway->fields[$field]['Default'] !== '')
                        {
                                if($this->gateway->fields[$field]['Default'] === 'CURRENT_TIMESTAMP')
                                {
                                        $constructField .= 'DEFAULT CURRENT_TIMESTAMP ';
                                }
                                else
                                {
                                        $constructField .= "DEFAULT '". $this->gateway->fields[$field]['Default'] ."'";
                                }
                        }
                    
                        if(isset($this->gateway->fields[$field]['Extra']) && $this->gateway->fields[$field]['Extra'] !== '')
                        {
                                $constructField .= $this->gateway->fields[$field]['Extra'];
                        }
                        
                        return $constructField;
                }

                public function createTable()
                {
                        if(isset($this->gateway->fields[0]) || !isset($this->gateway->engine))
                        {
                                return false;
                        }

                        $q = "CREATE TABLE IF NOT EXISTS `".$this->gateway->table."` (";
                        foreach($this->gateway->fields as $field => $params)
                        {
                                $q .= '`'. $field .'` '. $this->constructField($field) .', ';
                        }
                        foreach($this->gateway->indexes as $index => $params)
                        {
                                $q .= $this->constructIndex($index) .', ';
                        }
                        $q = rtrim($q, ', ') .') '. $this->gateway->engine .';';

                        return $this->db->query($q);
                }

		public function parseFieldDescription($descr)
		{
			#$descr = "timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP' on update CURRENT_TIMESTAMP";
			#echo $descr;
			preg_match
			(
				"/".
					"(\w+(\(.*\)(\s+UNSIGNED)?)?)".
					"(\s+(NOT NULL|NULL))?".
					"(\s+DEFAULT\s+'(.*)')?".
					"(\s+AUTO_INCREMENT)?".
				"/si",
				$descr, $matches
			);

			#print_r($matches);

			if (empty($matches[1])) return false;

			return array
			(
				"Type" => strtolower($matches[1]),
				"Null" => (!empty($matches[5]) && strcasecmp($matches[5], "NOT NULL") == 0)?"NO":"YES",
				"Default" => isset($matches[7])?$matches[7]:'',
				"Extra" => !empty($matches[8])?strtolower(trim($matches[8])):'',
			);

			print_r($r);exit;
		}

		public function createIndexesDescription($data)
		{
			if (empty($data) || !is_array($data)) return false;

			#echo "!!!";print_r($data);echo "???";

			$joined = array();
			foreach ($data as $item)
			{
				$title = '';
				if ($item["Key_name"] == "PRIMARY")
				{
					$title .= "PRIMARY KEY";
				}
				elseif ($item["Non_unique"] == 0)
				{
					$title .= "UNIQUE KEY ".$item["Key_name"];
				}
				elseif ($item["Non_unique"] == 1)
				{
					$title .= "KEY ".$item["Key_name"];
				}

				if (empty($joined[$title]))
				{
					$joined[$title] = $item["Column_name"];
				}
				elseif (is_array($joined[$title]))
				{
					$joined[$title][] = $item["Column_name"];
				}
				else
				{
					$joined[$title] = array($joined[$title], $item["Column_name"]);
				}
			}

			#print_r($joined);

			return $joined;
		}

                public function diff()
                {
                        if (empty($this->gateway->fields) || isset($this->gateway->fields[0]))
                        {
                                return false;
                        }

                        $diff = array();
                        $fieldParams = $this->db->table("SHOW COLUMNS FROM `".$this->gateway->table."`");
                        $fields = array();
                        foreach($fieldParams as $params)
                        {
                                $fields[] = $params['Field'];

                                if(!isset($this->gateway->fields[$params['Field']]))
                                {
                                    $diff['delete_fields'][] = $params['Field'];
                                    continue;
                                }

				$structured = $this->gateway->fields[$params['Field']];

				if (!is_array($structured))
				{
					$structured = $this->parseFieldDescription($this->gateway->fields[$params['Field']]);
				}

				#echo "<br /><br /><br />\r\n\r\n\r\n".$this->gateway->table."<br />";
				#print_r($this->gateway->table);
				#print_R($structured);
				#print_r($params);
				#print_r(array_diff($structured, $params));

                                if(count(array_diff($structured, $params)))
                                {
					#print_r($this->gateway->table);
					#print_R($structured);
					#print_r($params);
					#print_r(array_diff($structured, $params));
                                    $diff['edit_fields'][] = $params['Field'];
                                }
                        }

                        if($addFields = array_diff(array_keys($this->gateway->fields), $fields))
                        {
                                $diff['add_fields'] = $addFields;
                        }

			if (!isset($this->gateway->indexes))
                        {
                                return $diff;
                        }

                        $indexesParams = $this->db->table("SHOW INDEXES FROM `".$this->gateway->table."`");

			$indexesParams = $this->createIndexesDescription($indexesParams);
                        $indexes = array();
                        foreach($indexesParams as $title => $columns)
                        {
                                $indexes[] = $title;
                                if(!isset($this->gateway->indexes[$title]))
                                {
                                        $diff['delete_indexes'][] = $title;
                                        continue;
                                }

                                $index = $this->gateway->indexes[$title];
				if (!is_array($index)) $index = array($index);
				if (!is_array($columns)) $columns = array($columns);

                                if(count(array_diff($index, $columns)) || count(array_diff($columns, $index)))
                                {
                                        $diff['edit_indexes'][] = $title;
                                        continue;
                                }
                        }
                        if($addIndexes = array_unique(array_diff(array_keys($this->gateway->indexes), $indexes)))
                        {
                                $diff['add_indexes'] = $addIndexes;
                        }

                        foreach($diff as $key => $value)
                        {
                                $diff[$key] = array_unique($value);
                        }

                        return $diff;
                }

                public function constructIndex($indexName)
                {
			$index = '';
			if (is_array($this->gateway->indexes[$indexName]))
			{
				foreach($this->gateway->indexes[$indexName] as $field)
				{
					if (!empty($index)) $index .= ',';
					$index .= "`".$field .'`';
				}
			}
			else
			{
				$index .= $this->gateway->indexes[$indexName];
			}
                        return $indexName.'('.$index .')';
                }

                public function constructChanges($type, $data)
                {
                        $q = '';
                        foreach($data as $k => $v)
                        {
                                switch($type)
                                {
                                        case 'add_fields':
                                                $q .= ' ADD COLUMN `'. $v .'` '. $this->constructField($v) .', ';
                                        break;
                                        case 'delete_fields':
                                                $q .= ' DROP COLUMN `'. $v .'`, ';
                                        break;
                                        case 'edit_fields':
                                                $q .= ' MODIFY `'. $v .'` '. $this->constructField($v) .', ';
                                        break;
                                        case 'add_indexes':
                                                $q .= ' ADD '. $this->constructIndex($v) .', ';
                                        break;
                                        case 'delete_indexes':
                                                $q .= ' DROP '. str_replace("UNIQUE", "", $v) .', ';
                                        break;
                                        case 'edit_indexes':
                                                $q .= ' DROP '. str_replace("UNIQUE", "", $v) .', ADD '. $this->constructIndex($v) .', ';
                                        break;
                                        default:
                                                return false;
                                        break;
                                }
                        }

                    return $q;
                }

                public function editTable()
                {
                    $data = $this->diff();
                    if(!is_array(@$data) || !count(@$data))
                    {
                            return false;
                    }

                    $q = "ALTER TABLE `".$this->gateway->table."` ";
                    foreach($data as $type => $value)
                    {
                            $q .= $this->constructChanges($type, $value);	
                    }
                    $q = trim($q, ', ') .';';

		    #echo $q."<br />";

                    return $this->db->query($q);
                }
	}
