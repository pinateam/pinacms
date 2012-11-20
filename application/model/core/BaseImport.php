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



    class BaseImport
    {
        var $inputCoding = 'cp1251';
        var $outputCoding = 'UTF-8';
        var $dir = './import/';
        var $db;
        var $fields = array();
        var $table = '';

        function __construct()
        {
            $this->db = getDB();
        }

        public function setDir($dir)
        {
            $this->dir = $this->dir . $dir;
        }

        protected function getDir()
        {
            return $this->dir;
        }

        public function setInputCoding($coding)
        {
            $this->inputCoding = $coding;
        }

        public function setOutputCoding($coding)
        {
            $this->outputCoding = $coding;
        }

        public function constructSetCondition($data, $isAdd = false)
        {
                $result = "SET ";

                /*if (is_array($this->fields) && in_array($this->table."_description", $this->fields) && !isset($data[$this->table."_description"]) && $isAdd)
                {
                        $data[$this->table."_description"] = '';
                }*/

                $first = true;

                foreach ($data as $key=>$value)
                {
                        if (is_array($this->fields) && !in_array($key, $this->fields))
                        {
                                continue;
                        }

                        if ($first)
                                $first = false;
                        else
                                $result .= ", ";

                        $result .= "`".$key . "` = '".$this->db->escape($value)."'";
                }
                if ($first) return false;

                return $result;
        }

        protected function readDir()
        {
            if(!is_dir($this->getDir())) return false;
            $dh  = opendir($this->getDir());
            $files = array();
            while (false !== ($filename = readdir($dh)))
            {
                if(($filename != '.') && ($filename != '..') && (!is_dir($this->getDir()."/".$filename)))
                {
                    $path_parts = pathinfo($this->getDir().'/'.$filename);
                    if($path_parts['extension'] == 'csv')
                        $files[] = $filename;
                }
            }
            return $files;
        }

        protected function myIconv($data)
        {
            if(!is_array($data) || $this->inputCoding == 'UTF-8') return $data;
            foreach($data as $key=>$str)
            {
                $data[$key] = iconv($this->inputCoding, $this->outputCoding, $data[$key]);
            }
            return $data;
        }

        protected function openFile($dir, $file)
        {
            return fopen($dir . DIRECTORY_SEPARATOR . $file, 'r');
        }

        public function import()
        {
            $files = $this->readDir();
            if(!is_array($files)) return false;

            foreach($files as $file)
            {
                $fp = $this->openFile($this->getDir(), $file);
                if (!$fp) continue;
                $i = 0;
                while (($row = fgetcsv($fp, 0, ";")) !== FALSE)
                {
                    if(!isset($row[2]) || empty($row[2]) || count($this->fields) != count($row)) continue;
                    
                    $data = array_combine($this->fields, $row);

                    $data = $this->myIconv($data);
                    $this->db->query($q="REPLACE INTO `".$this->table."`".$this->constructSetCondition($data, true));
                    $i++;
                }
                fclose($fp);
            }
            return $i;
        }
    }
