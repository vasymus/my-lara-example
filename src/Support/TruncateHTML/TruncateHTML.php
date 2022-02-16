<?php

namespace Support\TruncateHTML;

class TruncateHTML
{
    public static function handleTruncate(string $html, int $limit): string
    {
        return static::restoreTags(
            static::truncateWords(
                $html,
                $limit
            )
        );
    }

    public static function restoreTags($input)
    {
        $opened = [];

        // loop through opened and closed tags in order
        if (preg_match_all("/<(\/?[a-z]+)>?/i", $input, $matches)) {
            foreach ($matches[1] as $tag) {
                if (preg_match("/^[a-z]+$/i", $tag, $regs)) {
                    // a tag has been opened
                    if (strtolower($regs[0]) != 'br') {
                        $opened[] = $regs[0];
                    }
                } elseif (preg_match("/^\/([a-z]+)$/i", $tag, $regs)) {
                    // a tag has been closed
                    $array = array_keys($opened, $regs[1]);
                    unset($opened[array_pop($array)]);
                }
            }
        }

        // close tags that are still open
        if ($opened) {
            $tagstoclose = array_reverse($opened);
            foreach ($tagstoclose as $tag) {
                $input .= "</$tag>";
            }
        }

        return $input;
    }

    public static function truncateWords($input, $numwords, $padding = "")
    {
        $output = strtok($input, " \n");
        while (--$numwords > 0) {
            $output .= " " . strtok(" \n");
        }
        if ($output != $input) {
            $output .= $padding;
        }

        return $output;
    }

    public static function myTruncate2($string, $limit, $break = " ", $pad = "...")
    {
        // return with no change if string is shorter than $limit
        if (strlen($string) <= $limit) {
            return $string;
        }

        $string = substr($string, 0, $limit);
        if (false !== ($breakpoint = strrpos($string, $break))) {
            $string = substr($string, 0, $breakpoint);
        }

        return $string . $pad;
    }
}
