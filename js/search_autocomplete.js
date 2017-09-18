console.log("inside search_autocomplete.js");
var options = {

    url: "resources/canada_america.json",

    categories: [{
        listLocation: "Canada",
        maxNumberOfElements: 500,
        header: "Canada - Cities/Towns"
    }, {
        listLocation: "America",
        maxNumberOfElements: 500,
        header: "America - Cities/Towns"
    }],

    getValue: function(element) {
        return element.city_town;
    },

    template: {
        type: "description",
        fields: {
            description: "region"
        }
    },

    list: {
        maxNumberOfElements: 8,
        match: {
            enabled: true
        },
        sort: {
            enabled: true
        }
    },

    theme: "square"
};

$( document ).ready(function() {      
    console.log("init options");
    $("#search_input").easyAutocomplete(options);
    console.log("after options");
});
