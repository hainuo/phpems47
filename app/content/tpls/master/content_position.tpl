		<div class="bloc">
		    <form action="?content-master-contents-lite" method="post">
			    <div class="title">移动分类</div>
			    <div class="content">
			        <div class="input long">
			            <label>标题：</label>
			            <input type="text" name="contentids" value="{x2;$contentids}" needle="needle" msg="您必须输入标题" readonly>
			        </div>
			        <div class="input inline">
            			<select msg="您必须选择一个推荐位" needle="needle" name="position">
			            	<option value="">选择推荐位</option>
			            	{x2;tree:$poses,pos,pid}
			            	<option value="{x2;v:pos['posid']}">{x2;v:pos['posname']}</option>
			            	{x2;endtree}
			            </select>
			        </div>
			        <div class="input"></div>
			        <div class="submit">
			            <input type="submit" value="移动">
			            <input type="reset" value="重置" class="white">
			            {x2;tree:$search,arg,sid}
			            <input type="hidden" name="search[{x2;v:key}]" value="{x2;v:arg}"/>
			            {x2;endtree}
			            <input type="hidden" name="movecposition" value="1">
			        </div>
		        </div>
			</form>
		</div>