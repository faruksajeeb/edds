<?php
use App\Lib\Webspice;
$webspice = new Webspice();
  
return [  
    'today' => 'আজ',  
    'tabular_statistic_title' => 'বিভাগভিত্তিক শেষ সাত দিনের পরিসংখ্যান',  
    'location'=>'এলাকা',
    'map_section_title'=>'জেলাভিত্তিক শেষ সাত দিনের সতর্কতা মানচিত্র',
    'copyright'=>'কপিরাইট © '.$webspice->convertToBanglaNumber(date('Y')).' আইসিডিডিআর, বি. সমস্ত অধিকার সংরক্ষিত।',
]; 