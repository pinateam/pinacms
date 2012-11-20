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



$request->filterParams("intval", "faq_id");

validateNotEmpty($request, 'faq_id', lng('internal_error'));

$request->trust();

require_once PATH_TABLES.'faq.php';
$faqGateway = new FaqGateway();
$question = $faqGateway->get($request->param('faq_id'));

$request->result('question', $question);
$request->result('faq_id', $request->param('faq_id'));

$request->result("question_statuses", array(
	array("value" => "Y", "caption" => lng('filter_yes'), "color" => "green"),
	array("value" => "N", "caption" => lng('filter_no'), "color" => "red"),
));

$request->addLocation(lng("faq_list"), href(array("action" => "faq.manage.home")));
$request->addLocation(lng("edit_faq_item"), href(array("action" => "faq.manage.edit")));

$request->setLayout('admin');
$request->ok();