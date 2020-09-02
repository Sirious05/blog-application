    document.querySelector('#img').addEventListener('input', (e) => {
        let dots;
        let partsPath = document.querySelector('#img').files[0].name.split('.');
        if (partsPath[0].length > 8) {
            dots = true;
        } else {
            dots = false;
        }
        if (dots === true) {
            document.querySelector('#img').previousElementSibling.textContent = document.querySelector('#img').files[0].name.slice(0, 8) + '...' + ' ' + partsPath[1];
        } else {
            document.querySelector('#img').previousElementSibling.textContent = document.querySelector('#img').files[0].name;
        }
    });
    async function postData(url, data) {
        let request = await fetch(`${url}`, {
            method: 'POST',
            cache: "no-cache",
            body: data,

        });
        return await request.text();
    }

    async function getData(url) {
        let request = await fetch(`${url}`);
        if (!request.ok || !url) {
            throw new Error(`Ошибка имеет статус ${request.status}`);
        }
        return await request.json();
    }

    function bindValidate(numberSelector, stringSelector) {
        let number = document.querySelectorAll(numberSelector),
            string = document.querySelectorAll(stringSelector);
        string.forEach(item => {
            item.addEventListener('input', (e) => {
                item.value = item.value.replace(/\d/, '');
            });
        });
        number.forEach(item => {
            item.addEventListener('input', (e) => {
                item.value = item.value.replace(/[-\.;":'a-zA-Zа-яА-Я]/, '');
            });
        });
    }
    bindValidate('input[name="id"]', 'input[type="text"]');
    bindValidate('input[name="id"]', 'textarea');
    document.querySelector('#blog').addEventListener('submit', (e) => {
        const status = document.createElement('div');
        const imgAlert = document.createElement('img');
        imgAlert.classList.add('status-img');
        status.style.marginTop = '30px';
        e.preventDefault();
        document.querySelector('#blog').parentNode.appendChild(status);
        document.querySelector('#blog').parentNode.appendChild(imgAlert);
        const statusMessage = {
            success: 'Успешно! Мы приняли ваши данные.',
            loading: 'Загрузка...Пожалуйста, подождите',
            failure: 'Упс... Произошла ошибка',
        };
        status.textContent = statusMessage.loading;
        const formData = new FormData(document.querySelector('#blog'));
        const path = './index.php';
        getData('./services/allId.json')
            .then(data => {
                const serversId = [];
                for (let key in data) {
                    serversId.push(data[key]);
                }

                function checkId(check) {
                    for (let i = 0; i < check.length; i++) {
                        if (check[i] == formData.get('id')) {
                            console.log(check[i], formData.get('id'));
                            return false;
                        }
                    }
                    return true;
                }
                let check = checkId(serversId);
                console.log(check);
                if (check === true) {
                    postData(path, formData)
                        .then(data => {
                            console.log(data);
                            status.textContent = statusMessage.success;
                            imgAlert.setAttribute('src', './local-images/success.png');
                            document.querySelector('#blog').classList.add('animated', 'fadeOut');
                            setTimeout(() => {
                                document.querySelector('#blog').style.display = 'none';
                                document.querySelector('#blog').classList.remove('animated', 'fadeOut');
                            }, 1000);
                        })
                        .catch(err => {
                            console.log(err);
                            status.textContent = statusMessage.failure;
                            imgAlert.setAttribute('src', './local-images/fail.png');
                            document.querySelector('#blog').classList.add('animated', 'fadeOut');
                            setTimeout(() => {
                                document.querySelector('#blog').style.display = 'none';
                                document.querySelector('#blog').classList.remove('animated', 'fadeOut');
                            }, 1000);
                        })
                        .finally(() => {
                            setTimeout(() => {
                                document.querySelector('#blog').style.display = 'block';
                                status.remove();
                                imgAlert.remove();
                            }, 5000);
                        });
                } else {
                    postData(path, formData)
                        .then(data => {
                            console.log(data);
                            status.textContent = 'Введенная запись уже имеется в базе данных';
                            imgAlert.setAttribute('src', './local-images/fail.png');
                            document.querySelector('#blog').classList.add('animated', 'fadeOut');
                            setTimeout(() => {
                                document.querySelector('#blog').style.display = 'none';
                                document.querySelector('#blog').classList.remove('animated', 'fadeOut');
                            }, 1000);
                        })
                        .catch(err => {
                            console.log(err);
                            status.textContent = statusMessage.failure;
                            imgAlert.setAttribute('src', './local-images/fail.png');
                            document.querySelector('#blog').classList.add('animated', 'fadeOut');
                            setTimeout(() => {
                                document.querySelector('#blog').style.display = 'none';
                                document.querySelector('#blog').classList.remove('animated', 'fadeOut');
                            }, 1000);
                        })
                        .finally(() => {
                            setTimeout(() => {
                                document.querySelector('#blog').style.display = 'block';
                                status.remove();
                                imgAlert.remove();
                            }, 5000);
                        });
                }
                return serversId;
            })
            .catch((err) => {
                console.log(err);
            });

    });