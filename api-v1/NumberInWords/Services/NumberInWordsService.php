<?php

namespace API\NumberInWords\Services;
class NumberInWordsService
{

    private array $units = [
        "",
        "um",
        "dois",
        "três",
        "quatro",
        "cinco",
        "seis",
        "sete",
        "oito",
        "nove"
    ];
    private array $tens = [
        "",
        "dez",
        "vinte",
        "trinta",
        "quarenta",
        "cinquenta",
        "sessenta",
        "setenta",
        "oitenta",
        "noventa"];
    private array $specials = [
        "",
        "onze",
        "doze",
        "treze",
        "catorze",
        "quinze",
        "dezesseis",
        "dezessete",
        "dezoito",
        "dezenove"
    ];
    private array $hundreds = [
        "",
        "cento",
        "duzentos",
        "trezentos",
        "quatrocentos",
        "quinhentos",
        "seiscentos",
        "setecentos",
        "oitocentos",
        "novecentos"
    ];
    private array $thousands = [
        "",
        "mil",
        "milhão",
        "bilhão",
        "trilhão",
        "quadrilhão",
        "quintilhão"
    ];

    /**
     * Return the number in full.
     * @param $number
     * @return string
     */
    public function translate($number): string
    {
        if ($number === 0) {
            return "zero";
        }
        return $this->numberInWord($number);
    }

    /**
     * @param $number
     * @return string
     */
    private function numberInWord($number):string
    {
        $explode = explode('.', str_replace(',', '.', $number));
        $integer = $explode[0];
        $decimal = $explode[1] ?? null;
        $text = "";

        if ($integer > 0) {
            $text .= $this->numberInteger($integer);
        }
        if(!empty($decimal)){
            $text.="vírgula {$this->numberDecimal($decimal)}";
        }
        return $text;
    }

    /**
     * @param $number
     * @return string
     */
    private function numberInteger($number): string
    {
        $text = "";
        $groups = array_reverse(str_split(str_pad($number, ceil(strlen($number) / 3) * 3, "0", STR_PAD_LEFT), 3));
        foreach ($groups as $key => $group) {
            $group_text = "";
            $hundreds = floor($group / 100);
            $tens = $group % 100;
            $unit = $group % 10;
            if ($hundreds > 0) {
                $group_text .= $this->hundreds[$hundreds]." e ";
            }
            if ($tens > 0) {
                $group_text = $this->groupText($tens, $group_text, $unit);
            }

            if ($group > 0) {
                $group_text .= $this->thousands[$key] . " ";
            }
            $text = $group_text . $text;
        }
        return $text;
    }

    /**
     * @param $number
     * @return string
     */
    private function numberDecimal($number): string
    {
        $group_text = "";
        $tens = $number % 100;
        $unit = $number % 10;
        if ($tens > 0) {
            $group_text = $this->groupText($tens, $group_text, $unit);
        }elseif ($unit >0){
            $group_text .= "{$this->units[$unit] } ";
        }
        return $group_text;
    }

    /**
     * @param int $tens
     * @param string $group_text
     * @param int $unit
     * @return string
     */
    private function groupText(int $tens, string $group_text, int $unit): string
    {
        if ($tens < 10) {
            $group_text .= "{$this->units[$tens] } ";
        } elseif ($tens < 20) {
            $group_text .= $this->specials[$tens - 10] . " ";
        } else {
            $group_text .= $this->tens[floor($tens / 10)] . " ";
            if ($unit > 0) {
                $group_text .= "e {$this->units[$unit]} ";
            }
        }
        return $group_text;
    }

}