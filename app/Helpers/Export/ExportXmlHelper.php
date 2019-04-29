<?php
namespace App\Helpers\Export;

class ExportXmlHelper implements ExportFileInterface
{
    private $data;
    private $filename;

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setData($data)
    {
        $xml = new \SimpleXMLElement('<root/>');
        $parent = $xml->addChild('books');

        foreach ($data as $value) {
            $child = $parent->addChild('book');

            foreach ($value as $k => $v) {
                $child->addChild($k, $v);
            }
        }

        $this->data = $xml->asXML();
    }

    public function getData()
    {
        return $this->data;
    }

    public function export()
    {
        header('Content-type: text/xml');
        header('Cache-Control: no-store, no-cache');
        header('Content-Disposition: attachment; filename="' . $this->getFilename() . '.xml"');

        echo $this->getData();
        exit;
    }
}