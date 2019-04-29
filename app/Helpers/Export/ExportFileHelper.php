<?php
namespace App\Helpers\Export;

class ExportFileHelper
{
    private $exporter;

    public function __construct($file, $toExport, $dataBuilder, $filename = 'file')
    {
        $data = $this->prepareData($toExport, $dataBuilder);

        switch ($file) {
            case 'csv':
                $this->exporter = new ExportCsvHelper();
                break;

            case 'xml':
                $this->exporter = new ExportXmlHelper();
                break;

            default:
                break;
        }

        $this->exporter->setFilename($filename);
        $this->exporter->setData($data['data'], $data['fields']);
    }

    public function prepareData($toExport, $dataBuilder)
    {
        switch ($toExport) {
            case 'title':
                $fields = ['title'];
                break;

            case 'author':
                $fields = ['forename', 'surname'];
                break;

            case 'title_author':
            default:
                $fields = ['title', 'forename', 'surname'];
                break;
        }

        $data = $dataBuilder->select($fields)
            ->get()
            ->toArray();

        return ['data' => $data, 'fields' => $fields];
    }

    public function export()
    {
        $this->exporter->export();
    }
}