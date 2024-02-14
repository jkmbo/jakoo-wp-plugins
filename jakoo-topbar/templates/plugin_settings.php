<style type="text/css">
    .form-group {
        margin-bottom: 10px;
        display: flex;
    }
    /*.form-group > * { float: left; }*/
    .form-group > label { width: 150px; margin-right: 30px; }
    .form-group .from-control { width: 400px; }
    .form-group > select width: 200px; }
    .form-group > input[type="submit"] { width: auto; }
    input.color-picker-hex { font-size: 11px; line-height: 1; min-height: 26px; }
    /*.preview-topbar, .dummy-website-content { margin-left: 150px; }*/
    .preview-topbar { font-size: 13px; margin-bottom: 5px; padding: 10px; line-height: 1; text-align: center; }
    .dummy-website-content p { background: #bababa; margin: 0 0 5px; }
    .dummy-website-content p:first-child { height: 200px; }
    .dummy-website-content p:nth-child(2) { height: 30px; }
    .preview-wrap { margin-left: 150px; width: 800px; padding: 8px; border: 1px solid #999; }
    .form-wrap { width: 970px; }
</style>

<section>
    <h2>Jakoo Top Bar Settings Page</h2>
    <p>Here you can customize settings for your topbar!</p>
    <?php
        $type = get_option('jakoo_topbar_type') ?: 'free_text';
        $text = get_option('jakoo_topbar_text') ?: 'This is the default topbar text, please modify it.';
        $bg_color = get_option('jakoo_topbar_bg_color') ?: '#000000';
        $text_color = get_option('jakoo_topbar_text_color') ?: '#FFFFFF';
        $text_size = get_option('jakoo_topbar_text_size') ?: 12;
        $padding = get_option('jakoo_topbar_padding') ?: 10;
    ?>
    <div class="wrap top-bar-wrapper">
        <div class="form-wrap">
            <form method="post" action="options.php">
                <?php settings_errors() ?>
                <?php settings_fields('jakoo_topbar_option_group'); ?>

                <div class="form-group">
                    <label for="jakoo_topbar_text">Type</label>

                    <select name="jakoo_topbar_type">
                        <option <?php echo $type == 'free_text' ? 'selected="selected"' : ''; ?> value="free_text">Free Text / HTML</option>
                        <option <?php echo $type == 'random_quotes' ? 'selected="selected"' : ''; ?> value="random_quotes">Random Quotes</option>
                    </select>
                </div>
                <div class="form-group" id="top_bar_text">
                    <label for="jakoo_topbar_text">Top Bar Text<br/><small>You can insert HTML here</small></label>
                    <textarea class="from-control" rows="5" name="jakoo_topbar_text"><?php echo $text; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Top Bar Background Color</label>
                    <input type="color" id="bg_color" value="<?php echo $bg_color; ?>"/> <input class="color-picker-hex" type="text" name="jakoo_topbar_bg_color" value="<?php echo $bg_color; ?>"/>
                </div>
                <div class="form-group">
                    <label>Top Bar Text Color</label>
                    <input type="color" id="text_color" value="<?php echo $text_color; ?>"/> <input class="color-picker-hex" type="text" name="jakoo_topbar_text_color" value="<?php echo $text_color; ?>"/>
                </div>
                <div class="form-group">
                    <label>Top Bar Text Size</label>
                    <select name="jakoo_topbar_text_size">
                        <?php for($i = 8; $i <= 100; $i++): ?>
                        <option <?php echo ($text_size == $i) ? 'selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select> <i style="display: block; margin-top: 5px;"> &nbsp; px</i>
                </div>
                <div class="form-group">
                    <label>Top Bar Padding</label>
                    <input type="text" name="jakoo_topbar_padding" value="<?php echo $padding; ?>">
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <label>&nbsp;</label>
                    <?php submit_button(null, 'primary', 'submit', false); ?>
                </div>

            </form>
        </div>

    </div>
</section>

<section>
    <h2>Preview</h2>
    <div class="preview-wrap">
        <div class="preview-topbar">Sample topbar text here...</div>
        <div class="dummy-website-content"><p></p><p></p></div>
    </div>

</section>

<script type="text/javascript">
    const topbarType = '<?php echo $type; ?>';
    const topbarText = '<?php echo $text; ?>';
    const topbarBgColor = '<?php echo $bg_color; ?>';
    const topbarTextColor = '<?php echo $text_color; ?>';
    const topbarTextSize = '<?php echo $text_size; ?>';
    const topbarPadding = '<?php echo $padding; ?>';
</script>