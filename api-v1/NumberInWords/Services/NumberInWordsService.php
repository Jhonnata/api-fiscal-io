<?php
namespace API\NumberInWords\Services;
class NumberInWordsService
{

    private array $units =[
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
    private array $tens =[
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
    private  array $hundreds = [
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
    private array $thousands  = [
        "mil",
        "milhão",
        "bilhão",
        "trilhão",
        "quadrilhão",
        "quintilhão"
    ];
    public function translate($number): string
    {
        return "TEST";
    }
}