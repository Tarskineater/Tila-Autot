<?php
class Excel_XML{

    /**
     * Header of excel document (prepended to the rows)
     */
    var $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?\><Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">";

    /**
     * Footer of excel document (appended to the rows)
     */
    var $footer = "</Workbook>";
    /**
     * Style of the content
     */
    var $style = "<Styles>
  <Style ss:ID=\"s34\">
   <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Bottom\"/>
   <Borders>
    <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
    <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
   </Borders>
   <Font x:Family=\"Swiss\" ss:Size=\"11\" ss:Bold=\"1\"/>
   <Interior ss:Color=\"#CCFFCC\" ss:Pattern=\"Solid\"/>
  </Style>
  <Style ss:ID=\"s21\">
   <Alignment ss:Vertical=\"Center\" ss:WrapText=\"1\"/>
  </Style>
 </Styles>";
    /**
     * Document lines (rows in an array)
     */
    var $lines = array ();
    /**
     * Worksheet title
     *
     * Contains the title of a single worksheet
     */
    var $worksheet_title = "Service Request Hitlist";
    
    /**
     * Add a single row to the $document string
     */
    function addRow ($array)
    {

        // initialize all cells for this row
        $cells = "";

        // foreach key -> write value into cells
        foreach ($array as $k => $v):
           
            //tranform the \n to the right format in excel
            $v = str_replace("\n","&#10;",$v);
            $cells .= "<Cell ss:StyleID=\"s21\"><Data ss:Type=\"String\">" . utf8_encode($v) . "</Data></Cell>\n";

        endforeach;

        // transform $cells content into one row
        $this->lines[] = "<Row>\n" . $cells . "</Row>\n";

    }
    
    /**
     * Add an array to the document
     *
     * This should be the only method needed to generate an excel
     * document.
     */
    function addArray ($array)
    {
        // run through the array and add them into rows
        // The first element of $array is the header array
        $headArray = $array[0];
        for($i=1;$i<count($array);$i++){   
            $dataArray[] = $array[$i];
        }
        
        $headCell = "";
        
        foreach ($headArray as $k => $v):
            $headCell .= "<Cell ss:StyleID=\"s34\"><Data ss:Type=\"String\">" . utf8_encode($v) . "</Data></Cell>\n";
        endforeach;
        
        $this->lines[] = "<Row>\n" . $headCell . "</Row>\n";
               
        foreach ($dataArray as $k => $v):
            $this->addRow ($v);
        endforeach;

    }
    /**
     * Set the worksheet title
     */
    function setWorksheetTitle ($title)
    {

        // strip out special chars first
        $title = preg_replace ("/[\\\|:|\/|\?|\*|\[|\]]/", "", $title);

        // now cut it to the allowed length
        $title = substr ($title, 0, 31);

        // set title
        $this->worksheet_title = $title;

    }
   /**
     * Generate the excel file
     */
    function generateXML ($filename){

        // deliver header (as recommended in php manual)
        
		<script language="javascript" type="text/javascript">
			pageModified();
		</script> 
		
		print "openXMLPage.push(\"$line\" );"; 
		
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $filename . ".xls\"");

        // print out document to the browser
        // need to use stripslashes for the damn ">"
        echo stripslashes ($this->header);
        echo stripslashes ($this->style);
        echo "\n<Worksheet ss:Name=\"" . $this->worksheet_title . "\">\n<Table>\n";
        echo "<Column ss:Index=\"1\" ss:AutoFitWidth=\"0\" ss:Width=\"60\"/>\n";
        echo implode ("\n", $this->lines);
        echo "</Table>\n</Worksheet>\n";
        echo $this->footer;
    }
}
?>