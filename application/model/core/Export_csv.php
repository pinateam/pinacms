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



    require_once PATH_TABLES .'subscription.php';

    class Export_csv
    {
        function __construct($relations, $dir)
        {
           $this->relations = $relations;
           $this->dir = $dir;
           $this->delimiter = ';';
        }

        function readDir()
        {
            if(!file_exists($this->dir))
                mkdir($this->dir);
            $dh  = opendir($this->dir);
            while (false !== ($filename = readdir($dh)))
            {
                if(($filename != '.') && ($filename != '..') && (!is_dir($this->dir."/".$filename)))
                {
                    $path_parts = pathinfo($this->dir.'/'.$filename);
                    if($path_parts['extension'] == 'csv')
                    {
                        $files[] = $filename;
                    }
                }
            }

            if(!empty($files))
            {
                $name_new_dir = date("YmdHis");
                mkdir($this->dir."/". $name_new_dir);
                $this->dir = $this->dir. "/". $name_new_dir;
            }
        }

        function writeFile()
        {
            foreach($this->relations as $table_name)
            {
                $obj = '';
                switch($table_name)
                {
                    case 'cody_subscription':
                        $obj = new SubscriptionGateway();
                    break;
                }

                if(!is_object($obj)) return false;

                $data = $obj->findAll();

                if(!is_array($data)) return false;
                
                $path_files[] =  $this->dir ."/". $table_name .".csv";
                $f = fopen($this->dir ."/". $table_name .".csv", "w");
                foreach($data as $value)
                {
                    fputcsv($f, $value, $this->delimiter);
                }
                fclose($f);
            }
            return $path_files;
        }
    }
