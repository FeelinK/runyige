<?php
/**
 * 常用数据处理.
 * User: thor
 * Date: 2014-11-5
 * Time: 下午4:49
 */

class ToolKit
{
    /**
     * 生成随机验证码
     * @param int $length
     * @return string
     */
    public static function mkValidatorCode( $length = 6)
    {
        $string = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTxXyYzZ0123456789";
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $string{mt_rand(0,strlen($string)-1)};//生成php随机数
        }
        return $key;
    }

    /**
     * 生成货号
     * @return string
     */
    public static function make_product_sn()
    {
        return 'MT'.mt_rand(10,99)
        . sprintf('%010d',time() - 946656000)
        . sprintf('%03d', (float) microtime() * 1000);
    }

    /**
     * 生成订单
     * @return string
     */
    public static function make_order_sn()
    {
        return 'MT'.mt_rand(10,99)
        . sprintf('%010d',time() - 946656000)
        . sprintf('%03d', (float) microtime() * 1000);
    }

    /**
     * 参数验证
     * @param $obj
     * @param $arr
     * @author alice
     * @date 2016-1-13
     * @return bool
     */
    public static function   checkProperties($obj, $arr)
    {
        if(empty($arr)) return true;
        $obj    =   (array) $obj;
        foreach($arr as $v){
            if(empty($obj[$v])){
                return false;}
        }
        return true;
    }

    /**
     * 生成Token
     * @param int $length
     * @return string
     */
    public static  function generateToken($length = 16)
    {
        $pattern = '1234567890@#$%^&*abcdefghijklmnopqrstuvwxyz';
        $key = '';
        for($i=0;$i<$length;$i++)
        {
            $key .= $pattern{mt_rand(0,strlen($pattern)-1)};//生成php随机数
        }
        return $key;
    }

    /**
     * 对多维数组排序
     * @param        $arr
     * @param        $keys
     * @param string $type
     * @return array
     * @example
     * $arr = array(
        array('name'=>'手机','brand'=>'诺基亚','price'=>1050),
        array('name'=>'笔记本电脑','brand'=>'lenovo','price'=>4300)
        ),
     * self::array_sort($arr,'price','desc')
     */
    public static function array_sort($arr,$keys,$type='asc')
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysvalue);
        }else{
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k=>$v){
            $new_array[] = $arr[$k];
        }
        return $new_array;
    }

    /**
     * 获取字符串的字母和数字
     */
    public static function getLetterNum($str){
        $pattern = '/[^a-zA-Z0-9]/i';
        $replacement = '';
        return preg_replace($pattern, $replacement,$str);
    }

    /**
     * 字节转换成M
     */
    public static function ByteIntoM($bytes,$median=2){
        return round($bytes/(1024*1024),2);
    }

    /**
     * 字节转换成G
     */
    public static function ByteIntoG($bytes,$median=2){
        return round($bytes/(1024*1024*1024),2);
    }

    /**
     * 匹配字符串中包含http或Http
     */
    public static function regexHttp($str){
        $regex = '/http|Http/';
        return preg_match($regex,$str);
    }

    /**
     * 制作分页列表
     * @param        $current_page_num 当前页码数
     * @param        $total_num  总页码数
     * @return string
     */
    public static function makePageList($current_page_num,$total_num){
        //页码范围计算
        $init = 1;//起始页码数
        $max = $total_num;//结束页码数
        $pagelen = 5;//要显示的页码个数
        $pagelen = ($pagelen % 2) ? $pagelen : $pagelen + 1;//页码个数
        $pageoffset = ($pagelen - 1)/2;//页码个数左右偏移量
        //分页数大于页码个数时可以偏移
        if($total_num > $pagelen){
            //如果当前页小于等于左偏移
            if($current_page_num <= $pageoffset){
                $init = 1;
                $max = $pagelen;
            }else{//如果当前页大于左偏移
                //如果当前页码右偏移超出最大分页数
                if($current_page_num +$pageoffset >= $total_num+1){
                    $init = $total_num - $pagelen + 1;
                }else{
                    //左右偏移都存在时的计算
                    $init = $current_page_num - $pageoffset;
                    $max = $current_page_num + $pageoffset;
                }
            }
        }


        $pageList = '';
        $pageList .= '<ul class="pagination pull-right">';
        if($current_page_num == 1){
            $pageList .= '';
        }else{
            $pageList .= '<li><a href="javascript:void(0);" page_num="1">首页</a></li>';
            $pageList .= '<li><a href="javascript:void(0);" page_num="'.($current_page_num-1).'">«</a></li>';
        }

        for($i = $init;$i <= $max;$i++){
            if($i == $current_page_num)
                $pageList .= '<li class="active"><a href="javascript:void(0);">'.$current_page_num.'</a></li>';
            else
                $pageList .= '<li><a href="javascript:void(0);" page_num="'.$i.'">'.$i.'</a></li>';
        }

        if($current_page_num == $total_num){
            $pageList .= '';
        }else if($total_num > 0){
            $pageList .= '<li><a href="javascript:void(0);"  page_num="'.($current_page_num+1).'">»</a></li>';
            $pageList .= '<li><a href="javascript:void(0);"  page_num="'.$total_num.'">尾页</a></li>';
        }
//        $pageList .= '<dd>共'.$total_num.'页,跳转到:</dd>';
//        $pageList .= '<dt><input id="target_page" class="pageNumSmall" type="text" /></dt>';
//        $pageList .= '<dt class="jump_to">GO</dt>';
//        $pageList .= '</dl></td>';
        $pageList .= '</ul>';

        return $pageList;
    }

    /**
     * 将对象数组转成普通数组
     * 当$value为null，整个对象作为value
     * @param $list
     * @param $key
     * @param null $value
     * @return array
     */
    public static function objectListToArr($list, $key, $value = null)
    {
        $arr = array();
        foreach ($list as $v) {
            if (is_null($value)) {
                $arr[$v->$key] = $v;
            } else {
                $arr[$v->$key] = $v->$value;
            }
        }
        return $arr;
    }

    /**
     * 无限级分类-一维数组转多维数组
     * @param $list 一维数据
     * @param $parentd_id 起始父ID
     * @param $parentd_str 父元素名称
     * @param $id_str id名称
     * @return array
     */
    public static function unLimitForLayer($list, $parentd_id, $parentd_str, $id_str){
        $arr = array();
        foreach($list as $val){
            if($val->$parentd_str == $parentd_id){
                $val->child = self::unLimitForLayer($list, $val->$id_str, $parentd_str, $id_str);
                $arr[] = $val;
            }
        }
        return $arr;
    }

    /**
     * 多维数组转一维数组
     * @param $list
     * @param string $prefix
     * @return array
     */
    public static function layerToPlanePrefix($list, $prefix = ''){

        $arr = array();
        foreach($list as $val){
            $val->prefix = $prefix;
            $arr[] = $val;
            if(is_array($val->child)){
                $subArr = self::layerToPlanePrefix($val->child, "&nbsp;&nbsp;&nbsp;&nbsp;".$prefix);
                $arr = array_merge($arr, $subArr);
            }
        }
        return $arr;
    }

    /**
     * 解析ES搜索结果,获取列表
     * @param $result
     * @return array
     */
    public static function fetchAllESResult($result)
    {
        if ($result['hits']['total'] > 0) {
            $temp_arr = array();
            foreach ($result['hits']['hits'] as $hit) {
                $hit['_source']['_id'] = $hit['_id'];
                $temp_arr[] = $hit['_source'];
            }
        } else {
            $temp_arr = array();
        }
        return $temp_arr;
    }

    /**
     * 解析ES搜索结果,获取当行数据
     * @param $result
     * @return array
     */
    public static function fetchRowESResult($result)
    {
        $result = ToolKit::fetchAllESResult($result);
        if (!empty($result)) {
            return $result[0];
        } else {
            return $result;
        }
    }

    /**
     * 返回json数据
     * @param $state
     * @param $msg
     * @param $status
     * @param $data
     * @return mixed
     */
    public static function response($state, $msg, $data = array(),$status = 0)
    {
        $response = array(
            'json' => array(
                'state' => $state."",
                'msg'   => $msg."",
                'data'  => $data,
                'status'=> $status.""
            )
        );

        return Response::json($response);
    }

    /**
     * 解析课程表数据的日期
     * @param $startSec
     * @return array
     */
    public static function parseScheduleWeek($startSec)
    {
        $weekArr = array('周一','周二','周三','周四','周五','周六','周日');

        $week = array();
        for ($i=0; $i<7; $i++){
            if (date("Y-m-d") == date("Y-m-d", $startSec)) {
                $today = true;
            } else {
                $today = false;
            }

            $week[] = array(
                'date' => date('d', $startSec),
                'week' => $weekArr[$i],
                'today'=> $today
            );
            $startSec += 3600 * 24; //加一天
        }

        return $week;
    }

    /**
     * 将数据列表切割成时间段
     * @param $data
     * @param $dateField
     * @return array
     */
    public static function dataListCutByDate($data, $dateField)
    {
        $dateStr = array(
            '本周','上周','前2周','一月前','两月前','三月前','半年前','一年前','两年前','更早'
        );
        $week = $weekOfDay = (date('w') != 0) ? date('w') : 7;
        $weekStartDay = time() - ($week - 1) * 3600 * 24;
        $weekStartTime = strtotime(date('Y-m-d',$weekStartDay));
        $dateStartTime = array(
            $weekStartTime,
            $weekStartTime - 7 * 3600 * 24,
            $weekStartTime - 14 * 3600 * 24,
            $weekStartTime - 30 * 3600 * 24,
            $weekStartTime - 60 * 3600 * 24,
            $weekStartTime - 90 * 3600 * 24,
            $weekStartTime - 180 * 3600 * 24,
            $weekStartTime - 360 * 3600 * 24,
            $weekStartTime - 720 * 3600 * 24,
            0
        );
        $dateCount = count($dateStr);
        $list = [];
        foreach($data as $vo){
            for($i=0;$i<$dateCount;$i++){
                if(strtotime($vo->$dateField) > $dateStartTime[$i]){
                    $list[$i]['name'] = $dateStr[$i];
                    $list[$i]['data'][] = $vo;
                    break;
                }
            }
        }
        return $list;
    }

    public static function is_phone($val){
        return preg_match('/^1[34568][0-9]{9}$/',$val);
    }
}