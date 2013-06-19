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



$order_statuses = array(
    "new" => lng("new"),
    "canceled" => lng("order_status_canceled"),
    "accepted" => lng("order_status_accepted"),
    "closed" => lng("order_status_closed")
);

if (!empty($request)) $request->result("order_statuses", $order_statuses);

$payment_statuses = array(
    "new" => lng("new"),
    "declined" => lng("order_status_declined"),
    "payed" => lng("order_status_payed"),
);

if (!empty($request)) $request->result("payment_statuses", $payment_statuses);

$shipping_statuses = array(
    "new" => lng("new"),
    "sent" => lng("order_status_sent"),
    "returned" => lng("order_status_returned"),
    "delivered" => lng("order_status_delivered"),
);

if (!empty($request)) $request->result("shipping_statuses", $shipping_statuses);


if (!empty($request))
$request->result("order_status_filter", array(
    array("value" => "new", "caption" => lng("new"), "color" => "green"),
    array("value" => "canceled", "caption" => lng("order_status_canceled"), "color" => "black"),
    array("value" => "accepted", "caption" => lng("order_status_accepted"), "color" => "red"),
    array("value" => "closed", "caption" => lng("order_status_closed"), "color" => "violet"),
    array("value" => "*", "caption" => lng("filter_all"), "color" => "orange"),
));

if (!empty($request))
$request->result("payment_status_filter", array(
    array("value" => "new", "caption" => lng("new"), "color" => "green"),
    array("value" => "declined", "caption" => lng("order_status_declined"), "color" => "black"),
    array("value" => "payed", "caption" => lng("order_status_payed"), "color" => "red"),
    array("value" => "*", "caption" => lng("filter_all"), "color" => "orange"),
));

if (!empty($request))
$request->result("shipping_status_filter", array(
    array("value" => "new", "caption" => lng("new"), "color" => "green"),
    array("value" => "sent", "caption" => lng("order_status_sent"), "color" => "red"),
    array("value" => "returned", "caption" => lng("order_status_returned"), "color" => "black"),
    array("value" => "delivered", "caption" => lng("order_status_delivered"), "color" => "violet"),
    array("value" => "*", "caption" => lng("filter_all"), "color" => "orange"),
));