<?php
use App\Lib\Webspice;
$webspice = new Webspice();
  
return [  
    'today' => 'আজ',  
    'tabular_statistic_title' => 'বিভাগ অনুযায়ী শেষ সাত দিনের পরিসংখ্যান',  
    'location'=>'এলাকা',
    'copyright'=>'কপিরাইট © '.$webspice->convertToBanglaNumber(date('Y')).' আইসিডিডিআর, বি. সমস্ত অধিকার সংরক্ষিত।',
]; 