<!DOCTYPE html>
<!--<div ng-include="'navbar.html'"></div>-->

<div class="row">
    <div class="col-md-12 well well-sm" style="min-height: 120px;">

            <div class="row">
                <div class="col-md-12 text-center">
                  Here is your first AD
                </div>

            </div>
    </div>

</div>

<div class="row">
		<div class="col-md-8 col-md-offset-1">
      <div class="row">
           <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="  search-query form-control" id="search_input" placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">
                            <span class=" glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
      </div>
      <div class="row">

        <section class="content">
           <h1>{{reviews_city.name}} Residential Propane  Prices</h1>
            <div class="row" style="margin-top:40px;">
                <div class="col-md-8 col-md-push-2">
                    <div class="well well-sm" style="background: rgba(0,151,169 , 0.5)">
                        <div class="text-right">
                            <a class="btn btn-success btn-green" href="#reviews-anchor" id="open-review-box">Leave a Review</a>
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
                                    
                                    <label class="col-md-4 control-label">Volume</label>
                                                  
                                    <span class="input-group-addon" style="margin-bottom : 20px;">
                                        
                                        <select class="form-control selectpicker" ng-model="post_review_selected_volume" required>
                                            <option value="1">Up to 500 liters</option>
                                            <option value="2">1,000 liters</option>
                                            <option value="3">2,000 liters</option>
                                            <option value="4">4,000 liters</option>
                                            <option value="5">7,000 liters+</option>
                                         
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
                                           value = '<%= session.getAttribute("id") %>'> 
                                    <label class="col-md-4 control-label" >Review</label>
                                    <textarea class="form-control animated" cols="50" id="new-review" name="comment" required="true" ng-model="post_review_comment"
                                              placeholder="Enter your review here..." rows="5" style="overflow: scroll; word-wrap: break-word;  height: 100px; margin-top:20px;"></textarea>

                                    <div class="text-left">
                                        <label class="col-md-4 control-label">Rating</label>
                                        <div class="stars starrr" data-rating="0"></div>
                                    </div>
                                     <div class="text-right">
                                        <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                                        <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                                        <button class="btn btn-success btn-lg" type="submit">Save</button>
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
                    <button type="button" class="btn btn-danger btn-filter active" ng-click ="changeReviewsVolume('1')">Up to 500 liters</button>
                    <button type="button" class="btn btn-danger btn-filter" ng-click ="changeReviewsVolume('2')">1,000 liters</button>
                    <button type="button" class="btn btn-danger btn-filter" ng-click ="changeReviewsVolume('3')">2,000 liters</button>
                    <button type="button" class="btn btn-danger btn-filter" ng-click ="changeReviewsVolume('4')">4,000 liters</button>
                    <button type="button" class="btn btn-danger btn-filter" ng-click ="changeReviewsVolume('5')">7,000 liters+</button>
                  </div>
                </div>
                <div class="table-container">
                  <table class="table table-filter table-responsive">
                    <tbody>
                        <tr data-status="pagado" class="rowlink" ng-repeat="review in reviews">
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle rowlink" data-toggle="dropdown" href="#">
                                    <h3> {{review.company_name}} </h3>
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <li>
                                        <a tabindex="-1" href="#">
                                            Review in row1
                                        </a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">
                                            Another review in row1
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                              <div id="stars-existing" class="starrr" data-rating="{{review.rating}}" ></div>({{review.reviews_count}} Reviews)
                              {{review.user_name}}
                        </td>

                          <td>
                             
                          <button type="button" class="btn btn-info" id="view_price_{{review.id}}" ng-click="viewPrice(review.id)">View Price</button>
                          <label id="show_price_{{review.id}}" style="display: none; font-size: 25px; color: rgb(0,151,169)">{{review.price}}</label>
                        </td>
                    <input type="hidden" id="check_first_name" value = '<%= session.getAttribute("first_name") %>' >
                      </tr>

                  
      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

        
        </section>
        
      </div>




    </div>

    <div class="col-md-2" >

            <div class="row">
                <div class="col-md-12 text-center well well-sm col-md-offset-1" style="min-height: 200px;">
                  Here is your second AD
                </div>

            </div>
           <div class="row">
                <div class="col-md-12 text-center well well-sm col-md-offset-1" style="min-height: 150px;">
                  Here is your third AD
                </div>

            </div>
    </div>

</div>

<script>
    // Starrr plugin (https://github.com/dobtco/starrr)
console.log("inside starts.js");
var __slice = [].slice;

(function($, window) {
  var Starrr;

  Starrr = (function() {
    Starrr.prototype.defaults = {
      rating: void 0,
      numStars: 5,
      change: function(e, value) {}
    };

    function Starrr($el, options) {
      var i, _, _ref,
        _this = this;

      this.options = $.extend({}, this.defaults, options);
      this.$el = $el;
      _ref = this.defaults;
      for (i in _ref) {
        _ = _ref[i];
        if (this.$el.data(i) != null) {
          this.options[i] = this.$el.data(i);
        }
      }
      this.createStars();
      this.syncRating();
      this.$el.on('mouseover.starrr', 'span', function(e) {
        return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
      });
      this.$el.on('mouseout.starrr', function() {
        return _this.syncRating();
      });
      this.$el.on('click.starrr', 'span', function(e) {
        return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
      });
      this.$el.on('starrr:change', this.options.change);
    }

    Starrr.prototype.createStars = function() {
      var _i, _ref, _results;

      _results = [];
      for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
        _results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
      }
      return _results;
    };

    Starrr.prototype.setRating = function(rating) {
      if (this.options.rating === rating) {
        rating = void 0;
      }
      this.options.rating = rating;
      this.syncRating();
      return this.$el.trigger('starrr:change', rating);
    };

    Starrr.prototype.syncRating = function(rating) {
      var i, _i, _j, _ref;

      rating || (rating = this.options.rating);
      if (rating) {
        for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
          this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
        }
      }
      if (rating && rating < 5) {
        for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
          this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
        }
      }
      if (!rating) {
        return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
      }
    };

    return Starrr;

  })();
  return $.fn.extend({
    starrr: function() {
      var args, option;

      option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      return this.each(function() {
        var data;

        data = $(this).data('star-rating');
        if (!data) {
          $(this).data('star-rating', (data = new Starrr($(this), option)));
        }
        if (typeof option === 'string') {
          return data[option].apply(data, args);
        }
      });
    }
  });
})(window.jQuery, window);

$(function() {
  return $(".starrr").starrr();
});

$( document ).ready(function() {
      
  $('#stars').on('starrr:change', function(e, value){
    $('#count').html(value);
  });
  
  $('#stars-existing').on('starrr:change', function(e, value){
    $('#count-existing').html(value);
  });

  $(function() {
      $(this).find('.dropdown-toggle').dropdown();

      $('.rowlink').on('click', function(e) {
          console.log('we sren ifuafui');
          $(this).find('.dropdown').toggleClass('open');
          e.stopPropagation();
      });
  });
});

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
    var first_name = '<%= session.getAttribute("first_name") %>';
    console.log("first name is inside opening the review box "+first_name);
    console.log(first_name);
    if(first_name !== 'null'){
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