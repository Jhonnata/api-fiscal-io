<?php

if (!function_exists('replace_accent')) {
    function replace_accent($string): string
    {
        $without_accent = array(
            'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', '' => 'Z', '' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ń' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ń' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f',
            'ă' => 'a', 'î' => 'i', 'â' => 'a', 'ș' => 's', 'ț' => 't', 'Ă' => 'A', 'Î' => 'I', 'Â' => 'A', 'Ș' => 'S', 'Ț' => 'T',
        );
        return strtr($string, $without_accent);
    }
}

if (!function_exists('array_sort')) {
    function array_sort($array, $on, $order = SORT_ASC): array
    {
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }
}

if (!function_exists('uuid')) {
    /**
     * Generate UUID string
     * @throws Exception
     */
    function uuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}

if (!function_exists('ellipsis')) {
    function ellipsis($text, $length = 30): string
    {
        if (strlen($text) > $length) {
            return substr(strip_tags($text), 0, $length) . '...';
        }
        return $text;
    }
}

if (!function_exists('removeSpecialChars')) {
    function removeSpecialChars($string): string
    {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $s = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = strtr($string, utf8_decode($a), $s);
        return utf8_decode($string);
    }
}

if (!function_exists('minifier')) {
    function minifier($code, $excludeRegexString = null)
    {
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/'
        );
        $replace = array('>', '<', '\\1');
        if (!empty($excludeRegexString)) {
            $excludeRegex = explode('|', $excludeRegexString);
            foreach ($excludeRegex as $exclude) {
                $search[] = '/' . $exclude . '/';
            }
        }
        return preg_replace($search, $replace, $code);
    }
}

if (!function_exists('rules')) {
    function rulesAccess($rules)
    {
        var_dump($rules);
    }
}

if (!function_exists('createDirectories')) {
    function createDirectories($directory, $rights = null)
    {
        $rights = $rights ?? 0777;
        $dirs = explode(DIRECTORY_SEPARATOR, $directory);
        $dir = '';
        foreach ($dirs as $part) {
            $dir .= $part . DIRECTORY_SEPARATOR;
            if (!is_dir($dir) && strlen($dir) > 0) {
                mkdir($dir, $rights);
            }
        }
    }
}

if (!function_exists('mask')) {
    function mask($val, $mask): string
    {
        $maskared = '';
        $k = 0;
        $val = str_replace('.', '', str_replace('-', '', $val));
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }
}

if (!function_exists('validateDate')) {
    /**
     * @throws Exception
     */
    function validateDate($date, $format): string
    {
        $date = str_replace('/', '-', $date);
        if (strlen($date) === 7) {
            $expDate = explode('-', $date);
            $year = (strlen($expDate[0]) === 4) ? $expDate[0] : $expDate[1];
            $month = (strlen($expDate[1]) !== 4) ? $expDate[1] : $expDate[0];
            $date = "{$year}-{$month}";
        }
        if (!strtotime($date)) {
            throw  new Exception('A data informada não está no formato correto');
        }
        return date($format, strtotime($date));
    }
}

if (!function_exists('validateCNPJ')) {
    function validateCNPJ($cnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string)$cnpj);
        if (strlen($cnpj) != 14) {
            return false;
        }
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
}

if (!function_exists('validateCpf')) {
    /**
     * @throws Exception
     */
    function validateCpf($cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        if (strlen($cpf) != 11) {
            return false;
        }
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('base64ImageCurl')) {
    /**
     * @throws Exception
     */
    function base64ImageCurl($url, $headers =[]): ?string
    {
        if (empty($url)) {
            return null;
        }
       // $headers = ["Origin: *"];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, base_url($url));
        $image = curl_exec($ch);
        curl_close($ch);
        if (!empty($image) && $image !== '{"status":401,"error":401,"messages":"Access denied!"}') {
            $mime_types = [
                'gif' => 'image/gif',
                'jpg' => 'image/jpg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
            ];
            $ext = pathinfo($url, PATHINFO_EXTENSION);
            $a = 'image/jpg';
            if (array_key_exists($ext, $mime_types)) {
                $a = $mime_types[$ext];
            }
            return "data:{$a};base64," . base64_encode($image);
        }
        return null;
    }
}

if (!function_exists('get_content')) {
    function get_content($filename): string
    {
        $handle = fopen($filename, 'r');
        $content = '';
        if ($handle) {
            while (!feof($handle)) {
                $content .= fread($handle, 8192);
            }
            fclose($handle);
        }
        return  $content;
    }
}