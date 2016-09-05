<?php

class tpl
{

    public $tpl_var = array();
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

        if($this->ev->url(1))
            $this->dir = $this->G->app.'/tpls/'.$this->ev->url(1).'/';
        else $this->dir = $this->G->app.'/tpls/app/';
    }

    //设置缓存事件
    public function setCacheTime($time = false)
    {
        if($time)$this->cacheTime = $time;
        else $this->isCache = 0;
    }

    //赋值变量
    public function assign($target,$vars)
    {
        if(is_array($vars))
        {
            foreach($vars as $key => $cnt)
                $this->tpl_var[$target][$key] = $vars[$key];
        }
        else
        {
            $this->tpl_var[$target] = $vars;
        }
    }

    //初始化模板文件地址
    public function initFile()
    {
        $this->fl->mdir('data/html/'.$this->dir);
        $this->fl->mdir('data/compile/'.$this->dir);
    }

    //读取模板
    public function readTpl($file)
    {
        if(file_exists($file))return $this->fl->readFile($file);
        else
            die('The template not fount which name is '.$file);
    }

    //判断字符值是否存在，并返回指定类型的值
    public function reBool($str,$bool = 0)
    {
        if($str)return intval($str);
        elseif($bool) return 1;
        else return 0;
    }

    //执行块
    public function exeBlock($id)
    {
        $this->G->make('api','content')->parseBlock($id);
    }

    //判断是否缓存
    public function isCached($file,$par = NULL,$cachename = NULL)
    {
        $source = 'app/'.$this->dir.$file.'.tpl';
        $outfile = 'data/compile/'.$this->dir.'%%cpl%%'.$file.'.php';
        if($cachename)$outcache = 'data/html/'.$this->dir.$cachename.'.html';
        else
            $outcache = 'data/html/'.$this->dir.$file.$par.'.html';
        if(file_exists($outcache) && $this->isCache)
        {
            if(((time()-filemtime($outcache))<= $this->cacheTime) && (filemtime($outfile) > filemtime($source)))
            {
                echo $this->fl->readFile($outcache);
                return true;
            }
        }
        return false;
    }

    public function isSimpleCached($cachename = NULL)
    {
        if($cachename)$outcache = 'data/html/'.$this->dir.$cachename.'.html';
        else
            return false;
        if(file_exists($outcache) && $this->isCache)
        {
            if((time()-filemtime($outcache))<= $this->cacheTime)
            {
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
        $this->compileArray($content);
        $this->compileDate($content);
        $this->compileRealSubstring($content);
        $this->compileSubstring($content);
        $this->compileRealVar($content);
        $this->compileEnter($content);
        $this->compileConst($content);
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
        $this->compileArray($content);
        $this->compileDate($content);
        $this->compileRealSubstring($content);
        $this->compileSubstring($content);
        $this->compileRealVar($content);
        $this->compileEnter($content);
        $this->compileConst($content);
        return $content;
    }

    public function compileInclude(&$content)
    {
        $limit = '/{x2;include:(\w+)}/';
        $replace = "'<?php \$this->_compileInclude(\'\${1}\'); ?>'";
        $content = preg_replace_callback($limit,function($matches){
          return '<?php  $this->_compileInclude('.$matches[1].');?>';
        },$content);
    }

    public function _compileInclude($file)
    {
        if($file)$this->fetch($file,NULL,0);
        if($this->isCache)include 'data/compile/'.$this->dir.'/%%cpl%%'.$file.'.php';
    }

    public function compileRealVar(&$content)
    {
        $limit = '/{x2;realhtml:([^}]+)}/';
        $replace = "'<?php echo html_entity_decode(\\\$this->ev->stripSlashes('.\$this->_compileArray('\${1}').')); ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo html_entity_decode($this->ev->stripSlashes('.$this->_compileArray($matches[1]).'))?>';
        },$content);
    }

    public function compileVar(&$content)
    {
        $limit = '/{x2;\$(\w+)}/';
        $content = preg_replace_replace($limit,function($matches){
            return '<?php echo $this->tpl_var['.$matches[1].'];?>';
        },$content);
    }

    public function _compileVar($str)
    {
        $limit = '/\$([\w|\']+)/';
        $replace = "'\$this->tpl_var[\'\${1}\']'";
        $str = preg_replace_callback($limit,function($matches){
            return '$this->tpl_var['.$matches[1].']';
        },$str);
        return $str;
    }

    public function compileTvar(&$content)
    {
        $limit = '/{x2;v:([\w|\']+)}/';
        $replace = "'<?php echo \$\${1}; ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo $'.$matches[1].';?>';
        },$content);
    }

    public function _compileTvar($str)
    {
        $limit = '/v:([\w|\']+)/';
        $replace = "'\$\${1}'";
        $str = preg_replace_callback($limit,function($matches){
            return '$'.$matches[1];
        },$str);
        return $str;
    }

    public function compileConst(&$content)
    {
        $limit = '/{x2;c:(\w+)}/';
        $replace = "'<?php echo \${1}; ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo $'.$matches[1].';?>';
        },$content);
    }

    public function compileArray(&$content)
    {
        $limit = '/{x2;([\$|v][\$|:|\[|\w|\]|\s|\']+)}/';
        $replace = "'<?php echo '.\$this->_compileArray('\${1}').'; ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo '.$this->_compileArray($matches[1]).';?>';
        },$content);
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
        $replace = "'<?php echo date(\${2},'.\$this->_compileArray('\${1}').'); ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo date($'.$matches[2].','.$this->_compileArray($matches[1]).');?>';
        },$content);
    }

    public function compileSubstring(&$content)
    {
        $limit = '/{x2;substring:([^,]+),([^}]+)}/';
        $replace = "'<?php echo \\\$this->G->make(\'strings\')->subString('.\$this->_compileArray('\${1}').',\${2}); ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo $this->G->make(\'strings\')->subString('.$this->_compileArray($matches[1]).','.$matches[2].'); ?>';
        },$content);
    }

    public function compileRealSubstring(&$content)
    {
        $limit = '/{x2;realsubstring:([^,]+),([^}]+)}/';
        $replace = "'<?php echo \\\$this->G->make(\'strings\')->subString(strip_tags(html_entity_decode(\\\$this->ev->stripSlashes('.\$this->_compileArray('\${1}').'))),\${2}); ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo $this->G->make(\'strings\')->subString(strip_tags(html_entity_decode($this->ev->stripSlashes('.$this->_compileArray($matches[1]).'))),'.$matches[2].'); ?>';
        },$content);
    }

    public function compileEval(&$content)
    {
        $limit = '/{x2;eval:([^}]+)}/';
        $replace = "'<?php '.\$this->_compileArray(\\\$this->ev->stripSlashes('\${1}')).'; ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php '.$this->_compileArray($this->ev->stripSlashes($matches[1])).'; ?>';
        },$content);
    }

    public function compileSql(&$content)
    {
        $limit = '/{x2;sql:"([^"]+)",([a-z]+)}/';
        $replace = "'<?php \$\${2}=\\\$this->G->make(\'pepdo\')->fetchAll(array(\"sql\"=>\"'.\$this->_compileArray('\${1}').'\")); ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php $'.$matches[2].'=$this->G->make(\'pepdo\')->fetchAll(array("sql"=>"'.$this->_compileArray($matches[1]).'")); ?>';

        },$content);
    }

    public function compileIf(&$content)
    {
        $limit = '/{x2;if:([^}]+)}/';
        $replace = "'<?php if('.\$this->_compileArray('\${1}').'){ ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php if('.$this->_compileArray($matches[1]).'){ ?>';
        },$content);

        $limit = '/{x2;elseif:([^}]+)}/';
        $replace = "'<?php } elseif('.\$this->_compileArray('\${1}').'){ ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php } elseif('.$this->_compileArray($matches[1]).'){ ?>';
        },$content);

        $limit = '/{x2;else}/';
        $replace = "<?php } else { ?>";
        $content = preg_replace($limit,$replace,$content);

        $limit = '/{x2;endif}/';
        $replace = "<?php } ?>";
        $content = preg_replace($limit,$replace,$content);
    }

    public function compileLoop(&$content)
    {
        $limit = '/{x2;loop:([^,]+),(\w+),*(\d*),*(\d*),*(\d*)}/';
        $replace = "'<?php  \$'.\${2}.'All = count('.\$this->_compileArray('\${1}').'); for(\$\${2}= '.\$this->reBool('\${3}').';\$\${2}<\$\${2}All;\$\${2}+='.\$this->reBool('\${5}',1).') { if('.\$this->reBool('\${4}').' && \$\${2}>='.\$this->reBool('\${4}').')break; ?>'";
        $content = preg_replace_callback($limit,function($matches){
            $html='<?php ';
            $html.='$'.$matches[2].'All = count('.$this->_compileArray('${1}').');';
            $html.='for($'.$matches[2].'= '.$this->reBool($matches[3]).';$'.$matches[2].'<$'.$matches[2].'All;';
            $html.='$'.$matches[2].'+='.$this->reBool($matches[5],1).')';
            $html.='{ if('.$this->reBool($matches[4]).' && $'.$matches[2].'>=';
            $html.=$this->reBool($matches[4]).')break;?>';
            return $html;
        },$content);

        $limit = '/{x2;endloop}/';
        $replace = "<?php } ?>";
        $content = preg_replace($limit,$replace,$content);
    }

    public function compileTree(&$content)
    {
        $limit = '/{x2;tree:([^,]+),(\w+),(\w+)}/';
        $replace = "'<?php \$\${3} = 0;  foreach('.\$this->_compileArray('\${1}').' as \$key => \$\${2}){   \$\${3}++; ?>'";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php $'.$matches[3].' = 0;  foreach('.$this->_compileArray($matches[1]).' as $key => $'.$matches[2].'){   $'.$matches[3].'++; ?>';
        },$content);

        $limit = '/{x2;endtree}/';
        $replace = "<?php } ?>";
        $content = preg_replace($limit,$replace,$content);
    }

    public function compileBlock(&$content)
    {
        $limit = '/{x2;block:(\d+)}/';
        $replace = "'<?php echo \$this->exeBlock(\"$1\"); ?>' ";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo $this->exeBlock('.$matches[1].'); ?>';
        },$content);
    }

    public function compileEnter(&$content)
    {
        $limit = '/{x2;enter}/';
        $replace = "'<?php echo \" \"; ?>' ";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php echo " "; ?> ';
        },$content);
    }

    public function compileCode(&$content)
    {
        $limit = '/{x2;code:(.+)}/';
        $replace = "'<?php '.'\$this->_compileArray('\${1}').'; ?>' ";
        $content = preg_replace_callback($limit,function($matches){
            return '<?php '.$this->_compileArray($matches[1]).'; ?> ';
        },$content);
    }

    //解析模板
    public function fetch($file,$par='',$type = 0,$cachename = NULL)
    {
        $this->initFile();
        $source = 'app/'.$this->dir.$file.'.tpl';
        $outfile = 'data/compile/'.$this->dir.'%%cpl%%'.$file.'.php';
        if($cachename)$outcache = 'data/html/'.$this->dir.$cachename.'.html';
        else
            $outcache = 'data/html/'.$this->dir.$file.$par.'.html';
        if((!file_exists($outfile)) || (filemtime($outfile) < filemtime($source)))
        {
            $content = $this->compileTpl($source);
            $this->fl->writeFile($outfile,$content);
            if($type)
            {
                include $outfile;
                $this->fl->delFile($outcache);
            }
        }
        else
        {
            if($this->isCache && (!file_exists($outcache) || (time() - filemtime($outcache)) > $this->cacheTime))
            {
                if($type)
                {
                    ob_start();
                    include $outfile;
                    $cachecontent = ob_get_contents();
                    ob_flush();
                    $this->fl->writeFile($outcache,$cachecontent);
                    ob_clean();
                }
            }
            else
            {
                include $outfile;
            }
        }
    }

    public function fetchContent($content)
    {
        return $this->compileContentTpl($content);
    }

    public function fetchExeCnt($file)
    {
        $source = 'app/'.$this->dir.$file.'.tpl';
        $content = $this->compileTpl($source);
        ob_start();
        eval(' ?>'.$source.'<?php ');
        $cachecontent = ob_get_contents();
        ob_flush();
        ob_clean();
        return $cachecontent;
    }

    //展示模板
    public function display($file,$par=NULL,$cachename = NULL)
    {
        $this->fetch($file,$par,1,$cachename);
    }
}
