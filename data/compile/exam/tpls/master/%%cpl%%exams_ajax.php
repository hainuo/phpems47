	        <script type="text/javascript">
	    	function selectexams(o,d){
	    		d = $('#'+d);
	    		s = d.val();
	    		if(s == '')s= ',';
	    		else
	    		s = ','+s+',';
	    		if($(o).is(':checked')){
					if(s.indexOf(','+$(o).val()+',') < 0){
						s = s+$(o).val()+',';
						s = s.substring(1,s.length-1);
					}
				}
				else{
					if(s.indexOf(','+$(o).val()+',') >= 0){
						var t = eval('/,'+$(o).val()+',/');
						s = s.replace(t,',');
						s = s.substring(1,s.length-1);
					}
				}
				if(s == ',' || s == ',,')s = '';
				d.val(s);
	    	}

	    	function markSelectedExams(n,o)
	    	{
	    		$("[name='"+n+"']").each(function(){if((','+$('#'+o).val()+',').indexOf(','+$(this).val()+',') >= 0)$(this).attr('checked',true);});
	    	}

	    	function selectall(obj,a){
	    		$(".sbox").prop('checked', $(obj).is(':checked'));
	    		$(".sbox").each(function(){
	    			selectexams(this,a);
	    		});
	    	}
	    	</script>
	        <table class="table table-hover">
	            <thead>
	                <tr>
	                    <th>ID</th>
				        <th>考试名称</th>
				        <th>组卷人</th>
				        <th>组卷类型</th>
				        <th>组卷时间</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php $eid = 0; foreach($this->tpl_var['exams']['data'] as $key => $exam){  $eid++; ?>
			        <tr>
						<td>
							<input rel="1" class="sbox" type="checkbox" name="ids[]" value="<?php echo $exam['examid'];?>" onclick="javascript:selectexams(this,'<?php echo $this->tpl_var['target']; ?>')"/>
						</td>
						<td>
							<?php echo $exam['exam'];?>
						</td>
						<td>
							<?php echo $exam['examauthor'];?>
						</td>
						<td>
							<?php if($exam['examtype'] == 1){?>随机组卷<?php } elseif($exam['examtype'] == 2){?>手工组卷<?php } else { ?>即时组卷<?php } ?>
						</td>
						<td>
							<?php echo date('Y-m-d',$exam['examtime']); ?>
						</td>
			        </tr>
			        <?php } ?>
	        	</tbody>
	        </table>
	        <div class="pagination pagination-right">
	            <ul><?php echo $this->tpl_var['exams']['pages'];?></ul>
	        </div>
	        <script type="text/javascript">
	    		jQuery(function($) {
					markSelectedExams('ids[]','<?php echo $this->tpl_var['target']; ?>');
	    		});
	    	</script>