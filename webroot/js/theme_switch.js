'use strict';
 $(function(){
    var ThemeSwitch = {
        submitUrl: $('#theme-switch-config-submit-url').html(),
        token: $('#theme-switch-config-token').html(),
        $button: $('#theme-switch-config-submit'),
        $smartphone: $('#theme-switch-config-smartphone'),
        $mobile: $('#theme-switch-config-mobile'),
        $waiting: $('#Waiting'),
        $dialog: $('#theme-switch-config-dialog'),
        $errors: {
            mobile: $('#error-message-mobile'),
            smartphone: $('#error-message-smartphone')
        },
        init: function() {
            var that = this;
            this.$button.on('click', function(){
                that.post();
            });
        },
        getData: function () {
            return {
                smartphone: this.$smartphone.val(),
                mobile: this.$mobile.val(),
                _Token: {key: this.token}
            };
        },
        post: function () {
            var that = this;
            $.ajax({
                url: this.submitUrl,
                type: 'POST',
                data: this.getData(),
                beforeSend: function () {
                    that.$waiting.show();
                },
                success: function (response, status) {
                    that.updateErrors();
                    that.$dialog.dialog({
                        modal: true,
                        title: 'テーマスイッチ',
                        width: 320,
                        buttons: {
                            "OK": function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                },
                error: function (request, status, error) {
                    var res = JSON.parse(request.responseText);
                    that.updateErrors(res.errors);
                },
                complete: function () {
                    that.$waiting.hide();
                }
            });
        },
        updateErrors: function (errors) {
            if(typeof errors === 'undefined') {
                errors = {};
            }
            for (var key in this.$errors) {
                if (!this.$errors.hasOwnProperty(key)) {
                    continue;
                }
                if (errors.hasOwnProperty(key)) {
                    this.$errors[key].show().html(errors[key][0]);
                } else {
                    this.$errors[key].hide().html('');
                }
            }
        }
    };

    ThemeSwitch.init();
});