(function Background() {
	var _canvas				= null;
	var _context			= null;
	var _nodes				= [];
	var _time				= Date.now();
	var _window_size		= {
		width:		0,
		height:		0
	};
	var _mouse				= {
		x:	-1E9,
		y:	-1E9
	};
	
	var _colors				= {
		background:	'rgba(11, 14, 22, 0.9)',
		node:		{
			default:	{
				background:	'#448FDA',
				color:		'#448FDA',
				alpha:		0.4
			},
			hover:		{
				background:	'#8F9AA3',
				color:		'#800000',
				alpha:		0.2
			}
		}
	};

	function NetworkNode(canvas, position, velocity) {
		var _canvas		= null;
		var _hover		= false;
		var _position	= {
			x: 0,
			y: 0
		};
		
		var _velocity	= {
			x: Math.random() * 2 - 1,
			y: Math.random() * 2 - 1
		};
		
		this.init = function init(canvas, position, velocity) {
			_canvas		= canvas;
			_position	= position;
			
			if(typeof(velocity) != 'undefined') {
				_velocity	= velocity;
			}
		};
		
		this.getX = function getX() {
			return _position.x;
		};
		
		this.getY = function getY() {
			return _position.y;
		};
		
		this.update = function update() {
			if(_position.x > _canvas.width + 50 || _position.x < -50) {
				_velocity.x = -_velocity.x;
			}
			
			if (_position.y > _canvas.height + 50 || _position.y < -50) {
				_velocity.y = -_velocity.y;
			}
		
			_position.x += _velocity.x;
			_position.y += _velocity.y;
		};
		
		this.setHover = function setHover(state) {
			_hover = state;
		};
		
		this.paint = function paint(context) {
			context.beginPath();
			
			context.globalAlpha	= _colors.node.default.alpha;
			context.fillStyle	= _colors.node.default.color;
			
			if(!_hover) {
				context.globalAlpha	= _colors.node.hover.alpha * 2.5;
				context.fillStyle	= _colors.node.hover.color;
			}
			
			context.arc((0.5 + _position.x) | 0, (0.5 + _position.y) | 0, 3, 0, 2 * Math.PI, false);
			context.fill();
		};
		
		this.init(canvas, position, velocity);
	}

	this.init = function init() {
		this.createMap();
		this.createAnimation();
	};
	
	this.createMap = function createMap() {
		new ol.Map({
			layers:		[
				new ol.layer.Tile({
					source: new ol.source.OSM()
				})
			],
			target:		document.querySelector('ctn-map'),
			controls:	[],
			view:			new ol.View({
				center:	[0, 0],
				zoom:	4
			})
		});
	};
	
	this.createAnimation = function createAnimation() {
		_canvas			= document.querySelector('canvas#particles');
		_context		= _canvas.getContext('2d');
		_window_size	= {
			width:	window.innerWidth,
			height:	window.innerHeight
		};
		_canvas.width	= _window_size.width;
		_canvas.height	= _window_size.height;
		
		window.addEventListener('resize', function onResize() {
			_window_size = {
				width:	window.innerWidth,
				height:	window.innerHeight
			};
			
			_canvas.width	= _window_size.width;
			_canvas.height	= _window_size.height;
		}, true);
		
		window.addEventListener('mousemove', function onMouseMove(event) {
			_mouse.x = event.clientX;
			_mouse.y = event.clientY;
		});

		for(var i = 0; i < _canvas.width * _canvas.height / (65*65); i++) {
			_nodes.push(new NetworkNode(_canvas, {
				x: Math.random() * _canvas.width,
				y: Math.random() * _canvas.height
			}));
		}

		this.loop();
	};
	
	this.loop = function loop() {
		this.clear();
		this.update();
		this.paint();
		requestAnimationFrame(this.loop.bind(this));
	};
	
	this.clear = function clear() {
		_context.clearRect(0, 0, _canvas.width, _canvas.height);
	};
	
	this.paint = function paint() {
		_context.globalAlpha	= 1;
		_context.fillStyle		= _colors.background;
		_context.fillRect(0, 0, _canvas.width, _canvas.height);
		
		for(var index = 0; index < _nodes.length; index++) {
			var node = _nodes[index];
			
			node.paint(_context);
			_context.beginPath();
			
			for(var index2 = _nodes.length - 1; index2 > index; index2 += -1) {
				var ball2	= _nodes[index2];
				var dist	= Math.hypot(node.getX() - ball2.getX(), node.getY() - ball2.getY());
				
				if(dist < 100) {
					_context.strokeStyle	= _colors.node.default.background;
					_context.globalAlpha	= 1 - (dist > 100 ? _colors.node.default.alpha : dist / 150);
					
					ball2.setHover(false);
					node.setHover(false);
					
					if(Math.hypot(node.getX() - _mouse.x, node.getY() - _mouse.y) > 150) {
						_context.strokeStyle = _colors.node.hover.background;
						_context.globalAlpha = _colors.node.hover.alpha;
						ball2.setHover(true);
						node.setHover(true);
					}
					
					_context.moveTo((0.5 + node.getX()) | 0, (0.5 + node.getY()) | 0);
					_context.lineTo((0.5 + ball2.getX()) | 0, (0.5 + ball2.getY()) | 0);
				}
			}
			
			_context.stroke();
		}
	};
	
	this.update = function update() {
		var difference = Date.now() - _time;
		
		for(var frame = 0; frame * 16.6667 < difference; frame++) {
			for(var index = 0; index < _nodes.length; index++) {
				_nodes[index].update();
			}
		}
		
		_time = Date.now();
	};
	
	this.init();
}());