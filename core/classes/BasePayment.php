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



    require_once PATH_TABLES.'payment.php';
    require_once PATH_TABLES.'temprorary_order.php';

    class BasePayment
    {
        function __construct()
        {
            $this->pay = new PaymentGateway;
            $this->temp_data = new TemproraryOrderGateway;
        }

        public function removeTempOrder($order_id)
        {
            $this->temp_data->remove($order_id);
        }

        public function addTempOrder($data)
        {
            $this->temp_data->add($data);
        }

        public function getParams($id)
        {
            return $this->temp_data->getParams($id);
        }

        protected function changeState()
        {
            
        }

        protected function culcControlSum()
        {
            
        }

        protected function getParamsAndController($id)
        {
            return $this->pay->getContollerAndParams($id);
        }
    }