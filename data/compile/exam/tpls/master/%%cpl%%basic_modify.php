<?php if(!$this->tpl_var['userhash']){?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2">
            <?php $this->_compileInclude('menu'); ?>
        </div>
        <div class="span10" id="datacontent">
            <?php } ?>
            <ul class="breadcrumb">
                <li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname'];?></a> <span
                            class="divider">/</span></li>
                <li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-basic">考场管理</a> <span class="divider">/</span></li>
                <li class="active">修改考场</li>
            </ul>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#">修改考场</a>
                </li>
                <li class="dropdown pull-right">
                    <a href="index.php?exam-master-basic&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">考场管理</a>
                </li>
            </ul>
            <form action="index.php?exam-master-basic-modifybasic" method="post" class="form-horizontal">
                <fieldset>
                    <div class="control-group">
                        <label for="basic" class="control-label">考场名称</label>
                        <div class="controls">
                            <input id="basic" name="args[basic]" type="text" value="<?php echo $this->tpl_var['basic']['basic'];?>"
                                   needle="needle" msg="您必须输入考场名称"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">考场状态</label>
                        <div class="controls">
                            <label class="radio inline">
                                <input name="args[basicclosed]" type="radio" value="0"
                                       <?php if(!$this->tpl_var['basic']['basicclosed']){?>checked<?php } ?>/>开启
                            </label>
                            <label class="radio inline">
                                <input name="args[basicclosed]" type="radio" value="1"
                                       <?php if($this->tpl_var['basic']['basicclosed']){?>checked<?php } ?>/>关闭
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="basicsubjectid" class="control-label">考试科目</label>
                        <div class="controls">
                            <select id="basictypeid" name="args[basictypeid]" needle="needle" msg="您必须选择考场分类">
                                <option value="">选择考场分类</option>
                                <?php $sid = 0; foreach($this->tpl_var['types'] as $key => $type){  $sid++; ?>
                                <option value="<?php echo $type['typeid'];?>"<?php if($type['typeid'] == $this->tpl_var['basic']['basictypeid']){?>
                                        selected<?php } ?>><?php echo $type['type'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="basicthumb" class="control-label">考场缩略图</label>
                        <div class="controls">
                            <div class="thumbuper pull-left">
                                <div class="thumbnail">
                                    <a href="javascript:;" class="second label""><em class="uploadbutton" id="catimg"
                                                                                     exectype="thumb"></em></a>
                                    <div class="first" id="catimg_percent"></div>
                                    <div class="boot"><img
                                                src="<?php if($this->tpl_var['basic']['basicthumb']){?><?php echo $this->tpl_var['basic']['basicthumb'];?><?php } else { ?>app/core/styles/images/noimage.gif<?php } ?>"
                                                id="catimg_view"/><input type="hidden" name="args[basicthumb]"
                                                                         value="<?php echo $this->tpl_var['basic']['basicthumb'];?>"
                                                                         id="catimg_value"/></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="basicapi" class="control-label">API标识</label>
                        <div class="controls">
                            <input id="basicapi" name="args[basicapi]" type="text" value="<?php echo $this->tpl_var['basic']['basicapi'];?>"
                                   datatype="datatable" max="12" msg="API标识为不超过12字符的英文或数字"/>
                            <span class="help-block">API标识用于对外提供接口信息，如果单独使用本系统无须填写</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="basicsubjectid" class="control-label">考试科目</label>
                        <div class="controls">
                            <select id="basicsubjectid" name="args[basicsubjectid]" needle="needle" msg="您必须选择考试科目">
                                <option value="">选择科目</option>
                                <?php $sid = 0; foreach($this->tpl_var['subjects'] as $key => $subject){  $sid++; ?>
                                <option value="<?php echo $subject['subjectid'];?>"<?php if($subject['subjectid'] == $this->tpl_var['basic']['basicsubjectid']){?>
                                        selected<?php } ?>><?php echo $subject['subject'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="basicareaid" class="control-label">考试地区</label>
                        <div class="controls">
                            <select id="basicareaid" name="args[basicareaid]" needle="needle" msg="您必须选择考试地区">
                                <option value="">选择地区</option>
                                <?php $aid = 0; foreach($this->tpl_var['areas'] as $key => $area){  $aid++; ?>
                                <option value="<?php echo $area['areaid'];?>"<?php if($area['areaid'] == $this->tpl_var['basic']['basicareaid']){?>
                                        selected<?php } ?>><?php echo $area['area'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">做为免费考场</label>
                        <div class="controls">
                            <label class="radio inline">
                                <input name="args[basicdemo]" type="radio" value="1"
                                       <?php if($this->tpl_var['basic']['basicdemo']){?>checked<?php } ?>/>是
                            </label>
                            <label class="radio inline">
                                <input name="args[basicdemo]" type="radio" value="0"
                                       <?php if(!$this->tpl_var['basic']['basicdemo']){?>checked<?php } ?>/>否
                            </label>
                            <span class="help-block">免费考场用户开通考场时不扣除积分</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="basicprice" class="control-label">价格设置</label>
                        <div class="controls">
                            <textarea class="input-xlarge" rows="4" name="args[basicprice]"
                                      id="basicprice"><?php echo $this->tpl_var['basic']['basicprice'];?></textarea>
                            <span class="help-block">请按照“时长:开通所需积分”格式填写，每行一个，时长以天为单位，免费考场此设置无效。</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button class="btn btn-primary" type="submit">提交</button>
                            <input type="hidden" name="basicid" value="<?php echo $this->tpl_var['basic']['basicid'];?>"/>
                            <input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
                            <input type="hidden" name="modifybasic" value="1"/>
                            <?php $aid = 0; foreach($this->tpl_var['search'] as $key => $arg){  $aid++; ?>
                            <input type="hidden" name="search[<?php echo $key;?>]" value="<?php echo $arg;?>"/>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
            </form>
            <?php if(!$this->tpl_var['userhash']){?>
        </div>
    </div>
</div>
</body>
</html>
<?php } ?>