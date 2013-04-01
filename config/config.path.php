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



    define('PATH_CORE', PATH.'core/');

    define('PATH_CONTROLLERS', PATH.'application/controllers/');
    define('PATH_API', PATH.'application/api/');
    define('PATH_TABLES', PATH.'application/model/tables/');
    define('PATH_DOMAIN', PATH.'application/model/domain/');
    define('PATH_FILTERS', PATH.'application/filters/');
    define('PATH_MODEL', PATH.'application/model/');
    define('PATH_PAYMENT', PATH.'application/model/payment/');

    define('PATH_LAYOUTS', PATH.'application/layouts/');
    define('PATH_VIEW', PATH.'application/view/');
    define('PATH_DEBUG', PATH.'var/debug/');
    define('PATH_TEMP', PATH.'var/temp/');
    define('PATH_COMPILED_TEMPLATES', PATH.'var/compiled/');
    define('PATH_VAR_CACHE', PATH.'var/cache/');

    define('PATH_CACHE', PATH.'cache/');

    define('PATH_FILES', PATH.'../001-files/');

    define('PATH_TEST', PATH.'test/');
    define('PATH_CONTROLLER_TEST', PATH.'test/controller/');

    define('PATH_VALIDATION', PATH.'application/validation/');

    define('PATH_LIB', PATH.'lib/');
    define('SITE_LIB', SITE.'lib/');

    define('PATH_SMARTY', PATH_LIB.'smarty/');
    define('PATH_PHPMAILER', PATH_LIB.'phpmailer-lite/');

    define('PATH_ATTACHMENTS', PATH.'attachments/');
    define('SITE_ATTACHMENTS', SITE.'attachments/');

    define('PATH_IMAGES', PATH.'images/');
    define('SITE_IMAGES', SITE.'images/');

    define('SITE_STYLE', SITE.'style/');
    define('SITE_STYLE_IMAGES', SITE.'style/images/');
    define('SITE_CSS', SITE.'style/css/');
    define('SITE_CACHE', SITE.'cache/');
    define('SITE_JS', SITE.'js/');
