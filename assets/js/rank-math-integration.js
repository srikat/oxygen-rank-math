(function ($) {
    RankMathIntegration = function () {
        if (typeof (RankMathApp) !== 'undefined') {
            RankMathApp.registerPlugin('RankMathIntegration');

            wp.hooks.addFilter('rank_math_content', 'RankMathIntegration', this.replaceDataWithOxygenMarkup);
        }
    }

	/**
	 * Replaces the full content with Oxygen generated markup, as it is supposed to contain the_content too
	 *
	 * @param data The data to modify
	 */
    RankMathIntegration.prototype.replaceDataWithOxygenMarkup = function (data) {
        // The full Oxygen generated markup is already enqueued
        return rm_data.oxygen_markup;
    };

    $(document).ready(function () {
        new RankMathIntegration();
    });
})(jQuery);
