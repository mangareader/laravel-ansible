<?php
/**
 * Created by PhpStorm.
 * User: hieunt
 * Date: 2/2/16
 * Time: 11:24 AM
 */
namespace App\Libraries;

class Utils
{
    const PRE_NONE = 0;
    const PRE_INFO = 1;
    const PRE_ERROR = 2;
    const PRE_CHANGED = 3;

    public static function print_pre($msg, $type = self::PRE_NONE)
    {
        $s = "";
        $e = "</span>";
        switch ($type) {
            case self::PRE_INFO:
                $s = '<span style="color:green">';
                break;
            case self::PRE_ERROR:
                $s = '<span style="color:red">';
                break;
            case self::PRE_CHANGED:
                $s = '<span style="color:yellow">';
                break;
        }
        return $s . $msg . $e;
    }

    public static function println_pre($msg, $type = self::PRE_NONE)
    {
        return self::print_pre($msg, $type) . "\n";
    }

    public static function output($request)
    {
        $msg = "";
        switch ($request->name) {
            case "on_start":
                $msg .= "On Start\n";
                break;
            case "play_start":
                $msg .= str_pad("PLAY [$request->pname] ", 90, "*") . "\n\n\n";
                $msg .= str_pad("GATHERING FACTS ", 90, "*") . "\n";
                break;
            case "task_start":
                $msg .= str_pad("\nTASK: [$request->tname] ", 90, "*") . "\n";
                break;
            case "ok":
                if ($request->changed == "True")
                    $msg .= self::print_pre("changed:  [$request->host]", self::PRE_CHANGED);
                else
                    $msg .= self::print_pre("ok:  [$request->host]", self::PRE_INFO);
                break;
            case "unreachable":
                $msg .= self::print_pre("fatal: [$request->host] => $request->res", self::PRE_ERROR);
                break;
            case "failed":
                $msg .= self::print_pre("failed: [$request->host] => $request->res", self::PRE_ERROR);
                break;
            case "skipped":
                $msg .= self::print_pre("skipped: [$request->host]", self::PRE_INFO);
                break;
            case "on_stats":
                $msg .= str_pad("\nPLAY RECAP ", 90, "*") . "\n";
                $data = json_decode($request->data);
                foreach ($data as $item) {
                    $msg .= str_pad($item->host, 30) . ":   ";
                    $msg .= self::print_pre(str_pad("ok=" . ($item->ok ? $item->ok : "0"), 15), $item->ok ? self::PRE_INFO : self::PRE_NONE);
                    $msg .= self::print_pre(str_pad("changed=" . ($item->changed ? $item->changed : "0"), 15), $item->changed ? self::PRE_CHANGED : self::PRE_NONE);
                    $msg .= self::print_pre(str_pad("unreachable=" . ($item->dark ? $item->dark : "0"), 15), $item->dark ? self::PRE_ERROR : self::PRE_NONE);
                    $msg .= self::print_pre(str_pad("failed=" . ($item->failures ? $item->failures : "0"), 15), $item->failures ? self::PRE_ERROR : self::PRE_NONE);
                    $msg .= "\n";
                }
                break;
        }
        return $msg;
    }
}