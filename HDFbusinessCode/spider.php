<?php
$w = false == empty($argv[1]) ? $argv[1] : exit('please input a param, for example "a、b、c..."');
//根据ascii码过滤控制字符
function special_filter($string)
{
    if(!$string) return '';

    $new_string = '';
    for($i =0; isset($string[$i]); $i++)
    {
        $asc_code = ord($string[$i]);    //得到其asc码

        //以下代码旨在过滤非法字符
        if($asc_code == 9 || $asc_code == 10 || $asc_code == 13){
            $new_string .= ' ';
        }
        else if($asc_code > 31 && $asc_code != 127){
            $new_string .= $string[$i];
        }
    }
    $new_string = str_replace(array("&amp;nbsp;","&nbsp;","&amp;"," ","\n","\\","\r","\n\r","\v","\t",'★',"\f"), '', $new_string);

    return trim($new_string);
}
$file = "fenge_a{$w}";
$handle = fopen($file, 'r');
$i = $j = $count = 0;
try{
    while(!feof($handle)) {
        $line = "https://".trim(fgets($handle));
        $line = str_replace("\t", "", $line);
        if(false == strpos($line, '/t/'))
        {
            $data = [];
            $html = file_get_contents($line);
            if(false == empty($html))
            {
                preg_match('/<script type="application.*?>(.*?)<\/script>/', $html, $match);
                if(false == empty($match[1]))
                {
                    $i++;
                    $count++;
                    if($i > 1000) {
                        $i = 0;
                        $j++;
                    }
                    $data['url'] = $line."\t";
                    $match[1] = mb_convert_encoding($match[1], 'utf-8', "gbk");
                    $match[1] = special_filter($match[1]);
                    $data['json'] = $match[1].PHP_EOL;
                    file_put_contents("/tmp/a{$w}_wapurlandjsondata{$j}.txt", $data, FILE_APPEND);
                    unset($data, $match);
                    echo "____________________/tmp/a{$w}_wapurlandjsondata{$j}.txt______COMPLETED__________".PHP_EOL;
                    echo "______________________________【$count/118147】".PHP_EOL;
                }
            }
        }
    }
    echo "______________________________DONE".PHP_EOL;
} catch(exception $e) {
    echo $e->getMessage();
}