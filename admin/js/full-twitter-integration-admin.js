(function ($) {
    'use strict';
    var $boxesContainer = $('.toggle-boxes-container');
    var animateSpeed = 400;
    var containerPadding = 45;
    var $goBackBtn = $('.go-back-btn');
    var $titleBtn = $('.fti-twitter-title');
    var $initialBlock = $('.fti-block-initial');

    setup_twitter_button();
    setup_blocks_swipe();
    set_initial_values();
    setup_go_back_btn();
    setup_title_btn();

    function setup_blocks_swipe() {
        $('.fti-option-block').each(function () {
            $(this).click(function (e) {
                e.preventDefault();
                var toggleBlock = $(this).attr('switchClass');
                toggle_blocks(toggleBlock);
            });
        });
    }

    function setup_go_back_btn() {
        $('.go-back-btn').stop(true, true).click(function () {
            toggle_blocks('fti-block-initial');
        });

    }

    function toggleInGoBackBtn() {
        if ($initialBlock.css('display') == 'none') {
            fadeInGoBackBtn();
        } else {
            fadeOutGoBackBtn();
        }
    }

    function setup_title_btn() {
        $titleBtn.click(function (e) {
            e.preventDefault();
            if ($initialBlock.css('display') == 'none') {
                $goBackBtn.click();
            }
        })
    }

    function fadeOutGoBackBtn() {
        $goBackBtn.stop(true, true).fadeOut();
    }

    function fadeInGoBackBtn() {
        $goBackBtn.stop(true, true).fadeIn();
    }

    /************* Toggle effects ****************/

    function toggle_blocks(toggleBlock) {
        var $block = $('.' + toggleBlock);
        var $toHide = $('.toggle-active');
        var blockWidth = $block.width();
        var blockHeight = $toHide.height();
        $toHide.removeClass('toggle-active');

        get_random_effect($block, $toHide, blockWidth, blockHeight);
    }

    function get_random_effect($block, $toHide, blockWidth, blockHeight) {
        var rand = getRandomInt(1, 4);

        switch (rand) {
            case 1:
                toggleEffect($block, $toHide, blockWidth, 0, blockHeight);
                break;

            case 2:
                toggleEffect($block, $toHide, -blockWidth, 0, blockHeight);
                break;

            case 3:
                toggleEffect($block, $toHide, 0, blockHeight, blockHeight);
                break;

            case 4:
                toggleEffect($block, $toHide, 0, -blockHeight, blockHeight);
                break;
        }
        console.log(rand);
    }

    function toggleEffect($block, $toHide, toLeft, toBottom, blockHeight) {
        console.log('toBottom', toBottom);
        console.log('blockHeight', blockHeight);
        $block.addClass('toggle-active').css({
            display: 'block',
            left: toLeft,
            bottom: toBottom,
            height: blockHeight
        }).stop(true, true).animate({
            left: 0,
            bottom: 0
        }, animateSpeed, function () {
            $toHide.hide()
            toggleInGoBackBtn();
        });
    }

    /************* End Toggle effects ****************/

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function setup_twitter_button() {
        $('.log-in-with-twitter-data').click(function () {
            $(this).each(function (e) {
                var externalUrl = $(this).attr('fti-ws');
                save_twitter_api_data(externalUrl);
            });
        });
    }

    function set_initial_values() {
        set_container_height();
        //set_container_height();
    }

    function set_container_height() {
        var $toggleActive = $('.toggle-active');
        $boxesContainer.animate({
            'height': $toggleActive.height() + containerPadding
        }, animateSpeed);
    }

    function save_twitter_api_data(externalUrl) {

        $.ajax({
            url: externalUrl
        }).done(function (data, more) {
            console.log(url, externalUrl);
            console.log(data, "done");
        });
    }

}(jQuery));