/*

Copyright (c) 2009 Robert Jan Bast

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.


Slider.js

Simple class for sliding elements within a container.


Sample HTML, CSS and JS

HTML

<div id="parent">
	<div class="a"></div>
	<div class="b"></div>
	<div class="c"></div>
	<div class="d"></div>
</div>

CSS

div{width:100px;height:100px}
#parent{overflow:hidden;}
.a{background-color:blue}
.b{background-color:red}
.c{background-color:green}
.d{background-color:yellow}

JS

	 var slider = new Slider('parent'); // default behavior
or var slider = new Slider('parent', {mode:'vertical', endless:true}); // up & down, endlessly
or var slider = new Slider('parent', {endless:true, onStart:function(){this.previous()}}); // reversed, endlessly

*/
var Slider = new Class({

	Implements: [Options, Events, Chain],

	options: {
		childrenSelector: 'div',
		endless: false,
		mode: 'horizontal', // horizontal | vertical
		autoSlide: true,
		autoDelay: 2000,
		fxOptions: {
			duration: 1000
		},
		onStart: function(){
			this.next();
		},
		onFirst: function(){
			this.next();
		},
		onLast: function(){
			this.previous();
		},
		onNext: function(){},
		onPrevious: function(){},
		onStop: function(){},
		onPause: function(){},
		onResume: function(){}
	},

	container: null,
	children: [],
	stack: {
		next: [],
		previous: []
	},
	fx: null,
	timeoutId: null,

	initialize: function(container, options){
		// Grab & extend our container element
		this.container = $(container);
		// Wtfux?
		if (!this.container){
			alert('You failed the internet, do not pass start and do not collect awesome fx effects');
		}
		// Apply options passed
		this.setOptions(options);
		// Grab all (current) children of our container, based on selector given
		this.children = this.container.getElements(this.options.childrenSelector).setStyle('float', 'left');
		// Stoopid, durrr
		if (this.children.length < 2){
			alert('Failure is imminent, it takes two to tango');
		}
		// Grab all children other than the currently visible one and loop through them
		this.children.slice(1,this.children.length).each(
			function(el){
				// Remove each element from the DOM and push them onto the 'next' stack
				this.stack.next.push(el.dispose());
			// I bind 'this', because otherwise this.stack is not accessible
			}.bind(this)
		);
		// If autoslide option is true
		if (this.options.autoSlide){
			// Start! durrr
			this.start();
		}
	},

	start: function(){
		this.fireEvent('start');
	},

	stop: function(){
		if (this.timeoutId){
			$clear(this.timeoutId);
		}
		this.fireEvent('stop');
	},

	next: function(){
		// Check if an fx instance isn't currently active
		if (!this.fx){
			// Check if we still have elements in the next stack OR if endless mode is set
			if (this.stack.next.length || this.options.endless){
				// If we have no more elements on the 'next' stack, we assume endless mode is true
				if (!this.stack.next.length){
					// Grab the last item from the 'previous' stack and push it onto the 'next' stack
					this.stack.next.push(this.stack.previous.pop());
				}
				// Get the current child, use selector given just to be sure we get the right one
				var currChild = this.container.getFirst(this.options.childrenSelector);
				// Get the next child we want
				var nextChild = this.stack.next.shift();
				// Generate the options object
				var opts = {'0': {}, '1': {}};
				// Figure out which mode we are running in
				switch (this.options.mode){
					// Vertical is ^ v
					case 'vertical' :
						// So we mess with top margin of current child
						opts['0']['margin-top'] = [0, -currChild.getStyle('height').toInt()],
						// And with bottom margin of the next child
						opts['1']['margin-bottom'] = [-currChild.getStyle('height').toInt(), 0];
						// Apply the bottom margin to the to be inserted child and inject it into the dom
						nextChild.setStyle('margin-bottom', -currChild.getStyle('height').toInt()).inject(currChild, 'after');
					break;
					// Horizontal is < >
					case 'horizontal' :
					default :
						// So we mess with left margin of current child
						opts['0']['margin-left'] = [0, -currChild.getStyle('width').toInt()],
						// And with right margin of the next child
						opts['1']['margin-right'] = [-currChild.getStyle('width').toInt(), 0];
						// Apply the right margin to the to be inserted child and inject it into the dom
						nextChild.setStyle('margin-right', -currChild.getStyle('width').toInt()).inject(currChild, 'after');
					break;
				}
				// Are we in autoslide mode?
				if (this.options.autoSlide){
					// Is there a timer active?
					if (this.timeoutId){
						// Clear it
						$clear(this.timeoutId);
					}
					// Generate the fxOptions object by merging default with some extra options
					var fxOptions = $merge(this.options.fxOptions, {
						// Add a onComplete event
						onComplete: function(e){
							// When we're done, set a timer again, cause this is like, autoslide mode, mkay
							this.timeoutId = this.next.delay(this.options.autoDelay, this);
						// Binding 'this' cause otherwise this.next and such are not accessible
						}.bind(this)
					});
				// No autoslide mode
				} else {
					// Default options are sufficient
					var fxOptions = this.options.fxOptions;
				}
				// Create the fx instance with the custom options, and add a chained function
				this.fx = new Fx.Elements($$(currChild, nextChild), fxOptions).start(opts).chain(
					function(){
						// unset the fx instance
						this.fx = null;
						// When we are done, dispose of the current child and put it on the 'previous' stack
						this.stack.previous.unshift(currChild.dispose().setStyles({'margin-top':0,'margin-bottom':0,'margin-left':0,'margin-right':0}));
					// Again, binding 'this' for accessibility
					}.bind(this)
				);
				// We've moved to the next element, fire event!
				this.fireEvent('next', nextChild);
			// Ohnoez, no more elements and no endless mode :(
			} else {
				// Since there are no more elements, fire the last event
				this.fireEvent('last');
			}
		}
	},

	previous: function(){
		// Check if an fx instance isn't currently active
		if (!this.fx){
			// Check if we still have elements in the previous stack OR if endless mode is set
			if (this.stack.previous.length || this.options.endless){
				// If we have no more elements on the 'previous' stack, we assume endless mode is true
				if (!this.stack.previous.length){
					// Grab the last item from the 'next' stack and push it onto the 'previous' stack
					this.stack.previous.push(this.stack.next.pop());
				}
				// Get the current child, use selector given just to be sure we get the right one
				var currChild = this.container.getFirst(this.options.childrenSelector);
				// Get the previous child we want
				var prevChild = this.stack.previous.shift();
				// Generate the options object
				var opts = {'0': {}, '1': {}};
				// Figure out which mode we are running in
				switch (this.options.mode){
					// Vertical is ^ v
					case 'vertical' :
						// So we mess with bottom margin of current child
						opts['0']['margin-bottom'] = [0, -currChild.getStyle('height').toInt()],
						// And with top margin of the previous child
						opts['1']['margin-top'] = [-currChild.getStyle('height').toInt(), 0];
						// Apply the top margin to the to be inserted child and inject it into the dom
						prevChild.setStyle('margin-top', -currChild.getStyle('height').toInt()).inject(currChild, 'before');
					break;
					// Horizontal is < >
					case 'horizontal' :
					default :
						// So we mess with right margin of current child
						opts['0']['margin-right'] = [0, -currChild.getStyle('width').toInt()],
						// And with left margin of the next child
						opts['1']['margin-left'] = [-currChild.getStyle('width').toInt(), 0];
						// Apply the left margin to the to be inserted child and inject it into the dom
						prevChild.setStyle('margin-left', -currChild.getStyle('width').toInt()).inject(currChild, 'before');
					break;
				}
				// Are we in autoslide mode?
				if (this.options.autoSlide){
					// Is there a timer active?
					if (this.timeoutId){
						// Clear it
						$clear(this.timeoutId);
					}
					// Generate the fxOptions object by merging default with some extra options
					var fxOptions = $merge(this.options.fxOptions, {
						// Add a onComplete event
						onComplete: function(e){
							// When we're done, set a timer again, cause this is like, autoslide mode, mkay
							this.timeoutId = this.previous.delay(this.options.autoDelay, this);
						// Binding 'this' cause otherwise this.previous and such are not accessible
						}.bind(this)
					});
				// No autoslide mode
				} else {
					// Default options are sufficient
					var fxOptions = this.options.fxOptions;
				}
				// Create the fx instance with the custom options, and add a chained function
				this.fx = new Fx.Elements($$(currChild, prevChild), fxOptions).start(opts).chain(
					function(){
						// unset the fx instance
						this.fx = null;
						// When we are done, dispose of the current child and put it on the 'next' stack
						this.stack.next.unshift(currChild.dispose().setStyles({'margin-top':0,'margin-bottom':0,'margin-left':0,'margin-right':0}));
					// Again, binding 'this' for accessibility
					}.bind(this)
				);
				// We've moved to the previous element, fire event!
				this.fireEvent('previous', prevChild);
			// Ohnoez, no more elements and no endless mode :(
			} else {
				// Since there are no more elements, fire the first event
				this.fireEvent('first');
			}
		}
	},

	pause: function(){
		this.fx.pause();
		this.fireEvent('pause');
	},

	resume: function(){
		this.fx.resume();
		this.fireEvent('resume');
	}

});