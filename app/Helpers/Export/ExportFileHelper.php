<?php
namespace App\Helpers\Export;

class ExportFileHelper
{
    private $exporter;

    /**
     * @param string $file [csv|xml]
     * @param array $data
     * @param string $filename
     * @param array $fields
    */
    public function __construct(string $file, array $data, string $filename = 'file', array $fields = [])
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