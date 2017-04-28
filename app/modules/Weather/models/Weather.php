<?php
class Weather extends Model
{
    public function log($value='')
    {
        echo 'log';
        var_dump(get_parent_class($this));
    }

    public function getUsers()
    {
//        $conn = $this->readServer()->connect();

        $conn = $this->connect([]);
        var_dump($conn);
    }
}
