
function exportData_subject_regular(){

    var filename=document.getElementById('fname').value;
  // Use the outerHTML attribute to get the HTML code of the entire table element (including the <Table> tag), and then wrap it into a complete HTML document. Set charset to urf-8 to prevent garbled code
    var html = "<html><head><meta charset='utf-8' /></head><body>" + document.getElementById("stud_search_reg").outerHTML + "</body></html>";
    
    // Instantiate a Blob object. The first parameter of its constructor is an array containing file contents, and the second parameter is an object containing file type attributes
    var blob = new Blob([html], { type: "application/vnd.ms-excel" });
    var a = document.getElementById("dd");
    
    // Use URL.createObjectURL() method to generate the Blob URL for the a tag.
    a.href = URL.createObjectURL(blob);
    
    // Set the download file name.
    a.download = filename;

}


function exportData_subject_backlog(){
    var filename=document.getElementById('fname').value;

  // Use the outerHTML attribute to get the HTML code of the entire table element (including the <Table> tag), and then wrap it into a complete HTML document. Set charset to urf-8 to prevent garbled code
    var html = "<html><head><meta charset='utf-8' /></head><body>" + document.getElementById("stud_search_blg").outerHTML + "</body></html>";
    
    // Instantiate a Blob object. The first parameter of its constructor is an array containing file contents, and the second parameter is an object containing file type attributes
    var blob = new Blob([html], { type: "application/vnd.ms-excel" });
    var a = document.getElementById("dd");
    
    // Use URL.createObjectURL() method to generate the Blob URL for the a tag.
    a.href = URL.createObjectURL(blob);
    
    // Set the download file name.
    a.download = filename;

}

function exportData_subject_phd(){
    var filename=document.getElementById('fname').value;

  // Use the outerHTML attribute to get the HTML code of the entire table element (including the <Table> tag), and then wrap it into a complete HTML document. Set charset to urf-8 to prevent garbled code
    var html = "<html><head><meta charset='utf-8' /></head><body>" + document.getElementById("stud_search_phd").outerHTML + "</body></html>";
    
    // Instantiate a Blob object. The first parameter of its constructor is an array containing file contents, and the second parameter is an object containing file type attributes
    var blob = new Blob([html], { type: "application/vnd.ms-excel" });
    var a = document.getElementById("dd");
    
    // Use URL.createObjectURL() method to generate the Blob URL for the a tag.
    a.href = URL.createObjectURL(blob);
    
    // Set the download file name.
    a.download = filename;

}


function printPage(id) {
    var id=document.getElementById('print').value;
    var html="<html>";
    html+= document.getElementById(id).innerHTML;
    html+="</html>";
    var printWin = window.open('','','left=0,top=0,width=60,height=100,toolbar=0,scrollbars=0,status =0');
    printWin.document.write(html);
    printWin.document.close();
    printWin.focus();
    printWin.print();
    printWin.close();
}