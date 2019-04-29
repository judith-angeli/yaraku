<?php
namespace App\Helpers\Export;

class ExportFileHelper
{
    private $exporter;

    public function __construct($file, $data, $filename = 'file', $fields = [])
    {
        switch ($file) {
            case 'csv':
                $this->exporter = new ExportCsvHelper();
                $this->exporter->setFields($fields);
                break;

            case 'xml':
                $this->exporter = new ExportXmlHelper();
                break;

            default:
                break;
        }

        $this->exporter->setFilename($filename);
        $this->exporter->setData($data);
    }

    public function export()
    {
        $this->exporter->export();
    }
}