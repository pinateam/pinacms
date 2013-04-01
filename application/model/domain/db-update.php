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



        require_once PATH_DOMAIN .'table_update.php';

	class DBUpdateDomain
	{
		var $gatewayFiles = array();
		var $tables       = array();

		function __construct()
		{
                        $this->init();
                        
                        $this->db = getDB();
                        $this->tables = $this->db->col('SHOW TABLES');
                }
                
                private function init()
                {
                        $dh  = opendir(PATH_TABLES);
	                while (false !== ($filename = readdir($dh)))
	                {
	                        if(($filename == '.') || ($filename == '..') || (is_dir(PATH_TABLES . $filename)))
	                        {
	                                continue;
	                        }
                                
                                include_once PATH_TABLES.$filename;
                                
                                $table = 'cody_'. str_replace('.php', '', $filename);
                                $gatewayClassName = $this->getGatewayClassName($filename);

	                        $this->tableGatewayList[$table] = array(
                                    'filename' => $filename,
                                    'class_name' => $gatewayClassName
                                );
	                }
                }

		public function getGatewayClassName($filename)
		{
			$gatewayClassName = str_replace('.php', '', $filename) .'Gateway';
			$gatewayClassName = strtoupper($gatewayClassName{0}).substr($gatewayClassName, 1, strlen($gatewayClassName));

			while($pos = strpos($gatewayClassName, '_'))
			{
				$gatewayClassName = substr_replace($gatewayClassName, '', $pos, 1);
				$gatewayClassName{$pos} = strtoupper($gatewayClassName{$pos});
			}
			$gatewayClassName = str_replace('_', '', $gatewayClassName);

			return $gatewayClassName;
		}

		public function findAddTables()
		{
			return array_diff(array_keys($this->tableGatewayList), $this->tables);
		}

		public function findEditTables()
		{
                        $tables = array();
                        foreach($this->tableGatewayList as $table => $tableGateway)
                        {
                                if(!in_array($table, $this->tables))
                                {
                                       continue;
                                }
                                
                                $tableUpdateDomain = new TableUpdateDomain($tableGateway['class_name']);
                                $diff = $tableUpdateDomain->diff();
				if(is_array($diff) && count($diff))
				{
					$tables[$table] = $diff;
				}
                        }

			return $tables;
		}

	        public function update()
	        {
                        $addTables = $this->findAddTables();
                        if(is_array($addTables) && count($addTables) > 0)
                        {
                            foreach($addTables as $table)
                            {
                                    $tableUpdateDomain = new TableUpdateDomain($this->tableGatewayList[$table]['class_name']);
                                    $tableUpdateDomain->createTable();
                            }
                        }
                        
                        $editTables = $this->findEditTables();
                        foreach($editTables as $table => $value)
                        {
                                $tableUpdateDomain = new TableUpdateDomain($this->tableGatewayList[$table]['class_name']);
                                
                                $tableUpdateDomain->editTable();
                        }
	        }
	}