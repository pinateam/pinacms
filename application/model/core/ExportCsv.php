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



    class ExportCsv
    {
        private $tables = array();
        private $dir = '';
        private $result_pathes = array();
        private $delimiter = ';';
        private $db;

        function __construct($tables)
        {
           $this->tables = $tables;
           $this->dir = PATH.'export';
           $this->db = getDB();
        }

        public function createDir()
        {
            if(!file_exists($this->dir))
                mkdir($this->dir);
                        
            return mkdir($this->dir = $this->dir ."/". date("YmdHis"));
        }

        public function array_to_csv($array)
        {
            $csv_arr = array();
            foreach ($array as $value)
            {
                if(empty($value)) {$csv_arr[] = '';continue;}
                $csv_arr[]='"'.preg_replace('/"/','""',$value).'"';
            }
            $csv_string=implode($this->delimiter,$csv_arr);

            return $csv_string;
        }

        public function export()
        {
            if(!$this->createDir()) return false;
            if(!is_array($this->tables)) return false;
            
            foreach($this->tables as $table_name)
            {
                $data = $this->db->table("SELECT * FROM `". $table_name ."`");

                if(!is_array($data)) return false;
                
                $f = fopen($this->result_pathes[] = $this->dir .DIRECTORY_SEPARATOR. $table_name .".csv", "w");
                if(!$f) return false;

                foreach ($data as $line)
                {
                    if(isset($line['directory_value']) && empty($line['directory_value'])) continue;
                    //fputcsv($f, $this->array_to_csv($line), $this->delimiter);
                    fwrite($f, $this->array_to_csv($line)."\r\n");
                }

                fclose($f);
            }
            return true;
        }

        public function getResult()
        {
            return $this->result_pathes;
        }
    }
