<?php
class DB
{
    var $conn = null;
    public $insert_id = 0;



    public function __construct($host, $user, $passwd, $dbname)
    {
        $this->conn = mysqli_connect($host, $user, $passwd, $dbname);
    }


    public function query($sql)
    {
        $query = mysqli_query($this->conn, $sql) or die('<pre>Error mysqli_query: ' . mysqli_error($this->conn) . '<br />' . $sql . '</pre>');

        if (preg_match("/^(insert|replace)\s+/i", $sql)) {
            $this->insert_id = @$this->conn->insert_id;
        }

        return $query;
    }

    public function insert($sql)
    {
        $query = mysqli_query($this->conn, $sql) or die('<pre>Error mysqli_query: ' . mysqli_error($this->conn) . '<br />' . $sql . '</pre>');
        return $query;
    }

    public function multipleinsert($sql)
    {
        $query = mysqli_multi_query($this->conn, $sql) or die('<pre>Error mysqli_query: ' . mysqli_error($this->conn) . '<br />' . $sql . '</pre>');
        return $query;
    }


    public function get_row($sql)
    {
        $query = $this->query($sql);
        return mysqli_fetch_object($query);
    }



    public function get_results($sql)
    {
        $query = $this->query($sql);
        $arr = array();
        while ($row = mysqli_fetch_object($query)) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_count($sql)
    {
        $query = $this->query($sql);
        return mysqli_num_rows($query);
    }


    public function get_var($sql)
    {
        $query = $this->query($sql);
        $row = mysqli_fetch_row($query);
        return $row[0];
    }
}
