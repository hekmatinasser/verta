<?php

namespace Hekmatinasser\Notowo;

/*
 * This file is part of the number to word package.
 *
 * (c) Nasser Hekmati <hekmati.nasser@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use InvalidArgumentException;
    
class Notowo {

    /*****************************  STATCT VARIABLE  ****************************/

    /**
     * Word use in format language.
     */
    const DEFAULT_LANG = 'en';

    /**
     * Format to use for __toString.
     *
     * @var string
     */
    protected $lang = self::DEFAULT_LANG; 

    protected $currency = ''; 

    protected $number_word = array();

    /*****************************  CONSTRUCT  ****************************/

    /**
     * return string of number
     *
     * @param string $number
     * @param string $lang
     * @return string
     */
    public function __construct($number, $lang = 'en') {
        $this->number = $number;
        $this->lang = $lang;

        $this->loadLang($lang);

        return $this;
    }

    /**
     * Create a static instance
     *
     *
     * @return static
     */
    public static function parse($number, $lang = 'en') {
        return new static($number, $lang);
    }

    /**
     * return string of number
     *
     * @param string $number
     * @return string
     */
	public function getWord($number) {
        if(is_numeric($number)) {
            $number = strval($number);
        }
        if(strlen($number) > 39){
            throw new InvalidArgumentException('Number max lenght 36 digit');
        }
        $formated = $this->number_format(strval($number), 0, '.', ',');
        $groups = explode(',', $formated);

        $steps = count($groups);

        $parts = array();
        foreach ($groups as $step => $group) {
            $group_words = $this->groupToWords($group);
            if ($group_words) {
                $part = implode(' ' . $this->number_word['and'] . ' ', $group_words);
            if (isset($this->number_word['step'][$steps - $step - 1])) {
                $part .= ' ' . $this->number_word['step'][$steps - $step - 1];
            }
                $parts[] = $part;
            }
        }
        return implode(' ' . $this->number_word['and'] . ' ', $parts);
	}

    /**
     * format number for change to word
     *
     * @param string $number
     * @param int $decimal_precision
     * @param string $decimals_separator
     * @param string $thousands_separator
     * @return string
     */
    private function number_format($number, $decimal_precision = 0, $decimals_separator = '.', $thousands_separator = ',') {
        $number = explode('.', str_replace(' ', '', $number));
        $number[0] = str_split(strrev($number[0]), 3);
        $total_segments = count($number[0]);
        for ($i = 0; $i < $total_segments; $i++) {
            $number[0][$i] = strrev($number[0][$i]);
        }
        $number[0] = implode($thousands_separator, array_reverse($number[0]));
        if (!empty($number[1])) {
           $number[1] = round($number[1], $decimal_precision);
        }
        return implode($decimals_separator, $number);
    }

    /**
     * group number to word
     *
     * @param array $group
     * @param string $lang
     * @return array
     */
    protected function groupToWords($group) {
        $d3 = floor($group / 100);
        $d2 = floor(($group - $d3 * 100) / 10);
        $d1 = $group - $d3 * 100 - $d2 * 10;

        $group_array = array();

        if ($d3 != 0) {
            $group_array[] = $this->number_word['d3'][$d3];
        }

        if ($d2 == 1 && $d1 != 0) { // 11-19
            $group_array[] = $this->number_word['d2-1'][$d1];
        } else if ($d2 != 0 && $d1 == 0) { // 10-20-...-90
            $group_array[] = $this->number_word['d2-2'][$d2];
        } else if ($d2 == 0 && $d1 == 0) { // 00
        } else if ($d2 == 0 && $d1 != 0) { // 1-9
            $group_array[] = $this->number_word['d1'][$d1];
        } else { // Others
            $group_array[] = $this->number_word['d2-2'][$d2];
            $group_array[] = $this->number_word['d1'][$d1];
        }
        if (!count($group_array)) {
            return FALSE;
        }
        return $group_array;
    }

    /**
     * Format the instance as a string using the set format
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getWord($this->number);
    }

    /**
     * fetch language file
     *
     * @param string $lang
     * @return void
     */
    private function loadLang($lang) {
        $locale = preg_replace_callback('/\b([a-z]{2})[-_](?:([a-z]{4})[-_])?([a-z]{2})\b/', function ($matches) {
            return $matches[1].'_'.(!empty($matches[2]) ? ucfirst($matches[2]).'_' : '').strtoupper($matches[3]);
        }, strtolower($lang));

        if (file_exists($filename = __DIR__.'/Lang/'.$locale.'.php')) {
            $this->lang = $locale;

            $this->number_word = include __DIR__.'/Lang/'.$locale.'.php';
            $this->currency = $this->number_word['currency'];

            return true;
        }
        throw new InvalidArgumentException('Unknown language ('.$lang.')');
    }

    /**
     * return languege
     *
     * @return string
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * return persian string of number
     *
     * @param string $lang
     * @return void
     */
    public function setLang($lang) {
        $this->loadLang($lang);
        return $this;
    }

    /**
     * set default language
     *
     * @return void
     */
    public function resetLang() {
        $this->loadLang(self::DEFAULT_LANG);
        return $this;
    }

    /**
     * return currency
     *
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * set currency string of number
     *
     * @param string $number
     * @return void
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * reset currency string of number
     *
     * @return void
     */
    public function resetCurrency() {
        $this->currency = $this->number_word['currency'];
        return $this;
    }

    /**
     * return currency string of number
     *
     * @param string $currency
     * @return string
     */
    public function currency($currency = null) {
        $currency = $currency == null ? $this->currency : $currency;
        return $this->getWord($this->number) . ' ' . $currency;
    }
}