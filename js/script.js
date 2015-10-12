/**
 * ownCloud - health
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Morris Jobke <hey@morrisjobke.de>
 * @copyright Morris Jobke 2015
 */

(function ($, OC, OCA) {

	OCA.Health = {

		render: function(data) {
			var template = Handlebars.compile($('#health-checks-template').html()),
				$settingsSection = $('#app-health');

			$settingsSection.find('checks-list').remove();
			$settingsSection.append(template(data));
		},

		load: function() {
			$.get(OC.generateUrl('/apps/health/checks'))
				.done(function(data){
					OCA.Health.render(data);
				})
				.fail(function(){
					console.log('Failed');
				});
		}
	};

	$(document).ready(function () {
		OCA.Health.load();
	});

})(jQuery, OC, OCA);
