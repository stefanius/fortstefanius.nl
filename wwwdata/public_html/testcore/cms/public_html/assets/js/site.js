
window.addEvent('domready', function() {
    
    /**
     * Active form fields
     */
    $$('input,textarea,select').addEvents({
        'focus': function(e) {
            this.addClass('focus');
        },
        'blur': function(e) {
            this.removeClass('focus');
        }
    });
	
    /**
     * Table row hover
     */
	$$('.table_data tbody tr').addEvents({
		'mouseenter': function(e) {
			this.addClass('row_hover');
		},
		'mouseleave': function(e) {
			this.removeClass('row_hover');
		}
	});
    
    /**
     * Squeezebox assigner
     */
    SqueezeBox.assign($$('a[rel=boxed]'), {
        ajaxOptions: {
            evalScripts: false,
            noCache: true,
            method: 'get'
        }
    });
    
    /**
     * Menu toggler
     *
    $$('a.toggler').each(function(toggler) {
        var myFx = new Fx.Slide(toggler.getNext('div'), {
            mode: 'vertical',
            duration: 250
        });
        if (!toggler.getParent('li').hasClass('open')) {
            myFx.hide();
        }
        toggler.store('myFx', myFx);
        toggler.addEvent('click', function(e) {
            if (e) e.stop();
            this.retrieve('myFx').toggle().chain(function() {
                this.getParent('li').toggleClass('open');
            }.bind(this));
        });
    });
    
    if (!$('main_menu')) {
        return;
    }
    
    var location = document.location.pathname;
    var toggler;
    
    $('main_menu').getElements('li').each(function(li) {
        if (!toggler) {
            var a = li.getFirst('a');
            var href = a.get('href');
            var regx = '^' + href;
            if (location.test(regx)) {
                var ul = li.getParent('ul');
                if (ul.hasClass('menu_item')) {
                    toggler = ul.getParent('li').getElement('.toggler');
                } else {
					var t = a.getNext('a');
					if (t.hasClass('toggler')) {
						toggler = t;
					}
				}
            }
        }
    });
    
    if (toggler) {
        toggler.fireEvent('click');
    }*/
});

/*
---

script: HtmlTable.Paginate.js

description: Paginate your table. Cool stuff.

license: MIT-style license

authors:
- Rob Bast

requires:
- /HtmlTable
- /Class.refactor

provides: [HtmlTable.Paginate]

...
*/

HtmlTable = Class.refactor(HtmlTable, {
    
    options: {
        pagination: false,
        paginators: []
    },
    
    initialize: function(){
        this.previous.apply(this, arguments);
        if (this.occluded) return this.occluded;
        this.paginators = this.options.paginators.map($);
        if (this.options.pagination){
            this.addEvent('sort', function(e){
                this.showPage(1);
            });
            this.enablePagination();
        }
    },
    
    showPage: function(page){
        this.currentPage = page;
        var first = page * this.options.pagination - this.options.pagination, last = first + this.options.pagination;
        $$(this.body.rows).each(function(el, i){
            var display = (i >= first && i < last) ? '' : 'none';
            el.setStyle('display', display);
        });
        this.paginators.each(function(paginator){
            var as = $(paginator).getElements('li').removeClass('current');
            as[page].addClass('current');
        });
        return this;
    },
    
    prevPage: function(){
        if (this.currentPage > 1) {
            this.showPage(this.currentPage.toInt()-1);
        }
        return this;
    },
    
    nextPage: function(){
        if (this.currentPage < this.totalPages) {
            this.showPage(this.currentPage.toInt()+1);
        }
        return this;
    },
    
    createPagination: function(){
        this.totalPages = Math.ceil(this.body.rows.length / this.options.pagination);
        if (this.totalPages > 1) {
            this.paginators.each(function(paginator){
                $(paginator).empty();
                var a = new Element('a', {
                    'html': '&#171;',
                    'href': '',
                    'events': {
                        'click': function(e){
                            if (e){
                                e.stop();
                            }
                            this.prevPage();
                        }.bind(this)
                    }
                });
                var li = new Element('li');
                li.adopt(a).inject(paginator);
                for (var page = 1; page <= this.totalPages; page++){
                    var a = new Element('a', {
                        'html': page,
                        'href': page,
                        'events': {
                            'click': function(e){
                                if (e){
                                    e.stop();
                                }
                                this.showPage(e.target.get('text'));
                            }.bind(this)
                        }
                    });
                    var li = new Element('li');
                    li.adopt(a).inject(paginator);
                }
                var a = new Element('a', {
                    'html': '&#187;',
                    'href': '',
                    'events': {
                        'click': function(e){
                            if (e){
                                e.stop();
                            }
                            this.nextPage();
                        }.bind(this)
                    }
                });
                var li = new Element('li');
                li.adopt(a).inject(paginator);
            }.bind(this));
            return this.showPage(1);
        }
        return this;
    },
    
    removePagination: function(){
        this.paginators.each(function(paginator){
            paginator.empty();
        });
        return this;
    },
    
    enablePagination: function(){
        this.createPagination();
        return this;
    },
    
    disablePagination: function(){
        this.removePagination();
        return this;
    }
});