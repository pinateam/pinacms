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



    include_once PATH_CORE."request/TestRequest.php";

    class UnitTest
    {   
            var $failures = array();
            var $currentTestMethod = '';
            var $currentNumberTest = 0;
            var $assertions = 0;

            function init()
            {
                    $this->db = getDB();
            }

            public function clearDB()
            {
                $tables = array(
                        'cody_import',
                        'cody_import_category',
                        'cody_category_type',
                        'cody_category_type_site',
                        'cody_category',
                        'cody_category_site',
                        'cody_category_logo',
                        'cody_product_type',
                        'cody_product',
                        'cody_product_site',
                        'cody_product_description',
                        'cody_product_category',
                        'cody_product_image_large',
                        'cody_product_image_small',
                        'cody_wishlist'
                );

                $db = getDB();
                foreach($tables as $table)
                {//echo 'TRUNCATE TABLE `'.$table.'` <br />';
                        $db->query("
                                TRUNCATE TABLE `".$table."`
                        ");
                }
            }

            public function getMessage()
            {
                    $errorMessage = $this->currentTestMethod .'('. get_class($this) .') with data set #'.$this->currentNumberTest .'('. print_r($this->currentInput, 1). ')';
                    $errorMessage .= '<br /> Failed asserting that <span style="color: red;" >('. print_r($this->currentResult, 1) .')</span> matches expected value <span style="color: red;" >'. print_r($this->currentExpected, 1) .'</span>';
                    
                    return $errorMessage;
            }

            public function test($action, $data)
            {
                    $result = '';
                    try
                    {
                            $request = new TestRequest($data);
                            $request->run($action);
                    }
                    catch (Exception $e)
                    {
                            $result = $e->getMessage();
                    }

                    return $result;
            }

//TODO: придумать соответствующее название, ведь проверка не совсем на эквивалентность, а скорее на включение одного
//массива в другой
            static function isArrayEquals($a, $b)
            {
                    if (!is_array($a)) return false;
                    $error = false;
                    foreach($a as $k => $v)
                    {
                            if(isset($b[$k]) && $b[$k] != $v)
                            {
                                    $error = true;
                            }
                    }
                    return $error;
            }

            public function printResult($tests)
            {
                    echo '<strong>TEST '. $this->currentTestMethod .'</strong>';
                    echo '<br />';
                    if(count($this->failures) > 0)
                    {
                            echo 'There was '. count($this->failures) ." failures:<br />\n";
                            foreach($this->failures as $key => $failure)
                            {
                                    echo $key + 1 .') '. $failure; echo "<br />\n";
                            }
                            echo 'FAILURES!<br />';
                            echo 'Tests: '. count($tests) .', Assertions: '. $this->assertions .', Failures: '. count($this->failures);
                    }
                    else
                    {
                            echo 'OK ('. count($tests) .' test, '. $this->assertions .' assertion)';
                    }
                    echo '<br /><br />';                    
            }
    
            public function assertEquals($a, $b, $message = '')
            {
                    $this->assertions++;
                    if($a == $b)
                    {
                            return true;
                    }

                    $this->failures[] = $message;
                    return false;
            }

            //возвращает false, если array не содержит key
            public function assertArrayHasKey($key, $array, $message = '')
            {
                    $this->assertions++;
                    if(array_key_exists($key, $array))
                    {
                            return true;
                    }
                    $this->failures[] = $message;
                    return false;
            }

            //возвращает false, если в массиве hqystack отсутствует значение needle
            public function assertContains($needle, $haystack, $message = '')
            {
                    $this->assertions++;
                    if(array_search($key, $array))
                    {
                            return true;
                    }
                    $this->failures[] = $message;
                    return false;
            }

            public function assertArrayHasHaystack($array, $haystack, $message = '')
            {
                    
                    foreach($haystack as $key => $value)
                    {
                            if(!isset($array[$key]) || $array[$key] != $haystack[$key])
                            {
                                    $this->failures[] = $message;
                                    return false;
                            }

                            if(is_array($array[$key]) && is_array($haystack[$key]) && !$this->assertArrayHasHaystack($array[$key], $haystack[$key]))
                            {
                                    $this->failures[] = $message;
                                    return false;
                            }
                    }

                    return true;
            }

            public function assertContainsAllAll($array, $haystack)
            {
                    if(count($array, 1) != count($haystack, 1))
                    {
                           return false;
                    }
                    foreach($array as $key => $value)
                    {
                            if(!isset($haystack[$key]) || $array[$key] != $haystack[$key])
                            {
                                    return false;
                            }

                            if(is_array($array[$key]) && is_array($haystack[$key]) && !$this->assertContainsAllAll($array[$key], $haystack[$key]))
                            {
                                    return false;
                            }
                    }

                    return true;
            }

            public function assertContainsAll($array, $haystack, $message = '')
            {
                    $this->assertions++;

                    #echo "RESULT";
                    #print_r($array);
                    #echo "EXPECTED";
                    #print_r($haystack);

                    /*if(count(array_diff($array, $haystack)) == 0 && count(array_diff_key($array, $haystack)) == 0)
                    {
                            return true;
                    }*/

                    if($this->assertContainsAllAll($array, $haystack))
                    {
                            return true;
                    }
                    
                    $this->failures[] = $message;
                    return false;
            }
    }