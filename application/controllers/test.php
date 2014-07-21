<?php

class Test extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
        $this->load->library("mpdf");
	}
	
	public function index()
	{
		$data["title"] = "สรุปข้อมูลการจัดสรรงบประมาณ";
		$data["path"] = array("งานแผน","รายงาน","สรุปข้อมูลการจัดสรรงบประมาณ");
		$data["submenu"] = Plans_menu(3);
		$this->template->load('template', 'report/myreprot_view', $data);

		 //print_r(apache_get_modules());
	}
    
    public function pdf()
    {

        $html = "<table border='1'><tr><th>ลำดับ</th><th>รายการ</th></tr>";
        $html .= "<tr><td>ลำดับ</td><td>รายการ</td></tr>";
        $html .= "</table>";
        
        $this->mpdf = new mPDF('utf-8', 'A4-L');
        $this->mpdf->SetAutoFont();

        $this->mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

        $this->mpdf->defaultheaderfontsize = 10;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = B;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 12;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = B;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 	/* 1 to include line below header/above footer */


        $this->mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}/{nb}| FMIS Report');
        $this->mpdf->SetFooter('{PAGENO}');	/* defines footer for Odd and Even Pages - placed at Outer margin */
        
       
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
        
        echo $html;
    }
    
}
