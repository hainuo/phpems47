		    	<script type="text/javascript">
		    	function selectall(obj,a,b){
		    		$(".sbox").prop('checked', $(obj).is(':checked'));
		    		$(".sbox").each(function(){
		    			selectquestions(this,a,b);
		    		});
		    	}
		    	</script>
		    	<form action="index.php?exam-master-exams-selectquestions" method="post" direct="modal-body">
					<table class="table">
						<tr>
							<td class="form-inline">
								录入时间：
								<input type="text" name="search[stime]" size="9" class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" id="stime" value="{x2;$search['stime']}"/> - <input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" size="9" type="text" name="search[etime]" id="etime" value="{x2;$search['etime']}"/>
								关键字：
								<input name="search[keyword]" class="input-small" size="8" type="text" value="{x2;$search['keyword']}"/>
							</td>
						</tr>
						<tr>
							<td class="form-inline">
								<select name="search[questionisrows]" class="input-medium">
						  		<option value="0">普通试题</option>
								<option value="1"{x2;if:$search['questionisrows']} selected{x2;endif}>题帽题</option>
						  		</select>
								<input type="hidden" name="search[questiontype]" value="{x2;$search['questiontype']}">
								<input type="hidden" name="search[questionsubjectid]" value="{x2;$search['questionsubjectid']}">
				        		录入人：<input name="search[username]" class="input-mini" size="5" type="text" value="{x2;$search['username']}"/>
								<select name="search[questionlevel]" class="combox input-medium">
							  		<option value="0">难度不限</option>
									<option value="1">易</option>
									<option value="2">中</option>
									<option value="3">难</option>
						  		</select>
							</td>
				        </tr>
				        <tr>
							<td class="form-inline">
						  		<select name="search[questionsectionid]" class="combox input-medium" id="sectionselect" target="knowsselect" refUrl="?exam-master-questions-ajax-getknowsbysectionid&sectionid={value}">
							  		<option value="">选择章节</option>
							  		{x2;if:$sections}
							  		{x2;tree:$sections,section,sid}
							  		<option value="{x2;v:section['sectionid']}"{x2;if:v:section['sectionid'] == $search['questionsectionid']} selected{x2;endif}>{x2;v:section['section']}</option>
							  		{x2;endtree}
							  		{x2;endif}
						  		</select>
						  		<select name="search[questionknowsid]" id="knowsselect" class="input-medium">
							  		<option value="">选择知识点</option>
							  		{x2;if:$knows}
							  		{x2;tree:$knows,know,kid}
							  		<option value="{x2;v:know['knowsid']}"{x2;if:v:know['knowsid'] == $search['questionknowsid']} selected{x2;endif}>{x2;v:know['knows']}</option>
							  		{x2;endtree}
							  		{x2;endif}
						  		</select>
								<button class="btn btn-primary" type="submit">检索</button>
							</td>
						</tr>
					</table>
				</form>
				<div class="input"></div>
				{x2;if:$search['questionisrows']}
				<table class="table table-hover">
					<thead>
						<tr>
					        <th><input type="checkbox" onclick="javascript:selectall(this,'iselectrowsquestions_{x2;$search['questiontype']}','ialreadyselectnumber_{x2;$search['questiontype']}');"/></th>
					        <th>试题内容</th>
					        <th>小题量</th>
					        <th>难度</th>
						</tr>
					</thead>
					<tbody>
						{x2;tree:$questions['data'],question,qid}
				        <tr>
				          <td><input rel="{x2;v:question['qrnumber']}" class="sbox" type="checkbox" name="ids[]" value="{x2;v:question['qrid']}" onclick="javascript:selectquestions(this,'iselectrowsquestions_{x2;$search['questiontype']}','ialreadyselectnumber_{x2;$search['questiontype']}')"/></td>
				          <td>
						  	  <a href="javascript:;" {x2;eval: echo strip_tags(html_entity_decode(v:question['qrquestion']))}>{x2;substring:strip_tags(html_entity_decode(v:question['qrquestion'])),165}</a>
						  </td>
						  <td>{x2;v:question['qrnumber']}</td>
						  <td>{x2;if:v:question['qrlevel']==2}中{x2;elseif:v:question['qrlevel']==3}难{x2;elseif:v:question['qrlevel']==1}易{x2;endif}</td>
				        </tr>
				        {x2;endtree}
					</tbody>
				</table>
				<div class="pagination pagination-right">
	            	<ul>{x2;$questions['pages']}</ul>
		        </div>
		    	<script type="text/javascript">
		    		jQuery(function($) {
						markSelectedQuestions('ids[]','iselectrowsquestions_{x2;$search['questiontype']}');
		    		});
		    	</script>
				{x2;else}
				<table class="table table-hover">
					<thead>
						<tr>
					        <th width="50"><input type="checkbox" onclick="javascript:selectall(this,'iselectquestions_{x2;$search['questiontype']}','ialreadyselectnumber_{x2;$search['questiontype']}');"/></th>
					        <th width="100">试题类型</th>
					        <th>试题内容</th>
					        <th width="50">难度</th>
						</tr>
					</thead>
					<tbody>
						{x2;tree:$questions['data'],question,qid}
				        <tr>
				          <td><input rel="1" class="sbox" type="checkbox" name="ids[]" value="{x2;v:question['questionid']}" onclick="javascript:selectquestions(this,'iselectquestions_{x2;$search['questiontype']}','ialreadyselectnumber_{x2;$search['questiontype']}')"/></td>
				          <td>{x2;$questypes[v:question['questiontype']]['questype']}</td>
				          <td>
						  	  <a href="javascript:;" title="{x2;eval: echo strip_tags(html_entity_decode(v:question['question']))}">{x2;substring:strip_tags(html_entity_decode(v:question['question'])),90}</a>
						  </td>
						  <td>{x2;if:v:question['questionlevel']==2}中{x2;elseif:v:question['questionlevel']==3}难{x2;elseif:v:question['questionlevel']==1}易{x2;endif}</td>
				        </tr>
				        {x2;endtree}
					</tbody>
				</table>
				<div class="pagination pagination-right">
	            	<ul>{x2;$questions['pages']}</ul>
		        </div>
		    	<script type="text/javascript">
		    		jQuery(function($) {
						markSelectedQuestions('ids[]','iselectquestions_{x2;$search['questiontype']}');
		    		});
		    	</script>
				{x2;endif}
