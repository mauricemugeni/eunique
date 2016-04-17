var DT = new function() {
	this.initGrid = function(params) {
		// Check if the table exists in the first place
		if ($(params.table).length == 0) return false;
		
		currentSource = params.url;
		initTable(params.table);
	}
	
	this.changeSource = function(url) {
		currentSource = url;
		DT.fnReloadAjax();
	}
	
	this.initEditable = function(params) {
		// Check if the table exists in the first place
		if ($(params.table).length == 0) return false;
		
		// In the event we have multiple sources
		if ( typeof(params.filter) !== "undefined" ) {
			initVariedSource(params);
		}
		
		// Attach the new form record control	
		if ( typeof(params.newForm) !== "undefined" ) {
			initNewRecord(params.newForm);
		}

		// Attach the edit form record control
		if ( typeof(params.editForm) !== "undefined" ) {
			initEditRecord(params);
		}
		
		// Attach the delete form record control
		if ( typeof(params.deleteForm) !== "undefined" ) {
			initDeleteRecord(params);
		}
                //Attach Contact form control
                if ( typeof(params.addContact) !==  "undefined") {
                    initNewContact(params);
                }
                //delete a particular contact member from group
                if ( typeof(params.checkContact) !==  "undefined") {
                    initCheckContact(params);
                }
                //display barcode image
                if ( typeof(params.displayBarcode) !== "undefined") {
                    initDisplayBarcode(params);
                }
		
		// Attach the status control
		if ( typeof(params.statusForm) !== "undefined" ) {
			initStatus(params);
		}
                //view responses
                if( typeof(params.viewResponses) !=="undefined")
                    {
                        initResponses(params);
                    }

                 //Approve Contacts
                 if( typeof(params.approveContacts) !=="undefined")
                     {
                         initApprove(params.approveContacts);
                     }
		currentSource = params.url;
		initEditableTable(params.table);
	}
	
	this.fnDraw = function () {oTable.fnDraw();}
	
	this.fnReloadAjax = function () {
		var oSettings= oTable.fnSettings();
		oTable.fnClearTable(oTable);
		oTable.oApi._fnProcessingDisplay(oSettings, true );

		$.getJSON(oSettings.sAjaxSource, null, function(json){
			/* Got the data - add it to the table */
			for (var i=0; i<json.aaData.length; i++) {
				oTable.oApi._fnAddData(oSettings, json.aaData[i]);
			}

			oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			oTable.oApi._fnProcessingDisplay(oSettings, false);
		});
	}
	
	var oTable;
	var currentSource = '';
	
	function initTable(tbl) {
		oTable = $(tbl).dataTable({
			"bProcessing": false, "bServerSide": false,
			"sAjaxSource": currentSource,
			"aaSorting": [[ 0, "desc" ]]
		});
	}
	
	function initEditableTable(tbl) {
		// Init table
		oTable = $(tbl).dataTable({
			"bProcessing": false, "bServerSide": false,
			"sAjaxSource": currentSource,
			"aaSorting": [[ 0, "desc" ]],
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				$.ajax( {
					"dataType": 'json',
					"type": "GET",
					"url": currentSource,
					"data": aoData,
					"success": fnCallback
				});
			}
		});
		
		// Set click events
		$(tbl+' > tbody > tr').live('click', function(event){
			if(event.ctrlKey) {
				$(this).toggleClass('info');
			}
			else {
				if ( $(this).hasClass('info') ) {
					$(tbl+' > tbody > tr').removeClass('info');
				}
				else {
					$(tbl+' > tbody > tr').removeClass('info');
					$(this).toggleClass('info');
				}
			}
		});
	}
	
	function initVariedSource(params) {
		// Set the filter
		$(params.filter+' a').click(function(){
			$(params.filter+' li').removeClass('active');
			$(this).parent().addClass('active');
			
			currentSource = $(this).attr('tab-url');	
			$(params.title).html( $(this).html() );
			oTable.fnDraw();
		});
		
		// Allow one to refresh the grid of the selected item
		if ( typeof(params.title) !== "undefined" )
			$(params.title).click(function(){oTable.fnDraw()});
	}
	function initNewRecord(func) {
		$('.tools #newRecord').click(function(){
			func();
		});
	}
        function initApprove(funct){
                $('.tools #approveContacts').click(function(){
			funct();
		});
        }
	function initEditRecord(params) {
		$('.tools #editRecord').click(function(){
			var h = getSelectedRecords(params, "top");
			
			// Open the form
			if ( h != "" ) params.editForm(h);
			else alert ( "Please select a record to edit" );
		});
	}
      
        
        function initResponses(params){
           $('.tools #viewResponces').click(function(){
			var h = getSelectedRecords(params, "top");
			
			// Open the form
			if ( h != "" ) params.viewResponses(h);
			else alert ( "Please select a record to view its responce" );
		}); 
        }
        function initDisplayBarcode(params)
        {
            $('.tools #barcodebtn').click(function(){
			var h = getSelectedRecords(params, "top");
			
			// Open the form
			if ( h != "" ) params.displayBarcode(h);
			else alert ( "Please select a record to view its barcode image" );
		});
        }
        
        function initNewContact(params)
        {
            $('.tools #newCustomer').click(function()
        {
            var j=getSelectedRecords(params, "top")
            
            if(j !="")params.addContact(j);
            else alert("Please select a group to add contact");
        });
        }
        function initCheckContact(params)
        {
               $('.tools #viewGroupCustomers').click(function()
                {
                    var y=getSelectedRecords(params, "top")

                    if(y !="")params.checkContact(y);
                    else alert("Please select a group to view contact(s)");
                });
        }
	
	function initDeleteRecord(params) {
		$('.tools #deleteRecord').click(function(){
			var h = getSelectedRecords(params);
			
			// Ensure data present
			if ( h == "" )  {
				alert ( "Please select a record to delete" );
				return false;
			}
			
			// Confirm deletion
			if (confirm('Are you sure you would like to delete the selected record(s)?') == false) {
				// Ensure that the item is unchecked when you leave
				$(params.table+' > tbody > tr').removeClass('info');
				return false;
			}
			
			// Post the data
			var input = [];
			input.push({name:"delete", value:h});
			
			$.ajax({
				url: params.deleteForm,
				type: "POST", data: input,
				success: function(output) {
					// Reload the table
					DT.fnReloadAjax();console.log(output);
					
					// Show additional stuff
					if ( typeof(params.successFunc) !== "undefined" )
						params.successFunc('delete');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("There was an error deleting the data.");
				}
			});
		});
	}
	
	function initStatus(params) {
		$('.tools #statusOff, .tools #statusOn').click(function(){
			var h = getSelectedRecords(params);
			
			// Ensure that data is present
			if ( h == "" ) {
				alert ( "Please select a record to alter its status" );
				return false;
			}
			
			// Confirm action
			if (confirm('Are you sure you would like to alter the status of the selected record(s)?') == false) {
				// Ensure that the item is unchecked when you leave
				$(params.table+' > tbody > tr').removeClass('info');
				return false;
			}
			
			// Send the data
			var input = [];
			input.push({name:$(this).attr('id'), value:h});
		
			$.ajax({
				url: params.statusForm,
				type: "POST", data: input,
				success: function(output) {
					// Reload the table
					DT.fnReloadAjax();
					
					// Show additional stuff
					if ( typeof(params.successFunc) !== "undefined" )
						params.successFunc('status');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("There was an error updating your status.");
				}
			});
		});
	}
	
	function getSelectedRecords(params, select) {
		if ( typeof(select) === "undefined" ) select = "all";
		
		var h = '', t = '', c = null;
		$(params.table+' > tbody > tr.info').each(function(){
			t = '';
			for ( var i in params.index ) {
				c = $(this).children('td')[params['index'][i]];
				
				if ( typeof(c)!=="undefined" && typeof(c.innerHTML)!=="undefined" ) {
					if ( t != '' ) t += ',';
					t += c.innerHTML;
				}
			}
				
			// If we are going to get the first item only, then lets get it
			if ( select == "top" ) {
				h = (h=="") ? t: h;
			}
			
			// Otherwise get everything
			else {
				if ( h != "" ) h+= "::";
				h += t;
			}
		});
		
		return h;
	}
        function getSelectedContactRecords(params, select) {
		if ( typeof(select) === "undefined" ) select = "all";
		
		var h = '', t = '', c = null;
		$('#test_details_table > tbody > tr.info').each(function(){
			t = '';
			for ( var i in params.index ) {
				c = $(this).children('td')[params['index'][i]];
				
				if ( typeof(c)!=="undefined" && typeof(c.innerHTML)!=="undefined" ) {
					if ( t != '' ) t += ',';
					t += c.innerHTML;
				}
			}
				
			// If we are going to get the first item only, then lets get it
			if ( select == "top" ) {
				h = (h=="") ? t: h;
			}
			
			// Otherwise get everything
			else {
				if ( h != "" ) h+= "::";
				h += t;
			}
		});
		
		return h;
	}
};

