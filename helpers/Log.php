<?php

class Log
{
    public static function write($message)
    {
        $time = date("d.m.Y H:i:s");

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        file_put_contents('log.txt', "[$time] $ip: $message\n", FILE_APPEND);
    }
}