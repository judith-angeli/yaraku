<?php
namespace App\Helpers\Export;

class ExportCsvHelper implements ExportFileInterface
{
    private $data;
    private $filename;
    private $fields;

    /**
     * @param string $filename
    */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
    */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param array $data
    */
    public function setData($data)
    {
        array_unshift($data, $this->getFields());
        $this->data = $data;
    }

    /**
     * @return array
    */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $fields
    */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return array
    */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Exports data to a CSV file
    */
    public function export()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $this->getFilename() . '.csv";');

        $f = fopen('php://output', 'w');

        foreach ($this->getData() as $row) {
            fputcsv($f, $row);
        }

        fclose($f);
    }
}