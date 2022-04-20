<?php

namespace App\Services\Search;

class ArraySearch
{

    /*
     * array keys for search
     */
    private $keys;

    /*
     * search words
     */
    private $words;

    /*
     * array
     */
    private $data;

    public function addKeys($keys) {
        $this->keys = $keys;
    }

    public function addWords($words) {
        $this->words = $words;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function search()
    {
        foreach ($this->data as $key => $result) {
            $this->data[$key]['score'] = 0;
            foreach ($this->words as $word) {
                foreach ($this->keys as $searchKey) {
                    $pos = strpos($result[$searchKey], $word);
                    if (is_numeric($pos)){
                        $this->data[$key]['score'] = $this->data[$key]['score'] + 1;
                    }
                }
            }
        }

        usort($this->data, function($a, $b) {
            return $a['score'] <= $b['score'];
        });

        return $this->data;
    }

}