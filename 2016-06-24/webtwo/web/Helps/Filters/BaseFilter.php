<?php

class Filters_BaseFilter
{
    protected $params;

    /**
     * @var RESTService
     */
    protected $rest;

    public function __construct()
    {
        $this->params = Input::all();
        $this->rest   = RESTService::instance();
    }

    /**
     * @param $rules
     * @param array $messages
     * @throws Exception
     *
     * @todo 自定义messages
     */
    protected function valid($rules, $messages = array())
    {
        $validator = Validator::make($this->params, $rules, $messages);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first(), ErrorCodeEnum::STATUS_ERROR_PARAMS_MUST);
        }
    }

    /**
     * 验证非空
     * @param $str
     * @return bool
     */
    public static function checkNull($str){
        if($str==''){
            return false;
        }
        return true;
    }
    /**
     * 字符串为指定长度范围
     * @param $value
     * @param $params
     * @return bool
     */
    public static function StrInLength($value, $params){
        $len = strlen($value);
        if (empty($params['min'])){
            $params['min'] = 0;
        }
        if ($len >= $params['min'] && $len <= $params['max'])
            return true;
        return false;
    }

    /**
     * 指定范围整数
     * @param $value
     * @param $params
     * @return bool
     */
    public static  function intInRange($value, $params) {
        if (!is_int($value)){
            return false;
        }
        if ($value < $params['min'] || $value > $params['max']){
            return false;
        }
        return true;
    }

    /**
     * 验证域名
     * @param $domain
     * @return bool
     */
    public static function isDomain($domain){
        //Domain names must mot have more than 63 characters.
        $domain_len = strlen($domain);
        if ($domain_len < 4 || $domain_len > 63) return false;

        //Domain names must use only alphanumeric characters and dashes (-).
        if (preg_match('/[^a-z\d-\.]/i', $domain)) return false;

        $domain_arr = explode('.', $domain);
        if (count($domain_arr) < 2) return false;

        $root_domain = array_pop($domain_arr);
        $root_domain_len = strlen($root_domain);
        if ($root_domain_len < 2 || $root_domain_len > 4 || preg_match('/[^a-z]/i', $root_domain)) return false;

        //Domain names must not begin or end with dashes (-).
        foreach ($domain_arr as $div_domain)
        {
            if (empty($div_domain)) return false;

            $div_domain_len = strlen($div_domain);

            if ($div_domain_len == 1)
            {
                if ($div_domain == '-') return false;
            }
            elseif ($div_domain_len == 2)
            {
                if (strpos($div_domain, '-') !== false) return false;
            }
            else
            {
                if (substr($div_domain, 0, 1) == '-' || substr($div_domain, -1, 1) == '-') return false;
            }
        }
        return true;
    }

    /**
     * 验证URL正确性
     * @param $url
     * @return bool
     */
    public static function isUrl($url)
    {
        return preg_match('/^(http[s]?:\/\/)?'.
            '(([0-9]{1,3}\.){3}[0-9]{1,3}'. // IP形式的URL- 199.194.52.184
            '|'. // 允许IP和DOMAIN（域名）
            '([0-9a-z_!~*\'()-]+\.)*'. // 三级域验证- www.
            '([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\.'. // 二级域验证
            '[a-z]{2,6})'.  // 顶级域验证.com or .museum
            '(:[0-9]{1,4})?'.  // 端口- :80
            '((\/\?)|'.  // 如果含有文件对文件部分进行校验
            '(\/[0-9a-zA-Z_!~\*\'\(\)\.;\?:@&=\+\$,%#-\/]*)?)$/',
            $url) == 1;
    }

}