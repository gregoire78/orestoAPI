<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function slug($str) {
    // Convertit tous les caractères en entités html
    $str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
    // Déspécialise tous les caractères déspécialisables (ex. é->e, œ -> oe, ç->c ou encore ñ->n)
    $str = preg_replace('/\&([A-Za-z])(?:grave|acute|circ|tilde|uml|ring|cedil)\;/', '$1', $str);
    $str = preg_replace('/\&([A-Za-z]{2})(?:lig)\;/', '$1', $str);
    // Supprime tous les caractères non déspécialisables (ex. & = &)
    $str = preg_replace('/\&([A-Za-z]*)\;/', '', $str);
    // Remplace tous autres caractères différent d'une lettre, d'un chiffre ou du délimiteur par le délimiteur
    $str = preg_replace('/[^A-Za-z0-9-]/', '-', $str);
    // Supprime les doublons de délimiteur
    $str = preg_replace('/[-]{2,}/', '-', $str);
    // Convertit la chaine en minuscule
    $str = strtolower($str);
    // Suprime les délimiteurs en début et fin de chaine
    $str = trim($str, '-');
    return $str;
}

function mb_ucfirst($string, $encoding)
{
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}