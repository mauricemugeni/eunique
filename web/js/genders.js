$(document).ready(function() {
    DT.initEditable({
        table: "#genders_view_table",
	url: "?genders",
        index: [0]
    });
});