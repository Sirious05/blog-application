document.querySelectorAll('.record__form').forEach(item => item.style.display = 'none');
document.querySelectorAll('.edit').forEach((item, n) => {
    item.addEventListener('click', () => {
        if (document.querySelectorAll('.record__form')[n].style.display === 'none') {
            document.querySelectorAll('.record__form')[n].style.display = 'block';
        } else {
            document.querySelectorAll('.record__form')[n].style.display = 'none';
        }
    });
});
document.querySelectorAll('.editmg').forEach(item => {
    item.addEventListener('input', (e) => {
        let dots;
        let partsPath = item.files[0].name.split('.');
        if (partsPath[0].length > 8) {
            dots = true;
        } else {
            dots = false;
        }
        if (dots === true) {
            item.previousElementSibling.textContent = item.files[0].name.slice(0, 8) + '...' + ' ' + partsPath[1];
        } else {
            item.previousElementSibling.textContent = item.files[0].name;
        }
    });
})

function bindAdminValidate(numberSelector, stringSelector) {
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
bindAdminValidate('input[name="edit-id"]', 'input[type="text"]');
async function AdminPostData(url, data) {
    let request = await fetch(`${url}`, {
        method: 'POST',
        cache: "no-cache",
        body: data,

    });
    if (!request.ok) {
        throw new Error(`Ошибка в ${request.url} имеет статус ${request.status}`);
    }
    return await request.text();
}
document.querySelectorAll('.record__form').forEach((item, n) => {
    item.addEventListener('submit', (e) => {
        let status = document.createElement('div');
        e.preventDefault();
        item.parentNode.appendChild(status);
        const statusMessage = {
            success: 'Успешно! Мы приняли ваши данные.',
            loading: 'Загрузка...Пожалуйста, подождите',
            failure: 'Упс... Произошла ошибка',
        };
        status.textContent = statusMessage.loading;
        const formData = new FormData(item);
        let id = item.parentNode.querySelectorAll('.record__id span')[n].textContent;
        formData.append('old-id', id);
        let path = './admin.php';
        AdminPostData(path, formData)
            .then(data => {
                console.log(data);
                window.location.reload(true);
                status.textContent = statusMessage.success;
                setTimeout(() => {
                    item.style.display = 'none';
                }, 1000);
            })
            .catch(err => {
                console.log(err);
                status.textContent = statusMessage.failure;
                item.classList.add('animated', 'fadeOut');
                setTimeout(() => {
                    item.style.display = 'none';
                }, 1000);
            })
            .finally(() => {
                item.classList.add('animated', 'fadeOut');
                document.querySelectorAll('input').forEach(item => item.value = '');
                setTimeout(() => {
                    item.classList.remove('animated', 'fadeOut');
                    item.style.display = 'flex';
                    status.remove();
                }, 5000);
            });
    });
});
document.querySelector('.wrapper').style.display = 'none';
document.querySelector('.add-post').addEventListener('click', () => {
    if (document.querySelector('.wrapper').style.display === 'none') {
        document.querySelector('.wrapper').style.display = 'flex';
        document.querySelector('.wrapper').style.flexDirection = 'column';
    } else {
        document.querySelector('.wrapper').style.display = 'none';
    }
});