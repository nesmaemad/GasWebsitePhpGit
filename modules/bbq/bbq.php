<!DOCTYPE html>


<div ng-include="'modules/HowItWorks/howItWorks.php'"></div>
<div class="row" style="background-color: #FFF8DC;margin-top: 70px;">
    <div class="col-md-7 col-md-offset-1">
      <div class="row">
           <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="  search-query form-control" id="search_input" placeholder="Search gas prices by city or zip" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger search-review" type="button" ng-click="updateReviewsBySearch()">
                            <span class=" glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
      </div>
      <?php $first_name =(isset($_COOKIE['first_name']))?$_COOKIE['first_name']:''; ?>
      <div class="row">

        <section class="content">
           <h1>{{reviews_city.name}} Residential Propane  Prices</h1>
            <div class="row" style="margin-top:40px;">
                <div class="col-md-8 col-md-push-2">
                    <div class="well well-sm" style="background: rgba(0,151,169 , 0.5)">
                        <div class="text-center">
                            <a class="btn btn-success" id="open-review-box" style="display: block;font-size: 20px;">Post Your Price</a>
                        </div>

                        <div class="row" id="post-review-box" style="display:none;">
                            <div class="col-md-12">
                                <form accept-charset="UTF-8"  method="post" id="post_form">
                                    <label class="col-md-4 control-label">Country</label>
                                    <span class="input-group-addon" style="margin-bottom : 20px;">
                                         
                                         <select name="department" class="form-control selectpicker" ng-model="post_review_selected_country"
                                                 ng-change="changeProvincy()" required="true">
                                           <option value="2">America</option>
                                           <option value="1">Canada</option>

                                         </select>
                                    </span>

                                    <label class="col-md-4 control-label" ng-if = "post_review_selected_country == '1'">Province / Territory</label>
                                    <label class="col-md-4 control-label" ng-if = "post_review_selected_country == '2'">State</label>                 
                                    <span class="input-group-addon" style="margin-bottom : 20px;">
                                        
                                        <select name="department" class="form-control selectpicker"
                                                ng-options="province.name for province in provinces" ng-model="post_review_selected_province" required="true">
                                        </select>   
                                    </span>
                                    
                                    <label class="col-md-4 control-label">Tank</label>
                                                  
                                    <span class="input-group-addon" style="margin-bottom : 20px;">
                                        
                                        <select class="form-control selectpicker" ng-model="post_review_selected_volume" required>
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
                                    </span>
                                    
                                    <label class="col-md-4 control-label">Company</label>
                                                  
                                    <span class="input-group-addon" style="margin-bottom : 20px;">
                                        <select name="company" class="form-control selectpicker"
                                                ng-options="company.name for company in post_review_companies" ng-model="selected_post_review_company" required="true">
                                        </select> 
                                    </span>
                                    
                                    <label class="col-md-4 control-label" ng-if="post_review_selected_country == '2'">Price per Gallon</label>
                                    <label class="col-md-4 control-label" ng-if="post_review_selected_country == '1'">Price per Litre</label>
                                    <input type="number" class="form-control animated" id="price" name="price" ng-model="post_review_price" required="true">
                                  
                                    <input id="ratings-hidden" name="rating" type="hidden" ng-model="post_review_rating"> 
                                    <input id="user_id" type="hidden" ng-model="post_review_user_id" 
                                           value = "<?php echo $_COOKIE['id'];?>"> 
                                    <label class="col-md-4 control-label" >Review</label>
                                    <textarea class="form-control animated" cols="50" id="new-review" name="comment" required="true" ng-model="post_review_comment"
                                              placeholder="Enter your review here..." rows="5" style="overflow: scroll; word-wrap: break-word;  height: 100px; margin-top:20px;"></textarea>
                                    <span class="help-block"><p id="characterLeft" class="help-block ">You have reached the limit</p></span>
                                    <div class="text-left">
                                        <label class="col-md-4 control-label">Rating</label>
                                        <div class="stars starrr" data-rating="0"></div>
                                    </div>
                                     <div class="text-right">
                                        <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                                        <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                                        <button class="btn btn-success btn-lg" id="btnSubmit" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> 

                </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <div class="btn-group gas_liter">
              
                                                                                                                            
                    <button type="button"  ng-click ="changeReviewsVolume('1')" ng-class="reviews_volume == '1' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">5 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('2')" ng-class="reviews_volume == '2' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">10 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('3')" ng-class="reviews_volume == '3' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">11 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('4')" ng-class="reviews_volume == '4' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">20 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('5')" ng-class="reviews_volume == '5' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">30 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('5')" ng-class="reviews_volume == '6' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">33 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('5')" ng-class="reviews_volume == '7' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">40 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('5')" ng-class="reviews_volume == '8' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">50 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('5')" ng-class="reviews_volume == '9' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">60 Lb</button>
                    <button type="button"  ng-click ="changeReviewsVolume('5')" ng-class="reviews_volume == '10' ? 'btn btn-danger btn-filter active' : 'btn btn-danger btn-filter'">100 Lb</button>
                  </div>
                </div>
                <div class="table-container">
                  <div class="table table-filter table-responsive" style="overflow-x: visible!important;">
                    <div class="reviews-body">
                      <div data-status="pagado" class="row rowlink reviews-row" ng-repeat="review in reviews">
                           
                         <div class="col-lg-6 reviews-cell">
                        
                                <a class="rowlink" data-toggle="dropdown" ng-click="getCompanyReviews(review.company_id)">
                                    <h3> {{review.company_name}} </h3>
                                </a>
                          
                        </div>

                        <div class="col-lg-4 reviews-cell">
                              <span data-ng-repeat="i in getNumber(review.rating) track by $index"
                                    class="glyphicon glyphicon-star" style="color: rgb(255, 200, 60); font-size: 20px;">
                              </span>
                              <span data-ng-repeat="i in getNumber(5 - review.rating) track by $index"
                                    class="glyphicon glyphicon-star-empty" style="font-size: 20px;">
                              </span>
                            <br/>
                            
                            <span>({{review.reviews_count}} Reviews)
                              <span style="color:#0097a9;">{{review.user_name}} </span>
                              </span>
                              <br/>
                              {{review.review}}
                        </div>

                        <div class="col-lg-2 reviews-cell">                            
                          <label  style=" font-size: 25px; color: rgb(0,151,169)">$ {{review.price}}</label>
                        </div>
                          
                        <div  role="menu" id="comapny_review_menu_{{review.company_id}}" class="reviews-cell hidden-company-reviews" aria-labelledby="dLabel" style="max-height: 200px;">
                            <div class="col-lg-12 review-block" >
                                <div class="row" ng-repeat="company_review in company_reviews" style="margin-bottom: 20px;">
                                    <div class="col-sm-4" >
                                            <img src="images/Icon-user.png" style="width: 60px;height: 60px" class="img-rounded">
                                            <div class="review-block-name"><a href="#">{{company_review.user_name}}</a></div>
                                            <div class="review-block-date">{{company_review.time * 1000  | date:'dd-MM-yyyy HH:mm:ss Z'}}</div>
                                    </div>
                                    <div class="col-sm-7 col-sm-push-1">
                                            <div class="review-block-rate">
                                                    <span data-ng-repeat="i in getNumber(company_review.rating) track by $index"
                                                        class="glyphicon glyphicon-star" style="color: rgb(255, 200, 60); font-size: 20px;">
                                                    </span>
                                                    <span data-ng-repeat="i in getNumber(5 - company_review.rating) track by $index"
                                                        class="glyphicon glyphicon-star-empty" style=" font-size: 20px;">
                                                    </span>
                                            </div>
                                            <div class="review-block-title">$ {{company_review.price}}</div>
                                            <div class="review-block-description">{{company_review.review}}</div>
                                    </div>

                                </div>


                            </div>

                        </div>  
                        
                         <input type="hidden" id="check_first_name" value = "<?php echo isset($_COOKIE['first_name'])?>" >
                       
                      </div>

                  
      
                    </div>
                  </div>
                </div>
              </div>
            </div>

        
        </section>
        
      </div>




    </div>
    


    <div class="col-md-2" style="margin-top: 30px;">
            <div class="row">
                <div class="col-md-12 text-center well well-sm col-md-offset-4" style="min-height: 200px;">
                  Here is your First AD
                </div>

            </div>
            <div class="row">
                <div class="col-md-12 text-center well well-sm col-md-offset-4" style="min-height: 200px;">
                  Here is your second AD
                </div>

            </div>
  
           <div class="row">
                <div class="col-md-12 text-center well well-sm col-md-offset-4" style="min-height: 200px;">
                  Here is your third AD
                </div>

            </div>
    </div>
    <div class="col-md-3">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-offset-1" style="height: 300px;overflow-y: scroll;box-shadow: 10px 10px 5px #888888;background:whitesmoke" >
                <h2 ng-if="country_id == '1'" class="text-center" style="color: #0097a9">Find Cheap Gas in Canada</h2>
                <h2 ng-if="country_id == '2'" class="text-center" style="color: #0097a9">Find Cheap Gas in America</h2>
                <div class="col-md-6" ng-repeat="province in quickSearchProvinces">
                    <a style="cursor: pointer;" ng-click="getProvinceReviews(province)">{{province.name}}</a>
                </div>
            </div>

        </div>
    </div>

</div>

<script>

//for posting a review
(function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u,null),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",f&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}})(window.jQuery||window.$);

var __slice=[].slice;(function(e,t){var n;n=function(){function t(t,n){var r,i,s,o=this;this.options=e.extend({},this.defaults,n);this.$el=t;s=this.defaults;for(r in s){i=s[r];if(this.$el.data(r)!=null){this.options[r]=this.$el.data(r)}}this.createStars();this.syncRating();this.$el.on("mouseover.starrr","span",function(e){return o.syncRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("mouseout.starrr",function(){return o.syncRating()});this.$el.on("click.starrr","span",function(e){return o.setRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("starrr:change",this.options.change)}t.prototype.defaults={rating:void 0,numStars:5,change:function(e,t){}};t.prototype.createStars=function(){var e,t,n;n=[];for(e=1,t=this.options.numStars;1<=t?e<=t:e>=t;1<=t?e++:e--){n.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"))}return n};t.prototype.setRating=function(e){if(this.options.rating===e){e=void 0}this.options.rating=e;this.syncRating();return this.$el.trigger("starrr:change",e)};t.prototype.syncRating=function(e){var t,n,r,i;e||(e=this.options.rating);if(e){for(t=n=0,i=e-1;0<=i?n<=i:n>=i;t=0<=i?++n:--n){this.$el.find("span").eq(t).removeClass("glyphicon-star-empty").addClass("glyphicon-star")}}if(e&&e<5){for(t=r=e;e<=4?r<=4:r>=4;t=e<=4?++r:--r){this.$el.find("span").eq(t).removeClass("glyphicon-star").addClass("glyphicon-star-empty")}}if(!e){return this.$el.find("span").removeClass("glyphicon-star").addClass("glyphicon-star-empty")}};return t}();return e.fn.extend({starrr:function(){var t,r;r=arguments[0],t=2<=arguments.length?__slice.call(arguments,1):[];return this.each(function(){var i;i=e(this).data("star-rating");if(!i){e(this).data("star-rating",i=new n(e(this),r))}if(typeof r==="string"){return i[r].apply(i,t)}})}})})(window.jQuery,window);$(function(){return $(".starrr").starrr()})

$(function(){

  $('#new-review').autosize({append: "\n"});

  var reviewBox = $('#post-review-box');
  var newReview = $('#new-review');
  var openReviewBtn = $('#open-review-box');
  var closeReviewBtn = $('#close-review-box');
  var ratingsField = $('#ratings-hidden');
 

  openReviewBtn.click(function(e)
  {
    var first_name = '<?php echo $first_name;?>';
    console.log("first name is inside opening the review box "+'<?php echo $first_name;?>');
    console.log(first_name);
    if(first_name !== ''){
        reviewBox.slideDown(400, function()
          {
            $('#new-review').trigger('autosize.resize');
            newReview.focus();
          });
        openReviewBtn.fadeOut(100);
        closeReviewBtn.show();
    }else{
        swal(
            'Oops...',
            'Please signin before posting!',
            'error'
        );
    }
  });

  closeReviewBtn.click(function(e)
  {
    e.preventDefault();
    reviewBox.slideUp(300, function()
      {
        newReview.focus();
        openReviewBtn.fadeIn(200);
      });
    closeReviewBtn.hide();
    
  });

  $('.starrr').on('starrr:change', function(e, value){
    ratingsField.val(value);
  });
});
</script>
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
    $(".hidden-company-reviews").css({
    'width':( (95 * $(".panel").width()/ 100 ) + 'px')
  });
$( document ).ready(function() {      

    $("#search_input").easyAutocomplete(options);

});

</script>

<script>
    $('#characterLeft').text('140 characters left');
    $('#new-review').keydown(function () {
        var max = 140;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('You have reached the limit');
            $('#characterLeft').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft').removeClass('red');            
        }
    }); 
</script>