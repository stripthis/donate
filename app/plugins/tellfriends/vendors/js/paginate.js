$(document).ready(function() {
	initPagination();
});

function pageselectCallback(page_index, jq){
		var new_content = $('table.index_wrapper:eq('+page_index+')').clone();
		var strNewHTML = new_content.html();
		strNewHTML = strNewHTML
			.replace(/hiddencheckbox/gi, "contactcheckbox"
				)
			.replace(/hiddenspan/gi, "contactspan");
			 $('table#Searchresult').empty().append(strNewHTML).find('input:checkbox')
   .click(function() {
     checkedEvent(this);
   });
   $('table#Searchresult').find('span.spantxt')
   .click(function() {
     clickEvent(this);
   });

                return false;
            }
           
            /** 
             * Callback function for the AJAX content loader.
             */
            function initPagination() {
                var num_entries = $('table.index_wrapper').length;
                // Create pagination element
                $("#Pagination").pagination(num_entries, {
                    num_edge_entries: 2,
                    num_display_entries: 8,
                    callback: pageselectCallback,
                    items_per_page:1
                });
             }
                    

function checkedEvent(ths){
			var chckVal = $(ths).val();
			//appending email address of checked checkbox
			if($(ths).is(':checked') == true){
				addContacts(chckVal);
			} else if($(ths).is(':checked') == false) { //removing email address of unchecked checkbox
				removeContacts(chckVal);
			}
}
function clickEvent(ths){
			arr = Array();
			arr = $(ths).attr('id').split("_");
			var checkboxId = 'contactcheckbox_'+arr[1];
			var chckVal = $('#'+checkboxId).val();
			//appending email address of checked checkbox
			
		if($('#'+checkboxId).is(':checked') == false){
				$('#'+checkboxId).attr('checked', true);
				addContacts(chckVal);
			} else if($('#'+checkboxId).is(':checked') == true) { //removing email address of unchecked checkbox
			    $('#'+checkboxId).attr('checked', false);
				removeContacts(chckVal);
			}
}