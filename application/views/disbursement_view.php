<div class="box box-color box-bordered">
    <div class="box-title">
		<h3>
			<i class="icon-table"></i>
			รายการเอกสารเบิกจ่าย
		</h3>
	</div>
	<div class="box-content nopadding">
		<table id="dg" class="easyui-datagrid" style="height:500px"
					url="<?php echo base_url(); ?>disbursement/get"
					toolbar="#toolbar"  
		            rownumbers="true" fitColumns="true" singleSelect="true" pagination="true">
				<thead>
					<tr>
						<th data-options="field:'doc_date',width:100" sortable="true">วันที่เบิกจ่าย</th>
						<th data-options="field:'doc_number',width:120" sortable="true">เลขที่เอกสาร</th>
						<th data-options="field:'file_number',width:70" sortable="true">ลำดับแฟ้ม</th>
						<th data-options="field:'subject',width:280" sortable="true">เรื่อง</th>
						<th data-options="field:'department',width:180" sortable="true">ภาควิชา</th>
						<th data-options="field:'costs',width:120" sortable="true">งบรายจ่าย</th>
						<th data-options="field:'coststype',width:100" sortable="true">ประเภท</th>
						<th data-options="field:'costsname',width:220" sortable="true">รายการจ่าย</th>
						<th data-options="field:'total_amount',width:150,align:'right'" formatter="formatCurrency" sortable="true">จำนวนเงิน</th>
					</tr>
				</thead>	
			</table>
			<?php if($this->session->userdata('Role') == 'Administrator' || $this->session->userdata('Role') == 'Finance'): ?>
			<div id="toolbar">
			 <a href="#" class="easyui-linkbutton" iconCls="icons-undo" plain="true" onclick="add()">เลือกเอกสารอนุมัติ</a>
		     <a href="#" class="easyui-linkbutton" iconCls="icons-edit" plain="true" onclick="edit()">แก้ไข</a>  
		     <a href="#" class="easyui-linkbutton" iconCls="icons-remove" plain="true" onclick="del()">ลบ</a>  
		    </div>
		    <?php endif; ?>
	  </div>
</div>		    

<script src="<?php echo base_url('assets/jquery-easyui/extension/datagrid-detailview.js');?>"></script>
<script type="text/javascript">
	    var base_url = '<?php echo base_url(); ?>';
		var url;
		function add(){
			url = base_url+'approve/';
			window.location.href = url;
		}
		function edit(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url = base_url+'disbursement/form/'+row.approve_id+'/'+row.id;
				window.location.href = url;
			}
		}
		function del(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
					if (r){
						$.post('<?php echo base_url(); ?>disbursement/delete',{id:row.id, app_id:row.approve_id},function(result){
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

$(document).ready(function() {
	 $(function(){
            $('#dg').datagrid({
                view: detailview,
                detailFormatter:function(index,row){
                    return '<div style="padding:2px"><table class="ddv"></table></div>';
                },
                onExpandRow: function(index,row){
                    var ddv = $(this).datagrid('getRowDetail',index).find('table.ddv');
                    ddv.datagrid({
                        url: base_url+'payment/get_detail/'+row.id,
                        fitColumns:true,
                        singleSelect:true,
                        rownumbers:true,
                        loadMsg:'',
                        height:'auto',
                        columns:[[
                            {field:'code',title:'รหัส',width:150},
                            {field:'name',title:'ชื่อผู้รับเงิน',width:200},
                            {field:'amount',title:'จำนวนเงิน',width:200,align:'right',formatter:formatCurrency}
                        ]],
                        onResize:function(){
                            $('#dg').datagrid('fixDetailRowHeight',index);
                        },
                        onLoadSuccess:function(){
                            setTimeout(function(){
                                $('#dg').datagrid('fixDetailRowHeight',index);
                            },0);
                        }
                    });
                    $('#dg').datagrid('fixDetailRowHeight',index);
                }
            });
        });
	
	
	
});

	</script>