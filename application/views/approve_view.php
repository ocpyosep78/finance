<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายการเอกสารต้นเรื่อง
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" 
					url="<?php echo base_url(); ?>approve/get"
					toolbar="#toolbar"  
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true">
				<thead>
					<tr>
                        <th data-options="field:'doc_date',width:55" sortable="true">วันที่</th>
						<th data-options="field:'doc_number',width:60" sortable="true">เลขที่ มอ.</th>
						<th data-options="field:'file_number',width:30" sortable="true">ลำดับ</th>
						<th data-options="field:'subject',width:200" sortable="true">เรื่อง</th>
                        <th data-options="field:'detail',width:170" sortable="true">รายละเอียด</th>
						<th data-options="field:'department',width:110" sortable="true">ภาควิชา/หน่วยงาน</th>
						<th data-options="field:'amount',width:80,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงินอนุมัติ</th>
					
					</tr>
				</thead>	
			</table>
			<?php if($this->session->userdata('Role') == 'Administrator' || $this->session->userdata('Role') == 'Finance'): ?>
			<div id="toolbar">  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-add" plain="true" onclick="add()">เพิ่ม</a>
		    <a href="#" class="easyui-linkbutton" iconCls="icons-ok" plain="true" onclick="disbursement()">เบิกจ่าย</a>
		    <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
		    <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a> 
		    </div>
		    <?php endif; ?>
	  </div>
	  
	  
</div>		    


<div id="dlg" class="easyui-dialog" style="width:740px;height:390px"  
        closed="true" buttons="#dlg-buttons">  

<div class="container-fluid">       
  <div class="row-fluid">
		<form id="fm" method="post" class="form-horizontal ">
	        <fieldset style="padding-top: 0">
		         <legend style="font-size: 11pt">ข้อมูลเอกสารต้นเรื่อง</legend>
				      <table border="0"  class="table-form span12">
				      	<tbody>
				      	<tr>
				      		<td>
                              
							    <label class="control-label" style="width: 80px;">เลขที่เอกสาร</label>
								<input type="text" name="doc_number" class="easyui-validatebox" style="font-size: 12px;width: 120px;" required="true">
				      		</td>
				      		<td>
				      			<label class="control-label" style="width: 80px;">ลำดับที่แฟ้ม</label>
								<input type="text" name="file_number" class="input-mini" style="font-size: 12px">
				      		</td>
				      		<td>
				      		     <label class="control-label" style="width: 80px;">คณะ</label>
				      	     	  <input id="ccfaculty" name="ccfaculty" class="easyui-combobox" style="height:30px;width:200px;"  required="true"
				                           data-options="url:'<?php echo base_url(); ?>faculty/combobox',
				                    	   valueField:'code',
				                           textField:'name',
				                           panelHeight:'auto',
				                           onSelect: function(rec){
										        var url = '<?php echo base_url(); ?>department/get_by/'+rec.code;  
												$('#ccdepartment').combobox('clear');
					                            $('#ccdepartment').combobox('reload', url);        
									        }
				                           ">   
				      		</td>
				      	</tr>
				      	<tr>
				      	     <td colspan="2">
 				      	     	<label class="control-label" style="width: 80px;">วันที่</label>
						          <input name="doc_date" class="easyui-datebox" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
							    
				      	     </td>
					     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">ภาควิชา</label>
				      	     	  <input id="ccdepartment" name="ccdepartment" class="easyui-combobox"
				     				       style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				          if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>division/get_by/'+rec.id;  
												$('#ccdivision').combobox('clear');
					                            $('#ccdivision').combobox('reload', url);
				                              }
									       }
				     				       ">
							    
				      	     </td>	
				      	</tr>
				      	<tr>
				      	   <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">เรื่อง</label>
				      	     	  <input type="text" name="subject" style="font-size: 12px;width:280px;">
							    
				      	     </td>
                            <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">หน่วยงาน</label>
				      	     	   <input id="ccdivision" name="ccdivision" class="easyui-combobox" style="height:30px;width:200px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />
							    
				      	     </td>
				      	</tr>
                        <tr>
				     			<td colspan="3">
				     				<label class="control-label" style="width: 80px;">รายละเอียด</label>
								<textarea name="detail" rows="2" style="font-size: 12px;width:565px;"></textarea>
								
				     			</td>
				     	</tr>
                        <tr>
				     		  <td colspan="2">
				     			  <label class="control-label" style="width: 80px;">วงเงินอนุมัติ</label>
				      	     	  <input type="text" id="amount" name="amount" class="easyui-numberbox" data-options="min:0,precision:2" style="font-size: 12px;"> บาท

				     		  </td>
                              <td>
                           
				     			  <label class="checkbox"><input type="checkbox" name="checkbox">ไม่ระบุจำนวนเงินอนุมัติ</label>
				      	     	
				     		  </td>
				     	</tr>
                        </tbody>
				     </table>

		    </fieldset>
		   
		    <div id="dlg-buttons">
			<button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			<button type="button" class="btn" onclick="javascript:$('#dlg').dialog('close')">Cancel</button>
		    </div>
		    
		</form>
   </div>
</div>

</div>




<script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
        var url;

        function add() {
            $('#dlg').dialog('open').dialog('setTitle', 'เพิ่มข้อมูลใหม่');
            $('#fm').form('clear');
            $('#ccfaculty').combobox('select', '53');
            url = base_url + 'approve/add';
        }

        function disbursement() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                url = '<?php echo base_url(); ?>disbursement/form/' + row.id;
                window.location.href = url;
            }
        }

        function edit() {
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','แก้ไขข้อมูล');
				$('#fm').form('load',row);
				url = '<?php echo base_url(); ?>approve/update/' + row.id;

				$('#ccfaculty').combobox('select','53');
				$('#ccdepartment').combobox('select',row.department_id); //select combobox
			}
		}

       function save() {
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
				  //  console.log(result);
				   
				    var result = eval('(' + result + ')');
					if (result.success){
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the user data
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}
		function del(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
					if (r){
					    $.post('<?php echo base_url(); ?>approve/delete', { id: row.id }, function (result) {
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}
		}


$(document).ready(function () {

        $('input[type="checkbox"][name="checkbox"]').change(function () {
            if (this.checked) {
                $('#amount').numberbox('setValue', 0.00);
                $('#amount').numberbox('disable');

            }
            else {
                $('#amount').numberbox('clear');
                $('#amount').numberbox('enable');
            }

        });
 });
</script>
