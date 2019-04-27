<?php
namespace App\Helpers\Export;

class ExportCsvHelper implements ExportFileInterface
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

    public function setData($data, $headers = [])
    {
        array_unshift($data, $headers);
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
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