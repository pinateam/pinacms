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



$request->filterParams("intval", "faq_group_id");

validateNotEmpty($request, "faq_group_id", lng('wrong_data'));

$request->trust();

require_once PATH_TABLES.'faq_group.php';

$faqGroupGateway = new FaqGroupGateway();
$group = $faqGroupGateway->get($request->param('faq_group_id'));
$request->result('group', $group);

$request->result('faq_group_id', $request->param('faq_group_id'));

$request->result("group_statuses", array(
	array("value" => "Y", "caption" => lng('enabled'), "color" => "green"),
	array("value" => "N", "caption" => lng('disabled'), "color" => "red"),
));    

$request->addLocation(lng("faq_groups"), href(array("action" => "faq-group.manage.home")));
$request->addLocation(lng("edit_faq_group"), href(array("action" => "faq-group.manage.edit")));

$request->setLayout('admin');
$request->ok();