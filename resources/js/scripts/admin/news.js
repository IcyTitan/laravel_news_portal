import JustValidate from 'just-validate';
(() => {
    'use strict';
    window.adminNewsHelper = function () {
        this.csrf = '';

        this.setCsrf = function (token) {
            this.csrf = token;
        };

        this.validate = function (save, update) {
            (() => {
                const validate = new JustValidate('#news-form', {
                    errorFieldCssClass: 'error',
                    errorLabelStyle: {
                        fontSize: '14px',
                        color: '#dc3545',
                    },
                    focusInvalidField: true,
                    lockForm: false,
                });

                validate
                    .addField('#form-name', [
                        {
                            rule: 'required',
                        },
                        {
                            rule: 'customRegexp',
                            value: /^[aA-zZаА-яЯ0-9-_,.]+$/i
                        },
                        {
                            rule: 'minLength',
                            value: 5,
                        },
                        {
                            rule: 'maxLength',
                            value: 250,
                        },
                    ])
                    .addField('#form-category', [
                        {
                            rule: 'required',
                        }
                    ])
                    .addField('#form-short-description', [
                        {
                            rule: 'required',
                        },
                        {
                            rule: 'customRegexp',
                            value: /^[aA-zZаА-яЯ0-9-_,. ]+$/i
                        },
                        {
                            rule: 'minLength',
                            value: 5,
                        },
                        {
                            rule: 'maxLength',
                            value: 400,
                        },
                    ])
                    .addField('#form-description', [
                        {
                            rule: 'required',
                        },
                        {
                            rule: 'customRegexp',
                            value: /^[aA-zZаА-яЯ0-9-_,. ]+$/
                        },
                        {
                            rule: 'minLength',
                            value: 5,
                        },
                        {
                            rule: 'maxLength',
                            value: 4000,
                        },
                    ])
                    .onSuccess((event) => {
                        if(event.submitter.classList.contains('btn-update')){
                            let rowId = $(event.submitter).attr('id-attr');
                            if (!rowId) {
                                alert('Не выбрана новость для редактирования');
                                return;
                            }
                            this.saveNews(update, rowId)
                        }else if(event.submitter.classList.contains('btn-save')){
                            this.saveNews(save)
                        }
                    });
            })();
        }

        this.clearErrors = function () {
            let errorElement = '';
            while (true) {
                errorElement = document.querySelector(`.error`);
                if (!errorElement) {
                    break;
                }
                errorElement.classList.remove('error');
            }
            document.querySelector(`.error-text`).classList.add('d-none');
        };

        this.showSuccess = function () {
            document.querySelector(`.success-text`).classList.remove('d-none');
            setTimeout(() => {
                document.querySelector(`.success-text`).classList.add('d-none');
            }, 10000);
        };

        this.saveNews = function (route, id) {
            let self = this;
            let Newsform = document.querySelector("#news-form");
            let NewsformData = new FormData(Newsform);
            if (id) {
                NewsformData.append('id', id);
            }
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: route,
                headers: {
                    'X-CSRF-TOKEN': self.csrf
                },
                cache: false,
                contentType: false,
                processData: false,
                data: NewsformData,
                success: function () {
                    if(id){
                        $(".btn-update").removeAttr('id-attr');
                        $(".btn-save").attr('disabled', false);
                        $(".btn-update").attr('disabled', true);
                    }else{
                        $(".btn-save").attr('disabled', false);
                    }
                    self.clearErrors();
                    self.showSuccess();
                    document.querySelector(`#news-form`).reset();
                    window.LaravelDataTables["news-table"].draw();
                },
                error: function (data) {
                    let responseText = JSON.parse(data.responseText);
                    self.clearErrors(responseText.message);
                    document.querySelector(`.error-text`).innerText = '';
                    document.querySelector(`.error-text`).classList.remove('d-none');
                    Object.keys(responseText.errors).map((error) => {
                        document.querySelector(`#form-${error}`).classList.add('error');
                    });
                    Object.values(responseText.errors).map((error) => {
                        document.querySelector(`.error-text`).innerText += error + '\n';
                    });
                },
            });
        };

        this.changeEntry = function (route, button) {
            let self = this;
            let rowId = button.attr('id-attr');
            if (!rowId) return;
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: route,
                headers: {
                    'X-CSRF-TOKEN': self.csrf
                },
                data: {
                    id: rowId,
                },
                success: function (response) {
                    window.LaravelDataTables["news-table"].draw();
                    $("input[name=name]").val(response.news['name']);
                    $("textarea[name=short-description]").val(response.news['short_description']);
                    $("textarea[name=description]").val(response.news['description']);
                    $('#form-category').val(response.news['category_id']);
                    $('.btn-update').attr('id-attr', rowId);
                }
            });
        }
    }
})();
