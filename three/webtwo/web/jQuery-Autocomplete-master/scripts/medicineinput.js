/*jslint  browser: true, white: true, plusplus: true */
/*global $, countries */

$(function () {
    'use strict';

    var countriesArray = $.map(countries, function (value, key) { return { value: value, data: key }; });

    //alert(countriesArray[1].value);

    // Initialize ajax autocomplete:
    $('.sel').autocomplete({
        // serviceUrl: '/autosuggest/service/url',
        //triggerSelectOnValidInput: false,
        lookup: countriesArray,
        showNoSuggestionNotice: false,
        noSuggestionNotice: '没有可匹配药材',
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },

        onSelect: function(suggestion) {
            var words = suggestion.value.split(' ');
            $(this).attr("value", words[1]);
            //$(this).attr("value", suggestion.value);
            $(this).attr("alt", suggestion.data);
        },

        onHint: function (hint) {
            $(this).val(hint);
        },

        onInvalidateSelection: function() {
            $(this).html('未选择');
            //$(this).html('You selected: none');
        }
    });

});