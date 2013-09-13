window.addEvent('domready', function() {
	document.formvalidator.setHandler('libelle',
		function (value) {
			regex=/^[^0-9]+$/;
			return regex.test(value);
		});
});