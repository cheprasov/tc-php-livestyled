<?php

namespace Refactor\Common\Storage;

class CSVStorage implements StorageInterface
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @param string $filename
     */
    public function __construct($filename, array $fields = [])
    {
        $this->filename = $filename;
        $this->fields = $fields;
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    protected function format($data)
    {
        if (!$data || !$this->fields) {
            return $data;
        }
        $result = [];
        foreach ($data as $i => $value) {
            $key = isset($this->fields[$i]) ? $this->fields[$i] : null;
            if ($key) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function getOne($id)
    {
        if (!$fp = fopen($this->filename, 'r')) {
            throw new \Exception("Could not open file {$this->filename}");
        }

        if (!flock($fp, LOCK_SH)) {
            throw new \Exception('Could not get the lock');
        }

        $result = null;

        while (($data = fgetcsv($fp, 0, ',')) !== false) {
            if ((int)$data[0] === $id) {
                $result = $data;
                break;
            }
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        return $this->format($result);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getList()
    {
        $list = [];
        if (!$file = file($this->filename)) {
            throw new \Exception("Could not open file {$this->filename}");
        }
        foreach ($file as $line) {
            if (!$line = trim($line)) {
                continue;
            }
            $list[] = $this->format(str_getcsv($line));
        }
        return $list;
    }
}
