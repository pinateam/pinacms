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



    require_once PATH_MODEL .'finder/post.php';
    require_once PATH_CORE.'classes/Paging.php';
    require_once PATH_CORE.'classes/Sorting.php';

    if (!$request->param("blog_id"))
    {
        $request->stop(lng("wrong_data_format"));
    }

    $sorting = new Sorting("post_created", "desc");
    $paging = new Paging($request->param('page'), $request->param("paging")?$request->param("paging"):10);

    $rules = array(
        "blog_id" => $request->param("blog_id"),
        "post_enabled" => 'Y'
    );

    $postFinder = new PostFinder();
    $ps = $postFinder->search($rules, $sorting, $paging);

    if(is_array($ps) && $request->param("separate_image"))
    foreach($ps as $key => $p)
    {
            preg_match('#<img\s+[^>]*?src\s*=\s*["\'`]?([^"\'`>]+)["\'`]?[^>]*>#i', $p['post_text'], $matches);
            $ps[$key]['img'] = $matches[1];
            $ps[$key]['post_text'] = preg_replace('#(<img[^>]*>)#', '', $p['post_text']);
    }

    $request->result("posts", $ps);
    $request->result('blog_id', $request->param("blog_id"));
    $request->result('paging', $paging->fetch());

    $request->addLocation($b['blog_title'], href(array("action" => "blog.view", "blog_id" => $blogId)));
    $request->ok();