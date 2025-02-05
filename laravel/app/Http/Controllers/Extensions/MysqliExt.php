<?php

namespace App\Http\Controllers\Extensions;

class MysqliExt
{

    public function query()
    {
        $mysqli = new \mysqli("mysql", "user", "secret", "sandbox");
        if ($result = $mysqli->query("SELECT * FROM users LIMIT 5")) {
            $result->free_result();
        }
        $mysqli->close();

        return ['success' => true];
    }

    public function accessDenied()
    {
        new \mysqli("mysql", "user", "wrongpowd", "sandbox");
    }

}
