

<div ng-include="'modules/HowItWorks/howItWorks.php'"></div>
<div class="row text-center" id="landing_body" style="background-color: #FFF8DC; height: 250px ">
    <h1 style="color: #0097a9">Find The Best Propane Price</h1>
    <div class="col-lg-8 col-lg-push-2" style="margin-top: 20px;">
        
            <div class="input-group col-md-12">
                    <div class="col-md-6">
              
                        <input type="text" class="form-control search-query" id="search_input" 
                               placeholder="Search propane prices by city or zip" 
                               style="position: absolute!important;height: 40px;width: 103.5%!important"
                               ng-model="zip_city"/>
                     
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" ng-model="landing_selected_category"
                                style="position: absolute!important;height: 40px;" ng-change="changeVolume()">
                                    <option value="reviews">Residential</option>
                                    <option value="commercial1" >Agriculture(Commercial)</option>
                                    <option value="commercial2" >Building and Development(Commercial)</option>
                                    <option value="commercial3" >Forklifts(Commercial)</option>
                                    <option value="commercial4" >Heating and Cooking(Commercial)</option>
                                    <option value="bbq">BBQ</option>
              
                        </select> 
                    </div>
                    <div class="col-md-2" ng-show="landing_selected_category == 'reviews' || landing_selected_category == 'commercial2'
                                ||landing_selected_category == 'commercial4'">
                        <select class="form-control" ng-model="landing_selected_volume"
                                style="position: absolute!important;height: 40px;" >
                                    <option value="1">Up to 999 Liters</option>
                                    <option value="2">1,000 - 1,999 Liters</option>
                                    <option value="3">2,000 - 4,999 Liters</option>
                                    <option value="4">5,000 - 9,999 Liters</option>
                                    <option value="5">10,000+ Liters</option>

                        </select> 
                    </div>
                    <div class="col-md-2" ng-show="landing_selected_category == 'commercial1'">

                        <select class="form-control" ng-model="landing_selected_volume"
                                style="position: absolute!important;height: 40px;"
                                 id="landing_selected_volume">
                                    <option value="6" >up to 5,000 liters</option>
                                    <option value="7" >5001 - 10,000 liters</option>
                                    <option value="8">10,001 - 30,000 liters</option>
                                    <option value="9" >30,001 - 60,000 liters</option>
                                    <option value="10" >60,001 - 99,999 liters</option>
                                    <option value="11" >100,000+ liters</option>

                        </select> 
                    </div>
                    <div class="col-md-2" ng-show="landing_selected_category == 'commercial3'">
                        <select class="form-control" ng-model="landing_selected_volume"
                                style="position: absolute!important;height: 40px;"
                                 id="landing_selected_volume">
                                
                                    <option value="12" >1 - 4 tanks/month</option>
                                    <option value="13" >5 - 10 tanks/month</option>
                                    <option value="14">10 - 20 tanks/month</option>
                                    <option value="15">20 - 40 tanks/month</option>
                                    <option value="16">40 - 70 tanks/month</option>
                                    <option value="17">71+ tanks/month</option>

                        </select> 
                    </div>
                    <div class="col-md-2" ng-show="landing_selected_category == 'bbq'">
                         <select class="form-control" ng-model="landing_selected_volume"
                                style="position: absolute!important;height: 40px;"
                                id="landing_selected_volume">
                                    <option value="1">5 Lb</option>
                                    <option value="2">10 Lb</option>
                                    <option value="3">11 Lb</option>
                                    <option value="4">20 Lb</option>
                                    <option value="5">30 Lb</option>
                                    <option value="6">33 Lb</option>
                                    <option value="7">40 Lb</option>
                                    <option value="8">50 Lb</option>
                                    <option value="9">60 Lb</option>
                                    <option value="10">100 Lb</option>

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

<div class="row" style="background:white;height: 250px;">
    <div class="col-md-4 text-center well well-sm col-sm-12 col-md-push-1" style="min-height: 200px;margin-top: 20px;">
      Here is your first AD
    </div>
    
    <div class="col-md-4 text-center well well-sm col-md-push-2 col-sm-12" style="min-height: 200px;margin-top: 20px;">
      Here is your second AD
    </div>

</div>
<!--<div class="row" style="background:white;height: 380px;">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-offset-1" style="height: 340px;box-shadow: 10px 10px 5px #888888;background:#dedcdc">
                <h2 class="text-center" style="color: #0097a9">Find Cheap Propane in America</h2>
                <div class="col-md-2" ng-repeat="state in states">
                    <a style="cursor: pointer;" ng-click="getProvinceReviews(state)">{{state.name}}</a>
                </div>
            </div>

        </div>
    </div>
    
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-offset-1" style="height: 340px;box-shadow: 10px 10px 5px #888888;background:#dedcdc">
                <h2 class="text-center" style="color: #0097a9">Find Cheap Propane in Canada</h2>
                <div class="col-md-6" ng-repeat="province in provinces">
                    <a style="cursor: pointer;" ng-click="getProvinceReviews(province)">{{province.name}}</a>
                </div>
       
            </div>

        </div>
    </div>
</div>-->

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