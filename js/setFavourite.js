/* 
 * add this function to Drupal.ajax.prototype commands 
 * to use it as standard drupal #ajax
 */

(function ($){
    // add this function to Drupal ajax commands
    Drupal.ajax.prototype.commands.favourite_set = function(ajax, response, status){
         // remove order-agency class for all articles
        $('article').removeClass('order-agency');
        // set given artice as selected
        var selector = response['selector'];
        $('.'+selector).closest("article").addClass('order-agency');
    }
})(jQuery);