$(document).ready(function() {
    DT.initEditable({
        table: "#admin_areas_view_table",
	url: "?admin_areas",
        index: [0]
    });
});