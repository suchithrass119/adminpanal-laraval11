<?php
namespace App\Helpers;

class SecurityHelper
{

    public function xss_strip($value)
    {
        $value = preg_replace('/(script|style).*?\/script/ius', '', $value) ? preg_replace('/script.*?\/script/ius', '', $value) : $value; // $value =preg_replace('/script.*?\/script/ius', '', $value)
        $value = preg_replace('#<a.*?>([^>]*)</a>#i', '$1', $value);
        return $value;
    }

    public function sql_strip($data)
    {
        // remove whitespaces from begining and end
        $data = trim($data);
        $data = str_ireplace(";", "", $data);
        $data = str_ireplace("--", "", $data);
        $data = str_ireplace("%", "", $data);
        $data = str_ireplace("'\'", "", $data);
        $data = str_ireplace("'", "", $data);
        $data = str_ireplace("*", "", $data);
        $data = str_ireplace("=", "", $data);
        $data = str_ireplace("+", "", $data);
        $data = str_ireplace("&", "", $data);
        $data = str_ireplace("&quot;", "", $data);
        $data = str_ireplace("&&", "", $data);
        $id = str_ireplace("OR", "", $data);
        $id = str_ireplace("AND", "", $data);
        $data = str_ireplace("SELECT", "", $data);
        $id = str_ireplace("UNION", "", $data);
        $data = pg_escape_string($data);
        return $data;
    }

    public function hostheader_validate($host_addr)
    {
        return 1; //Uncomment this to access this from other computers on the same network

        // $valid_host = ['localhost'];
        $host_addr = trim($host_addr);
        $valid_host = config('constants.host_headers');
        if (!in_array($host_addr, $valid_host)) {
            return 0;
        } else {
            return 1;
        }
    }
}
