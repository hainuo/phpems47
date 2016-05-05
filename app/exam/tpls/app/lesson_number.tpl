                            <table class="table table-hover table-bordered">
								<tr class="success"><td colspan="2">{x2;$knows['knows']}</td></tr>
	                            <tr>
	                            {x2;tree:$questype,quest,qid}
	                            	<td>
	                            	{x2;v:quest['questype']}（共{x2;$numbers[v:quest['questid']]}题）
	                            	{x2;if:$numbers[v:quest['questid']]}
	                            	<a href="index.php?exam-app-lesson-ajax-setlesson&questype={x2;v:quest['questid']}&knowsid={x2;$knows['knowsid']}" class="btn btn-primary ajax" action-before="clearStorage">练习</a>
	                            	{x2;else}
	                            	<a href="javascript:;" class="btn">练习</a>
	                            	{x2;endif}
	                            	</td>
	                            	{x2;if:v:qid % 2 == 0}
                            	</tr>
                            	<tr>
	                            	{x2;endif}
	                        	{x2;endtree}
	                        	</tr>
                        	</table>