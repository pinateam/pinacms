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



$order_statuses = array(
    "new" => "Новый",
    "canceled" => "Отменен",
    "accepted" => "Принят",
    "closed" => "Закрыт"
);

if (!empty($request)) $request->result("order_statuses", $order_statuses);

$payment_statuses = array(
    "new" => "Новый",
    "declined" => "Отклонен",
    "payed" => "Оплачен"
);

if (!empty($request)) $request->result("payment_statuses", $payment_statuses);

$shipping_statuses = array(
    "new" => "Новый",
    "sent" => "Отправлен",
    "returned" => "Вернулся",
    "delivered" => "Доставлен"
);

if (!empty($request)) $request->result("shipping_statuses", $shipping_statuses);


if (!empty($request))
$request->result("order_status_filter", array(
    array("value" => "new", "caption" => "Новый", "color" => "green"),
    array("value" => "canceled", "caption" => "Отменен", "color" => "black"),
    array("value" => "accepted", "caption" => "Принят", "color" => "red"),
    array("value" => "closed", "caption" => "Закрыт", "color" => "violet"),
    array("value" => "*", "caption" => "Не важно", "color" => "orange"),
));

if (!empty($request))
$request->result("payment_status_filter", array(
    array("value" => "new", "caption" => "Новый", "color" => "green"),
    array("value" => "declined", "caption" => "Отклонен", "color" => "black"),
    array("value" => "payed", "caption" => "Оплачен", "color" => "red"),
    array("value" => "*", "caption" => "Не важно", "color" => "orange"),
));

if (!empty($request))
$request->result("shipping_status_filter", array(
    array("value" => "new", "caption" => "Новый", "color" => "green"),
    array("value" => "sent", "caption" => "Отправлен", "color" => "red"),
    array("value" => "returned", "caption" => "Вернулся", "color" => "black"),
    array("value" => "delivered", "caption" => "Доставлен", "color" => "violet"),
    array("value" => "*", "caption" => "Не важно", "color" => "orange"),
));