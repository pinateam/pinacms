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



$request->filterAllParams("strip_tags trim");
$request->filterParams("filter_only_y_n", "faq_group_enabled");

validateNotEmpty($request, "faq_group_title", lng('enter_title'));

require_once PATH_VALIDATION .'validation.url.php';
validateUrlNotUsed($request, 'faq-group.view', 'faq_group_id=');

$request->trust();

require_once PATH_TABLES .'faq_group.php';
$faqGroupGateway = new FaqGroupGateway();
$faq_group_id = $faqGroupGateway->add($request->params("faq_group_title faq_group_enabled"));

$request->set('url_action', 'faq-group.view');
$request->set('url_params', 'faq_group_id='.$faq_group_id);

$request->run('meta.manage.set');
$request->run('config.manage.url-set');

$request->set('menu_item_title', $request->param("faq_group_title"));
$request->set('menu_item_enabled', $request->param("faq_group_enabled"));
$request->run('menu.manage.set-show');

$request->setRedirect(href(array("action" => "faq-group.manage.edit", 'faq_group_id' => $faq_group_id)));
$request->ok();
