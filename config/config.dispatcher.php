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



$config_dispatcher   = array();
$config_dispatcher[] = array('action' => 'home', 'pattern' => '');
$config_dispatcher[] = array('action' => 'user.enter', 'pattern' => 'enter');

$config_dispatcher[] = array('action' => 'product.view', 'pattern' => 'product-{product_id:any}');
$config_dispatcher[] = array('action' => 'category.view', 'pattern' => 'category-{category_id:any}');
$config_dispatcher[] = array('action' => 'category.view', 'pattern' => 'category-{category_id:any}-{page:any}');

$config_dispatcher[] = array('action' => 'post.view', 'pattern' => 'post-{post_id:num}');
$config_dispatcher[] = array('action' => 'page.view', 'pattern' => 'page-{page_id:num}');
#$config_dispatcher[] = array('action' => 'blog.posts', 'pattern' => 'news/', 'blog_id' => '1');
$config_dispatcher[] = array('action' => 'post.edit', 'pattern' => 'post/edit-{post_id:num}');
$config_dispatcher[] = array('action' => 'post.delete', 'pattern' => 'post-delete-{post_id:any}');
$config_dispatcher[] = array('action' => 'post.user', 'pattern' => 'post-list-{username:any}');
$config_dispatcher[] = array('action' => 'post.context-history', 'pattern' => 'my-last-added-posts');
$config_dispatcher[] = array('action' => 'work-group.view', 'pattern' => 'works-{work_group_id:num}');
$config_dispatcher[] = array('action' => 'work.view', 'pattern' => 'work-{work_id:num}');

$config_dispatcher[] = array('action' => 'feedback.contactus', 'pattern' => 'feedback');

$config_dispatcher[] = array('action' => 'sitemap.home', 'pattern' => 'sitemap');
$config_dispatcher[] = array('action' => 'person.home', 'pattern' => 'team');
$config_dispatcher[] = array('action' => 'work.home', 'pattern' => 'works');
$config_dispatcher[] = array('action' => 'faq.home', 'pattern' => 'faq');
$config_dispatcher[] = array('action' => 'vacancy.home', 'pattern' => 'vacancies');
$config_dispatcher[] = array('action' => 'company.address', 'pattern' => 'address');
$config_dispatcher[] = array('action' => 'gallery.home', 'pattern' => 'gallery');