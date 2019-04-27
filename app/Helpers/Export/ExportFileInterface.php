<?php
namespace App\Helpers\Export;


interface ExportFileInterface
{
    public function setFilename($filename);
    public function getFilename();
    public function setData($data);
    public function getData();
    public function export();
}