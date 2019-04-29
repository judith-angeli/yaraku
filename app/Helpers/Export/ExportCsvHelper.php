<?php
namespace App\Helpers\Export;

class ExportCsvHelper implements ExportFileInterface
{
    private $data;
    private $filename;
    private $fields;

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
        array_unshift($data, $this->getFields());
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function export()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $this->getFilename() . '.csv";');

        $f = fopen('php://output', 'w');

        foreach ($this->getData() as $row) {
            fputcsv($f, $row);
        }

        exit;
    }
}