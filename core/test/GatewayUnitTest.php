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



        require_once PATH_DOMAIN .'unit_test.php';

        class GatewayUnitTest extends UnitTest
        {
                public function constructCondition($data)
                {
                        $first = true;
                        $result = '';
                        foreach ($data as $key=>$value)
                        {
                                if ($first)
                                        $first = false;
                                else
                                        $result .= "AND ";

                                $result .= "`".$key . "` = '".$this->db->escape($value)."'";
                        }
                        if ($first) return false;

                        return $result;
                }

                public function test($object, $function, $resultFunction)
                {
                        $this->currentNumberTest++;

                        $this->currentResult = call_user_method_array(
                                $function,
                                $object,
                                array_values($this->currentInput)
                        );

                        if($resultFunction == '')
                        {
                                $this->assertContainsAll(
                                        $this->currentResult, 
                                        $this->currentExpected, 
                                        $this->getMessage()
                                );
                        }
                        else
                        {
                                call_user_method(
                                        $resultFunction,
                                        $this
                                ); 
                        }
                }

                public function run()
                {
                        foreach($this->functions as $testData)
                        {
                                $this->assertions        = 0;
                                $this->currentNumberTest = 0;
                                $this->currentTestMethod = 'function ('. get_class($this) .') '. $testData['test_function'];
                                $this->failures = array();

                                $provider = call_user_method(
                                        $testData['provider'], 
                                        $this
                                );
                                foreach($provider as $data)
                                {
                                        $this->currentInput    = $data['input'];
                                        $this->currentExpected = $data['expected'];

                                        $this->test(
                                                $testData['object'],
                                                $testData['test_function'],
                                                $testData['result_function']
                                        );

                                        $result = $this->db->table("
                                                SELECT *
                                                FROM `cody_wishlist`
                                        ");//$this->clearDB();
                                        //echo print_r($result,1);//die;
                                }
                                $this->clearDB();
                                $this->printResult($provider);
                        }
                }
        }