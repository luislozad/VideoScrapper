<div x-data="{  
  uid: new ShortUniqueId({ length: 10 }),
  
  url: '',
  
  jsonEditor: null,
  
  view: 'params',
  
  params: [],
  headers: [],
  body: '',
  
  sortParams: [],
  sortHeaders: [],

  init() {
    const editor = ace.edit('editor');
    editor.setTheme('ace/theme/dawn');
    
    editor.session.setMode('ace/mode/json'); // Configuración para JSON

    const json = '';

    editor.setValue(json, -1);

    this.jsonEditor = editor;

    this.enableEditor(false);
  },

  enableEditor(value) {
    const containerEditor = document.querySelector('.editor');
    
    if (this.jsonEditor) {
      if (value) {
        this.jsonEditor.setReadOnly(false);
        this.jsonEditor.container.style.pointerEvents = 'auto';
        containerEditor.classList.remove('disabled-editor');
      } else {
        this.jsonEditor.setReadOnly(true);
        this.jsonEditor.container.style.pointerEvents = 'none';
        containerEditor.classList.add('disabled-editor');
      }
    }
  },

  parseQueryString(url) {
    // Creamos un objeto URL a partir de la cadena de URL proporcionada
    const urlObj = new URL(url);

    // Obtenemos las query parameters de la URL
    const params = new URLSearchParams(urlObj.search);

    // Convertimos los parámetros a un array de objetos
    const result = [];
    for (const [key, value] of params) {
        const newItem = this.newItem({ key, value });
        result.push(newItem);
    }

    return result;
  },

  reorderQueryString(paramsArray, url) {
    // Creamos un objeto URL a partir de la cadena de URL proporcionada
    const urlObj = new URL(url);

    // Creamos una nueva instancia de URLSearchParams para construir la nueva query string
    const newParams = new URLSearchParams();

    // Iteramos sobre el array de parámetros proporcionado y añadimos cada uno a newParams
    paramsArray.forEach(({ key, value }) => newParams.append(key, value));

    // Establecemos la nueva query string en el objeto URL
    urlObj.search = newParams.toString();

    // Devolvemos la URL completa con la query string reordenada
    return urlObj.toString();
  },

  handlerInputUrl({target}) {
    if (target && target.value) {
      const url = target.value;
      const newParams = this.parseQueryString(url);
      this.params = newParams;
      this.sortParams = newParams.map(({ id }) => ({ id }));
    } else if (target && !target.value) {
      this.params = [];
      this.sortParams = [];
    }
  },

  capitalizeAndSort(inputString) {
    // Capitalizar la primera letra del string recibido
    const capitalizedString = inputString.charAt(0).toUpperCase() + inputString.slice(1);
    
    // Concatenar 'sort' con el string capitalizado
    return 'sort' + capitalizedString;
  },

  moveTo(oldPosition, newPosition, array) {
    // Asegurarse de que las posiciones sean válidas
    if (oldPosition < 0 || newPosition < 0 || oldPosition >= array.length || newPosition >= array.length) {
        console.error('Posiciones fuera de rango');
        return [];
    }

    // Si la posición no ha cambiado, no hacemos nada
    if (oldPosition === newPosition) {
        return array;
    }

    // Deslizar el elemento hacia la nueva posición
    if (oldPosition < newPosition) {
        // Deslizar hacia adelante
        for (let i = oldPosition; i < newPosition; i++) {
            [array[i], array[i + 1]] = [array[i + 1], array[i]]; // Intercambiar elementos
        }
    } else {
        // Deslizar hacia atrás
        for (let i = oldPosition; i > newPosition; i--) {
            [array[i], array[i - 1]] = [array[i - 1], array[i]]; // Intercambiar elementos
        }
    }

    return array;  
  },

  sortQueryList(sortParams) {
    const params = JSON.parse(JSON.stringify(this.params || []));

    const map = new Map(params.map(item => [item.id, item]));

    return sortParams.map(item => {
        const value = map.get(item.id);
        return { ...item, ...value };
    });    
  },

  urlUpdate(list) {
    if (this.view === 'params') {
      const sortQueryList = this.sortQueryList(list);
      this.url = this.reorderQueryString(sortQueryList, this.url);
    }
  },

  sortItems(item, newPos, listName) {
    const sortListName = this.capitalizeAndSort(listName);
    const sortList = this[sortListName];

    const list = JSON.parse(JSON.stringify(sortList || []));

    const { id } = item;

    const oldPos = list.findIndex(item => item.id === id);

    if (oldPos < 0) {
      return;
    }

    const newList = this
    .moveTo(oldPos, newPos, list)
    .map(({ id }) => ({ id }));
    
    if (newList.length > 0) {
      this.urlUpdate(newList);
      this[sortListName] = newList;
    }
  },

  openModalDanger(id, listName) {
    this.currentDeleteItem = { id, listName };
  },
  currentDeleteItem: {},
  handlerDeletItem(listName, id) {
    const list = JSON.parse(JSON.stringify(this[listName] || []));
    const newList = list.filter(({ id: itemID }) => itemID !== id);
    return newList;
  },
  newList(listName, item) {
    const list = JSON.parse(JSON.stringify(this[listName] || []));
    list.unshift(item);  

    return list;
  },
  newItem(item) {
    if (item) {
      return { ...item, id: this.uid.rnd() };
    }
    return { key: '', value: '', id: this.uid.rnd() };
  },
  addItem(listName) {
    const sortListName = this.capitalizeAndSort(listName);

    const item = this.newItem();
    
    this[listName] = this.newList(listName, item);
    this[sortListName] = this.newList(sortListName, { id: item.id });

    this.urlUpdate(this[sortListName]);
  },
  deleteItem() {
    const { id, listName } = this.currentDeleteItem;
    const sortListName = this.capitalizeAndSort(listName);

    this[listName] = this.handlerDeletItem(listName, id);
    this[sortListName] = this.handlerDeletItem(sortListName, id);

    this.urlUpdate(this[sortListName]);

    this.currentDeleteItem = {};

  },
  deleteAllItems(listName) {
    const sortListName = this.capitalizeAndSort(listName);
    
    this[sortListName] = [];

    this[listName] = [];

    this.urlUpdate([]);

    this.currentDeleteItem = {};
  },
  onItemUpdate() {
    const sortParams = this.sortParams;
    this.urlUpdate(sortParams);
  }
}">
    <x-pg-media-downloader::api-service-manager.input />
    <x-pg-media-downloader::api-service-manager.tabs />

    <div x-show="view === 'params'">
      <x-pg-media-downloader::api-service-manager.tabs.params /> 
    </div>
    <div x-show="view === 'headers'" style="display: none;">
      <x-pg-media-downloader::api-service-manager.tabs.headers /> 
    </div>    
    <div x-show="view === 'body'" style="display: none;">
      <x-pg-media-downloader::api-service-manager.tabs.body /> 
    </div>
</div>
  
