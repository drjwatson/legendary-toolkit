jQuery(document).ready(function( $ ) {

    function loadVariants($elem) {
        let selectedFamily = $elem.find('option:selected').val()
        let dataType = $elem.attr('data-type')
        let weightSelect = $('select.font-selector-weight[data-type="'+ dataType +'"]')
        let selectedVariant = (weightSelect.attr('data-selected')) ? weightSelect.attr('data-selected') : 'regular';
        weightSelect.empty()
        $.getJSON("https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCzOdFDkLRrWOePEGIribIpUV3BM2SuO9s&sort=popularity", function(fonts){
            let selectedIndex = fonts.items.findIndex(p => p.family == selectedFamily)
            if (fonts.items.hasOwnProperty(selectedIndex)) {
                for (let i = 0; i < fonts.items[selectedIndex].variants.length; i++) {
                    let variant = fonts.items[selectedIndex].variants[i];
                    let isSelected = (selectedVariant == variant) ? 'selected' : '';
                    // optionally remove italic variants
                    // if (variant.indexOf('italic') == -1)
                        weightSelect.append(`<option ${isSelected} value="${variant}">${variant}</option>`)
                }
            }

        });
    }

    // $(window).on('load', loadVariants)
    $('.font-selector').on('change load', function() {
        loadVariants($(this));
    });
    $('.font-selector').each(function(i,elem) {
        loadVariants($(this));
    })
    
    // todo: Get available variants and populate weight field
    // todo: Create API URL to @import font in stylesheet
});
