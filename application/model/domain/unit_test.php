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

            public function printStart($module)
            {
                    echo '..................................................<strong>Тестирование модуля '.$module.'</strong>..................................................<br />';
            }

            public function printEnd()
            {
                    echo '<br />..................................................<strong>Тестирование завершено</strong>...........................................................<br /><br />';
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
    
    
            public function writeError()
            {
                    $errorMessage = $this->currentTestMethod .'('. get_class($this) .') with data set #'. $this->currentNumberTest .'(';
                    foreach($this->currentInput as $field => $value)
                    {
                            $errorMessage .= $field .'='. $value .' ';
                    }
                    $errorMessage .= ')<br /> Failed asserting that <span style="color: red;" >'. $this->currentResult .'</span> matches expected value <span style="color: red;" >'. $this->currentExpected .'</span>';
                    $this->failures[] = $errorMessage;
            }

            public function printResult($tests)
            {
                    if(count($this->failures) > 0)
                    {
                            echo 'There was '. count($this->failures) ." failures:<br />\n";
                            foreach($this->failures as $key => $failure)
                            {
                                    echo $key + 1 .') '. $failure; echo "<br />\n";
                            }
                            echo 'FAILURES!<br />';
                            echo 'Tests: '. count($tests) .', Assertions: '. count($tests) .', Failures: '. count($this->failures);
                    }
                    else
                    {
                            echo 'OK ('. count($tests) .' test, '. count($this->assertions) .' assertion)';
                    }
                    
            }
    
            public function assertEquals($a, $b)
            {
                    $this->assertions++;
                    if($a == $b)
                    {
                            return true;
                    }
    
                    $this->writeError();                        
    
                    return false;
            }

    }