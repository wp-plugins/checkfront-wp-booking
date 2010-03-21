jQuery(document).ready(function() {
    // Declare variables to hold twitter API url and user name
    var twitter_api_url = 'http://search.twitter.com/search.json';
    var twitter_user    = 'checkfront';

    // Enable caching
    jQuery.ajaxSetup({ cache: true });

    // Send JSON request
    // The returned JSON object will have a property called "results" where we find
    // a list of the tweets matching our request query
    jQuery.getJSON(
        twitter_api_url + '?callback=?&rpp=5&q=from:' + twitter_user,
        function(data) {
			var tweet_html = '';
            jQuery.each(data.results, function(i, tweet) {
                // Uncomment line below to show tweet data in Fire Bug console
                // Very helpful to find out what is available in the tweet objects
                //console.log(tweet);


                // Before we continue we check that we got data
                if(tweet.text !== undefined) {
                    // Calculate how many hours ago was the tweet posted
                    var date_tweet = new Date(tweet.created_at);
                    var date_now   = new Date();
                    var date_diff  = date_now - date_tweet;
                    var hours      = Math.round(date_diff/(1000*60*60));
	          		var re = /(https?:\/\/(([-\w\.]+)+(:\d+)?(\/([\-\w/_\.]*(\?\S+)?)?)?))/ig;        


                    // Build the html string for the current tweet
                     tweet_html += '<li>';
			        tweet_html += tweet.text.replace(re, '<a href="$1" target="blank">$1</a>');
                    tweet_html    += '<br/><small>' + hours;
                    tweet_html    += ' hours ago</small><\/li>';

                    // Append html string to tweet_container div
                }
            });
            jQuery('#tweet_container').html('<ul>' + tweet_html + '</ul>');
        }
    );
});

