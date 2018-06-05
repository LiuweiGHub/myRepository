<?php
include_once(dirname(__FILE__).'/init.php');
set_time_limit(0);
ini_set('memory_limit', '1024M');
include_once("/tmp/libs/PHPExcel.php");
include_once("/tmp/libs/PHPExcel/Writer/Excel2007.php");
require_once('/tmp/libs/PHPExcel/Writer/Excel5.php');
require_once('/tmp/libs/PHPExcel/IOFactory.php');

//创建新的phpexcel对象
$objPHPExcel = new PHPExcel;
//-.生成简单Excel
$fileName = "hospitalDatas222222";
$headArr = array("标准名", "别名", "是否是民营", "医院概况", "医院官网", "门诊时间", "挂号时间", "医院地址", "医院电话", "医院等级", "医院类型", "医院图片", "科室信息（以h5的形式展现，请在下方填写有科室信息的科室数）", "是否可挂号（可挂号的标1，不可挂号的标0）");
setExcelHead($objPHPExcel, $fileName, $headArr);
//获取医院数据
$xmlData = file_get_contents("http://api.haodf.com/openplatform/hospitaldata4baidu/index.xml");
preg_match_all("/http:\/\/api.haodf.com\/openplatform\/hospitaldata4baidu\/[0-9]{1,3}.xml/",$xmlData,$matches);
$hospitalDatas = [];
$cnt = $k = 0;
foreach($matches[0] as $i => $url)
{
    $hospitalData = file_get_contents($url);
    $hospitalData = (preg_replace("/[\s]{2,}/", "", $hospitalData));
    preg_match_all("/<Hospital><name>(.*?)<\/name><hospitalId>(.*?)<\/hospitalId>.*?<Department_count>(.*?)<\/Department_count>/", $hospitalData, $datas);
    $cnt += count($datas[2]);
    foreach($datas[2] as $key => $hospitalId)
    {
        $k ++;
        $a = [];
        $hospital = DAL::get()->find('hospital', $hospitalId);
        if (false == $hospital instanceof Hospital) continue;
        $data['name'] = $datas[1][$key];
        $data['alias'] = $hospital->aliases;
        $data['isPublic'] = "否";
        $data['survey'] = empty($hospital->intro) ? 0 : 1;
        $data['url'] = 0;
        $data['clinicTime'] = 0;
        $data['registrationTime'] = 0;
        $data['address'] = empty($hospital->address) ? 0 : 1;
        $data['phone'] = empty($hospital->phone) ? 0 : 1;
        $data['level'] =  0 == $hospital->grade ? 0 : 1;
        $data['type'] = 1;
        $data['img'] = 0;
        $data['department_count'] = $hospital->facultyCount;
        //医院开通加号的医生数量
        $doctorCount = HospitalProxy::getInstance()->getDoctorCountByHospitalCommonName($hospital->commonName);
        $data['isRegistration'] = 0 == $doctorCount ? 0 : 1;  // 是否可预约挂号
        $data = XString::convertArrayToUnicode($data);
        array_push($a, $data);
        writeData($objPHPExcel, $a, $k);
        saveFile($objPHPExcel, $fileName);
    }
    saveFile($objPHPExcel, $fileName);
    echo "_________________________TOTAL HOSPITAL CNT[$cnt]____________________________________".PHP_EOL;
}


function setExcelHead($objPHPExcel, $fileName, $headArr)
{
    if(empty($fileName))
    {
        exit;
    }
    $date = date("Y-m-d",time());
    $fileName .= "_{$date}.xlsx";

    $objProps = $objPHPExcel->getProperties();
    //设置表头 从第1列开始
    $key = ord("A");
    foreach($headArr as $v) {
        $column = chr($key);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($column.'1', $v);
        $key += 1;
    }
}

function writeData($objPHPExcel, $data, $key)
{
    $column = $key + 1;
    if(empty($data) || !is_array($data))
    {
        exit("data must be a array");
    }
    $objActSheet = $objPHPExcel->getActiveSheet();

    //遍历二维数组
    foreach($data as $rows)
    {
        $span = ord("A");
        foreach($rows as $value)
        {
            $j = chr($span);
            //按照B1,B2,C2,D2的顺序逐个写入单元格数据
            $objActSheet->setCellValue($j.$column, $value);
            //移动到当前行右边的单元格
            $span++;
        }
    }
}

function saveFile($objPHPExcel, $fileName)
{
    $fileName = iconv("utf-8","gb2312", $fileName);
    //重命名
    $objPHPExcel->getActiveSheet()->setTitle('simple');
    //设置活动单指数到第一个表,所以Excel打开这是第一个表
    $objPHPExcel->setActiveSheetIndex(0);

    PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //脚本方式运行，保存在当前目录
    $objWriter->save("/tmp/$fileName.xlsx");

    // 输出文档到页面
    // header('Content-Type: application/vnd.ms-excel');
    // header('Content-Disposition: attachment;filename="test.xls"');
    // header('Cache-Control: max-age=0');
    // $objWriter->save("php://output");

}