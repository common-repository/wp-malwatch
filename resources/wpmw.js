function EJEJC_lc(th) { return false; }

jQuery(document).ready(function($) {
	$('.wpmw-file-contents a').click(function(event) {
		event.preventDefault();
		
		var $this = $(this);
		var $pre = $this.parent().siblings('pre');
		if($pre.is(':visible')) {
			$pre.hide();
			$this.text('Show Contents');
		} else {
			$pre.show();
			$this.text('Hide Contents');
		}
	});
	$('.wpmw-section-description h3 a, .wpmw-section-description h4 a').click(function(event) {
		event.preventDefault();
		
		var $this = $(this);
		var $div = $this.parent().siblings('div');
		if($div.is(':visible')) {
			$div.hide();
		} else {
			$div.show();
		}
	});
});