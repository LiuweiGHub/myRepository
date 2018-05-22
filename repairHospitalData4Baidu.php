<?php
/*
 *Author: liuwei
 *Time :2018-05-21
 */
include_once(dirname(__FILE__).'/init.php');
ini_set('memory_limit', '521M');

$xmlData = file_get_contents("http://api.haodf.com/openplatform/hospitaldata4baidu/index.xml");
preg_match_all("/http:\/\/api.haodf.com\/openplatform\/hospitaldata4baidu\/[0-9]{1,3}.xml/",$xmlData,$matches);
$hospitalDatas = [];
$cnt = $docCnt = 0;
foreach($matches[0] as $i => $url)
{
    $hospitalData = file_get_contents($url);
    $hospitalData = (preg_replace("/[\s]{2,}/", "", $hospitalData));
    preg_match_all("/<Hospital><name>(.*?)<\/name><hospitalId>(.*?)<\/hospitalId>.*?<Department_count>(.*?)<\/Department_count>/", $hospitalData, $datas);
    $hospitalDatas = $data = [];
    $cnt += count($datas[2]);
    foreach($datas[2] as $key => $hospitalId)
    {
        $data['name'] = $datas[1][$key];
        $data['department_count'] = $datas[3][$key];
        $hospital = DAL::get()->find('hospital', $hospitalId);
        $data['doctor_count'] = $hospital->doctorCount;
        $docCnt += $data['doctor_count'];
        array_push($hospitalDatas, $data);
    }
    $fileName = "/tmp/hospitaldata".$i.".json";
    file_put_contents($fileName, json_encode($hospitalDatas, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    echo "_________________________FILE {$i} COMPLETED____________________________________".PHP_EOL;
    echo "_________________________TOTAL HOSPITAL CNT[$cnt]____________________________________".PHP_EOL;
    echo "_________________________TOTAL DOCTOR CNT[$docCnt]____________________________________".PHP_EOL;
}
