<?php

function Plans_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("budget_status" => "เปิด-ปิดแหล่งงบประมาณ", "budget_main" => "จัดการแหล่งงบประมาณ");
		   break;
		case '2': $submenu = array("mgt_plans" => "จัดสรรงบประมาณระดับแผนงาน", "mgt_product" => "จัดสรรงบประมาณระดับผลผลิต", "mgt_costs" => "จัดสรรงบประมาณระดับรายจ่าย");
		   break;
		case '3': $submenu = array("report_planners" => "สรุปข้อมูลการจัดสรรงบประมาณ");
		   break;
		default: $submenu = array("budget_status" => "เปิด-ปิดแหล่งงบประมาณ", "budget_main" => "จัดการแหล่งงบประมาณ");
		   break;
	}
	
	return $submenu;
}

function Finance_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("approve" => "รายการเอกสารต้นเรื่อง","report_approve" => "ภาพรวมการขออนุมัติ");
		   break;
		case '2': $submenu = array("disbursement/form" => "เพิ่มข้อมูลเบิกจ่าย","disbursement" => "แสดงรายการเบิกจ่ายทั้งหมด");
		   break;
		case '3': $submenu = array("report_disbursement" => "รายงานการจ่ายจำแนกตามแผน");
		   break;
		default: $submenu = array("approve" => "ขออนุมัติใช้งบประมาณ","approve_report" => "รายงานภาพรวมการขออนุมัติ");
		   break;
	}
	
	return $submenu;
}

function Mananger_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("budget_status" => "ขออนุมัติใช้งบประมาณ","report_summary" => "สรุปภาพรวมรายจ่าย");
		   break;
		default: $submenu = array("budget_status" => "ขออนุมัติใช้งบประมาณ","report_summary" => "สรุปภาพรวมรายจ่าย");
		   break;
	}
	
	return $submenu;
}


function Admin_menu($id)
{
	switch ($id) {
		case '1': $submenu = array("budget" => "แหล่งงบประมาณ","budget_main" => "ปีงบประมาณ");
		   break;
		case '2': $submenu = array("plans" => "ข้อมูลรายการแผนงาน","product" => "ข้อมูลรายการผลผลิต","project" => "ข้อมูลรายการโครงการ","activity" => "ข้อมูลรายการกิจกรรม");
		   break;
		case '3': $submenu = array("costs" => "ข้อมูลงบรายจ่าย","costs_group" => "ข้อมูลหมวดรายจ่าย","costs_type" => "ข้อมูลประเภทรายจ่าย","costs_lists" => "ข้อมูลรายการรายจ่าย","costs_sublist" => "ข้อมูลรายการรายจ่ายย่อย");
		   break;
		case '4': $submenu = array("faculty" => "ข้อมูลคณะ","department" => "ข้อมูลภาควิชา","division" => "ข้อมูลหน่วยงาน");
		   break;
		case '5': $submenu = array("payer" => "ข้อมูลผู้รับเงิน");
		   break;
		default: $submenu = array("budget" => "แหล่งงบประมาณ","budget_main" => "ปีงบประมาณ");
		   break;
	}
	
	return $submenu;
}


