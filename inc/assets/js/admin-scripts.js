function open_settings_tab(evt, tabName) {
    evt.preventDefault();
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

(function() {
    document.getElementById("legendary_toolkit_general_tab").click();
})();

jQuery(document).ready(function( $ ) {
	
    $('[name="theme_options[footer_columns]"]').on('input', function(ev) {
        var num_columns = $(this).val();
        $('[id^="footer_column_row_"]').each(function(i,el) {
            var id = $(el).attr('id');
            var col_num = id[id.length -1];
            if (num_columns < col_num) {
                $(el).addClass('hidden');
            }
            else {
                $(el).removeClass('hidden');
            }
            
        });
    });
	
});