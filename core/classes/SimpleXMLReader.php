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



/**
 * Simple XML Reader
 *
 * @license Public Domain
 * @author Dmitry Pyatkov(aka dkrnl) <dkrnl@yandex.ru>
 * @url http://github.com/dkrnl/SimpleXMLReader
 */
class SimpleXMLReader extends XMLReader
{

    /**
     * Callbacks
     *
     * @var array
     */
    protected $callback = array();

    /**
     * Add node callback
     *
     * @param  string   $name
     * @param  callback $callback
     * @param  integer  $nodeType
     * @return SimpleXMLReader
     */
    public function registerCallback($name, $callback, $nodeType = XMLREADER::ELEMENT)
    {
        if (isset($this->callback[$nodeType][$name])) {
            throw new Exception("Already exists callback $name($nodeType).");
        }
        if (!is_callable($callback)) {
            throw new Exception("Already exists parser callback $name($nodeType).");
        }
        $this->callback[$nodeType][$name] = $callback;
        return $this;
    }

    /**
     * Remove node callback
     *
     * @param  string  $name
     * @param  integer $nodeType
     * @return SimpleXMLReader
     */
    public function unRegisterCallback($name, $nodeType = XMLREADER::ELEMENT)
    {
        if (!isset($this->callback[$nodeType][$name])) {
            throw new Exception("Unknow parser callback $name($nodeType).");
        }
        unset($this->callback[$nodeType][$name]);
        return $this;
    }

    /**
     * Run parser
     *
     * @return void
     */
    public function parse()
    {
        if (empty($this->callback)) {
            throw new Exception("Empty parser callback.");
        }
        $continue = true;
        while ($continue && $this->read()) {
            if (isset($this->callback[$this->nodeType][$this->name])) {
                $continue = call_user_func($this->callback[$this->nodeType][$this->name], $this);
            }
        }
    }

    /**
     * Run XPath query on current node
     *
     * @param  string $path
     * @param  string $version
     * @param  string $encoding
     * @return array(SimpleXMLElement)
     */
    public function expandXpath($path, $version = "1.0", $encoding = "UTF-8")
    {
        return $this->expandSimpleXml($version, $encoding)->xpath($path);
    }

    /**
     * Expand current node to string
     *
     * @param  string $version
     * @param  string $encoding
     * @return SimpleXMLElement
     */
    public function expandString($version = "1.0", $encoding = "UTF-8")
    {
        return $this->expandSimpleXml($version, $encoding)->asXML();
    }

    /**
     * Expand current node to SimpleXMLElement
     *
     * @param  string $version
     * @param  string $encoding
     * @param  string $className
     * @return SimpleXMLElement
     */
    public function expandSimpleXml($version = "1.0", $encoding = "UTF-8", $className = null)
    {
        $element = $this->expand();
        $document = new DomDocument($version, $encoding);
        $node = $document->importNode($element, true);
        $document->appendChild($node);
        return simplexml_import_dom($node, $className);
    }

    /**
     * Expand current node to DomDocument
     *
     * @param  string $version
     * @param  string $encoding
     * @return DomDocument
     */
    public function expandDomDocument($version = "1.0", $encoding = "UTF-8")
    {
        $element = $this->expand();
        $document = new DomDocument($version, $encoding);
        $node = $document->importNode($element, true);
        $document->appendChild($node);
        return $document;
    }

}