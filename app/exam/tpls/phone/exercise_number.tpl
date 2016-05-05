                            {x2;tree:$questype,quest,qid}
                            {x2;if:!v:quest['questsort'] && $numbers[v:quest['questid']]}
                            <option value="{x2;v:quest['questid']}">
                            	{x2;v:quest['questype']}（共{x2;$numbers[v:quest['questid']]}题）
                            </option>
                            {x2;endif}
                        	{x2;endtree}