require('./bootstrap');

const api = '/api/photo';

function Toast(options) {

    if ( !options.message ) {
        throw new Error('Toast.js - You need to set a message to display');
        return;
    }

    this.options = options;
    this.options.type = options.type || 'default';

    this.toastContainerEl = document.querySelector('.toastjs-container');
    this.toastEl = document.querySelector('.toastjs');

    this._init();
}

Toast.prototype._createElements = function() {
    return new Promise((resolve, reject) => {

        this.toastContainerEl = document.createElement('div');
        this.toastContainerEl.classList.add('toastjs-container');
        this.toastContainerEl.setAttribute('role', 'alert');
        this.toastContainerEl.setAttribute('aria-hidden', true);

        this.toastEl = document.createElement('div');
        this.toastEl.classList.add('toastjs');

        this.toastContainerEl.appendChild(this.toastEl);
        document.body.appendChild(this.toastContainerEl);

        setTimeout(() => resolve(), 500);
    })
};

Toast.prototype._addEventListeners = function() {

    document.querySelector('.toastjs-btn--close').addEventListener('click', () => {
        this._close();
    })

    if ( this.options.customButtons ) {
        const customButtonsElArray = Array.prototype.slice.call( document.querySelectorAll('.toastjs-btn--custom') );
        customButtonsElArray.map( (el, index) => {
            el.addEventListener('click', (event) => this.options.customButtons[index].onClick(event) );
        });
    }

};

Toast.prototype._close = function() {
    return new Promise((resolve, reject) => {
        this.toastContainerEl.setAttribute('aria-hidden', true);
        setTimeout(() => {

            this.toastEl.innerHTML = '';
            this.toastEl.classList.remove('default', 'success', 'warning', 'danger');

            if ( this.focusedElBeforeOpen ) {
                this.focusedElBeforeOpen.focus();
            }

            resolve();

        }, 1000);
    });
};

Toast.prototype._open = function() {

    this.toastEl.classList.add(this.options.type);
    this.toastContainerEl.setAttribute('aria-hidden', false);

    let customButtons = '';
    if ( this.options.customButtons ) {
        customButtons = this.options.customButtons.map( (customButton, index) => {
            return `<button type="button" class="toastjs-btn toastjs-btn--custom">${customButton.text}</button>`
        } )
        customButtons = customButtons.join('');
    }

    this.toastEl.innerHTML = `
        <p>${this.options.message}</p>
        <button type="button" class="toastjs-btn toastjs-btn--close">Close</button>
        ${customButtons}
    `;

    this.focusedElBeforeOpen = document.activeElement;
    document.querySelector('.toastjs-btn--close').focus();
};

Toast.prototype._init = function() {
    Promise.resolve()
        .then(() => {
            if ( this.toastContainerEl ) {
                return Promise.resolve();
            }
            return this._createElements();
        })
        .then(() => {
            if ( this.toastContainerEl.getAttribute('aria-hidden') == 'false'  ) {
                return this._close();
            }
            return Promise.resolve();
        })
        .then(() => {
            this._open();
            this._addEventListeners();
        })
};


function Photos(el) {
    if (!el) { return; }

    this.container = el;
    this.image = this.container.querySelector('#js-image');
    this.cancel = this.container.querySelector('#js-image-cancel');
    this.accept = this.container.querySelector('#js-image-accept');
    this.photos = [];
    this.next = null;
    this.page = null;

    if (this.container.length === 0 || this.cancel.length !== this.accept.length) {
        return;
    }
    this._init();
}

Photos.prototype._init = async function () {
    this.clickListener = this._clickEvent.bind(this);

    this.accept.addEventListener('click', this.clickListener, false);
    this.cancel.addEventListener('click', this.clickListener, false);

    await this._getRandomPhotos(null);
    await this._load();
}

Photos.prototype._load = async function () {
    if (!this.photos) {
        return;
    }
    let random = Math.floor(Math.random() * this.photos.length);

    if (!this.photos[random]) {
        this._default();
        return;
    }
    if (this.photos.length < 3) {
        await this._getRandomPhotos(this.next);
    }

    this._print(random);
    this._delete(random);
}

Photos.prototype._clickEvent = async function (e) {
    e.preventDefault();

    let elem = e.target;
    let status = (/true/).test(elem.getAttribute('data-status'));
    let photo_id = this.image.getAttribute('data-id');

    if (photo_id === null || photo_id === undefined) {
        return;
    }

    this._disable();
    await this._save(photo_id, status);
    await this._load();
};

Photos.prototype._getRandomPhotos = async function (page) {
    try {
        const response = await axios.get(api, { params: { page: page } });
        if (page) {
            this.photos = [...this.photos, ...response.data.data];
        } else {
            this.photos = response.data.data;
        }
        this.next = response.data.next;
        this.page = response.data.page;
    } catch (error) {
        new Toast({message: error.response.data.message, type: 'danger'});
    }
}

Photos.prototype._save = async function(photo_id, status) {
    let img = this.image.src;

    try {
        await axios.post(api, {
            photo_id: photo_id,
            status: status,
            photo_url: img
        });
    } catch (error) {
        new Toast({message: error.response.data.message, type: 'danger'});
    }
}

Photos.prototype._disable = function () {
    this.cancel.disabled = true;
    this.accept.disabled = true;
}

Photos.prototype._enable = function () {
    this.cancel.disabled = false;
    this.accept.disabled = false;
}

Photos.prototype._print = function (index) {
    let id = this.photos[index];
    let width = this.image.width;
    let height = this.image.height;

    this.image.setAttribute('data-id', id);
    this.image.src = `https://picsum.photos/id/${id}/${width}/${height}`;

    this.image.onload = function () {
        this._enable();
    }.bind(this);
}


Photos.prototype._default = function () {
    this.image.removeAttribute('data-id');
    this.image.src = '/img/default.jpg';
}

Photos.prototype._delete = function (index) {
    this.photos.splice(index, 1);
}

new Photos(document.getElementById('Image'));


function createRaw(raw) {
    let tr = document.createElement('tr');
    let td = document.createElement('td');
    let id = document.createElement('a');
    let btn = document.createElement('button');

    id.href = raw.photo_url;
    id.textContent = raw.id;
    id.className = 'text-underline'
    id.target = '_blank';
    td.append(id);
    tr.append(td);

    td = document.createElement('td');
    td.textContent = raw.status;
    tr.append(td);

    td = document.createElement('td');
    td.className = 'text-right';
    btn.type = 'button';
    btn.textContent = 'Reset';
    btn.className = 'rounded-lg py-4 px-6 bg-secondary text-white';
    btn.addEventListener('click', async function () {
        try {
            await axios.patch(`${api}/${raw.photo_id}`, {
                status: null
            });
            location.reload();
        } catch (error) {
            new Toast({message: error.response.data.message, type: 'danger'});
        }
    })
    td.append(btn);
    tr.append(td);

    return tr;
}

async function renderTable(el) {
    if (!el) {
        return;
    }

    try {
        const response = await axios.get(`${api}/all`);
        const photos = response.data.data;

        photos.forEach((element) => {
            el.append(createRaw(element))
        });

    } catch (error) {
        new Toast({message: error.response.data.message, type: 'danger'});
    }

}

renderTable(document.getElementById('Table'));
