(function(window, angular, $, undefined){
	
	angular.module("ngCaracteres", ["ng"]).factory("$characteristics", function(){
		var c = function(){
			this.characteristics = [];
			
			this.buildForm = function(jsonCharacteristics){
				angular.forEach(jsonCharacteristics, function(v, k){
					var input;
					jsonCharacteristics[k].label = v.term.name;
					jsonCharacteristics[k].widget = 'text';
					try{
						input = JSON.parse(v.input);
						if(input.label)
							jsonCharacteristics[k].label = input.label;
						if(input.options) {
							jsonCharacteristics[k].widget = 'select';
							jsonCharacteristics[k].options = input.options;
						}
					}
					catch(e){
						
					}
				});
			};
		};
		
		return new c();
	});
	
})(window, window.angular, window.jQuery);