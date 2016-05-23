<?php
ini_set("auto_detect_line_endings", true);
require 'vendor/autoload.php';

//首先循环目录 读出所有的html
$dir = '/Users/fengliu/Downloads/基金从业2016网页备份';

class files
{

    //创建文件夹
    public function mdir($path)
    {
        if (!file_exists($path)) {
            $this->mdir(dirname($path));
            mkdir($path, 0777);
        }
    }

    //列出文件夹下的文件
    public function listDir($target)
    {
        $target = rtrim($target, '/');
        if (!is_dir($target)) return false;
        $handle = dir($target);
        $elem = [];
        while (false !== ($entry = $handle->read())) {
            if (($entry != '.') && ($entry != '..')) {
                if (is_file($target . '/' . $entry))
                    $elem['file'][] = ['name' => $entry, 'path' => $target . '/' . $entry, 'modify' => filemtime($target . '/' . $entry), 'size' => filesize($target . '/' . $entry)];
                elseif (is_dir($target . '/' . $entry))
                    $elem['dir'][] = ['name' => $entry, 'path' => $target . '/' . $entry, 'modify' => filemtime($target . '/' . $entry)];
            }
        }
        return $elem;
    }

    //复制文件夹
    public function copyDir($source, $destination, $child)
    {
        if (!is_dir($destination)) mkdir($destination, 0777);
        $handle = dir($source);
        while ($entry = $handle->read()) {
            if (($entry != '.') && ($entry != '..')) {
                if (is_dir($source . '/' . $entry)) {
                    if ($child) xCopy($source . '/' . $entry, $destination . '/' . $entry, $child);
                } else {
                    if (file_exists($destination . '/' . $entry)) unlink($destination . '/' . $entry);
                    if (!copy($source . '/' . $entry, $destination . '/' . $entry)) return false;
                }
            }
        }
        return true;
    }

    //删除文件夹
    public function delDir($dir)
    {
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != '.' && $file != '..') {
                $fullpath = $dir . '/' . $file;
                if (!is_dir($fullpath)) {
                    $this->delDir($fullpath);
                } else {
                    unlink($fullpath);
                }
            }
        }
        closedir($dh);
        rmdir($dir);
    }

    //写入文件
    public function writeFile($out, $content = '')
    {
        $t = dirname($out);
        if (!is_dir($t))
            $this->mdir($t);
        $fp = fopen($out, 'w');
        flock($fp, LOCK_EX);
        $wp = fwrite($fp, $content);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    //删除文件
    public function delFile($file)
    {
        if (file_exists($file)) unlink($file);
    }

    //读取文件
    public function readFile($file)
    {
        if (function_exists('file_get_contents')) {
            $content = file_get_contents($file);
        } else {
            $ay = file($file);
            if (!$ay) return false;
            foreach ($ay as $tmp) {
                $content .= $tmp;
            }
        }
        return $content;
    }

    //向文件追加内容
    public function appendFile($file, $content = '', $seek = -1)
    {
        $fp = fopen($file, 'a');
        if ($seek >= 0) fseek($fp, $seek);
        flock($fp, LOCK_EX);
        fwrite($fp, $content);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    //上传文件
    public function uploadFile($file, $updir, $sExtension = null, $name = null)
    {
        if (!$sExtension) $sExtension = $this->getFileExtName($file['name']);
        if (!$name) $name = time() . rand(1000, 9999);
        if (!file_exists($updir)) $this->mdir($updir);
        $url = $updir . $name . '.' . $sExtension;
        if (file_exists($url)) unlink($url);
        move_uploaded_file($file['tmp_name'], $url);
        if (file_exists($url)) {
            $oldumask = umask(0);
            chmod($url, 0777);
            umask($oldumask);
        }
        return $url;
    }

    //获取文件扩展名
    public function getFileExtName($filename)
    {
        $filename = strtolower($filename);
        $exts = explode('.', $filename);
        $ext = $exts[count($exts) - 1];
        if (strpos($ext, '?') >= 0) {
            $ext = explode('?', $ext);
            return $ext[0];
        } else
            return $ext;
    }

    //通过网络下载一个文件
    public function wGetFiles($url, $updir)
    {
        $sExtension = $this->getFileExtName($url);
        $name = time() . rand(1000, 9999);
        if (!file_exists($updir)) $this->mdir($updir);
        $path = $updir . $sExtension . '/' . date("Ymd", TIME) . '/' . $name . '.' . $sExtension;
        if (file_exists($path)) unlink($path);
        $this->writeFile($path, $this->readFile($url));
        if (file_exists($path)) {
            $oldumask = umask(0);
            chmod($url, 0777);
            umask($oldumask);
        }
        return $path;
    }

    //检测文件夹是否可写
    public function dirWriteAble($dir)
    {
        if (!is_dir($dir)) {
            $this->mdir($dir);
        }
        if (is_dir($dir)) {
            $writeable = $this->fileWriteAble("$dir/.test.tmp", 1);
        }
        return $writeable;
    }

    //检测文件是否可写
    public function fileWriteAble($file, $delTestFile = 0)
    {
        if ($fp = @fopen($file, 'w')) {
            fclose($fp);
            if ($delTestFile) @unlink($file);
            $writeable = 1;
        } else {
            $writeable = 0;
        }
        return $writeable;
    }

    public function outCsv($fname, $r)
    {
        if ($this->dirWriteAble(dirname($fname))) {
            $fp = fopen($fname, 'w');
            foreach ($r as $line) {
                fputcsv($fp, $line);
            }
            fclose($fp);
            return $fname;
        } else
            return false;
    }

    //生成缩略图
    public function thumb($source, $target, $width, $height, $isresize = 1, $isstream = false)
    {
        list($swidth, $sheight) = getimagesize($source);
        if (!$width) $width = $swidth;
        if (!$height) $height = $sheight;
        if ($isresize) {
            $w = $swidth / $width;
            $h = $sheight / $height;
            if ($w > $h) $height = $sheight / $w;
            else $width = $swidth / $h;
        }
        $tmp_pic = imagecreatetruecolor($width, $height);
        $ext = $this->getFileExtName($source);
        $s_pic = $this->createImage($source, $ext);
        if (!$s_pic) return false;
        if (function_exists('imagecopyresampled')) imagecopyresampled($tmp_pic, $s_pic, 0, 0, 0, 0, $width, $height, $swidth, $sheight);
        else imagecopyresized($tmp_pic, $s_pic, 0, 0, 0, 0, $width, $height, $swidth, $sheight);
        if ($isstream) $target = null;
        if ($this->writeImage($tmp_pic, $target, 100, 'png')) return true;
        else return false;
    }

    //生成水印
    public function waterMark($source, $logo, $alpha = 50, $isstream = false)
    {
        list($swidth, $sheight) = getimagesize($source);
        list($width, $height) = getimagesize($logo);
        $ext = $this->getFileExtName($source, false);
        $ext2 = $this->getFileExtName($logo, false);
        $s_pic = $this->createImage($source, $ext);
        imagealphablending($s_pic, true);
        $l_pic = $this->createImage($logo, $ext2);
        imagecopymergegray($s_pic, $l_pic, intval($swidth - $width), intval($sheight - $height), 0, 0, $width, $height, $alpha);
        if ($this->writeImage($s_pic, $source, 100, $ext)) return true;
        else return false;
    }

    //创建一个图片文件
    public function createImage($source, $ext)
    {
        switch ($ext) {
            case 'jpg':
                if (function_exists('imagecreatefromjpeg')) return imagecreatefromjpeg($source);
                else return false;
                break;

            case 'gif':
                if (function_exists('imagecreatefromgif')) return imagecreatefromgif($source);
                else return false;
                break;

            case 'png':
                if (function_exists('imagecreatefrompng')) return imagecreatefrompng($source);
                else return false;
                break;

            default:
                return false;
                break;
        }
    }

    //写入图片文件图像信息
    public function writeImage($source, $target, $alpha, $ext)
    {
        switch ($ext) {
            case 'jpg':
                if (imagejpeg($source, $target, $alpha)) return true;
                else return false;
                break;

            case 'gif':
                if (imagejpeg($source, $target, $alpha)) return true;
                else return false;
                break;

            case 'png':
                if (imagejpeg($source, $target, $alpha)) return true;
                else return false;
                break;

            default:
                return false;
                break;
        }
    }

    //创建随即验证码图片
    public function createRandImage($randCode = null, $width = 60, $height = 24, $mix = 50)
    {
        $par = intval($width / 4);
        $randCode = strval($randCode);
        $image = imagecreatetruecolor($width, $height);
        $gray = ImageColorAllocate($image, 55, 55, 55);
        imagefill($image, 0, 0, $gray);
        for ($i = 0; $i < 4; $i++) {
            $text_color = imagecolorallocate($image, rand(128, 255), rand(128, 255), rand(128, 255));
            imagettftext($image, 14, intval(rand(0, 60)), 10 + $i * $par, 23 + rand(3, 8), $text_color, 'files/public/font/Symbola.ttf', $randCode[$i]);
        }
        for ($i = 0; $i < 250; $i++) {
            $randcolor = ImageColorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($image, rand(1, $width), rand(1, $height), $randcolor);
        }
        imagepng($image);
        imagedestroy($image);
        return $randCode;
    }
}


function myscandir($pathname, $data = [])
{
    foreach (glob($pathname) as $filename) {
        if (is_dir($filename)) {
            $data = myscandir($filename . '/*', $data);
        } elseif (is_file($filename) and strpos($filename, 'html') > 0) {
//            echo $filename;
            $data[] = $filename;
        }
    }
    return $data;
}

function myscandir2($path)
{

    $mydir = dir($path);
    while ($file = $mydir->read()) {
        if (($file != ".") AND ($file != "..") and ($file != '.DS_Store')) {
            $data[] = $file;

        }
    }
    return $data;
}


function dump($arg)
{
    echo '<pre>';
    var_dump($arg);
    echo '</pre>';
}

function parsHtml($htmlfile, $item = 0)
{
    dump('开始处理文件' . $htmlfile);
    global $dir;
    //var_dump($htmlfile);
    //处理所属知识点
    if (strpos($htmlfile, '章节预测题'))
        $knowledge = false;
    else
        $knowledge = true;
    $html = file_get_contents($htmlfile);
    $dom = new \HtmlParser\ParserDom($html);
    $exam = $dom->find('div.exam');
    $questions = [];
    //处理文件名
    $filename = str_replace($dir, '.', $htmlfile);
    $filename = str_replace('.html', '-' . $item . '.csv', $filename);
    $questions['filename'] = $filename;
    foreach ($exam as $key => $e) {
        //处理题干
        $title = $e->find('span.exam_sub', 0);
        $title = $title->getPlainText();

        //处理题型
        //1单选题2多选题3判断题4问答题5填空题6故障题
        if (strpos($title, '多选题') > 0)
            $type = 2;
        if (strpos($title, '单选题') > 0)
            $type = 1;
        if (strpos($title, '判断题') > 0)
            $type = 3;
        if (strpos($title, '问答题') > 0)
            $type = 4;
        if (strpos($title, '填空题') > 0)
            $type = 5;
        if (strpos($title, '故障题') > 0)
            $type = 6;

        //处理选项
        $body = '';
        $options = $e->find('div.exam_options a');
        //选项数目
        $nums = count($options);
        foreach ($options as $v) {
            $body .= '<p>' . $v->getPlainText() . '</p>';
        }

        //处理答案
        $answer = $e->find('div.exam_option_menu a');
        if (empty($answer)) {
            var_dump($e->getPlainText());
            dump($filename);
            continue;
        }
        $answer = $answer[0]->getAttr('href');
        if (empty($answer)) {
            var_dump($e->getPlainText());
            dump($filename);
            continue;
        }
        preg_match('/\'([A-Z0-9]+)\'/', $answer, $matches);
//        dump($matches);
        if (!empty($matches)) {
            $answer = $matches[1];
        } else {
            dump($e->getPlainText());
            dump($filename);
            continue;//跳过 如果有错题就跳过
        }
        if ($type == 3 && $answer == 0) {//判断题 B为错误A为正确
            $answer = 'B';
        }
        if($type == 3 && $answer==1) {
            $answer = 'A';
        }
//        不需要进行多项处理
//        $lenth=strlen($answer);
//        $preanswer=$answer;
//        $answer='';
//        if ($lenth>1){
//            for($i=0,$i<$lenth,$i++){
//                $answer=$preanswer[$i].','
//            }
//        }

        //处理答题分析
        $anlyze = $e->find('div.exam_analyze_value pre', 0)->getPlainText();

        //处理所属知识点

        $questions[$key] = [
            'title'   => $title,
            'type'    => $type,
            'options' => $body,
            'nums'    => $nums,
            'answer'  => $answer,
            'anlyze'  => $anlyze,
        ];
//       dump($questions[$key]);
//       exit;
    }

//    var_dump($filename);exit;
    return $questions;
}

set_time_limit(0);
//批量获取文件
$datas = myscandir($dir);
foreach ($datas as $key => $data) {
//对文件进行处理
    $data = parsHtml($data, $key);
    $file = new files();
    $content = '';
    $filename = 'xxxx/'.$data['filename'];
    unset($data['filename']);
    $file->writeFile($filename, $content);

    $filehandler = fopen($filename, "w");
    foreach ($data as $questions) {
        $content = [];
        $content[] = $questions['type'];
        $content[] = iconv('utf8', 'gb2312//ignore', $questions['title']);
        $content[] = iconv('utf8', 'gb2312//ignore', $questions['options']);
        $content[] = $questions['nums'];
        $content[] = $questions['answer'];
        $content[] = iconv('utf8', 'gb2312//ignore', $questions['anlyze']);
        $content[] = 0;
        $content[] = 0;

//    $content = "'" . $questions['type'] . "'" . ',';
//    $content .= "'" . addslashes($questions['title']) . "'" . ',';
//    $content .= "'" . $questions['options'] . "'" . ',';
//    $content .= "'" . $questions['nums'] . "'" . ',';
//    $content .= "'" . $questions['answer'] . "'" . ',';
//    $content .= '0,0';
//    $content .= '\n';
        fputcsv($filehandler, $content);
    }
    dump('文件写入完成' . $filename);
    fclose($filehandler);
    dump($key);
}