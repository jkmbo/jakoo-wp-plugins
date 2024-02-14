class JakooTopbarFrontEnd {
    constructor(jakooTopbarType, jakooTopBarFinalText) {
        const targetSelector = '.jakoo-topbar-fe';
        // there is a limitation to opensource random quotes of up to 180 requests per mins only so let's make sure we still present something to the user.
        if(jakooTopbarType == 'random_quotes') {
            if(jakooTopBarFinalText == 'Unable to fetch random quote at the moment') {
                jakooTopBarFinalText = window.localStorage.getItem('jakoo-topbar-text');
            } else {
                localStorage.setItem('jakoo-topbar-text', jakooTopBarFinalText);
            }
        }
        jQuery(targetSelector).html(jakooTopBarFinalText);
    }
}

new JakooTopbarFrontEnd(window.jakooTopbarType, window.jakooTopBarFinalText);