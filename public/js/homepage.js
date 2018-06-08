/**** Automatic Language Translation ****/
function switchLanguage() {

    /*var userLang = navigator.language || navigator.userLanguage;*/
    var language = 'fr';
    /*if(userLang == 'fr') language = 'fr';*/

    /* If user has selected a language, we apply it */
    if (Cookies.get('app-language')) {
        language = Cookies.get('app-language'); 
    }
    
    /* We get current language on page load */
    $("[data-translate]").jqTranslate(
		['index', 'navbar'], 
		{
            		forceLang: language, 
			defaultLang: 'fr', 
			fallbackLang: 'fr', 
			path: location.origin +'/translation'
		}
     );

    $('.language-picker').val(language).trigger("change");

}

function formatState (state) {
  if (!state.id) {  return state.text; }
  var $state = $(
    '<span><img src="'+location.origin+'/img/language/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
  );
  return $state;
};

$(document).ready(function () {

	/*select list*/
	$(".language-picker").select2({
	  	templateResult: formatState,
	  	templateSelection : formatState,
	   	minimumResultsForSearch: Infinity
	});


    switchLanguage();

    /* Change language on click in a select input for example */
    $('.language-picker').on('change', function(e) {
        e.preventDefault();

        /* We save language inside a cookie */
        Cookies.set('app-language', $(this).val());
	location.reload();
    });

});