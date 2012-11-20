/** Рейтинг заметок в виде звезд jquery.rating.js
 *  http://biznesguide.ru/coding/156.html
 *  Copyright (c) 2011 Шамшур Иван (http://twitter.com/ivanshamshur)
 *  Dual licensed under the MIT and GPL licenses
 */
 
;(function($){	
    $.rating = function(e, o){
        this.options = $.extend({
            fx: 'full',
            image: '',
            width: 32,
            stars: 5,
            minimal: 0,
            titles: [],
            readOnly: false,
            url: '',
            type: 'post',
            loader: '',
            click: function(){}
        }, o || {});

        this.el = $(e);
        this.left = 0;
        this.val = parseFloat($('.val',e).val()) || 0;
        if(this.val > this.options.stars) this.val = this.options.stars;
        if(this.val < 0) this.val = 0;
        this.old = this.val;
        this.votes = parseInt($('.votes',e).val()) || '';
        this.voteID = $('.vote-id',e).val() || '';
        this.vote_wrap = $('<div class="vote-wrap"></div>');
        this.vote_block = $('<div class="vote-block"></div>');
        this.vote_hover = $('<div class="vote-hover"></div>');
        this.vote_stars = $('<div class="vote-stars"></div>');
        this.vote_active = $('<div class="vote-active"></div>');
        this.vote_result = $('<div class="vote-result"></div>');
        this.vote_success = $('<div class="vote-success"></div>');
        this.loader = $('<img src="'+this.options.loader+'" alt="load...">');
        this.init();
    };
    var $r = $.rating;
    $r.fn = $r.prototype = {
        rating: '0.1'
    };
    $r.fn.extend = $r.extend = $.extend;

    $r.fn.extend({        
    	init: function(){    	
            this.render();
            if(this.options.readOnly) return;
            var self = this, left = 0, width = 0;

            this.vote_hover.bind('mousemove mouseover',function(e){
                if(self.options.readOnly) return;
                var $this = $(this),
                score = 0;
                left = e.clientX>0 ? e.clientX: e.pageX;
                width = left - $this.offset().left - 2;
                var max = self.options.width*self.options.stars,
                min = self.options.minimal*self.options.width;
                if(width > max) width = max;
                if(width < min) width = min;
                score = Math.round( width/self.options.width * 10 ) / 10; //округляем до 1 знака после запятой
                if(self.options.fx == 'half'){
                    width = Math.ceil(width/self.options.width*2)*self.options.width/2;
                }
                else if(self.options.fx != 'float'){
                    width = Math.ceil(width/self.options.width) * self.options.width;
                }
                score = Math.round( width/self.options.width * 10 ) / 10;
                self.vote_active.css({
                    'width':width,
                    'background-position':'left center'
                });
                //self.vote_success.html('Ваша оценка: '+score);

             })
             .bind('mouseout',function(){
                    if(self.options.readOnly) return;
                    self.old = self.val;
                    self.reset();
                    self.vote_success.empty();
             }).
             bind('click.rating',function(){
                 if(self.options.readOnly) return;
                 var score = Math.round( width/self.options.width * 10 ) / 10;
                 if(score > self.options.stars) score = self.options.stars;
                 if(score < 0) score = 0;
                 self.old = self.val;
                 self.val = (self.val*self.votes +score)/(self.votes + 1);
                 self.val.toFixed(1);
                 //self.vote_success.html('Ваша оценка: '+score);
                 //if(self.options.url != ''){
                     self.send(score);
                 //}
                 self.options.readOnly = false;
                 self.options.click.apply(this,[score]);
             });
    	},
        set: function(){
            this.vote_active.css({
                'width':this.val*this.options.width,
                'background-position':'left bottom'
            });
    	},
    	reset: function(){
            this.vote_active.css({
                'width':this.old*this.options.width,
                'background-position':'left bottom'
            });
    	},
        setvoters: function(){
            this.vote_result.html(this.declOfNum(this.votes));  
        },
    	render: function(){
            this.el.html(this.vote_wrap.append(
                this.vote_hover.css({
                    padding:'0 4px',
                    height:this.options.width,
                    width:this.options.width*this.options.stars
                }),
                this.vote_result.text(this.declOfNum(this.votes)),
                this.vote_success
            ));
            this.vote_block.append(
                this.vote_stars.css({
                    height:this.options.width,
                    width:this.options.width*this.options.stars,
                    background:"url('"+this.options.image+"') left top"
                }),
                this.vote_active.css({
                    height:this.options.width,
                    width:this.val*this.options.width,
                    background:"url('"+this.options.image+"') left bottom"
                })
            ).appendTo(this.vote_hover);    		
    	},
    	send: function(score){    		
            var self = this;
            //self.votes++;
            self.set();
            self.setvoters();
            /*this.vote_result.html(this.loader);
            $.ajax({
                url: self.options.url,
                type: self.options.type,
                data:{id:this.voteID,score:score},
            dataType: 'json',
                success: function(data){
                    if(data.status == 'OK') {
                      self.votes++;
                      self.set();
                    }
                    else{
                        self.reset();
                    }
                    self.setvoters();
                    if(data.msg)self.vote_success.html(data.msg);
                }
            });*/
    	},
    	declOfNum: function(number){  
    	    if(number <= 0) return '';
            number = Math.abs(Math.floor(number));
            cases = [2, 0, 1, 1, 1, 2];  
            return number+' '+ this.options.titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
        }  
    });
    
    
    $.fn.rating = function(o){    	
    	if (typeof o == 'string') {
            var instance = $(this).data('rating'), args = Array.prototype.slice.call(arguments, 1);
            return instance[o].apply(instance, args);
        } else {
            return this.each(function() {
                var instance = $(this).data('rating');
                if (instance) {
                    if (o) {
                        $.extend(instance.options, o);
                    }                    
                    instance.init();                    
                } else {                	
                    $(this).data('rating', new $r(this, o));
                }
            });
        }
    };	
})(jQuery);