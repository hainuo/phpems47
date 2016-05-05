{x2;include:head}
<body>
<!--导航-->
{x2;include:nav}
<!--头部-->
<div id="head">
	<div id="banner"><img src="app/exam/styles/image/head_banner.jpg" border="0" usemap="#Map" longdesc="注册会计师机考模拟系统" />
      <map name="Map" id="Map">
        <area shape="rect" coords="20,25,181,75" href="http://www.dongao.com/" title="东奥会计在线" />
      </map>
	</div>
</div>
<!--主体-->
<div id="main">
	<!--主体左侧-->
	{x2;include:left}
	<!--主体左侧 结束-->
	<!--主体右侧 -->
	<div id="right_760" class="right_970">
    	{x2;include:bread}
    	<div class="bor_top"></div>
    	<div class="bor_mid">
    		<div id="hide_left"><a href="javascript:pr()"></a></div>
            <div id="notice">
            	<h2 class="page_title"><img src="app/exam/styles/image/km_{x2;$data['currentsubject']['subjectid']}.jpg" alt="会计" class="mr_10" /><span id="time_top">考试剩余时间：<b><span id="timer_h">00</span>：<span id="timer_m">00</span>：<span id="timer_s">00</span></b></span></h2>
                <div id="tixingmulu">
                	<h3>目录（考试分成以下部分）</h3>
                    <table width="100%">
                      {x2;tree:$sessionvars['examsessionsetting']['questype'],question,eqid}
                      {x2;if:v:question['number']}
                      {x2;if:!v:url}
                      {x2;eval: v:url=v:key}
                      {x2;endif}
                      <tr>
                        <td><b>{x2;$ols[v:eqid]}、{x2;$questype[v:key]['questype']}</b><br /><p>{x2;v:question['describe']}。</p></td>
                        <td><a href="?exam-app-exam-exampaper&questype={x2;v:key}" class="enter_btn"></a></td>
                      </tr>
                      {x2;endif}
                      {x2;endtree}
                    </table>
                    <div class="mt_10"><b><span class="red">注意：</span>本场考试时间为<span class="red">{x2;$sessionvars['examsessiontime']}</span>分钟。</b></div>
                </div>
                <div id="bnt_back_next"><a href="?exam-app-exam-special" id="btn_back"></a><a href="?exam-app-exam-exampaper&questype={x2;v:url}" id="btn_next"></a></div>
            </div>
    	</div>
    	<div class="bor_bottom"></div>
    </div>
	<!--主体右侧 结束-->
{x2;include:foot}
<script type="text/javascript">
$(document).ready(function(){
$.get('?exam-app-index-ajax-lefttime&rand'+Math.random(),function(data){
		var setting = {
			time:{x2;$sessionvars['examsessiontime']},
			hbox:$("#timer_h"),
			mbox:$("#timer_m"),
			sbox:$("#timer_s"),
			finish:function(){window.location='?exam-app-exam-subpaper';}
		}
		setting.lefttime = parseInt(data);
		if(setting.lefttime < 10)da.util.sessionStorage.setItem("form1",null);
		countdown(setting);
	});
});
</script>
{x2;include:foot}
</body>
</html>