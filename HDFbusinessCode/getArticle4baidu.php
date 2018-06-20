<?php
include_once(dirname(__FILE__).'/init.php');
set_time_limit(0);
ini_set('memory_limit', '4800M');
getArticle4Baidu();
function getArticle4Baidu()
{
    $articleIds = DAL::get()->queryArticleId4Baidu('article');
    $count = count($articleIds);
    $n = 0;
    foreach($articleIds as $key => $articleId)
    {
        $article = DAL::get()->find('article', $articleId['fld_articleid']);
        if(false == $article instanceof Article || false == $article->space instanceof Space || false == $article->space->host instanceof Doctor) continue;
        $url = $article->getTouchUrl();
        file_put_contents("/tmp/url.txt", $url."\n", FILE_APPEND);
        printf((memory_get_usage()/1048576)."MB\n");
        $n++;
        echo "________________________________EFECTIVE IDS [$n/{$count}]__________________________".PHP_EOL;
        unset($article, $url);
        BeanFinder::get('LocalCache')->removeAll();

    }
    echo "DONE".PHP_EOL;
}


//src/domain/dao/articledao.php 中添加方法queryArticleId4Baidu
public function queryArticleId4Baidu()
    {
            $sql = "SELECT
                fld_articleid
                FROM
                    tab_Article
                    WHERE
                        price = 0
                        and shield = 0
                        and doctype != 'pdf'
                        and contenttype != 3
                        and fld_ArticleIsDeleted = 0";
            return $this->getDb()->query($sql);
    }



第二步：
curl -H 'Content-Type:text/plain' --data-binary @url.txt "http://data.zz.baidu.com/urls?appid=1579675208606918&token=yzH3QLd4dPOuT9sq&type=realtime"