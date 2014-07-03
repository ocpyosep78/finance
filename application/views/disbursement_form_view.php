<div id="dlg" class="easyui-dialog" style="width:740px;height:390px"  
        closed="true" buttons="#dlg-buttons">  

<div class="container-fluid">       
  <div class="row-fluid">
		<form id="fm_popup" method="post" class="form-horizontal ">
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
						          <input name="doc_date" class="easyui-datebox" required="true" style="height:30px;width: 133px;" data-options="formatter:myformatter,parser:myparser" >
							    
				      	     </td>
					     <td colspan="2">
 				      	     	  <label class="control-label" style="width: 80px;">ภาควิชา</label>
				      	     	  <input id="ccdepartment" name="ccdepartment" class="easyui-combobox" required="true"
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
			<button type="button" class="btn btn-primary" onclick="save_new_document()">Save changes</button>
			<button type="button" class="btn" onclick="javascript:$('#dlg').dialog('close')">Cancel</button>
		    </div>
		    
		</form>
   </div>
</div>

</div>



<div class="container-fluid">       
  <div class="row-fluid">
		<form id="fm" class="form-horizontal ">
	        <fieldset style="padding-top: 0">
		         <legend style="font-size: 11pt">อ้างอิงเอกสารส่งเบิก</legend>
		         
		           <input type="hidden" id="approveid" name="approveid">

                    <table border="0"  class="table-form span12">
                        <tr>
                            <td>
							        <label class="control-label" style="width: 80px;">เอกสารเลขที่</label>
								    <input type="text" id="approve_doc_number" name="approve_doc_number" style="font-size: 12px;width: 120px;">
                                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icons-search'" onclick="checking()">ตรวจสอบ</a>
				      	    </td>
                            <td> 
                                 <label class="control-label" style="width: 150px;">หรือ <a href="#" onclick="add()">เพิ่มเอกสารใหม่</a></label>
                                 
				      	    </td>
                        </tr>
                        <tr>
				     			<td colspan="2">
				     			<label class="control-label" style="width: 80px;">เรื่อง</label>
				     			<input type="text"  name="approve_subject" style="font-size: 12px;width:280px;" disabled="disabled">
			                       
				     	        </td>
                                
				     	</tr>
                        <tr>
				     		  <td colspan="2">
				     			  <label class="control-label" style="width: 80px;">วงเงินอนุมัติ</label>
				      	     	  <input type="text" name="approve_amount" style="font-size: 12px;width:120px;" disabled="disabled"> บาท
				     		  </td>
				     	</tr>
                    </table>

		
						<legend style="font-size: 11pt">ข้อมูลเบิกจ่าย</legend>
						 <table id="pay-table" border="0"  class="table-form span12">
						 	<tbody>
                                <tr>
                                 <td colspan="2">
                                  <table border="0">
                                  		<tr>
                                          <td>
                                    		 <label class="control-label" style="width: 80px;">เลขที่เอกสาร</label>
						                         <input type="text" name="paydoc_number" class="input-medium" style="font-size: 12px">
                                    	  </td>
                                         <td>
				     			                  <label class="control-label" style="width: 160px;">ลำดับที่แฟ้ม</label>
							                      <input type="text" name="payfile_number" class="input-mini" style="font-size: 12px">
				     			          </td>
                                   </tr>
                                  	<tr>
                                          <td>
                                    		 <label class="control-label" style="width: 80px;">วันที่เบิกจ่าย</label>
						                         <input name="pay_date" class="easyui-datebox" style="height:30px;width: 150px;" data-options="formatter:myformatter,parser:myparser" required="true">
                                    	  </td>
                                         <td>
				     			                 <label class="control-label" style="width: 160px;">เลขที่ใบส่งของ / ใบเสร็จ</label>
							                     <input type="text" name="invoice_number" style="width: 153px;" style="font-size: 12px">
				     			          </td>
                                   </tr>
                                   </table>
                                  </td>
                         </tr>
                         
                          <tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">แผนงาน</label>
				     				<input id="ccplans" name="ccplans" class="easyui-combobox" style="height:30px;width:245px" required="true"  
				                           data-options="url:'<?php echo base_url(); ?>mgt_plans/get_by/<?php echo $this->session->userdata('budget_year_id'); ?>',
                                           valueField:'id',textField:'name',panelHeight:'auto',
				                           onSelect: function(rec){
				                           	   if(isset(rec)){
									             var ccurl = '<?php echo base_url(); ?>mgt_product/get_by/'+rec.id;  
											     $('#ccproduct').combobox('clear');
				                                 $('#ccproduct').combobox('reload', ccurl);
				                               }
									        }
				                           ">  
				     			</td>
                                <td>
				     			  <!-- <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress1"></div>-->
				     				
				     			</td>
				     		</tr>
                            <tr>
				     			<td>
				     				<label class="control-label" style="width: 80px;">งาน</label>
				     				<input id="ccproduct" name="ccproduct" class="easyui-combobox" required="true" 
				     				       style="height:30px;width:245px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				        	if(isset(rec)){
					                           }
									       }
				     				       ">
				     			</td>
                                <td>
				     			  <!-- <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress2"></div>-->
				     				
				     			</td>
				     		</tr>
                            <tr>
				     			<td>
				     			<label class="control-label" style="width: 80px;">งบรายจ่าย</label>
				     			<input id="ccgroup" name="ccgroup" class="easyui-combobox" required="true" style="height:30px;width:245px;" 
				     		                data-options="url:'<?php echo base_url(); ?>costs_group/combobox2',
		            	                                  valueField:'id',
		                                                  textField:'name',
		                                                  groupField:'type',
		                                                  panelHeight:'auto',
		                                                  onSelect: function(rec){        
		                                  	                if(isset(rec)){                         
                                                             $('#txtcosts').val(rec.costs_id);
                                             
                                                             var url = '<?php echo base_url(); ?>costs_type/get_by/'+rec.id;  
											                 $('#cctype').combobox('clear');
				                                             $('#cctype').combobox('reload', url);
				                                            }
										                 }
				     		                "/>
				                     <input type="hidden" id="txtcosts" name="txtcosts" />	
				     	        </td>
                                <td>
				     			  <!-- <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress3"></div>-->
				     				
				     			</td>
				     		</tr>
                            <tr>
				     			<td>
				     			<label class="control-label" style="width: 80px;">ประเภท</label>
				     			<input id="cctype" name="cctype" class="easyui-combobox" required="true"
				     				       style="height:30px;width:245px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				         if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>costs_lists/get_by/'+rec.id;  
												$('#cclists').combobox('clear');
					                            $('#cclists').combobox('reload', url);
					                           }
									       }
				     				       ">	
			                       
				     	        </td>
                                <td>
				     			  <!-- <label class="control-label" style="width: 80px;">วงเงิน</label>
				     			   <div id="myprogress5"></div>-->
				     				
				     			</td>
				     		</tr>
                            <tr>
				     			<td colspan="2">
				     			<label class="control-label" style="width: 80px;">รายการ</label>
				     			<input id="cclists" name="cclists" class="easyui-combobox" required="true"
				     				       style="height:30px;width:425px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto',
				     				        onSelect: function(rec){
				     				        if(isset(rec)){	
										        var url = '<?php echo base_url(); ?>costs_sublist/get_by/'+rec.id;  
												$('#ccsublist').combobox('clear');
					                            $('#ccsublist').combobox('reload', url);
					                         }
									       }
				     				       ">	
			                       
				     	        </td>
                                
				     		</tr>
                            <tr>
				     			<td colspan="2">
				     			<label class="control-label" style="width: 80px;">รายการย่อย</label>	
			                       <input id="ccsublist" name="ccsublist" class="easyui-combobox" style="height:30px;width:425px;" 
				     				       data-options="valueField:'id',textField:'name',panelHeight:'auto'" />
				     	        </td>
                                
				     		</tr>
						 	<tr>
						 			<td style="width: 330px;">
						 			   <input type="hidden" name="payerid[1]">	
						 			   <label class="control-label" style="width: 80px;">ผู้รับเงิน 1</label>
					                   <input id="ccpayer1" name="ccpayer[1]" class="easyui-combobox" style="height:30px;" required="true"
		                                 data-options="url:'<?php echo base_url(); ?>payer/combobox',
		            	                  valueField:'payer_code',
		                                  textField:'name',
		                                  groupField:'type',
		                                  panelHeight:'auto'
		                                 ">
						 			</td>
						 			<td>
						 				<label class="control-label" style="width: 70px;">จำนวน</label>
						 				<input type="text" name="sum[1]" onkeyup="plus()"  class="input-small" style="text-align:right;" required="true"> บาท
						 			</td>
						 			
						 	</tr>
						 	</tbody>
						 </table>
						 <table border="0" class="table-form span12">
                                  <tr>
                                          <td style="width: 330px;">
                                    	
                                    	  </td>
                                         <td>
				     			               <label class="control-label" style="width: 70px;">รวมเงิน</label>
							                   <input type="text" id="total_amount" name="total_amount" class="input-small" style="text-align:right;" disabled="disabled"> บาท
				     			          </td>
                                   </tr>
                          </table>
                         <button class="btn" type="button" onclick="add_pay();"><i class="icon-plus"></i></button>
		    </fieldset>
		   
		    <div id="dlg-buttons" class="form-actions">
			<button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			<button id="cancelButton" type="button" class="btn" onclick="window.location.assign('<?php echo base_url(); ?>disbursement/')">Cancel</button>
		    </div>
		    
		</form>
   </div>
</div>

<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
    var approve_id = '<?php echo $approve_id; ?>';
    var disbursement_id = '<?php echo $disbursement_id; ?>';
    var num = 1;
    var url;
   

function checking() {
    var doc_number = $('#approve_doc_number').val().replace('/','_');
    var jqsonurl = base_url + 'approve/check_document/' + doc_number;
    $.getJSON(jqsonurl, function (data) {
        $.each(data, function (index, val) {
            $.messager.alert('ผลการค้นหา', 'พบเอกสารจำนวน ' + val.numrows + ' รายการ');
            $('#approveid').val(val.id);
            $("input[name='approve_subject']").val(val.subject);
            $("input[name='approve_amount']").val(val.amount);
        });
    });
 
}

function add(){
       $('#dlg').dialog('open').dialog('setTitle','เพิ่มข้อมูลใหม่');
       $('#fm_popup').form('clear');
       url = base_url+'approve/add';
}

function add_pay(){

	num = num + 1;
    var html = '<tr id="tr'+num+'"><td><input type="hidden" name="payerid['+num+']"><label class="control-label" style="width: 80px;">ผู้รับเงิน '+num+'</label><input id="ccpayer'+num+'" name="ccpayer['+num+']" class="easyui-combobox" style="height:30px;" required="true"></td><td><label class="control-label" style="width: 70px;">จำนวน </label><input type="text" name="sum['+num+']" onkeyup="plus()" class="input-small" style="text-align:right;" required="true"> บาท &nbsp; <button class="btn" type="button" onclick="delete_pay()"><i class="icon-remove"></i></button></td></tr>'
    $('#pay-table').append(html);
  
    var ccurl = base_url + 'payer/combobox';
    $("input[name^='ccpayer']").combobox({
	    url: ccurl,
	    valueField:'payer_code',
	    textField:'name',
	    groupField:'type',
		panelHeight:'auto'
    });
    
}

function delete_pay(){
	var oldsum = parseFloat($("input[name='sum["+num+"]']").val().replace(/[,]/g,''));
	
	var amount = parseFloat($('#total_amount').val().replace(/[,]/g,''));
	
	if(oldsum){
	$('#total_amount').val(amount - oldsum);
	}
	
	if($("input[name='payerid["+num+"]']").val()){
		var rowid = $("input[name='payerid["+num+"]']").val();
			if (rowid){
				console.log(rowid);
				$.messager.confirm('ยืนยัน','คุณแน่ใจหรือว่าต้องการลบข้อมูลรายการนี้?',function(r){
					if (r){
						$.post('<?php echo base_url(); ?>payment/delete_by/'+rowid,function(result){
							if (result.success){
								$("#tr"+num).remove();
								num = num - 1;
								 $('#cancelButton').attr("disabled", true);
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
	else{
		$("#tr"+num).remove();
		num = num - 1;
	}
}

function plus(){

	$("input[name^='sum']").sum({
	  bind: "keyup"
	, selector: "#total_amount"
	, oncalc: function (value, settings){
		// you can use this callback to format values
		
		var e=window.event?window.event:event;
        var keyCode=e.keyCode?e.keyCode:e.which?e.which:e.charCode;
		
		//0-9 (numpad,keyboard)
		if ((keyCode>=96 && keyCode<=105)||(keyCode>=48 && keyCode<=57)){
			/*if(value <= balance){
			    $('#total_balance').val(balance - value);
			    return true;
			 }*/
		    return true;
		}
		//backspace,delete,left,right,home,end
	   if (',8,46,37,39,36,35,110,190,'.indexOf(','+keyCode+',')!=-1){
	       // $('#total_balance').val(balance - value); return true;
	       return true;
	   }
		else  $(this).val(''); return false;
	}
	
   });
}


		
function save(){
			 if(disbursement_id > 0){
			    url = base_url + 'disbursement/update/'+disbursement_id;
			 }else if(disbursement_id == 0){
				url = base_url + 'disbursement/add';
			 }

			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					console.log(result);
					var result = eval('('+result+')');
					if (result.success){
					    
                        // Case: When if update
					    if (disbursement_id > 0) {
					        $.messager.alert('ผลการบันทึก', 'บันทึกข้อมูลเบิกจ่ายเรียบร้อย');
					        window.location.href = base_url + 'disbursement/';
					    }
					    else {
					        $.messager.alert('ผลการบันทึก', 'บันทึกข้อมูลเบิกจ่ายเรียบร้อย');
					        $('#fm').form('clear');
					        $('#approve_doc_number').focus();
					    }


					} else {
						alert(result.msg);
					}
				}
			});
}



function save_new_document() {
    $('#fm_popup').form('submit', {
        url: url,
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (result) {
            var result = eval('(' + result + ')');

            if (result.success) {
                $('#dlg').dialog('close');		// close the dialog
                $('#approveid').val(result.row_id);

                var jqsonurl = base_url + 'approve/check_document_by_id/' + result.row_id;
                $.getJSON(jqsonurl, function (data) {
                    $.each(data, function (index, val) {
                        $('#approve_doc_number').val(val.doc_number);
                        $("input[name='approve_subject']").val(val.subject);
                        $("input[name='approve_amount']").val(val.amount);
                    });
                });
               
            } else {
                $.messager.show({
                    title: 'Error',
                    msg: result.msg
                });
            }
        }
    });
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

    // Case: Auto load approve document
    if (approve_id > 0) {
        $('#approveid').val(approve_id);
        var jqsonurl = base_url + 'approve/check_document_by_id/' + approve_id;
        $.getJSON(jqsonurl, function (data) {
            $.each(data, function (index, val) {
                $('#approve_doc_number').val(val.doc_number);
                $("input[name='approve_subject']").val(val.subject);
                $("input[name='approve_amount']").val(val.amount);
            });
        });
    }


   // console.log( $("input[name='budgetyear_id']").val());
  //  $("input[name='budgetyear_id']").val(source_year);


  
    // Case: updata Disbursement and payment data
    if(disbursement_id > 0)
    {
	    	var jqsonurl = base_url +'disbursement/get_by/' + disbursement_id;
		    	$.getJSON(jqsonurl, function(data) {
		        $.each(data, function(index, val) {
		        
		           $('#fm').form('load',{
		           	paydoc_number:val.doc_number,
		           	payfile_number:val.file_number,
		           	pay_date:formatThaiDate(val.doc_date),
		           	invoice_number:val.invoice_number
		           });

		            //plans combobox
		           $('#ccplans').combobox('select', val.mgt_plans_id);

		            //hidden textbox costs
		           $('#txtcosts').val(val.costs_id);

		            //ccgroup combobox
		           $('#ccgroup').combobox('select', val.costs_group_id);

		           //product combobox
		           ccurl = base_url + 'mgt_product/get_by/' + val.mgt_plans_id;
		           $('#ccproduct').combobox('clear').combobox('reload', ccurl).combobox('select', val.mgt_product_id);

		            //cctype combobox
		           ccurl = base_url + 'costs_type/get_by/' + val.costs_group_id;
		           $('#cctype').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_type_id);;

		            //cclists combobox
		           ccurl = base_url + 'costs_lists/get_by/' + val.costs_type_id;
		           $('#cclists').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_lists_id);

		            //ccsublist combobox
		           if (val.costs_sublist_id > 0) {
		               ccurl = base_url + 'costs_sublist/get_by/' + val.costs_lists_id;
		               $('#ccsublist').combobox('clear').combobox('reload', ccurl).combobox('select', val.costs_sublist_id);
		           }

		        });
		        
		        
		    });
		    var jqsonurl = base_url +'payment/get_by/' + disbursement_id;
		    	$.getJSON(jqsonurl, function(data) {
		    	
		    	var count = data.length;
		    	var total_payment = 0.00;
		    	
		        $.each(data, function(index, val) {
		              if(count == data.length){
		              		$("input[name='payerid[1]']").val(val.id);
		              		$("#ccpayer1").combobox('select',val.payer_code);
		              		$("input[name='sum[1]']").val(val.amount);
		              		count--;
		              }
		              else{
		              		add_pay();
		              		$("input[name='payerid["+num+"]']").val(val.id);
		              		$("#ccpayer"+num).combobox('select',val.payer_code);
		              		$("input[name='sum["+num+"]']").val(val.amount);
		              		count--;
		              }
	                total_payment = total_payment + parseFloat(val.amount);
		        });
		        
		        $('#total_balance').val(parseFloat($('#amount').val().replace(/[,]/g,'')) - total_payment);
		        $('#total_amount').val(total_payment);
		    });
    }


    
});
	
</script>
