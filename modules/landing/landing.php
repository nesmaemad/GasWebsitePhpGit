

<div ng-include="'modules/HowItWorks/howItWorks.php'"></div>
<div class="row text-center" id="landing_body" style="background-color: #FFF8DC; height: 250px ">
    <h1 style="color: #0097a9">Find The Best Gas Price</h1>
    <div class="col-lg-8 col-lg-push-2" style="margin-top: 20px;">
        
            <div class="input-group col-md-12">
                    <div class="col-md-7">
              
                        <input type="text" class="form-control search-query" id="search_input" 
                               placeholder="Search gas prices by city or zip" 
                               style="position: absolute!important;height: 40px;width: 103%!important"
                               ng-model="zip_city"/>
                     
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" ng-model="landing_selected_volume"
                                style="position: absolute!important;height: 40px;">
                                    <option value="1">Up to 999 Liters</option>
                                    <option value="2">1,000 - 1,999 Liters</option>
                                    <option value="3">2,000 - 4,999 Liters</option>
                                    <option value="4">5,000 - 9,999 Liters</option>
                                    <option value="5">10,000+ Liters</option>

                        </select> 
                    </div>
                    <div class="col-md-2">
                        <span class="input-group-btn">
                            <button class="btn btn-danger" type="button" ng-click="updateReviewsByLandingSearch()"
                                    style="position: absolute!important;height: 40px;">
                                
                                  Search  <span class=" glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
            </div>
        
    </div>

</div>
<div class="row" style="background:white;height: 380px;">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-offset-1" style="height: 340px;box-shadow: 10px 10px 5px #888888;background:#dedcdc">
                <h2 class="text-center" style="color: #0097a9">Find Cheap Gas in America</h2>
                <div class="col-md-2" ng-repeat="state in states">
                    <a style="cursor: pointer;" ng-click="getProvinceReviews(state)">{{state.name}}</a>
                </div>
            </div>

        </div>
    </div>
    
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-offset-1" style="height: 340px;box-shadow: 10px 10px 5px #888888;background:#dedcdc">
                <h2 class="text-center" style="color: #0097a9">Find Cheap Gas in Canada</h2>
                <div class="col-md-6" ng-repeat="province in provinces">
                    <a style="cursor: pointer;" ng-click="getProvinceReviews(province)">{{province.name}}</a>
                </div>
       
            </div>

        </div>
    </div>
</div>

<script>
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
        return element.name;
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
    console.log("paneeeeeeeeeeeeeeeeeeeel "+( (80 * $(".panel").width()/ 100 ) + 'px'));
    $(".dropdown-menu").css({
    'width':( (70 * $(".panel").width()/ 100 ) + 'px')
  });
$( document ).ready(function() {      

    $("#search_input").easyAutocomplete(options);

});

</script>
<style>
.easy-autocomplete-container {
     width: 103%;
    
}
</style>