<div class="max-w-max border border-blue-500 rounded p-4 divide-y" x-data="{ 
    step: 'configuration',
    next: false,
    save: false,
    error: false,
    field: 'Save',       
    save: async function() {
        const data = this.getData();
        try {
            const res = await $wire.save(data);
            return res;
        } catch(e) {
            this.newNext('error');
            return ({ error: true });
        }
    },
    newNext: function(val) {
        if (val === 'save') {
            this.next = true;
            this.field = 'Next';
            this.error = false;
        } else if (val === 'error') {
            this.next = false;
            this.error = true;
        }
    },
    getData: function() {
        return this.db;
    },
    db: {
        appName: '',
        username: '',
        password: '',
        hostDB: 'localhost',
        portDB: '3306',
        database: '',
        usernameDB: '',
        passwordDB: '',
        email: '',
    },
    resetValidations: async function() {
        if (this.error) {
            this.error = false;
            await $wire.resetValidations();
        }
    },
    validation: async function() {
        if (this.next && this.field === 'Save') {
            this.next = false;
            const res = await this.save();
            if (res && !res.error) {
                this.field = 'Next';
                this.save = true;
                this.newNext('save');
            } else {
                this.newNext('error');
            }
        } else if (this.next && this.save && this.field === 'Next') {
            await $wire.nextStep();
        }

    }

}" x-init="$watch('db', (db) => {
    const list = Object.values(db);

    next = list.every((v) => v);

    resetValidations();
})">
    <x-install.steps />
    <div class="flex mt-4 pt-7 px-3 divide-y flex-wrap max-w-3xl flex-col">
        <x-errors :errors="$errors" />   
        <x-install.configuration />
    </div>
    <x-install.next />
</div>
