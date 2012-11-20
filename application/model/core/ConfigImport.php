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



    require_once './application/model/core/BaseImport.php';

    class ConfigImport extends BaseImport
    {

        private function bingoCondition($config_group, $myrow_array)
        {
                $bingo = 0;
                foreach($config_group as $key => $value)
                {
                    if($key == $myrow_array[7])
                    {
                        $bingo = 1;
                    }
                }
                return $bingo == 0;
        }

        public function import()
        {

            die("deprecated");
            $files = $this->readDir($this->getDir());

            if(is_array($files))
            {
                $config_group = array();
                $db = getDB();
                $db->query("DELETE FROM cody_config");
                $db->query("DELETE FROM cody_config_directory");
                $db->query("DELETE FROM cody_config_group");
                $i = 0;

                foreach($files as $fvalue)
                {
                    $fp = $this -> readOfFile($dir, $fvalue);
                    if (!$fp) continue;
                        while (!feof($fp))
                        {
                            $myrow = $this -> readRowInFile($fp);
                            if(empty($myrow)) continue;

                            $myrow_array = explode(';', $myrow);
                            if(
                                    (count($config_group) > 0 && $this->bingoCondition($config_group, $myrow_array))
                                    || count($config_group) < 0
                            )
                            {
                                    $config_group[$myrow_array[7]]['start'] = 0;
                                    $config_group[$myrow_array[7]]['end'] = 0;
                                    $config_group[$myrow_array[7]]['site_id'] = $myrow_array[0];
                                    $config_group[$myrow_array[7]]['module_key'] = $myrow_array[1];
                            }

                        }
                    fclose($fp);
                }

                foreach($files as $fvalue)
                {
                    $fp = $this -> readOfFile($dir, $fvalue);
                    if ($fp)
                    {
                        while (!feof($fp))
                        {
                            $myrow = $this -> readRowInFile($fp);
                            if(!empty($myrow))
                            {
                                $myrow_array = explode(';', $myrow);
                                $i++;
                                if(!empty($myrow_array[0]))
                                {

                                    foreach($config_group as $key => $value)
                                    {
                                        if($myrow_array[7] == $key)
                                        {
                                            if($config_group[$myrow_array[7]]['start'] == 0)
                                                $config_group[$myrow_array[7]]['start'] = $i;
                                            $config_group[$myrow_array[7]]['end'] = $i;
                                        }
                                    }

                                    $db->query("INSERT INTO cody_config
                                                SET site_id='$myrow_array[0]',
                                                module_key='$myrow_array[1]',
                                                config_key='$myrow_array[2]',
                                                config_value='$myrow_array[3]',
                                                config_type='$myrow_array[4]',
                                                config_title='$myrow_array[5]',
                                                config_description='$myrow_array[6]',
                                                config_order = '$i'
                                               ");

                                    $db->query("INSERT INTO cody_config_directory
                                                SET config_module_key='$myrow_array[1]',
                                                config_key='$myrow_array[2]',
                                                directory_module_key='$myrow_array[8]',
                                                directory_key='$myrow_array[9]'
                                               ");
                                }
                            }
                        }
                        echo "Данные из файла ". $fvalue ." загружены!<br />";
                    }
                    else echo "Ошибка при открытии файла";
                    fclose($fp);
                }
            }
        }
    }
