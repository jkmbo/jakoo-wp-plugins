class TopBar {
    constructor(topbarType, topbarText, topbarBgColor, topbarTextColor, topbarTextSize, topbarPadding) {
        this.qoutesEndpoint = 'https://api.quotable.io/quotes/random?tags=famous-quotes';

        this.topbarType = topbarType;
        this.topbarText = topbarText;
        this.topbarBgColor = topbarBgColor;
        this.topbarTextColor = topbarTextColor;
        this.topbarTextSize = topbarTextSize;
        this.topbarPadding = topbarPadding;

        this.loadTopbarInSettings(this.topbarType, this.topbarBgColor, this.topbarTextColor, this.topbarTextSize, this.topbarPadding);
        this.attachEvents();
    }

    attachEvents() {
        const self = this;
        jQuery(document).ready(function($){
            jQuery('[name="jakoo_topbar_type"]').on('change', function(){
                self.loadTopbarInSettings(jQuery(this).val());
            });

            jQuery('#bg_color, #text_color').on('input', function(){
                jQuery(this).siblings('.color-picker-hex').val(jQuery(this).val());
                self.updatePreviewScreen(null, jQuery('[name="jakoo_topbar_bg_color"]').val(), jQuery('[name="jakoo_topbar_text_color"]').val(), jQuery('[name="jakoo_topbar_text_size"]').val(), jQuery('[name="jakoo_topbar_padding"]').val());
            });

            jQuery('[name="jakoo_topbar_text"]').on('keyup keydown', function(){
                self.updatePreviewScreen(jQuery(this).val(), jQuery('[name="jakoo_topbar_bg_color"]').val(), jQuery('[name="jakoo_topbar_text_color"]').val(), jQuery('[name="jakoo_topbar_text_size"]').val(), jQuery('[name="jakoo_topbar_padding"]').val());
            });

            jQuery('[name="jakoo_topbar_text_size"]').on('change', function(){
                self.updatePreviewScreen(jQuery('[name="jakoo_topbar_text"]').val(), jQuery('[name="jakoo_topbar_bg_color"]').val(), jQuery('[name="jakoo_topbar_text_color"]').val(), jQuery(this).val(), jQuery('[name="jakoo_topbar_padding"]').val());
            });

            jQuery('[name="jakoo_topbar_padding"]').on('keyup keydown', function(){
                self.updatePreviewScreen(jQuery('[name="jakoo_topbar_text"]').val(), jQuery('[name="jakoo_topbar_bg_color"]').val(), jQuery('[name="jakoo_topbar_text_color"]').val(), jQuery('[name="jakoo_topbar_text_size"]').val(), jQuery(this).val());
            });

            jQuery('.color-picker-hex').on('keyup keydown', function(){
                jQuery(this).siblings('[type="color"]').val(jQuery(this).val());
            });
        });
    }

    updatePreviewScreen(text, bgColor, textColor, textSize, padding) {
        if(text) {
            jQuery('.preview-topbar').html(text);
        }

        if(bgColor) {
            jQuery('.preview-topbar').css('background-color', bgColor);
        }

        if(textColor) {
            jQuery('.preview-topbar').css('color', textColor);
        }

        if(textSize) {
            jQuery('.preview-topbar').css('font-size', textSize + 'px');
        }

        if(padding) {
            jQuery('.preview-topbar').css('padding', padding + 'px');
        }
    }

    async getRandomQuotes() {
        const response = await fetch(
            this.qoutesEndpoint,
        );

        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }
        const data = await response.json();
        if(typeof data[0] !== 'undefined' && typeof data[0]['content'] !== 'undefined' && typeof data[0]['author'] !== 'undefined') {
            return '"' + data[0]['content'] + '" - <i><small>' + data['0']['author'] + '</small></i>';
        } else {
            return 'Unable to fetch random quote';
        }
    }

    loadTopbarInSettings(topbarType) {
        const self = this;

        if(topbarType == 'random_quotes') {
            jQuery('#top_bar_text').hide();

            const promise = this.getRandomQuotes();
            promise.then((data) => self.updatePreviewScreen(data, jQuery('[name="jakoo_topbar_bg_color"]').val(), jQuery('[name="jakoo_topbar_text_color"]').val(), jQuery('[name="jakoo_topbar_text_size"]').val(), jQuery('[name="jakoo_topbar_padding"]').val()));

        } else {
            jQuery('#top_bar_text').show();
            self.updatePreviewScreen(this.topbarText, jQuery('[name="jakoo_topbar_bg_color"]').val(), jQuery('[name="jakoo_topbar_text_color"]').val(), jQuery('[name="jakoo_topbar_text_size"]').val(), jQuery('[name="jakoo_topbar_padding"]').val());
        }

    }
}

new TopBar(topbarType, topbarText, topbarBgColor, topbarTextColor, topbarTextSize, topbarPadding);