(function Background() {
	var _canvas				= null;
	var _context				= null;
	var _window_size		= {
		width:		0,
		height:		0
	};
	var _particle_count		= 50;
	var _particle_distance	= 100;
	var _particles				= [];
	var _distance;
	
	function Particle() {
		this.x		= Math.random() * _window_size.width;
		this.y		= Math.random() * _window_size.height;
		this.vx		= -1 + Math.random() * 2;
		this.vy		= -1 + Math.random() * 2;
		this.radius	= Math.random() * 0;
		this.paint	= function paint() {
			_context.fillStyle = 'rgba(255, 255, 255, 0.5)';
			_context.beginPath();
			_context.arc(this.x, this.y, 5, 1, Math.PI * 5, false);
			_context.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
			_context.fill();
		}
	};
	
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
		_context			= _canvas.getContext('2d');
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
		
		for(var index = 0; index < _particle_count; ++index) {
			_particles.push(new Particle());
		}
		
		this.loop();
	};
	
	this.loop = function loop() {
		this.paint();
		requestAnimationFrame(this.loop.bind(this));
	};
	
	this.paint = function paint() {
		_context.clearRect(0, 0, _window_size.width, _window_size.height);
		_context.fillStyle = 'rgba(11, 14, 22, 0.9)';
		_context.fillRect(0, 0, _window_size.width, _window_size.height);

		for (var index = 0; index < _particles.length; ++index) {
			_particles[index].paint();
		}

		this.update();
	};
	
	this.update = function update() {
		for (var i = 0; i < _particles.length; i++) {
			p = _particles[i];

			p.x += p.vx;
			p.y += p.vy

			if(p.x + p.radius > _window_size.width) {
				p.x = p.radius;
			} else if(p.x - p.radius < 0) {
				p.x = _window_size.width - p.radius;
			}

			if(p.y + p.radius > _window_size.height) {
				p.y = p.radius;
			} else if(p.y - p.radius < 0) {
				p.y = _window_size.height - p.radius;
			}
			
			for(var j = i + 1; j < _particles.length; j++) {
				p2 = _particles[j];
				this.distance(p, p2);
			}
		}
	};
	
	this.distance = function distance(p1, p2) {
		var dx			= p1.x - p2.x;
		var dy			= p1.y - p2.y;
		var _distance = Math.sqrt(dx * dx + dy * dy);
		
		if(_distance <= _particle_distance) {
			_context.beginPath();
			_context.strokeStyle = 'rgba(255, 255, 255,' + (1 - _distance / _particle_distance) + ')';
			_context.moveTo(p1.x, p1.y);
			_context.lineTo(p2.x, p2.y);
			_context.stroke();
			_context.closePath();
			
			var ax = dx / 7000;
			var ay = dy / 7000;
			
			p1.vx	-= ax;
			p1.vy	-= ay;
			p2.vx	+= ax;
			p2.vy	+= ay;
		}  
	};
	
	this.init();
}());