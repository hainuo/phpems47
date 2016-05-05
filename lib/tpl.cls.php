<?php

class tpl
{

    public $tpl_var = [];
    private $isCache = 1;
    private $cacheTime = 300;

    public $G;
    public $dir;
    public $cacheDir;

    public function __construct(&$G)
    {
        $this->G = $G;

        $this->fl = $this->G->make('files');
        $this->ev = $this->G->make('ev');

        if ($this->ev->url(1))
            $this->dir = $this->G->app . '/tpls/' . $this->ev->url(1) . '/';
        else $this->dir = $this->G->app . '/tpls/app/';
    }

    //设置缓存事件
    public function setCacheTime($time = false)
    {
        if ($time) $this->cacheTime = $time;
        else $this->isCache = 0;
    }

    //赋值变量
    public function assign($target, $vars)
    {
        if (is_array($vars)) {
            foreach ($vars as $key => $cnt)
                $this->tpl_var[$target][$key] = $vars[$key];
        } else {
            $this->tpl_var[$target] = $vars;
        }
    }

    //初始化模板文件地址
    public function initFile()
    {
        $this->fl->mdir('data/html/' . $this->dir);
        $this->fl->mdir('data/compile/' . $this->dir);
    }

    //读取模板
    public function readTpl($file)
    {
        if (file_exists($file)) return $this->fl->readFile($file);
        else
            die('The template not fount which name is ' . $file);
    }

    //判断字符值是否存在，并返回指定类型的值
    public function reBool($str, $bool = 0)
    {
        if ($str) return intval($str);
        elseif ($bool) return 1;
        else return 0;
    }

    //执行块
    public function exeBlock($id)
    {
        $this->G->make('api', 'content')->parseBlock($id);
    }

    //判断是否缓存
    public function isCached($file, $par = null, $cachename = null)
    {
        $source = 'app/' . $this->dir . $file . '.tpl';
        $outfile = 'data/compile/' . $this->dir . '%%cpl%%' . $file . '.php';
        if ($cachename) $outcache = 'data/html/' . $this->dir . $cachename . '.html';
        else
            $outcache = 'data/html/' . $this->dir . $file . $par . '.html';
        if (file_exists($outcache) && $this->isCache) {
            if (((time() - filemtime($outcache)) <= $this->cacheTime) && (filemtime($outfile) > filemtime($source))) {
                echo $this->fl->readFile($outcache);
                return true;
            }
        }
        return false;
    }

    public function isSimpleCached($cachename = null)
    {
        if ($cachename) $outcache = 'data/html/' . $this->dir . $cachename . '.html';
        else
            return false;
        if (file_exists($outcache) && $this->isCache) {
            if ((time() - filemtime($outcache)) <= $this->cacheTime) {
                echo $this->fl->readFile($outcache);
                return true;
            }
        }
        return false;
    }

    //编译模板
    public function compileTpl($source)
    {
        $content = $this->readTpl($source);
        $this->compileBlock($content);
        $this->compileTree($content);
        $this->compileLoop($content);
        $this->compileEval($content);
        $this->compileSql($content);
        $this->compileIf($content);
        $this->compileInclude($content);
        $this->compileVar($content);
        $this->compileArray($content);
        $this->compileDate($content);
        $this->compileRealSubstring($content);
        $this->compileSubstring($content);
        $this->compileRealVar($content);
        $this->compileEnter($content);
        $this->compileConst($content);
        $content = $this->_compileTvar($content);
        return $content;
    }

    public function compileContentTpl($content)
    {
        $this->compileBlock($content);
        $this->compileTree($content);
        $this->compileLoop($content);
        $this->compileEval($content);
        $this->compileSql($content);
        $this->compileIf($content);
        $this->compileInclude($content);
        $this->compileVar($content);
        $this->compileArray($content);
        $this->compileDate($content);
        $this->compileRealSubstring($content);
        $this->compileSubstring($content);
        $this->compileRealVar($content);
        $this->compileEnter($content);
        $this->compileConst($content);
        $content = $this->_compileTvar($content);
        return $content;
    }

    public function compileInclude(&$content)
    {
        $limit = '/{x2;include:(\w+)}/su';
        $replace = "<?php \$this->_compileInclude('\${1}'); ?>";
        $content = preg_replace($limit, $replace, $content);
    }

    public function _compileInclude($file)
    {
        if ($file) $this->fetch($file, null, 0);
        if ($this->isCache) include 'data/compile/' . $this->dir . '/%%cpl%%' . $file . '.php';
    }

    public function compileRealVar(&$content)
    {
        $limit = '/{x2;realhtml:([^}]+)}/su';
        $replace = "<?php echo html_entity_decode(\$this->ev->stripSlashes(\$this->_compileArray(\${1}))); ?>";
        preg_match_all($limit, $content, $matches);
        //$content = preg_replace($limit,$replace,$content);
        $replace = [];
        foreach ($matches[0] as $kM => $strM) {
            $replace[$kM] = '<?php echo html_entity_decode($this->ev->stripSlashes('.$this->_compileArray($matches[1][$kM]).')); ?>';
//            var_dump($strM,$replace[$kM]);
            $content = str_replace($strM,$replace[$kM],$content);
        }
//        var_dump($replace,$content);
        unset($matches);
//        $content = preg_replace($limit, $replace, $content);
    }

    public function compileVar(&$content)
    {
        $limit = '/{x2;\$(\w+)}/';
        $replace = "<?php echo \$this->tpl_var['\${1}']; ?>";
        $content = preg_replace($limit, $replace, $content);
    }

    public function _compileVar($str)
    {
        $limit = '/\$([\w|\']+)/';
        $replace = "\$this->tpl_var['\${1}']";
        $str = preg_replace($limit, $replace, $str);
        return $str;
    }

    public function compileTvar(&$content)
    {
        $limit = '/{x2;v:([\w|\']+)}/';
        $replace = "<?php echo \${1}; ?>";
        $content = preg_replace($limit, $replace, $content);
    }

    public function _compileTvar($str)
    {
        $limit = '/v:([\w|\']+)/';
        $replace = "\$\${1}";
        $str = preg_replace($limit, $replace, $str);
        return $str;
    }

    public function compileConst(&$content)
    {
        $limit = '/{x2;c:(\w+)}/';
        $replace = "<?php echo $1; ?>";
        $content = preg_replace($limit, $replace, $content);
    }

    public function compileArray(&$content)
    {
        $limit = '/{x2;([\$|v][\$|:|\[|\w|\]|\s|\']+)}/';
        $replace = "<?php echo \${1}; ?>";
        preg_match_all($limit,$content,$matches);
//        var_dump($matches);
        $replace = [];
        foreach ($matches[0] as $kM => $strM) {
            $replace[$kM] = '<?php echo '. $this->_compileArray($matches[1][$kM]) . $matches[2][$kM].';?>';
//            echo '<pre>';
//            var_dump($strM,$replace[$kM]);
//            echo '</pre>';
            $content = str_replace($strM,$replace[$kM],$content);
        }
        unset($matches);

//        $content = preg_replace($limit, $replace, $content);
    }

    public function _compileArray($str)
    {
        $str = $this->_compileVar($str);
        $str = $this->_compileTvar($str);
        return $str;
    }

    public function compileDate(&$content)
    {
        $limit = '/{x2;date:([^,]+),([^}]+)}/';
        $replace = "<?php echo date(\${2},\${1}); ?>";
        $content = preg_replace($limit, $replace, $content);
    }

    public function compileSubstring(&$content)
    {
        $limit = '/{x2;substring:([^,]+),([^}]+)}/';
        $replace = "<?php echo \$this->G->make('strings')->subString(\${1},\${2}); ?>";
        $content = preg_replace($limit, $replace, $content);
    }

    public function compileRealSubstring(&$content)
    {
        $limit = '/{x2;realsubstring:([^,]+),([^}]+)}/';
        preg_match_all($limit, $content, $matches);
        //$content = preg_replace($limit,$replace,$content);
        $replace = [];
        foreach ($matches[0] as $kM => $strM) {
            $replace[$kM] = '<?php echo $this->G->make(\'strings\')->subString(strip_tags(html_entity_decode($this->ev->stripSlashes(' . $this->_compileArray($matches[1][$kM]) . '))),'.$matches[2][$kM].'); ?>';
//            var_dump($strM,$replace[$kM]);
            $content = str_replace($strM,$replace[$kM],$content);
        }
        unset($matches);

//        $content = preg_replace($limit,$replace,$content);
    }

    public function compileEval(&$content)
    {
        $limit = '/{x2;eval:([^}]+)}/';
        $replace = " <?php \${1}; ?>";
            $content = preg_replace($limit,$replace,$content);
            }

            public function compileSql(&$content)
            {
            $limit = '/{x2;sql:"([^"]+)",([a-z]+)}/';
            $replace = "<?php \$\${
                2}=\\\$this->G->make('pepdo')->fetchAll(array(\"sql\"=>\"'.\$this->_compileArray('\${1}').'\")); ?>";
        $content = preg_replace($limit, $replace, $content);
    }

        public
        function compileIf(&$content)
        {
            $limit = '/{x2;if:([^}]+)}/';
            $replace = '<?php if($1){ ?>';
            preg_match_all($limit, $content, $matches);
            $replace = [];
            foreach ($matches[0] as $kM => $strM) {
                $replace[$kM] = '<?php if(' . $this->_compileArray($matches[1][$kM]) . '){?>';
//            var_dump($strM,$replace[$kM]);
                $content = str_replace($strM, $replace[$kM], $content);
            }

            unset($matches);
            $limit = '/{x2;elseif:([^}]+)}/';
            $replace = '<?php } elseif(\$this->_compileArray($1)){ ?>';
            preg_match_all($limit, $content, $matches);
            //$content = preg_replace($limit,$replace,$content);
            $replace = [];
            foreach ($matches[0] as $kM => $strM) {
                $replace[$kM] = '<?php } elseif(' . $this->_compileArray($matches[1][$kM]) . '){?>';
//            var_dump($strM,$replace[$kM]);
                $content = str_replace($strM, $replace[$kM], $content);
            }
            unset($matches);


            $limit = '/{x2;else}/';
            $replace = "<?php } else { ?>";
            $content = preg_replace($limit, $replace, $content);

            $limit = '/{x2;endif}/';
            $replace = "<?php } ?>";
            $content = preg_replace($limit, $replace, $content);
        }

        public
        function compileLoop(&$content)
        {
            $limit = '/{x2;loop:([^,]+),(\w+),*(\d*),*(\d*),*(\d*)}/';
            $replace = "<?php \n\$'.\${2}.'All = count('.\$this->_compileArray('\${1}').');\nfor(\$\${2}= '.\$this->reBool('\${3}').';\$\${2}<\$\${2}All;\$\${2}+='.\$this->reBool('\${5}',1).')\n{\nif('.\$this->reBool('\${4}').' && \$\${2}>='.\$this->reBool('\${4}').')break;\n?>";
            $content = preg_replace($limit, $replace, $content);

            $limit = '/{x2;endloop}/';
            $replace = "<?php } ?>";
            $content = preg_replace($limit, $replace, $content);
        }

        public
        function compileTree(&$content)
        {
            $limit = '/{x2;tree:([^,]+),(\w+),(\w+)}/';
            preg_match_all($limit, $content, $matches);
            //$content = preg_replace($limit,$replace,$content);
            $replace = [];
//        var_dump($matches);
            foreach ($matches[0] as $kM => $strM) {
                $replace[$kM] = '<?php $' . $matches[3][$kM] . ' = 0; foreach(' . $this->_compileArray($matches[1][$kM]) . ' as $key => $' . $matches[2][$kM] . '){  $' . $matches[3][$kM] . '++; ?>';
//            var_dump($strM,$replace[$kM]);
                $content = str_replace($strM, $replace[$kM], $content);
            }
            unset($matches);
//        exit;
//        $content = preg_replace($limit,$replace,$content);

            $limit = '/{x2;endtree}/';
            $replace = "<?php } ?>";
            $content = preg_replace($limit, $replace, $content);
        }

        public
        function compileBlock(&$content)
        {
            $limit = '/{x2;block:(\d+)}/';
            $replace = "<?php echo \$this->exeBlock('$1'); ?>\n";
            $content = preg_replace($limit, $replace, $content);
        }

        public
        function compileEnter(&$content)
        {
            $limit = '/{x2;enter}/';
            $replace = "<?php echo \"\n\"; ?>\n";
            $content = preg_replace($limit, $replace, $content);
        }

        public
        function compileCode(&$content)
        {
            $limit = '/{x2;code:(.+)}/';
            $replace = "<?php \$this->_compileArray('\${1}; ?>\n";
            $content = preg_replace($limit, $replace, $content);
        }

        //解析模板
        public
        function fetch($file, $par = '', $type = 0, $cachename = null)
        {
            $this->initFile();
            $source = 'app/' . $this->dir . $file . '.tpl';
            $outfile = 'data/compile/' . $this->dir . '%%cpl%%' . $file . '.php';
            if ($cachename)
                $outcache = 'data/html/' . $this->dir . $cachename . '.html';
            else
                $outcache = 'data/html/' . $this->dir . $file . $par . '.html';
            if ((!file_exists($outfile)) || (filemtime($outfile) < filemtime($source))) {
                $content = $this->compileTpl($source);
                $this->fl->writeFile($outfile, $content);
                if ($type) {
                    include $outfile;
                    $this->fl->delFile($outcache);
                }
            } else {
                if ($this->isCache && (!file_exists($outcache) || (time() - filemtime($outcache)) > $this->cacheTime)) {
                    if ($type) {
                        ob_start();
                        include $outfile;
                        $cachecontent = ob_get_contents();
                        ob_flush();
                        $this->fl->writeFile($outcache, $cachecontent);
                        ob_clean();
                    }
                } else {
                    include $outfile;
                }
            }
        }

        public
        function fetchContent($content)
        {
            return $this->compileContentTpl($content);
        }

        public
        function fetchExeCnt($file)
        {
            $source = 'app/' . $this->dir . $file . '.tpl';
            $content = $this->compileTpl($source);
            ob_start();
            eval(' ?>' . $source . '<?php ');
            $cachecontent = ob_get_contents();
            ob_flush();
            ob_clean();
            return $cachecontent;
        }

        //展示模板
        public
        function display($file, $par = null, $cachename = null)
        {
            $this->fetch($file, $par, 1, $cachename);
        }
    }

?>