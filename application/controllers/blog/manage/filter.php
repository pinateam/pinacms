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



require_once PATH_TABLES .'blog.php';

$blogGateway = new BlogGateway();
$blogs = $blogGateway->findAll();
$filters = array();
foreach ($blogs as $blog)
{
	$filters[] = array(
		'value' => $blog['blog_id'],
		'caption' => $blog['blog_title'],
		'color' => 'orange'
	);
}

if($request->param('filter_all'))
{
	$filters[] = array('value' => '0', 'caption' => lng('static_pages'), 'color' => 'orange');
	$filters[] = array('value' => 'N', 'caption' => lng('filter_all'), 'color' => 'orange');
}
$request->result('filters', $filters);

$blogId = $request->param("blog_id");
$request->result('filter', (!empty($blogId)||($blogId==='0'))?$blogId:'N');

$request->ok();