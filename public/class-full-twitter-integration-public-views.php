<?php
/**
 *
 * @link       http://full-twitter-integration.com
 * @since      1.0.0
 * @package    Full_Twitter_Integration
 * @subpackage Full_Twitter_Integration/public
 * @author     Tomas Agrimbau <tomas@theamalgama.com>
 *
 */
class Full_Twitter_Integration_Public_Views
{

    private $fti_helper;

    public function __construct()
    {
        $this->fti_helper = new Full_Twitter_Integration_Helper();

    }

    public function get_tweets_list($tweetsArray, $hashtag = null, $displayImages = false, $imagesSize, $displayProfileImages = false)
    {
        $return = "";

        if (isset($tweetsArray) && is_array($tweetsArray)) {

            foreach ($tweetsArray as $tweet) {
                $return .= '
                <div id="fti-tweet-' . $tweet->id . '" class="fti-tweet-loop-box">
                    <a class="fti-tweeter-user" href="https://twitter.com/' . $tweet->user->screen_name . '" target="_blank" id="fti-user-id-' . $tweet->user->id . '">';

                if ($displayProfileImages) {
                    $return .= '<img src="' . $tweet->user->profile_image_url . '" style="border-color: #' . $tweet->user->profile_link_color . ';">';
                };

                $return .= '<span class="fti-user-name">@' . $tweet->user->screen_name . '</span>
                    </a>
                <div class="fti-tweet-content">';

                $return .= $this->parse_tweet($tweet, $hashtag);

                if ($displayImages) {
                    $return .= $this->get_tweet_image($tweet, $imagesSize);
                }

                $return .= '</div></div>';

            }
        }

        return $return;
    }


    public function get_tweets_slider($tweetsArray, $hashtag = null, $displayProfileImage = false)
    {
        return $this->get_tweets_list($tweetsArray, $hashtag);

    }


    public function loop_tweets_for_widget($tweetsArray, $hashtag = null, $instance)
    {
        if (isset($tweetsArray) && is_array($tweetsArray)) {
            foreach ($tweetsArray as $tweet) {
                ?>
                <div id="fti-tweet-<?php echo $tweet->id; ?>" class="fti-tweet-loop-box">
                    <a class="fti-tweeter-user" href="https://twitter.com/<?php echo $tweet->user->screen_name; ?>"
                       target="_blank" id="fti-user-id-<?php echo $tweet->user->id; ?>">
                        <?php if ($instance['display-profile-image']) { ?>
                            <img src="<?php echo $tweet->user->profile_image_url; ?>"
                                 style="border-color: #<?php echo $tweet->user->profile_link_color; ?>;">
                        <?php }; ?>
                        <span class="fti-user-name">@<?php echo $tweet->user->screen_name; ?></span>
                    </a>

                    <div class="fti-tweet-content">
                        <?php
                        echo $this->parse_tweet($tweet, $hashtag);

                        if ($instance['display-tweets-images']) {
                            echo $this->get_tweet_image($tweet);
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
        } elseif (isset($tweetsArray) && !is_array($tweetsArray)) {
            echo $tweetsArray;
        }
    }

    public function display_widget_title($args, $instance, $append = '', $userData = null)
    {
        $instanceTitle = "";
        if (isset($instance['title'])) {
            $instanceTitle = $instance['title'];
        } else if (!is_null($userData) && isset($userData->screen_name)) {
            $instanceTitle = $userData->screen_name;
        }

        $title = apply_filters('widget_title', $instanceTitle);
        echo $args['before_widget'];
        if (!empty($title)) {
            ?>
            <div class="fti-widget-title-container">
                <?php
                if ($instance['display-profile-image'] && is_object($userData) && isset($userData->screen_name)) {
                    echo $this->get_user_title($userData);
                } else {
                    echo $this->get_formated_title($append, $title);
                }
                ?>
            </div>
        <?php
        }

    }

    public function get_user_title($userData)
    {
        if (isset($userData)) {
            $return = '
                <a class="fti-tweeter-user fti-tweeter-user-title fti-title"
                   href="https://twitter.com/' . $userData->screen_name . '" target="_blank" id="fti-user-id-' . $userData->id . '">
                    <img src="' . $userData->profile_image_url . '" style="border-color: #' . $userData->profile_link_color . ';">
                    <h2 class="fti-widget-title">@' . $userData->screen_name . '</h2>
                </a>';

            return $return;
        }

    }

    public function get_formated_title($append, $title)
    {
        $href = 'https://twitter.com/';
        if ($append == '#') {
            $href .= 'search?q=DomingoDe';
        } else {
            $href .= $title;
        }

        $return = '<a href="' . $href . '" target="_blank" class="fti-title">
            <h2 class="fti-widget-title">' . $append . str_replace(array('#', '@'), array('', ''), $title) . '</h2>
        </a>';

        return $return;
    }

    public function loop_tweets_without_user_for_widget($tweetsArray, $hashtag = null, $instance = null)
    {
        if (isset($tweetsArray) && is_array($tweetsArray)) {
            foreach ($tweetsArray as $tweet) {

                ?>
                <div id="fti-tweet-<?php echo $tweet->id; ?>" class="fti-tweet-loop-box">
                    <div class="fti-tweet-content">
                        <?php
                        echo $this->parse_tweet($tweet, $hashtag);


                        if ($instance['display-tweets-images']) {
                            $this->get_tweet_image($tweet);
                        }
                        ?>
                    </div>
                </div>

            <?php
            }
        } elseif (isset($tweetsArray) && !is_array($tweetsArray)) {
            echo $tweetsArray;
        }
    }


    private function parse_tweet($tweet, $hashtag)
    {
        $link = 'https://twitter.com/' . $tweet->user->screen_name . '/status/' . $tweet->id;
        $pre = '<a href="' . $link . '" target="_blank" class="tweet-content">';
        $after = '</a>';

        if ($hashtag) {
            $tweetContent = $this->format_choosen_hashtag($tweet->text, $hashtag);
        } else {
            $tweetContent = $tweet->text;
        }

        return $pre . $tweetContent . $after;
    }

    private function get_tweet_image($tweet, $imageSize = "thumb")
    {
        $return = '';
        if (isset($tweet->entities->media)) {
            foreach ($tweet->entities->media as $media) {
                $imageUrl = $media->url;
                $imageSrc = $media->media_url . ':' . $imageSize;

                $return .= '
                <div class="image-btn-container">
                    <a target="_blank" href="' . $imageUrl . '" class="image-container">
                        <img src="' . $imageSrc . '">
                    </a>
                </div>';
            }
        }

        return $return;
    }

    private function format_choosen_hashtag($content, $hashtag)
    {
        $hashtag = str_replace('#', '', $hashtag);
        $patterns = array('/#' . $hashtag . '/i');
        $replacements = array('<span class="fti-hashtag">#' . $hashtag . '</span>');

        $content = preg_replace($patterns, $replacements, $content);
        return $content;

    }


}



