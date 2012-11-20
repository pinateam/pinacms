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



    require_once PATH_TABLES .'category_site.php';
    require_once PATH_TABLES .'product_site.php';
    require_once PATH_TABLES .'post.php';
    require_once PATH_MODEL .'finder/category.php';
    require_once PATH_MODEL .'finder/product.php';
    require_once PATH_MODEL .'finder/post.php';
    require_once PATH_CORE.'classes/Paging.php';

    class SitemapDomain
    {
        function __construct()
        {
	    $config = getConfig();
            $this->datebaseReadStep = 500;
            $this->sitemapMaxUrls = $config->get('xml_sitemap', 'max_urls')?$config->get('xml_sitemap', 'max_urls'):1000;
            $this->catFinder = new CategoryFinder();
            $this->prodFinder = new ProductFinder();
            $this->postFinder = new PostFinder();
            $this->paging = new Paging(0, $this->datebaseReadStep);
            $this->catSorting = new Sorting('category_id', "asc");
            $this->prodSorting = new Sorting('product_id', "asc");
            $this->postSorting = new Sorting('post_id', "asc");

            $this->fileName = 'index';
            $this->fp = false;
            
            $this->countUrls = 0;

            $cat = new CategorySiteGateway();
            $prod = new ProductSiteGateway();
            $post = new PostGateway();

            $this->types= array(
                'cats' => array(
                    'loc' => htmlentities(href(array("action" => "category.view", 'category_id' => ''))),
                    'priority' => $config->get('xml_sitemap', 'cat_priority')?$config->get('xml_sitemap', 'cat_priority'):0.8,
                    'count' => (int)$cat->reportCountBy('category_avail', 'Y'),
                ),
                'prods' => array(
                    'loc' => htmlentities(href(array('action' => 'product.view', 'product_id' => ''))),
                    'priority' => $config->get('xml_sitemap', 'prod_priority')?$config->get('xml_sitemap', 'prod_priority'):1,
                    'count' => (int)$prod->reporteCountBy('product_available', 'Y'),
                ),
                'posts' => array(
                    'loc' => htmlentities(href(array('action' => 'post.view', 'post_id' => ''))),
                    'priority' => $config->get('xml_sitemap', 'post_priority')?$config->get('xml_sitemap', 'post_priority'):0.5,
                    'count' => (int)$post->reportCountBy('site_id', Site::id()),
                )
            );
	    
            $this->countFiles = ceil(($this->types['cats']['count'] + $this->types['prods']['count'] + $this->types['posts']['count'] )/ $this->sitemapMaxUrls);

            @mkdir(PATH.'sitemap'.DIRECTORY_SEPARATOR);
            @mkdir(PATH.'sitemap'.DIRECTORY_SEPARATOR.Site::id().DIRECTORY_SEPARATOR);

            $this->dir = PATH .'sitemap'. DIRECTORY_SEPARATOR . Site::id() . DIRECTORY_SEPARATOR;
        }

        private function indexHeader()
        {
            gzwrite($this->fp, '<?xml version="1.0" encoding="UTF-8"?>');
            gzwrite($this->fp, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
        }

        private function indexFooter()
        {
            gzwrite($this->fp, '</sitemapindex>');
        }

        private function getData($type, $start)
        {
            $this->paging = new Paging(ceil($start/$this->datebaseReadStep) + 1, $this->datebaseReadStep);
            switch ($type)
            {
                case 'cats':
                    return $this->catFinder->searchIds(array('avail' => 'Y'), $this->catSorting, $this->paging);
                break;

                case 'prods':
                    return $this->prodFinder->searchIds(array('store' => array('only_available')), $this->prodSorting, $this->paging);
                break;

                case 'posts':
                    return $this->postFinder->searchIds(array(), $this->postSorting, $this->paging);
                break;
            }
            return false;
        }

        private function sitemapHeader()
        {
            gzwrite($this->fp, '<?xml version="1.0" encoding="UTF-8"?>');
            gzwrite($this->fp, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
            gzwrite($this->fp, '<url>');
        }

        private function sitemapFooter()
        {
            gzwrite($this->fp, '</url>');
            gzwrite($this->fp, '</urlset>');
        }

        private function checkCreateFile()
        {
            if($this->countFiles > 1 && $this->countUrls >= $this->sitemapMaxUrls)
            {
                $this->fileName++;
                $this->countUrls = 0;
                $this->closeFile();
                $this->createFile();
            }
        }

        private function createFile($type = '')
        {
            $this->fp = gzopen($this->dir . $this->fileName .'.xml.gz', 'w');
            if($type == 'index') $this->indexHeader();
            else $this->sitemapHeader();
        }

        private function closeFile($type = '')
        {
            if($type == 'index') $this->indexFooter();
            else $this->sitemapFooter();
            gzclose($this->fp);
        }

        private function generateIndexFile()
        {
            if($this->countFiles == 1) return;
            $this->fileName = 'index';
            $this->createfile('index');
            for($i = 1; $i <= $this->countFiles; $i++)
            {
                gzwrite($this->fp, '<sitemap>');
                gzwrite($this->fp, '<loc>'. htmlentities(Site::baseUrl(Site::id()) .'sitemap/'. Site::id() .'/'. $i .'.xml.gz') .'</loc>');
                gzwrite($this->fp, '<lastmod>'. date("Y-m-d") .'</lastmod>');
                gzwrite($this->fp, '</sitemap>');
            }
            $this->closeFile('index');
        }

        public function writeUrls($type, $ids)
        {
            if (!isset($this->types[$type]) || !is_array($ids)) return;

            $this->checkCreateFile();
            $this->countUrls += count($ids);

            foreach($ids as $id)
            {
                gzwrite($this->fp, '<loc>'. $this->types[$type]['loc'] .$id .'</loc>');
                gzwrite($this->fp, '<priority>'. $this->types[$type]['priority'] .'</priority>');
                gzwrite($this->fp, '<lastmod>'. date("Y-m-d") .'</lastmod>');
            }
        }

        function scanDir()
        {
            $list = scandir($this->dir);
            unset($list[0],$list[1]);
            return array_values($list);
        }

        // функция очищения папки
        function clearDir()
        {
            $list = $this->scanDir($this->dir);
            foreach ($list as $file)
            {
                if (is_dir($this->dir . $file))
                {
                    $this->clearDir($this->dir . $file . DIRECTORY_SEPARATOR);
                    rmdir($this->dir . $file);
                }
                else
                {
                    unlink($this->dir . $file);
                }
            }
        }

        public function generate()
        {
            $this->clearDir();

            if($this->countFiles == 1) $this->fileName = 'index';
            else $this->fileName = 1;
            $this->createFile();
            foreach($this->types as $type => $value)
            {
                for($start = 0; $start <= $this->types[$type]['count']; $start += $this->datebaseReadStep)
                {
                    $this->writeUrls($type, $this->getData($type, $start));
                }
            }
            $this->closeFile();

            $this->generateIndexFile();
        }
    }