function download_pdf(documentation) {
	var myiframe = parent.document.getElementById('pdf_download');
	myiframe.src = "archives/download.php" + "?x=" + documentation;
}